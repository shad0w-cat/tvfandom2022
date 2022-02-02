<?php
function loginCheck ($loginDetails)
{
    require 'login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    $us = mysqli_real_escape_string($connection, $loginDetails['username']);
    $pass = mysqli_real_escape_string($connection, $loginDetails['passwd']);
    if ($connection->connect_error) die($connection->connect_error);
    $query = "SELECT 1 FROM `users` WHERE `username` = '$us' AND `passwd` = '$pass';";
    $result = $connection->query($query);
    if (!$result)
    {
        die($connection->error);
    }
    $rows = $result->num_rows;
    $result->close();
    $connection->close();
    if ($rows > 0)
    return true;
    else 
    return false;
}
function loginCheckM ($loginDetails)
{
    require 'login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    $us = mysqli_real_escape_string($connection, $loginDetails['username']);
    $pass = mysqli_real_escape_string($connection, $loginDetails['passwd']);
    if ($connection->connect_error) die($connection->connect_error);
    $query = "SELECT 1 FROM `users` WHERE (`username` = '$us' AND `passwd` = '$pass') AND (`qualify` = '1');";
    $result = $connection->query($query);
    if (!$result)
    {
        die($connection->error);
    }
    $rows = $result->num_rows;
    $result->close();
    $connection->close();
    if ($rows > 0)
    return true;
    else 
    return false;
}
?>
