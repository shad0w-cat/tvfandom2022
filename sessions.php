<?php
function checkLog($username)
{
    require 'login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($connection->connect_error) die($connection->connect_error);
    $query = "SELECT * FROM `prelimsessions`;";
    $result = $connection->query($query);
    if (!$result)
    {
        die($connection->error);
    }
    $rows = $result->num_rows;

    for ($j = 0 ; $j < $rows ; ++$j)
    {
        $result->data_seek($j);
        $rowData = $result->fetch_array(MYSQLI_ASSOC);
        if ($rowData['username'] == $username)
        {
            return [$rowData['start_time'],$rowData['end_time'],$rowData['started'],$rowData['ended']];
        }
        else
            return false;
    }
    $result->close();
    $connection->close();
}

function addNewUser($details)
{
    print_r($details);
    // require 'login.php';
    // $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    // if ($connection->connect_error) die($connection->connect_error);
    // $query = "INSERT INTO `tvfandom`.`users` (`username`, `fName`, `lName`, `mailid`, `prelim`, `prelimScore`, `mains`, `mainsScore`) VALUES ('s', 's', 's', 's', 's', 's', 's', 's');";
    // $result = $connection->query($query);
    // if (!$result)
    // {
    //     die($connection->error);
    // }
    // $rows = $result->num_rows;

    // for ($j = 0 ; $j < $rows ; ++$j)
    // {
    //     $result->data_seek($j);
    //     $rowData = $result->fetch_array(MYSQLI_ASSOC);
    //     if ($rowData['username'] == $username)
    //     {
    //         return [$rowData['start_time'],$rowData['end_time'],$rowData['started'],$rowData['ended']];
    //     }
    //     else
    //         return false;
    // }
    // $result->close();
    // $connection->close();
}
?>