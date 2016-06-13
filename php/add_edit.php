<?php
require_once 'connection.php';
require_once 'database.php';
require_once 'csv.php';
require_once 'function.php';

define('CSV_PATH', '../csv/');
define('IMAGE_PATH', '../images/users/');
define('IMAGE_CONT_PATH', '../images/contestants/');
define('DEFAULT_IMG_PATH', '../images/');
define('MAX_FILE_SIZE', 1024000);

//get admin image
$image_name = getAllMembers('users', array('picture_name', 'gender'), array('email', '=', $myemail), 1);
if($image_name[1] == 'male') {
    $user_picture = (isset($image_name[0]) && file_exists(IMAGE_PATH . $image_name[0])) ? IMAGE_PATH . $image_name[0] : DEFAULT_IMG_PATH . 'male.gif' ;
}
else {
    $user_picture = (isset($image_name[0]) && file_exists(IMAGE_PATH . $image_name[0])) ? IMAGE_PATH . $image_name[0] : DEFAULT_IMG_PATH . 'female.png' ;
}

//required to edit participants
$query = "SELECT election.election_start_date FROM election WHERE election_id = '$election_id'";
$time_result = $connection1->query($query);
$election_start = $time_result->fetch()[0];
$election_start_time = strtotime($election_start);
$time_diff = $election_start_time - time();

$select_query = "SELECT users.user_id, users.fname, users.gender, users.lname, users.email, joined.joined_date, users.picture_name FROM users INNER JOIN joined USING (user_id) WHERE joined.election_id = :election_id";

$smh = $connection1->prepare($select_query);
$smh->bindValue(':election_id', $election_id);
$smh->execute();
$users = $smh->fetchAll(PDO::FETCH_ASSOC);

if(!empty($users)) {
    $contestant_id = array();
    $status = '';
    foreach($users as $row => $user) {
        $check_query = "SELECT user_id FROM contestants WHERE user_id = :user_id AND election_id = :election_id";
        $smh = $connection1->prepare($check_query);

        $smh->bindValue(':user_id', $user['user_id']);  
        $smh->bindValue(':election_id', $election_id);
        $smh->execute();
        $users_ids = $smh->fetchAll(PDO::FETCH_COLUMN, 0);

        if(!empty($users_ids)) {
            array_push($contestant_id, $users_ids[0]);
        }
    }

    $i = 0;
    foreach($users as $row => $user) {
        $status = (!empty($contestant_id) && in_array($user['user_id'], $contestant_id)) ? 'contestant' : 'voter';
        $users[$i]['status'] = $status;
        if($status == 'contestant') {
            $contestant_img = getAllMembers('contestants', array('picture_name'), array('user_id', '=', $user['user_id']), 1, array('election_id', '=', $election_id));
            if($user['gender'] == 'male') {
                $users[$row]['picture_name'] = (file_exists(IMAGE_CONT_PATH . $contestant_img[0])) ? IMAGE_CONT_PATH . $contestant_img[0] : DEFAULT_IMG_PATH . 'male.gif' ;
            }
            else {
                $users[$row]['picture_name'] = (file_exists(IMAGE_CONT_PATH . $contestant_img[0])) ? IMAGE_CONT_PATH . $contestant_img[0] : DEFAULT_IMG_PATH . 'female.png' ;
            }
        }
        else {
            if(isset($user['gender']) && $user['gender'] == 'male') {
                $users[$row]['picture_name'] = (isset($user['picture_name']) && file_exists(IMAGE_PATH . $user['picture_name'])) ? IMAGE_PATH . $user['picture_name'] : DEFAULT_IMG_PATH . 'male.gif';
            }
            elseif(isset($user['gender']) && $user['gender'] == 'female') {
                $users[$row]['picture_name'] = (isset($user['picture_name']) && file_exists(IMAGE_PATH . $user['picture_name'])) ? IMAGE_PATH . $user['picture_name'] : DEFAULT_IMG_PATH . 'female.png';
            }
            else {
                $users[$row]['picture_name'] = DEFAULT_IMG_PATH . 'voting1.jpg';
            }
        }
        // $users[$row]['picture_name'] = ($user['picture_name'] && file_exists(IMAGE_PATH . $user['picture_name'])) ? IMAGE_PATH . $user['picture_name'] : DEFAULT_IMG_PATH . 'voting1.jpg';
        $i++;
    }
}

