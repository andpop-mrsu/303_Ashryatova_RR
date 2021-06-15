<?php
include 'functions.php';
$student = "";
$groupStudent= "";
if(isset($_GET['studentId'])){
    $student = RB::findOne('students', 'id=?', [$_GET['studentId']]);
    $groupStudent = RB::findOne('groups','student_id=?',[$_GET['studentId']]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Результаты сессий</title>
</head>
<link rel="stylesheet" href="images/styles.css" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="ajax.js"></script>
<body background="images/background_image.png" id="session_result">
<a class="submit" href="index.php">Назад</a>

<h1 style=" margin-left: 10%; margin-bottom: -3%;"> Результаты сессий </h1>

<div style="padding: 1% 0 0 10%;">
    <label style="visibility: hidden" id="studentId"><?=$_GET['studentId'];?></label>
    <hr>
    <label style="font-size: 20px">Студент: <?=$student['surname']." ".$student['name']." ".$student['lastname'];?></label>
    <hr>
    <label style="font-size: 20px">Группа: <?=$groupStudent['direction'];?></label>
</div>

<div style="padding: 1% 0 0 8%;">
    <table style="border: none">
        <tr>
            <th style="visibility: hidden;"></th>
            <th>Курс</th>
            <th>Предмет</th>
            <th>Баллы</th>
            <th> </th>
        </tr>
        <?php
        sessionResults();
        ?>
    </table>
    <hr>
    <hr>
    <hr>
    <a class="submit" onclick="newSessionResultID()">Добавить</a>
</div>

</body>
</html>
<?php
if(isset($_POST['deleteSessionResultId'])){
    $subject_id = RB::findOne('sessionresults', 'id=?', [$_POST['deleteSessionResultId']]);
    $subject = RB::findOne('subjects', 'id=?',[$subject_id['subject_id']]);

    ?>
    <div class="confirmation">
        <label style="visibility: hidden" id="deleteSessionResultId"><?=$_POST['deleteSessionResultId'];?></label>
        <label>Удалить результат сессии по предмету "<?=$subject['subject'];?>"?</label><br>
        <input class="submit" type="submit"
               style="background: #ff6666;" value="Удалить" onclick="deleteSessionResult_()">
        <input class="submit" type="button" value="Отмена" onclick="location.reload()">
    </div>
    <?php
}
if(isset($_POST['deleteSessionResult'])){
    deleteSessionResult();
    ?>
    <script>location.reload();</script>
    <?php
}

if(isset($_POST['edit_session_result'])){
    $subject_id = RB::findOne('sessionresults', 'id=?', [$_POST['edit_session_result']]);
    $subject = RB::findOne('subjects', 'id=?',[$subject_id['subject_id']]);
    ?>
    <div class="confirmation">
        <label style="visibility: hidden" id="updateSessionResult" name="updateSessionResults"><?=$_POST['edit_session_result'];?></label>
        <label>Редактировать результат сессии по предмету "<?=$subject['subject'];?>"?</label><br>
        <label> Количество баллов
            <input type="text" value="<?=$subject_id['points'];?>" id="points" name="points"></label>
        <input class="submit" type="submit"
               style="background: #a3d04c;" value="Изменить" onclick="updateSessionResult()">
        <input class="submit" type="button" value="Отмена" onclick="location.reload()">
    </div>
<?php
}

if(isset($_POST['updateSessionResultId']) && isset($_POST['points'])){
    updateSessionResults();
?>
    <script>location.reload();</script>
<?php
}
?>