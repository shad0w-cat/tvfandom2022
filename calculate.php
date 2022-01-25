<?php
date_default_timezone_set('Asia/Kolkata');
session_start();
$tc = strtotime("now") - $_SESSION['start_time'];
echo $tc . '<br>';
echo ($_SESSION['start_time']-strtotime('today')).'<br>';
echo ($_SESSION['end_time']-strtotime('today')).'<br>';
echo $_SESSION['qstarted'].'<br>';

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

// $score = $wrong = $right = $attemps = 0;
// require_once 'login.php';
// $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// if ($connection->connect_error) die($connection->connect_error);

// $query = "SELECT `qno`, `answer` FROM `prelimques`;";
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
//     foreach ($_POST as $key => $value)
//     {
//         if ($key == "option".$rowData['qno'])
//         {
//             echo $key . ' = ' . $value . ' = ' . $rowData['answer'] . '<br>';
//             $attemps++;
//             if(trim($value) == trim($rowData['answer']))
//             {
//                 $right++;
//                 $score += 10;
//             }
//             else
//             {
//                 echo $key . '<br>';
//                 $wrong++;
//                 $score -= 5;
//             }
//         }
//     }
    
// }
// echo $score . '<br>' . $attemps . '<br>' . $right . '<br>' . $wrong;
// $result->close();

// $start_time = date('Y-m-d h:i:sa',$_SESSION['start_time']);
// $end_time = date('Y-m-d h:i:sa',$_SESSION['end_time']);
// $query = "INSERT INTO `prelimresults` (`username`, `start_time`, `end_time`, `started`, `ended`) VALUES ('$_SESSION['username']', $start_time, $end_time, 1,1);";
// // $result = $connection->query($query);
// // if (!$result)
// // {
// //     die($connection->error);
// // }

// // $result->close();
// $query = "INSERT INTO `prelimresults` (`username`, `pqa`, `pqc`, `pqw`, `ptc`, `score`) VALUES ('$_SESSION['username']', $attemps, $right, $wrong, , $score)";
// $connection->close();

session_unset();
session_destroy();

// sleep(5);
// header("Location: index.html");
?>