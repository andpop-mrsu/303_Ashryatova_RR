<?php
    $db = new PDO('sqlite:../data/db.db');
    $all_groups_q = "SELECT group_name from all_groups;";
    $all_groups_arr = $db->prepare($all_groups_q);
    $all_groups_arr->execute();
    $all_groups = $all_groups_arr->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Добавить студента</title>
</head>
<link rel="stylesheet" href="styles.css" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="ajax.js"></script>
<body>
<div class = "back_to_main">
        <a href="index.php">Назад</a>
</div>
<div class="refs">

    <form action = "<?php $_PHP_SELF ?>" method = "GET" onchange="checkData(this)">
    <h1 class = "newStText" >Новый студент</h1>
            <fieldset class="fieldset_class">
                <legend> Информация о студенте </legend>
                <h4>Группа:
                    <select name = "group_">
                        <?php
                            foreach($all_groups as $gr){
                                $val = $gr['group_name'];
                        ?>
                                <option><?=$val;?></option>
                        <?php
                            }
                        ?>
                    </select>
                </h4>
                <hr>
                <h4>Фамилия:
                    <input required class = "text_input" type="text" name="surname" value=""><br>
                </h4>
                <hr>
                <h4>Имя:
                    <input required class = "text_input" type="text" name="name" value=""><br>
                </h4>
                <hr>
                <h4>Отчество:
                    <input required class = "text_input" type="text" name="lastname" value=""><br>
                </h4>
                <hr>
                <h4>Пол:
                    <li><input required class="radio_b" type="radio" name="sex" value="m"> Мужской</li>
                    <li><input required class="radio_b" type="radio" name="sex" value="f"> Женский</li>
                </h4>
                <hr>
                <h4>Дата рождения:
                    <input required class = "date_birth" type="date" name="birthday" value=""><br>
                </h4>
                <hr>
                <h4>Студенческий билет:
                    <input required class = "text_input" type="text" name="student_card" value=""><br>
                </h4>
            </fieldset>
 
        <input class = "sendInfoNewStudent" type = "submit" value="Добавить"/>
    </form>
</div>
<?php
    if(isset($_GET["group_"]) && isset($_GET["surname"]) && isset($_GET["name"]) && isset($_GET["lastname"]) && isset($_GET["sex"]) && isset($_GET["birthday"]) && isset($_GET["student_card"])){
        if($_GET["sex"]=="m"){
            $sex_ = 1;
        }
        else{
            $sex_ = 0;
        }
        $direction_id = $_GET["group_"][2];
        $temp = $_GET["group_"][0];
        $ind = $db->prepare("SELECT MAX(s.id) from students as s;");
        $ind->execute();
        $res = $ind->fetchColumn();
        $ind1 = $res+1;
        $date_of_admission = (date("Y") - $temp)."-09-01";
        $new_student_q = 'INSERT INTO students (id,surname, name, lastname, date_of_birth, sex, date_of_admission, direction_id, student_card) VALUES'
                        .'(:id,:surname, :name, :lastname, :birthday, :sex, :date_of_admission, :direction_id, :student_card);';
        $ins=$db->prepare($new_student_q);
        $ins->execute([
            ':id'=> $ind1,
            ':surname' => $_GET["surname"],
            ':name' => $_GET["name"],
            ':lastname' => $_GET["lastname"], 
            ':birthday' => $_GET["birthday"], 
            ':sex' => $_GET["sex"], 
            ':date_of_admission' => $date_of_admission, 
            ':direction_id' => $direction_id,
            ':student_card' => $_GET["student_card"],
        ]);
        $gr = $_GET["group_"];
        $st_gr = 'INSERT into groups (student_id, direction) values (:student_id, :direction);';
        $pr_st_gr=$db->prepare($st_gr);
        $pr_st_gr->execute([
                ':student_id' => $ind1,
                ':direction' => $gr,
        ]);
    }
?>

</body>
</html>