<?php
function readCsv($file = '', $delimiter = ',') {
    if(!file_exists($file) || !is_readable($file)) {
        return false;
    }

    ini_set('auto_detect_line_endings', true);

    $header = null;
    $data = array();
    
    if (($handle = fopen($file, 'r')) !== false) {
        while (($row = fgetcsv($handle, 1024, $delimiter)) !== false) {
            if(empty($header) || count(array_diff($header, $row)) == 0) {
                foreach($row as $field => $value) {
                    $header[] = strtolower(trim($value));
                }
            }
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }

    ini_set('auto_detect_line_endings',false);

    return $data;
}

function search_in_array($srchvalue, $array) {
    if (is_array($array) && count($array) > 0) {
        $foundkey = array_search($srchvalue, $array);
        if ($foundkey === FALSE) {
            foreach ($array as $key => $value) {
                if (is_array($value) && count($value) > 0) {
                    $foundkey = search_in_array($srchvalue, $value);
                    if ($foundkey != FALSE)
                        return $foundkey;
                }
            }
        }
        else {
            return $foundkey;
        }
    }
}

//changed has been changed for project
function array_to_table($array, $recursive = false, $null = '&nbsp;') {
    // Sanity check
    if (empty($array) || !is_array($array)) {
        return false;
    }

    if (!isset($array[0]) || !is_array($array[0])) {
        $array = array($array);
    }

    // Start the table
    $table = "<table>\n";

    // The header
    $table .= "\t<tr>";

    //Add an abitrary serial number S/N

    $table .= '<th>S/N</th>';

    // Take the keys from the first row as the headings
    foreach (array_keys($array[0]) as $heading) {
        $table .= '<th>' . $heading . '</th>';
    }
    $table .= "</tr>\n";

    // The body
    $i = 0;
    foreach ($array as $row) {
        $table .= "\t<tr>" ;
        foreach ($row as $cell) {
            $table .= '<td>' . ++$i . '</td>';

            $table .= '<td>';

            // Cast objects
            if (is_object($cell)) { $cell = (array) $cell; }
            
            if ($recursive === true && is_array($cell) && !empty($cell)) {
                // Recursive mode
                $table .= "\n" . array2table($cell, true, true) . "\n";
            } else {
                $tooltip = "gettype(): ".strtoupper(gettype($cell));
                $table .= '<span title="'.$tooltip.'">'.( (strlen($cell) > 0) ?
                htmlspecialchars((string) $cell) : $null) .'</span>';
            }

            $table .= '</td>';
        }

        $table .= "</tr>\n";
    }

    $table .= '</table>';
    return $table;
}

function array_values_recursive($array)
{
    $arrayValues = array();
    if(is_array($array)) {
        foreach ($array as $value) {
            if (is_scalar($value) OR is_resource($value))
            {
                 $arrayValues[] = $value;
            }
            elseif (is_array($value))
            {
                 $arrayValues = array_merge($arrayValues, array_values_recursive($value));
            }
        }
        return $arrayValues;
    }
    else return false;
}

function csv_valid_voters($csvFields = array(), $query_result = array(), $fields = array(), $status = 0) {
    $data = array();
    $emails = array_unique(array_values_recursive($csvFields));

    $valid_voters_emails = array();
    $valid_voters_id = array();
    $valid_users_emails = array();

    $i = 0;
    foreach($emails as $email) {
        foreach($query_result as $row) {
            if(search_in_array($email, $row)) {
                $valid_voters_id[$i][$fields[0]]  = $row[$fields[0]];
                $valid_voters_emails[$i]  = $row[$fields[count($fields) - 1]];
                $i++;
            }   
        }
    }

    foreach($emails as $email) {
        if(!in_array($email, $valid_voters_emails)) {
            $valid_users_emails[] = $email;
        }
    }

    if(!empty($valid_voters_id) && $status === 0)
        return $valid_voters_id;

    else if(!empty($valid_users_emails) && $status === 1)
        return $valid_users_emails;

    else return false;
}

function base64url_encode($data) { 
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
}

function base64url_decode($data) { 
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
}
