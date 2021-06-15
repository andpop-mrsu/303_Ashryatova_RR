<?php
include 'functions.php';
$student = "";
$groupStudent= "";
$subjects = [];
if(isset($_REQUEST['studentId'])){
    $student = RB::findOne('students', 'id=?', [$_REQUEST['studentId']]);
    $groupStudent = RB::findOne('groups','student_id=?',[$_REQUEST['studentId']]);
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Новый результат сессии</title>
</head>
<link rel="stylesheet" href="images/styles.css" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="ajax.js"></script>
<script src="check.input.data.js"></script>
<body background="images/background_image.png" id="new_session_result">
<a class="submit" href="sessions-results.php?studentId=<?=$_REQUEST['studentId'];?>">Назад</a>

<form class="add_new_student" style="width: 700px" method="post">
    <h1 style="margin-bottom: -3%">Новый результат сессии</h1>
    <label style="visibility: hidden" id="studentId"><?=$_REQUEST['studentId'];?></label><hr>
    <label>Студент: <?=$student['surname']." ".$student['name']." ".$student['lastname'];?> </label><hr>
    <label>Группа: <?=$groupStudent['direction'];?> </label><hr>
    <label>
        Курс:
            <?php course($groupStudent); ?>
    </label>
    <hr>
    <label>
        Семестр:
        <?php semester(); ?>
    </label>
    <hr>
    <label>
        Предмет:
        <select onchange="newSessionResult()" id="subject" name="subject">
            <option>Выбрать</option>
            <?php
            if(isset($_POST['course']) && isset($_POST['semester'])){

                $subjects = getSubjects($groupStudent['direction']);

            }?>
        </select>
    </label>
    <hr>
    <label>
        Количество баллов:
        <input required type="text" value="" name="points" id="points" onchange="checkValuePoints()"></label>
    </label>
    <hr>
    <input class="submit" type="submit" id="add_button" value="Добавить" onclick="sendData()">
</form></body></html>

<?php
    if(isset($_POST['subject_id']) && isset($_POST['studentId']) && isset($_POST['points'])){
        addNewSessionResult($subjects[$_POST['subject_id']-1]);
        ?>
        <script>
            document.location.href = 'sessions-results.php?studentId='+<?=$_REQUEST['studentId'];?>;
        </script>
<?php

    }?>