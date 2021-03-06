<?php
// Start the session
session_start();
date_default_timezone_set('Asia/Kolkata');
require 'logincheck.php';
if($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    header("Location: index.html?access=3");   
}
else if (!loginCheck($_POST))
{
    header("Location: index.html?access=8xc");   
}
else 
{
    require 'checkquizstatus.php';
    $status = checkStatus('prelim');
    if ($status[0] == 0)
    {
        header("Location: index.html?access=1");
    }
    else if ($status[1] == 1)
    {
        header("Location: index.html?access=2");
    }
    else 
    {
        require_once 'sessions.php';
        $username = $_POST['username'];
        $info = checkLog($username, 'prelim');
        if ($info == false)
        {
            startNewSession();
        }
        else 
        {
            $_SESSION['qname']='prelims';
            $_SESSION['start_time']=$info[0];
            $_SESSION['end_time']=$info[1];
            $_SESSION['qended']=$info[3];
            $_SESSION['username']=$_POST['username'];
            
            if ($_SESSION['qended']==1 || strtotime($_SESSION['end_time']) < strtotime("now"))
            {
                header("Location: ". strtok($_SERVER['HTTP_REFERER'], '?') . "?access=0");
            }
        }
    }
}

function startNewSession() 
{
    $timeLimit= quizEndTime('prelim');
    $_SESSION['qname']='prelims';
    $_SESSION['start_time']=date('H:i:s', strtotime("now"));
    $_SESSION['end_time']=date("H:i:s", strtotime("now " . $timeLimit . "min"));
    $_SESSION['username']=$_POST['username'];
    addNewSession($_SESSION, 'prelim');
    /*echo $_SESSION['server_end'];*/
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="assets/font/stylesheet.css" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prelims - TV Fandom</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="shortcut icon" href="assets/img/favicon.jpg" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@100;200;300;400;500;600;900&display=swap" rel="stylesheet">
</head>

<body style="background: none;">
    <div id="main">
        <header>
            <div class="logo">
                <h1>TV Fandom</h1>
            </div>
            <div id="countdown" class="countdown-shadow"></div>
            <div style="clear: both"></div>

        </header>
        <!-- <div class="gapdiv"> -->
        </div>
        <main>
            <div class="questions">
                <form action="calculate.php" method="post" id="quiz-form">
                    <?php 
                    require  'q.php';
                    prelim();
                    ?>
                    
                    <input type="submit" value="Submit" id="submit-btn">
                </form>
                <div style="clear: both"></div>
            </div>
        </main>
    </div>
    <script>
        var now = <?php echo strtotime('now'); ?> ;
        var distance = <?php echo strtotime($_SESSION['end_time']); ?> - now + 1;
        console.log(distance);
        var x = setInterval(function () {

            // Get today's date and time

            // Find the distance between now and the count down date
            // console.log(distance);
            // Time calculations for days, hours, minutes and seconds
            var minutes = Math.floor((distance % (60 * 60)) / (60));
            var seconds = Math.floor((distance % (60)));
            // Output the result in an element with id="demo"
            document.getElementById("countdown").innerText = "Time Left: " + minutes + "m " + seconds + "s ";
            if (distance < 600)
            {
                document.getElementById("countdown").classList.remove('countdown-shadow');
                document.getElementById("countdown").classList.add('countdown-shadow-10min');
            }
            if (distance < 300)
            {
                document.getElementById("countdown").classList.remove('countdown-shadow-10min');
                document.getElementById("countdown").classList.add('countdown-shadow-5min');
            }
                //document.getElementById("countdown").style.color = 'rgb(211, 12, 12)';
            /*document.getElementById("countdown").style.fontSize = 'larger';*/

            // If the count down is over, write some text 
            if (distance <= 0) {
                clearInterval(x);
                // document.getElementById("countdown").innerText = "EXPIRED";
                document.forms["quiz-form"].submit();
            }
            
            <?php
            // $s = strtotime("now");
            //     echo 'console.log("' . $s . '" , "' . $_SESSION['end_time'] . '")' ;

            // if ($_SESSION['end_time']<time())
            // {
            //     echo 'document.getElementById("submit-btn").click()';
            //     echo 'console.log(' .time() . ' == ' . $_SESSION['end_time'] . ')' ;
            // }
            ?>
            distance = distance-1;
        }, 1000);

        function resetRadio(e){
            let v = e.getAttribute('name');
            let c = document.getElementsByName(v);
            for (var i = 0 ; i < c.length; i++)
            c[i].checked = false;
        }


        function random(min,max) {
            const num = Math.floor(Math.random()*(max-min)) + min;
            return num;
        }
        function randomColor() {
            return 'rgb(' + random(0, 255) + ', ' + random(0, 255) + ', ' + random(0, 255) + ')';
        }
        let radioColor;
        let shadowColor;
        

        const stylesheet = document.styleSheets[1];
        for (let i = 0; i < stylesheet.cssRules.length; i++) {
            if (stylesheet.cssRules[i].selectorText === 'input[type="radio"]:checked + label') {
                //console.log("f");
                shadowColor = stylesheet.cssRules[i];
            }
            else if (stylesheet.cssRules[i].selectorText === 'input[type="radio"]:checked::after')
            {
                //console.log("f");
                radioColor = stylesheet.cssRules[i];
            }
            //else
            //console.log(stylesheet.cssRules[i]);
        }

        function setRandomColor() {
            colorR = randomColor();
            const shadow = '1px 1px 6px ' + colorR;
            const border = '6px solid ' + colorR;
            shadowColor.style.setProperty('text-shadow', shadow);
            radioColor.style.setProperty('border', border)
        }

        $(document).ready(function () {
            $('input[type=radio]').on('change', setRandomColor);
        });
    </script>
</body>

</html>