<?php
date_default_timezone_set('Asia/Kolkata');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userpassArray = explode(',', $_POST['pass']);
    $username = $userpassArray[1];
    $password = $userpassArray[0];
    //echo $username . $password;
    if ($username == 'superAdmin@HY' && $password == 'JinneMeraDilLutiya')
    {
        echo '
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin Panel - TV Fandom</title>
            <link rel="shortcut icon" href="assets/img/favicon.jpg" type="image/x-icon">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <style>
                table {
                    width: 100%;
                    table-layout: fixed;
                    border: 2px solid black;
                    border-collapse: collapse;
                    font-size: 15px;
                    font-family: "Calibri";
                }

                table,
                td,
                tr,
                th {
                    border: 1px solid black;
                }

                th:nth-child(2),
                td:nth-child(2) {
                    width: 20%;
                }

                th:nth-child(3),
                td:nth-child(3) {
                    width: 25%;
                }

                th:nth-child(1),
                td:nth-child(1) {
                    width: 15%;
                    overflow: hidden;
                }
            </style>
        </head>

        <body>
            <button type="button" id="startPrelim">Start Prelim Quiz</button>
            <button type="button" id="stopPrelim">Stop Prelim Quiz</button>
            <button type="button" id="showPrelims">Show Prelim Quiz Results</button>
            <button type="button" id="startMains">Start Mains Quiz</button>
            <button type="button" id="stopMains">Stop Mains Quiz</button>
            <button type="button" id="showMains">Show Mains Quiz Result</button>
            <form action"admin.php" method="POST">
                <input type="hidden" autofocus name="pass" value=' . $_POST['pass'] . ' />
                <input type="hidden" autofocus name="function-type" value="" />
            </form>            
            <script>
            $(document).ready(function () {
                $("button").on("click", function () {
                    //console.log(this.id);
                    $("input[name=\"function-type\"]").val(this.id);
                    document.forms[0].submit();
                    //console.log($("input[name=\"function-type\"]").val());
                });
            });
            </script>
        </body>

        </html>
        ';

        if ($_POST['function-type'])
        {
            require 'login.php';
            $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
            if ($connection->connect_error) die($connection->connect_error);
    
            if ($_POST['function-type'] == 'startPrelim')
            {
                $stime=date("H:i:s", strtotime("now"));
                $query = "UPDATE `quiz` SET `startStatus` = '1', `startTime` = '$stime'  WHERE (`qid` = 'prelim');";
                $result = $connection->query($query);
                if (!$result)
                {
                    die($connection->error);
                }
                else 
                {
                    echo '<br> Prelims have now started!!';
                }
            }
            else if ($_POST['function-type'] == 'startMains')
            {
                $stime=date("H:i:s", strtotime("now"));
                $query = "UPDATE `quiz` SET `startStatus` = '1', `startTime` = '$stime'  WHERE (`qid` = 'mains');";
                $result = $connection->query($query);
                if (!$result)
                {
                    die($connection->error);
                }
                else 
                {
                    echo '<br> Mains have now started!!';
                }
            }
            else if ($_POST['function-type'] == 'stopPrelim')
            {
                $etime=date("H:i:s", strtotime("now"));
                $query = "UPDATE `quiz` SET `endStatus` = '1', `endTime` = '$etime'  WHERE (`qid` = 'prelim');";
                $result = $connection->query($query);
                if (!$result)
                {
                    die($connection->error);
                }
                else 
                {
                    echo '<br> Prelims is now stopped!!';
                }
            }
            else if ($_POST['function-type'] == 'stopMains')
            {
                $etime=date("H:i:s", strtotime("now"));
                $query = "UPDATE `quiz` SET `endStatus` = '1', `endTime` = '$etime'  WHERE (`qid` = 'mains');";
                $result = $connection->query($query);
                if (!$result)
                {
                    die($connection->error);
                }
                else 
                {
                    echo '<br> Mains is now stopped!!';
                }

            }
            else if ($_POST['function-type'] == 'showPrelims')
            {
                $query = "SELECT `p`.*, `u`.`fullName` AS `FN`, `u`.mailid  FROM `prelimresults` AS `p`, `users` AS `u`  WHERE (`u`.`username` = `p`.`username`) ORDER BY `p`.`score` DESC;";
                $result = $connection->query($query);
                if (!$result)
                {
                    die($connection->error);
                }
                $rows = $result->num_rows;

                echo '<h3> Prelims Result </h3>';
                echo '<table>';
                echo '<tr>';
                echo '<th>User ID</th>';
                echo '<th>Full Name</th>';
                echo '<th>Email</th>';
                echo '<th>Questions Attempted</th>';
                echo '<th>Questions Correct</th>';
                echo '<th>Question Wrong</th>';
                echo '<th>Time Taken</th>';
                echo '<th>Score</th>';
                echo '</tr>';
                for ($j = 0 ; $j < $rows ; ++$j)
                {
                    $result->data_seek($j);
                    $rowData = $result->fetch_array(MYSQLI_ASSOC);
                    echo '<tr>';
                    echo '<td>' . $rowData['username'] . '</td>' ;
                    echo '<td>' . $rowData['FN'] . '</td>' ;
                    echo '<td>' . $rowData['mailid'] . '</td>' ;
                    echo '<td>' . $rowData['pqa'] . '</td>' ;
                    echo '<td>' . $rowData['pqc'] . '</td>' ;
                    echo '<td>' . $rowData['pqw'] . '</td>' ;
                    echo '<td>' . $rowData['ptc'] . '</td>' ;
                    echo '<td>' . $rowData['score'] . '</td>' ;
                    echo '</tr>';
                }
                echo '</table>';
                $result->close();
            }
            else if ($_POST['function-type'] == 'showMains')
            {
                $query = "SELECT `m`.*, `u`.`fullName` AS `FN`, `u`.mailid  FROM `mainsresults` AS `m`, `users` AS `u`  WHERE (`u`.`username` = `m`.`username`) ORDER BY `m`.`score` DESC;";
                $result = $connection->query($query);
                if (!$result)
                {
                    die($connection->error);
                }
                $rows = $result->num_rows;

                echo '<h3> Mains Result </h3>';
                echo '<table>';
                echo '<tr>';
                echo '<th>User ID</th>' ;
                echo '<th>Full Name</th>' ;
                echo '<th>Email</th>' ;
                echo '<th>Questions Attempted</th>' ;
                echo '<th>Questions Correct</th>' ;
                echo '<th>Question Wrong</th>' ;
                echo '<th>Time Taken</th>' ;
                echo '<th>Score</th>' ;
                echo '</tr>';
                for ($j = 0 ; $j < $rows ; ++$j)
                {
                    $result->data_seek($j);
                    $rowData = $result->fetch_array(MYSQLI_ASSOC);
                    echo '<tr>';
                    echo '<td>' . $rowData['username'] . '</td>';
                    echo '<td>' . $rowData['FN'] . '</td>';
                    echo '<td>' . $rowData['mailid'] . '</td>';
                    echo '<td>' . $rowData['pqa'] . '</td>';
                    echo '<td>' . $rowData['pqc'] . '</td>';
                    echo '<td>' . $rowData['pqw'] . '</td>';
                    echo '<td>' . $rowData['ptc'] . '</td>';
                    echo '<td>' . $rowData['score'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                $result->close();
            }
            else 
            {
                echo 'option undefined!';
            }
            $connection->close();

        }
    }
    else
    {
        header("Location: ". strtok($_SERVER['HTTP_REFERER'], '?') . "?access=0");
    }
}
else {
    echo '
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Panel - TV Fandom</title>
        <link rel="shortcut icon" href="assets/img/favicon.jpg" type="image/x-icon">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>

    <body>
        <form action"admin.php" method="POST">
            <input type="password" autofocus name="pass" placeholder="Enter yoour password" required value=""/>
            <input type="submit" />
        </form>
        <script>
            var url = new URL(window.location);
            var access = url.searchParams.get("access");
            if (access == 0) {
                alert("Wrong Password");
            }
        </script>
    </body>

    </html>
    ';
}
?>