$time_query = "SELECT election_start_date, election_time_from FROM election WHERE election_id = :id";
$smd = $connection1->prepare($time_query);
$smd->bindValue('id', $election_id);
$smd->execute();
$result = $smd->fetchAll(PDO::FETCH_ASSOC);

$election_start = $result[0]['election_start_date'] . ' ' . $result[0]['election_time_from'];

$date_diff = strtotime($election_start) - strtotime("now");


$privacy_status = getAllMembers('election', array('privacy'), array('election_id', '=', $election_id), 1);
$success_message = '';

if(!concluded($result[0]["election_start_date"],$result[0]["election_time_from"],3600)) {
    $display_style = 'block';
    $display_cell = 'table-cell';
}
else {
    $display_style = 'none';
    $display_cell = 'none';
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //get needed election details in case you need to send mail
    $admin_query = "SELECT
                          election.election_name,users.fname AS admin_fname,users.lname AS admin_lname
                    FROM
                          election
                    LEFT JOIN
                          users
                    ON
                          election.user_id = users.user_id
                    WHERE
                          election_id = $election_id";
    $admin = $connection1->prepare($admin_query);
    $admin->execute();
    $admin->setFetchMode(PDO::FETCH_ASSOC);
    $admin = $admin->fetchAll()[0];
    $election_name = $admin['election_name'];
    $sender_name = strtoupper($admin['admin_fname'])." ".$admin['admin_lname'];
    $mail_subject = "Invitation to join the election - ".$election_name;
    $recipient_name = '';
    //set default mail body as though all emails is going to ignored
    $mail_body = "Hello User.<br>
                  This is to notify you that,even though you are yet to create an account with us,
                  ".$sender_name." has invited you to be a voter
                  in the election named <bold>".$election_name."</bold>. The acceptance of this invitation
                  makes you a valid voter in the election but if rejected, this invitation will
                  be removed from the list of your current invitations. Also note that this invitation
                  will be available for a specified period of time depending on the type of election
                  which ".$election_name." is. To see more details about this invitation or respond to it,
                  <a href='evoting.oauife.edu.ng'>SignUp</a> now.";


    $errors = array();
    $success_message = "<div class='report'><h3>Submission Report<span class='text-danger pull-right fa fa-close' onclick='$(this).parent().parent().slideUp(800);'></span></h3>";
    $request_count = $joined_count = $invite_count = $ignored_count = $added = $ignored = $added_joined = 0;
    $display_ignored = $display_ignored_invites = $display_joined = $display_request = $display_invited = $display_invites = [];
    $request_members = getAllMembers('request', array('user_id'), array('election_id', '=', $election_id), 1);
    $invite_members = getAllMembers('invites', array('user_id'), array('election_id', '=', $election_id), 1);
    $joined_members = getAllMembers('joined', array('user_id'), array('election_id', '=', $election_id), 1);
    $ignored_members = getAllMembers('ignored', array('email'), array('election_id', '=', $election_id), 1);

    if(!empty($_FILES['election_csv']['name']) && !empty($_POST['email'])) {
        $errors[] = 'Please use only a medium of email input at a time';
    }

    elseif(!empty($_FILES['election_csv']['name'])) {
        $csv_name = date('His') . trim($_FILES['election_csv']['name']);
        $csv_type = $_FILES['election_csv']['type'];
        $csv_size = $_FILES['election_csv']['size'];
        $csv_tmp = $_FILES['election_csv']['tmp_name'];
        $csv_ext= strtolower(end(explode('.', $csv_name)));
        $csv_valid_types = array('text/csv', 'application/csv', 'text/comma-separated-values',
            'application/excel', 'application/vnd.ms-excel', 'application/vnd.msexcel', 'application/octet-stream');

        $target = CSV_PATH . basename($csv_name);

        if(!is_uploaded_file($csv_tmp)) {
            $errors[] = 'Please upload CSV file';
        }
        elseif($csv_size > MAX_FILE_SIZE) {
            $errors[] = 'The CSV file must not be greater than ' . (MAX_FILE_SIZE / 1024) . 'KB';
        }
        elseif(!in_array($csv_type, $csv_valid_types) || $csv_ext !== 'csv')  {
            $errors[] = 'Uploaded file must be in the CSV format';
        }
        elseif(!move_uploaded_file($csv_tmp, $target)) {
            $errors[] = 'There was problem uploading your csv file';   
        }

        $csvFields = readCsv($target);
        $field_count = 0;

        if(!$csvFields) {
            $errors[0] = 'Cannot read csv file. Please upload a valid csv file';
        }
        else  {
            foreach($csvFields as $field) {
                $field_count = count($field);
            }

            if($field_count != 1) {
                $errors[] = 'Please upload a csv file containing emails only';
            }

            $emails = array_values_recursive($csvFields);
            $valid_email_count = 0;
            if(count($emails) == 0) {
                $errors[] = 'The uploaded csv file contains no valid email address';
            }
            else {
                foreach($emails as $row => $email) {
                    if(strpos($email, '@') == false) {
                        $valid_email_count++;
                    }
                }
                if($valid_email_count > 1) {
                    $errors[] = 'Please upload a csv file containing email addresses';
                }
            }
        }

        if(empty($errors)) {
            $not_invited = 0;
            $select_query = "SELECT email, user_id FROM users";
            $smh = $connection1->prepare($select_query);

            if($smh->execute()) {
                $result = $smh->fetchAll(PDO::FETCH_ASSOC);
            }

            $fields = array('user_id', 'email');
            $valid_voters = csv_valid_voters($csvFields, $result, $fields);
            $valid_users = csv_valid_voters($csvFields, $result, $fields, 1);

            if(is_array($valid_voters) && !empty($valid_voters)) {
                for($i=0; $i<count($valid_voters); $i++) {
                    $valid_voters[$i]['election_id'] = $election_id;
                }
                
                foreach($valid_voters as $voter) {
                    if($request_members && in_array($voter['user_id'], $request_members)) {
                        $display_request[] = getAllMembers('users', array('email'), array('user_id', '=', $voter['user_id']), 1)[0];
                        $request_count++;
                    }
                    elseif($invite_members && in_array($voter['user_id'], $invite_members)) {
                        $display_invited[] = getAllMembers('users', array('email'), array('user_id', '=', $voter['user_id']), 1)[0];
                        $invite_count++;
                    }
                    elseif($joined_members && in_array($voter['user_id'], $joined_members)) {
                        $display_joined[] = getAllMembers('users', array('email'), array('user_id', '=', $voter['user_id']), 1)[0];
                        $joined_count++;
                    }
                    else {
                        $user_id = user_id($myemail);
                        if($voter['user_id'] != $user_id) {
                            $insert_query = "INSERT INTO invites (user_id, election_id) VALUES (:user_id, :election_id)";
                            $smh = $connection1->prepare($insert_query);
                            //invite this user and send notification
                            if ($smh->execute($voter)) {
                                $recipient = getAllMembers('users',['*'],['user_id','=',$voter['user_id']])[0];
                                $recipient_address = $recipient['email'];
                                $recipient_name = strtoupper($recipient['fname'])." ".$recipient['lname'];
                                //generate mail body
                                $mail_body = "Hello ".$recipient['username'].".<br>
                                                This is to notify you that ".$sender_name." has invited you to be a voter
                                                in the election named ".$election_name.". The acceptance of this invitation
                                                makes you a valid voter in the election but if rejected, this invitation will
                                                be removed from the list of your current invitations. Also note that this invitation
                                                will be available for a specified period of time depending on the type of election
                                                which ".$election_name." is. To see more details about this invitation or respond to it,
                                                <a href='evoting.oauife.edu.ng'>Login into your account</a> now.";
                                sendEmail($recipient_address,$recipient_name,$mail_subject,$mail_body);
                            }

                            $display_invites[] = getAllMembers('users', array('email'), array('user_id', '=', $voter['user_id']), 1)[0];
                            $added++;   
                        }
                        else $not_invited = 1;
                    }
                }
            }

            if(count($valid_users) > 0) {
                $ignored_voters = array();
                foreach($valid_users as $user => $email) {
                    if(!in_array($email, $ignored_members)) {
                        $ignored_voters[] = array('email' => $email, 'election_id' => $election_id);
                        $ignored++;
                    }
                    else {
                        $display_ignored[] = $email;
                        $ignored_count++;
                    }
                }
                if(is_array($ignored_voters) && !empty($ignored_voters)) {
                    foreach($ignored_voters as $voters) {
                        $insert_query = "INSERT INTO ignored (email, election_id) VALUES (:email, :election_id)";
                        $smh = $connection1->prepare($insert_query);
                        if($smh->execute($voters)){
                            //send notification
                            sendEmail($voters['email'],$recipient_name,$mail_subject,$mail_body);
                        }
                        // $display_ignored_invites[] = $voters['email'];
                        array_push($display_ignored_invites, $voters['email']);
                    }
                }
            }
        }

        $ignored_num = $ignored + $ignored_count;
        $ignored_total = array_merge($display_ignored_invites, $display_ignored);
        $not_invited_succ = $joined_count + $request_count + $ignored_num + $invite_count;

        $success_message .= '<ul class="list-unstyled">';
        $success_message .= "<li><i class='fa fa-check-square-o text-success'></i>Users successfully invited to this election: <b>{$added}</b> " . displayView($added, $display_invites, 'Email addresses with active accounts and successfully invited') . "</li>";
        $success_message .= "<li><i class='fa fa-close text-danger'></i>Users not successfully invited to this election: <b>$not_invited_succ</b> <a href='#view' data-toggle='collapse' href='#view' aria-expanded='false' aria-controls='view'>View Details</a></li><ul style='list-style: none; padding-left: 15px;' class='collapse' id='view'>";
        $success_message .= ($ignored_num != 0) ? "<li><i class='fa fa-caret-right '></i>Users with no active account: <b>{$ignored_num}</b> " . displayView($ignored_num, $ignored_total, 'Email Address with no active account') . "</li>" : '';
        $success_message .= ($invite_count != 0) ? "<li><i class='fa fa-caret-right'></i>Users who are already invited to this election: <b>{$invite_count}</b> " . displayView($invite_count, $display_invited, 'Email addresses with active accounts but already invited') . "</li>" : '';
        $success_message .= ($joined_count != 0) ? "<li><i class='fa fa-caret-right'></i>Users who already joined this election: <b>{$joined_count}</b> " . displayView($joined_count, $display_joined, 'Email addresses which already joined this election') . "</li>" : '';
        $success_message .= ($request_count != 0) ? "<li><i class='fa fa-caret-right text-danger'></i>Users who already requested to join this election: <b>{$request_count}</b> " . displayView($request_count, $display_request, 'Email addresses requesting to join election') . "</li>" : '';
        $success_message .= "</ul></ul><hr>";

        $success_message .= ($not_invited == 1) ? '<p style="color: maroon">* Note that an invitation cannot be sent to your email address for the election you created</p>' : '';

        $count = ((count($csvFields) - 5) <= 0) ? count($csvFields) : 5;
        $emails = array_values_recursive($csvFields);

        if(is_array($emails) && !empty($emails)) {
            $success_message .= '<p class="primary" style="color: #fff; padding: 10px;">The first five (or less) email addresses in the uploaded csv file are as follows:<p>';
            $success_message .= '<div class="table-responsive">
                                    <table class="table table-bordered" style="background:white">
                                        <thead>
                                            <tr>
                                                <th>Index</th>
                                                <th style="text-align:left;">Email Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
            for($i=0; $i < $count; $i++) {
                $j = $i + 1;
                    $success_message .= '<tr>
                                            <td>' . $j . '</td>
                                            <td style="text-align:left;">' . $emails[$i] . '</td>
                                        </tr>';
            }
            $success_message .= '       </tbody>
                                    </table>
                                </div>';
        }
        else {
            $success_message .=  '<p>There was a problem displaying the emails in the uploaded csv file. Please proceed to be sure of the final outcome</p>';
        }

        foreach($csvFields as $array => $value) {
            $key = (is_array($value)) ? array_keys($value) : $key = $array[0];
        }

        if(strpos($key[0], '@')) {
            $success_message .= '<div style="margin-bottom: 20px;"><hr>';
            $success_message .= '<p><em>**Please note that </em><strong>' . $key[0] . '</strong><em> was considered invalid for invitation as it was taken to be the header of the csv file uploaded**</em></p></div>';
        }
    }

    elseif(!empty($_POST['email'])) {
        $email = $_POST['email'];

        //email still needs more validation
        $email = strip_tags(trim($email));
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "{$email} is not a valid email address";
        }
        else {
            $user_members = getAllMembers('users', array('user_id', 'email'), array('email', '=', $email));
            if($user_members && is_array($user_members) && !empty($user_members)) {
                $user_id = $user_members[0]['user_id'];
                if($request_members && in_array($user_id, $request_members)) {
                    $request_count++;
                }
                elseif($invite_members && in_array($user_id, $invite_members)) {
                    $invite_count++;
                }
                elseif($joined_members && in_array($user_id, $joined_members)) {
                    $joined_count++;
                }
                else {
                    $insert_query = "INSERT INTO invites (user_id, election_id) VALUES (:user_id, :election_id)";
                    $smh = $connection1->prepare($insert_query);
                    $smh->bindValue('user_id', $user_id);
                    $smh->bindValue('election_id', $election_id);
                    //execute the query and send notification
                    if ($smh->execute()) {
                        //get recipient
                        $recipient = getAllMembers('users',['*'],['user_id','=',$user_id])[0];
                        $recipient_address = $recipient['email'];
                        $recipient_name = strtoupper($recipient['fname'])." ".$recipient['lname'];
                        //generate mail body
                        $mail_body = "Hello ".$recipient['username'].".<br>
                                                This is to notify you that ".$sender_name." has invited you to be a voter
                                                in the election named ".$election_name.". The acceptance of this invitation
                                                makes you a valid voter in the election but if rejected, this invitation will
                                                be removed from the list of your current invitations. Also note that this invitation
                                                will be available for a specified period of time depending on the type of election
                                                which ".$election_name." is. To see more details about this invitation or respond to it,
                                                <a href='evoting.oauife.edu.ng'>Login into your account</a> now.";
                        sendEmail($recipient_address,$recipient_name,$mail_subject,$mail_body);

                    }

                }   
            }
            else {
                if(!in_array($email, $ignored_members)) {
                    $insert_query = "INSERT INTO ignored (email, election_id) VALUES (:email, :election_id)";
                    $smh = $connection1->prepare($insert_query);
                    $smh->bindValue(':email', $email);
                    $smh->bindValue('election_id', $election_id);
                    //execute the query and send notification
                    if ($smh->execute()) {
                        //send notification
                        sendEmail($email,$recipient_name,$mail_subject,$mail_body);

                    }
                    $added_joined++;
                }
                else {
                    $ignored_count++;
                }
            }
        }
        $success_message .= "<p>The user with email address <a>{$email}</a> ";
        if($request_count > 0) {
            $success_message .= "has already sent you a request to join this election. Please acknowledge the request";
        }
        elseif($invite_count > 0) {
            $success_message .= "had already been sent an invitation to join this election";
        }
        elseif($joined_count > 0) {
            $success_message .= "has already joined this election";
        }
        elseif($ignored_count > 0) {
            $success_message .= "does not have an account on this platform. Please advise him or her to create one";
        }
        elseif($added_joined > 0) {
            $success_message .= "will be invited for this election once he/she creates an account";
        }
        else {
            $success_message .= "has successfully been sent an invitation to join this election";
        }
        $success_message .= "</p>";
    }

    else {
        $errors[0] = 'This field is required';
    }
    $success_message .= "</div>";
}

?>