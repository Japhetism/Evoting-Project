<?php
/**
 * Created by PhpStorm.
 * User: gabriel
 * Date: 2/20/16
 * Time: 7:10 AM
 */

function getAllPosts($election_id){
    global $connection1;
    $post_query=$connection1->prepare("SELECT post_id,post_key,post FROM posts WHERE election_id='$election_id'");
    $post_query->execute();
    $post_query->setFetchMode(PDO::FETCH_ASSOC);
    $allPosts=$post_query->fetchAll();
    return $allPosts;
}

//function to check attachment,returns the tablename if connected otherwise,null
function attached($tableName,$user_id,$election_id){
    global $connection1;
    $query=$connection1->prepare("SELECT election_id FROM $tableName WHERE user_id='$user_id' AND election_id='$election_id'");
    $query->execute();
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $status=$query->fetchColumn();
    if(!empty($status)){
        return $tableName;
    }else{
        return null;
    }
}

//get all contestants for a particular post using the post_id
function getAllContestants($post_id){
    global $connection1;
    $contest=$connection1->query("SELECT * FROM contestants WHERE post_id='$post_id'");
    $contest->execute();
    $contest->setFetchMode(PDO::FETCH_ASSOC);
    $contestants=$contest->fetchAll();
    return $contestants;
}

//get user names
function contestantName($user_id,$con_id = null){
    global $connection1;
    $badmus=$connection1->prepare("SELECT fname,lname FROM users WHERE user_id='$user_id'");
    $badmus->execute();
    $badmus->setFetchMode(PDO::FETCH_ASSOC);
    $details=$badmus->fetchAll();
    $output = strtoupper($details[0]['fname'])." ".$details[0]['lname'];
    if ($con_id != null) {
        $badmus1=$connection1->prepare("SELECT nickname FROM contestants WHERE contestant_id='$con_id'");
        $badmus1->execute();
        $badmus1->setFetchMode(PDO::FETCH_ASSOC);
        $details1=$badmus1->fetchAll();
        $output .= '</b><br>('.$details1[0]['nickname'].')';
    }
    return $output;
}
//get Election details
function getElectionDetails($election_id){
    global $connection1;
    $getElectionDetails=$connection1->prepare("SELECT * FROM election WHERE election_id='$election_id'");
    $getElectionDetails->execute();
    $getElectionDetails->setFetchMode(PDO::FETCH_ASSOC);
    $election_details1=$getElectionDetails->fetchAll();
    return $election_details1;
}

//checking if a user has voted
function hasvoted($user_id, $election_id){
    global $connection1;
    $gabriel=$connection1->query("SELECT has_voted FROM joined WHERE user_id='$user_id' AND election_id='$election_id'");
    $gabriel->execute();
    $gabriel->setFetchMode(PDO::FETCH_ASSOC);
    $details=$gabriel->fetchColumn();
    return $details;
}

//getting the user_id from email address
function user_id($myemail){
    global $connection1;
    $kennedy=$connection1->prepare("SELECT user_id FROM users WHERE email='$myemail'");
    $kennedy->execute();
    $kennedy->setFetchMode(PDO::FETCH_ASSOC);
    $details=$kennedy->fetchAll();
    return $details[0]['user_id'];
}

//getting email address from user_id
function email($id){
    global $connection1;
    $kennedy=$connection1->prepare("SELECT email FROM users WHERE user_id='$id'");
    $kennedy->execute();
    $kennedy->setFetchMode(PDO::FETCH_ASSOC);
    $details=$kennedy->fetchAll();
    return $details[0]['email'];
}

function incrementContestantVote($contestant_id){
    global $connection1;
    $efe="UPDATE contestants SET number_of_votes = number_of_votes + 1 WHERE contestant_id='$contestant_id'";
    $connection1->exec($efe);
    $last_Id= $connection1->lastInsertId();
    return $last_Id;
}

function joined_id($user_id, $election_id){
    global $connection1;
    $gabriel=$connection1->query("SELECT joined_id FROM joined WHERE user_id='$user_id' AND election_id='$election_id'");
    $gabriel->execute();
    $gabriel->setFetchMode(PDO::FETCH_ASSOC);
    $details=$gabriel->fetchColumn();
    return $details;
}

function getMembersSubstr($table = null, $params = null, $where_clause = null) {
    $sub_query = "";

    if((is_string($table) || is_array($table)) && is_array($params)) {
        $str_param = implode(', ', $params);
        if(is_array($table)) {
            $table =  implode(', ', $table);
        }
        $sub_query .= "SELECT {$str_param} FROM {$table}";
    }

    if(isset($table) && is_array($where_clause)) {
        $sub_query .= " WHERE";
    }

    if(is_array($where_clause) && count($where_clause) == 3) {
        $operators = array('<', '<=', '>', '>=', '=', '!=');
        $field = $where_clause[0];
        $operator = $where_clause[1];
        $value = $where_clause[2];

        if(in_array($operator, $operators)) {
            $sub_query .= " $field {$operator} '$value'";
        }
    }

    return $sub_query;
}

function getAllMembers($table = null, $params = null, $where_clause = null, $result_type = 0, $binary_op = null, $sec_clause = null, $limit = false, $limit_value = null) {
    $query = "";
    if(isset($table) && !empty($params)) {
        global $connection1;
        if(is_array($where_clause) && count($where_clause) == 3) {
            $query = getMembersSubstr($table, $params, $where_clause);
        }
        else {
            $query = getMembersSubstr($table, $params);
        }

        $binary_ops = array('OR', 'AND');
        if($binary_op && in_array($binary_op, $binary_ops) && is_array($sec_clause)) {
            $query .= " {$binary_op}" . getMembersSubstr(null, null, $sec_clause);
        }
        if($limit == true && is_numeric($limit_value)) {
            $query .= " LIMIT {$limit_value}";
        }
        if($result = $connection1->query($query)) {
            if($result_type == 0) {
                return $result->fetchAll(PDO::FETCH_ASSOC);
            }
            else {
                return array_values_recursive($result->fetchAll(PDO::FETCH_ASSOC));
            }
        }
        else {
            return false;
        }
    }
    return false;
}

//getting contestant id
function checkContestant($user_id, $election_id){
    global $connection1;
    $get_cont = $connection1->query("SELECT contestant_id FROM contestants WHERE user_id='$user_id' AND election_id='$election_id'");
    $get_cont->execute();
    $get_cont->setFetchMode(PDO::FETCH_ASSOC);
    $cont_id = $get_cont->fetchColumn();
    return $cont_id;
}