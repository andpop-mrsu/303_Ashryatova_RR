<?php
include 'functions.php';
$selectedGroup = "Все группы";
if(isset($_POST['group'])){
    $selectedGroup = $_POST['group'];
    ?>
    <script>document.getElementById("group").value = <?=$selectedGroup;?>;</script>
    <?php
}
$all_students = getAllStudents($selectedGroup);
$all_groups = getAllExistGroups();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Студенты</title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="ajax.js"></script>
<link rel="stylesheet" href="images/styles.css" type="text/css" />
<body id="main_page" background="images/background_image.png">
<div>
    <h1 style=" margin-left: 1%; margin-bottom: -1%;"> Студенты </h1>
</div>
<div>
    <h4> Группа:
        <select id="group" onchange="selectGroupInTable(this)">
            <option>Все группы</option>
            <?php
            foreach ($all_groups as $group){
                ?>
                <option><?=$group['g'];?></option>
                <?php
            }
            ?>
        </select>
    </h4>
    <table>
        <tr>
            <th style="display: none"></th>
            <th>Группа</th>
            <th>Направление подготовки</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Пол</th>
            <th>Дата рождения</th>
            <th>Студенческий билет</th>
            <th> </th>
        </tr>
        <?php createTableForStudentsData($all_students);?>
    </table>
</div>
<a class="submit" href="create-new-student.php">Добавить студента</a>
<?php
    if(isset($_POST['deleteStudentId'])){
        $student = RB::findOne('students', 'id=?', [$_POST['deleteStudentId']]);
        $snl = $student['surname']." ".$student['name']." ".$student['lastname'];
        ?>
        <div class="confirmation">
            <label style="visibility: hidden" id="deleteStudent"><?=$_POST['deleteStudentId'];?></label>
            <label>Удалить студента <?=$snl;?>?</label><br>
            <input class="submit" type="submit"
                   style="background: #ff6666;" value="Удалить" onclick="deleteStudent_()">
            <input class="submit" type="button" value="Отмена" onclick="location.reload()">
        </div>
        <?php
    }
    if(isset($_POST['deleteStudent'])){
        deleteStudentFromDataBase();
        ?>
        <script>location.reload();</script>
    <?php
    }
    ?>

</body>
</html>

