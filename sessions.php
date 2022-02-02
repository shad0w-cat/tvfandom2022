<?php
date_default_timezone_set('Asia/Kolkata');

function checkLog($username, $quizName)
{

    require 'login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($connection->connect_error) die($connection->connect_error);
    $query = "SELECT * FROM `" . $quizName . "sessions`;";
    $result = $connection->query($query);
    if (!$result)
    {
        die($connection->error);
    }
    $rows = $result->num_rows;
    $flag = false;
    $resultArray;
    for ($j = 0 ; $j < $rows ; ++$j)
    {
        $result->data_seek($j);
        $rowData = $result->fetch_array(MYSQLI_ASSOC);
        if ($rowData['username'] == $username)
        {
            $resultArray = [$rowData['start_time'],$rowData['end_time'],$rowData['started'],$rowData['ended']];
            $flag = true;
            break;
        }
    }
    $result->close();
    $connection->close();
    if ($flag)
        return $resultArray;
    else
        return false;
}

function quizEndTime($quizName) 
{
    $tarr;
    require 'login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($connection->connect_error) die($connection->connect_error);

    $query = "SELECT `timeLimit` FROM `quiz` WHERE `qid` = '$quizName';";
    $result = $connection->query($query);
    $rowDT;
    if (!$result)
    {
        die($connection->error);
    }
    $rows = $result->num_rows;

    for ($j = 0 ; $j < $rows ; ++$j)
    {
        $result->data_seek($j);
        $rowData = $result->fetch_array(MYSQLI_ASSOC);
        $rowDT =$rowData['timeLimit'];
    }
    $result->close();
    $connection->close();
    return $rowDT;
}

function addNewSession($details, $quizName)
{
    date_default_timezone_set('Asia/Kolkata');

    //print_r($details);
    require 'login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($connection->connect_error) die($connection->connect_error);
    $username=$details['username'];
    $start_time = date('H:i:s',strtotime($details['start_time']));
    $end_time = date('H:i:s',strtotime($details['end_time']));
    $query = "INSERT INTO `" . $quizName . "sessions` (`username`, `start_time`, `end_time`, `started`) VALUES ('$username', '$start_time', '$end_time', 1);";
    //echo $query;
    $result = $connection->query($query);
    if (!$result)
    {
        die($connection->error);
    }
    
    $connection->close();
}
?>