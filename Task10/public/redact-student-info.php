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
    <title>Редактировать данные студента</title>
</head>
<link rel="stylesheet" href="images/styles.css" type="text/css" />
<body background="images/background_image.png" id="redactPage">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="ajax.js"></script>
<script src="check.input.data.js"></script>
<a class="submit" href="index.php">Назад</a>
<form class="add_new_student" method="post" onchange="checkDataStudent(this)">
    <h1>Редактировать данные студента</h1>
    <label style="display: none" name="studentId"><?=$_GET['studentId'];?></label>
    <label>Группа:
        <select name = "group">
            <?php
            $all_groups = getAllGroups();
            foreach ($all_groups as $group){
                if($group['g']!=$groupStudent['direction']){
                ?>
                <option><?=$group['g'];?></option>
                <?php
                }else{
                    ?>
                    <option selected><?=$group['g'];?></option>
                    <?php
                }
            }
            ?>
        </select>
    </label>
    <hr>
    <label>Фамилия:
        <input required type="text" name="surname" value="<?=$student['surname'];?>"><br>
    </label>
    <hr>
    <label>Имя:
        <input required type="text" name="name" value="<?=$student['name'];?>"><br>
    </label>
    <hr>
    <label>Отчество:
        <input required type="text" name="lastname" value="<?=$student['lastname'];?>"><br>
    </label>
    <hr>
    <label>Пол:
        <?php
        if($student['sex'] == 'm'){?>
            <li><input class="radio_b" type="radio" name="sex" value="m" checked> Мужской</li>
            <li><input class="radio_b" type="radio" name="sex" value="f"> Женский</li>
        <?php
        }else{?>
            <li><input class="radio_b" type="radio" name="sex" value="m"> Мужской</li>
            <li><input class="radio_b" type="radio" name="sex" value="f" checked> Женский</li>
        <?php
        }
        ?>
    </label>
    <hr>
    <label>Дата рождения:
        <input required class = "date_birth" type="date" name="birthday" value="<?=$student['date_of_birth'];?>"><br>
    </label>
    <hr>
    <label>Студенческий билет:
        <input required type="text" name="student_card" value="<?=$student['student_card'];?>"><br>
    </label>
    <hr>
    <input class="submit" type = "submit" value="Изменить"/>
</form>
</body>
</html>

<?php
if(!empty($_POST)){
    redactStudentInfo();
}
?>
