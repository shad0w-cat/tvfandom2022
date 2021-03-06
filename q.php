<?php
function prelim()
{
    require 'login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($connection->connect_error) die($connection->connect_error);

    $query = "SELECT `qno`, `question`, `options`, `image`, `imgloc` FROM `prelimques`;";
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
        echo '<div class="question">';
        if ($rowData['image'] == 1)
        echo '<img class="question-img" src="https://drive.google.com/uc?export=view&id=' . $rowData['imgloc'] . '"/>';
        echo '<h4> <span>Question ' . $j+1 . '</span></h4>';
        echo '<p class="question-text">' . trim($rowData['question']) . '</p>';
        //echo '<input type="hidden" class="qno-input" name="qno" value="' . $rowData['qno'] . '">';
        //echo '<iframe src="https://drive.google.com/file/d/1ZIUG8EhjEQoSOVYQWdZavDwjzFxqfHFW/preview" width="640" height="480" allow="autoplay"></iframe>';

        echo '<hr>';
        echo '<br>';
        echo '<br>';
        $i = 0;
        foreach (explode(",",$rowData['options']) as $opt)
        {
            $i++;
            echo '<input type="radio" class="options" id="Q' . $j+1 . 'Opt' . $i . '" name="option'. $j+1 .'" value="' . trim($opt) . '">';
            echo '<label class="option-labels" for="Q' . $j+1 . 'Opt' . $i . '"><span></span>' . trim($opt) . ' </label><br>';
        }
        echo '<button type="button" name="option' . $j+1 . '"class="reset-btn" onClick=resetRadio(this)>Clear</button>';
        echo '<div style="clear: both"></div>';
        echo '</div>';
    }
    $result->close();
    $connection->close();
}

function mains()
{
    require 'login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($connection->connect_error) die($connection->connect_error);

    $query = "SELECT `mqno`, `question`, `qtype`, `qres`, `qresloc`, `options` FROM `mainsques`;";
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
        echo '<div class="question">';
        if ($rowData['qres'] == 'image')
            echo '<img class="question-img" src="https://drive.google.com/uc?export=view&id=' . $rowData['qresloc'] . '"/>';
        if ($rowData['qres'] == 'audio')
            echo '<audio class="question-img" src="https://drive.google.com/uc?export=view&id=' . $rowData['qresloc'] . '" controls></audio>';
        if ($rowData['qres'] == 'video')
            echo '<video class="question-img" src="https://drive.google.com/uc?export=view&id=' . $rowData['qresloc'] . '" controls></video>';
        echo '<h4>  <span class="particletext">Question ' . $j+1 . '</span></h4>';
        echo '<p class="question-text">' . trim($rowData['question']) . '</p>';
        //echo '<input type="hidden" class="qno-input" name="qno" value="' . $rowData['qno'] . '">';
        //echo '<iframe src="https://drive.google.com/file/d/1ZIUG8EhjEQoSOVYQWdZavDwjzFxqfHFW/preview" width="640" height="480" allow="autoplay"></iframe>';

        echo '<hr>';
        echo '<br>';
        echo '<br>';
        if ($rowData['qtype'] == 'MCQ')
        {
            $i = 0;
            foreach (explode(",",$rowData['options']) as $opt)
            {
                $i++;
                echo '<input type="radio" class="options" id="Q' . $j+1 . 'Opt' . $i . '" name="option'. $j+1 .'" value="' . trim($opt) . '">';
                echo '<label class="option-labels" for="Q' . $j+1 . 'Opt' . $i . '"><span></span>' . trim($opt) . ' </label><br>';
            }
            echo '<button type="button" name="option' . $j+1 . '" class="reset-btn" onClick="resetRadio(this)"> Clear </button>';
            echo '<div style="clear: both"></div>';
        }
        if ($rowData['qtype'] == 'TITA')
        {
            echo '<label class="option-labels" for="Q' . $j+1 . 'tita">Answer: <span>[For multiple answers use comma (,) to seperate them]</span></label><br>';
            echo '<input type="text" class="tita" id="Q' . $j+1 . 'tita" name="tita'. $j+1 .'" placeholder="Type your answer here"><br>';
            echo '<button type="button" name="tita' . $j+1 . '" class="reset-btn" onClick="resetRadio(this)"> Clear </button>';
            echo '<div style="clear: both"></div>';
        }
        
        echo '</div>';
    }
    $result->close();
    $connection->close();
}
?>