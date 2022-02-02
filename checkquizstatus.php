<?php

function checkStatus($quizname)
{
    date_default_timezone_set('Asia/Kolkata');

    require 'login.php';

    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($connection->connect_error) die($connection->connect_error);

    $query = "SELECT `startStatus`, `endStatus` FROM `quiz` WHERE `qid` = '$quizname';";
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
        $rowDT = [$rowData['startStatus'],$rowData['endStatus']];
    }
    $result->close();
    $connection->close();
    return $rowDT;
}
?>