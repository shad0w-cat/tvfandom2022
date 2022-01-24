<?php
session_start();
echo $_SESSION['start_time'].'<br>';
echo $_SESSION['end_time'].'<br>';
echo $_SESSION['started'].'<br>';

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
    $type = "qtext";
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
                $attemps++;
                if($value == $rowData['answer'])
                {
                    $right++;
                    $score += 10;
                }
                else
                {
                    $wrong++;
                    $score -= 5;
                }
            }
        }
       
    }
    echo $score . '<br>' . $attemps . '<br>' . $right . '<br>' . $wrong;
    $result->close();
    $connection->close();
?>