<?php
date_default_timezone_set('Asia/Kolkata');
session_start();
if ($_SESSION['qname']=='prelims')
preCalc();
else 
mainCalc();
function preCalc()
{
    $tt = strtotime("now") - strtotime($_SESSION['start_time']);
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     $name = test_input($_POST["name"]);
    //     $email = test_input($_POST["email"]);
    //     $website = test_input($_POST["website"]);
    //     $comment = test_input($_POST["comment"]);
    //     $gender = test_input($_POST["gender"]);
    //   }
    
    // function test_input($data) {
    //     $data = trim($data);
    //     $data = stripslashes($data);
    //     $data = htmlspecialchars($data);
    //     return $data;
    // }
    $score = $wrong = $right = $attemps = 0;
    require_once 'login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($connection->connect_error) die($connection->connect_error);

    $query = "SELECT `qno`, `answer` FROM `prelimques`;";
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
        foreach ($_POST as $key => $value)
        {
            if ($key == "option".$rowData['qno'])
            {
                //echo $key . ' = ' . $value . ' = ' . $rowData['answer'] . '<br>';
                $attemps++;
                if(trim($value) == trim($rowData['answer']))
                {
                    $right++;
                    $score += 10;
                }
                else
                {
                    //echo $key . '<br>';
                    $wrong++;
                    $score -= 5;
                }
            }
        }
        
    }
    //echo $score . '<br>' . $attemps . '<br>' . $right . '<br>' . $wrong;
    $result->close();
    $username = $_SESSION['username'];
    $query = "INSERT INTO `prelimresults` (`username`, `pqa`, `pqc`, `pqw`, `ptc`, `score`) VALUES ('$username', '$attemps', '$right', '$wrong', '$tt', '$score');";
    $result = $connection->query($query);
    if (!$result)
    {
        die($connection->error);
    }
    
    $query = "UPDATE `prelimsessions` SET `ended` = '1' WHERE (`username` = '$username');";
    $result = $connection->query($query);
    if (!$result)
    {
        die($connection->error);
    }

    $query = "UPDATE `users` SET `prelim` = '1', `prelimScore` = '$score' WHERE (`username` = '$username');";
    $result = $connection->query($query);
    if (!$result)
    {
        die($connection->error);
    }

    $connection->close();
}

function mainCalc()
{
    $tt = strtotime("now") - strtotime($_SESSION['start_time']);
    //echo $tt;
    //print_r($_SESSION);
    $score = $wrong = $right = $attemps = 0;
    require_once 'login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($connection->connect_error) die($connection->connect_error);

    $query = "SELECT `mqno`, `answer` FROM `mainsques`;";
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
        foreach ($_POST as $key => $value)
        {
            if ($key == "option".$rowData['mqno'])
            {
                //echo $key . ' = ' . $value . ' = ' . $rowData['answer'] . '<br>';
                $attemps++;
                if(trim($value) == trim($rowData['answer']))
                {
                    
                    $right++;
                    $score += 10;
                }
                else
                {
                    //echo $key . '<br>';
                    $wrong++;
                    $score -= 5;
                }
            }
            else if ($key == "tita".$rowData['mqno'])
            {
                //echo $key . ' = ' . $value . ' = ' . preg_replace('/[^a-z0-9]/', '',strtolower(trim($rowData['answer']))) . '<br>';
                $attemps++;
                if(preg_replace('/[^a-z0-9 "\']/', '',strtolower(trim($value))) == preg_replace('/[^a-z0-9 "\']/', '',strtolower(trim($rowData['answer']))))
                {
                    $right++;
                    $score += 10;
                }
                else
                {
                    //echo $key . '<br>';
                    $wrong++;
                    $score -= 5;
                }
            }
        }
        
    }
    //echo $score . '<br>' . $attemps . '<br>' . $right . '<br>' . $wrong;
    $result->close();
    $username = $_SESSION['username'];
    $query = "INSERT INTO `mainsresults` (`username`, `mqa`, `mqc`, `mqw`, `mtc`, `score`) VALUES ('$username', '$attemps', '$right', '$wrong', '$tt', '$score');";
    $result = $connection->query($query);
    if (!$result)
    {
        die($connection->error);
    }
    
    $query = "UPDATE `mainssessions` SET `ended` = '1' WHERE (`username` = '$username');";
    $result = $connection->query($query);
    if (!$result)
    {
        die($connection->error);
    }

    $query = "UPDATE `users` SET `mains` = '1', `mainsScore` = '$score' WHERE (`username` = '$username');";
    $result = $connection->query($query);
    if (!$result)
    {
        die($connection->error);
    }

    $connection->close();
}
session_unset();
session_destroy();
// sleep(5);
header("Location: index.html");
?>