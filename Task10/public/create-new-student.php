<?php
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Новый студент</title>
</head>
<link rel="stylesheet" href="images/styles.css" type="text/css" />
<body background="images/background_image.png">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="check.input.data.js"></script>
<a class="submit" href="index.php">Назад</a>
<form class="add_new_student" method="post" onchange="checkDataStudent(this)">
    <h1>Новый студент</h1>
        <label>Группа:
            <select name = "group">
                <?php
                $all_groups = getAllGroups();
                foreach ($all_groups as $group){
                    ?>
                    <option><?=$group['g'];?></option>
                <?php
                }
                ?>
            </select>
        </label>
        <hr>
        <label>Фамилия:
            <input required type="text" name="surname" value=""><br>
        </label>
        <hr>
        <label>Имя:
            <input required type="text" name="name" value=""><br>
        </label>
        <hr>
        <label>Отчество:
            <input required type="text" name="lastname" value=""><br>
        </label>
        <hr>
        <label>Пол:
            <li><input required class="radio_b" type="radio" name="sex" value="m"> Мужской</li>
            <li><input required class="radio_b" type="radio" name="sex" value="f"> Женский</li>
        </label>
        <hr>
        <label>Дата рождения:
            <input required class = "date_birth" type="date" name="birthday" value=""><br>
        </label>
        <hr>
        <label>Студенческий билет:
            <input required type="text" name="student_card" value=""><br>
        </label>
        <hr>
    <input class="submit" type = "submit" value="Добавить"/>
</form>
</body>
</html>

<?php
    if(!empty($_POST)){
        addNewStudentToDataBase();
        header("location: index.php");
    }
?>
