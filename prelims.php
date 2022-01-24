<?php
// Start the session
date_default_timezone_set('Asia/Kolkata');

require_once 'checksession.php';
$username = "hello";
$info = checkLog($username);
session_start();
if ($info == false)
{
    function startNewSession();
}

function startNewSession () 
{
    $_SESSION['start_time']=strtotime("now");
    $_SESSION['end_time']=strtotime("now + 1min");
    $_SESSION['started']=true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TV Fandom</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <div id="login">

    </div>
    <div id="main">
        <header>
            <div class="logo">
                <h1>TV Fandom</h1>
            </div>
            <div id="countdown"></div>
        </header>
        <div class="gapdiv">
        </div>
        <main>
            <div class="questions">
                <form action="calculate.php" method="post">
                    <?php require  'q.php'?>
                    
                    <input type="submit" value="Submit" id="submit-btn">
                </form>
                <div style="clear: both"></div>
            </div>
        </main>
    </div>
    <script>
        var now = <?php echo time(); ?> ;
        var distance = 5.1 * 60 * 1000;
        var x = setInterval(function () {

            // Get today's date and time

            // Find the distance between now and the count down date
            //console.log(distance);
            // Time calculations for days, hours, minutes and seconds
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            distance = distance - 1000;
            // Output the result in an element with id="demo"
            document.getElementById("countdown").innerText = "Time Left: " + minutes + "m " + seconds + "s ";
            if (distance < 600000)
                document.getElementById("countdown").classList.add('countdown-shadow-10min');
            if (distance < 300000)
                document.getElementById("countdown").classList.add('countdown-shadow-5min');
                //document.getElementById("countdown").style.color = 'rgb(211, 12, 12)';
            document.getElementById("countdown").style.fontSize = 'larger';

            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerText += "EXPIRED";
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
        }, 1000);

        function resetRadio(e){
            let v = e.getAttribute('name');
            let c = document.getElementsByName(v);
            for (var i = 0 ; i < c.length; i++)
            c[i].checked = false;
        }
    </script>
</body>

</html>