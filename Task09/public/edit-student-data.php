<?php
    $db = new PDO('sqlite:../data/db.db');
    $all_groups_q = "SELECT group_name from all_groups;";
    $all_groups_arr = $db->prepare($all_groups_q);
    $all_groups_arr->execute();
    $all_groups = $all_groups_arr->fetchAll(PDO::FETCH_ASSOC);
    $student_data="";
    $st_id = "";
    $group = "";
    $surname = "";
    $name = "";
    $lastname = "";
    $date_of_birth = "";
    $sex = "";
    $date_of_admission = "";
    $direction_id = "";
    $student_card = "";
    if(isset($_REQUEST['id']) && isset($_REQUEST['group'])){
        $id = $_REQUEST['id'];
        $get_student_id = "SELECT id, surname, name, lastname, date_of_birth, sex, date_of_admission, direction_id, student_card from students where id = '$id';";
        $st_g1 = $db->prepare($get_student_id);
        $st_g1->execute();    
        $student_data = $st_g1->fetchAll(PDO::FETCH_ASSOC);
        $st_id = $student_data[0]['id'];
        $group = $_REQUEST['group'];
        $surname = $student_data[0]['surname'];
        $name = $student_data[0]['name'];
        $lastname = $student_data[0]['lastname'];
        $date_of_birth = $student_data[0]['date_of_birth'];
        $sex = $student_data[0]['sex'];
        $date_of_admission = $student_data[0]['date_of_admission'];
        $direction_id = $student_data[0]['direction_id'];
        $student_card = $student_data[0]['student_card'];
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Редактировать данные студента</title>
</head>
<link rel="stylesheet" href="styles.css" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="ajax.js"></script>
<body id="body1">
<div class = "back_to_main">
        <a href="index.php">Назад</a>
</div>
<div class="refs">

    <form action = "<?php $_PHP_SELF ?>" method = "get">
    <h1 class = "newStText" >Редактировать данные студента</h1>
            <fieldset class="fieldset_class">
                <legend> Информация о студенте </legend>
                <input type="hidden" name="st_id" value="<?=$st_id;?>">
                <h4>Группа:
                    <select name = "group_">
                        <?php
                            foreach($all_groups as $gr){
                                $val = $gr['group_name'];
                                if($val!=$group){
                        ?>
                                <option><?=$val;?></option>
                        <?php
                                }
                                else{
                                    ?>
                                    <option selected><?=$val;?></option>
                                    <?php
                            }
                        }
                        ?>
                    </select>
                </h4>
                <hr>
                <h4>Фамилия:
                    <input required class = "text_input" type="text" name="surname" value=<?=$surname;?>><br>
                </h4>
                <hr>
                <h4>Имя:
                    <input required class = "text_input" type="text" name="name" value=<?=$name;?>><br>
                </h4>
                <hr>
                <h4>Отчество:
                    <input required class = "text_input" type="text" name="lastname" value=<?=$lastname;?>><br>
                </h4>
                <hr>
                <h4>Дата рождения:
                    <input required class = "date_birth" type="date" name="birthday" value=<?=$date_of_birth;?>><br>
                </h4>
                <hr>
                <h4>Студенческий билет:
                    <input required class = "text_input" type="text" name="student_card" value=<?=$student_card;?>><br>
                </h4>
            </fieldset>
 
        <input class = "sendInfoNewStudent" type = "submit" value="Изменить"/>
    </form>
</div>

<?php
    
    if(isset($_REQUEST['st_id']) && isset($_GET["group_"]) && isset($_GET["surname"]) && isset($_GET["name"]) && isset($_GET["lastname"]) && isset($_GET["birthday"]) && isset($_GET["student_card"])){
        $direction_id = $_GET["group_"][2];
        $temp = $_GET["group_"][0];
        $date_of_admission = (date("Y") - $temp)."-09-01";
        $st_id = $_REQUEST['st_id'];
        $surname = $_GET["surname"];
        $name = $_GET["name"];
        $lastname = $_GET["lastname"];
        $birthday = $_GET["birthday"]; 
        $student_card = $_GET["student_card"];
        $new_student_q = "UPDATE students SET surname = :surname, name = :name, lastname = :lastname, date_of_birth = :birthday, date_of_admission = :date_of_admission, direction_id = :direction_id, student_card = :student_card WHERE id = '$st_id';";
        $ins=$db->prepare($new_student_q);
        $ins->bindValue(':surname', $surname);
        $ins->bindValue(':name', $name);
        $ins->bindValue(':lastname', $lastname);
        $ins->bindValue(':birthday', $birthday);
        $ins->bindValue(':date_of_admission', $date_of_admission);
        $ins->bindValue(':direction_id', $direction_id);
        $ins->bindValue(':student_card', $student_card);
        $ins->execute();
        $gr = $_GET["group_"];
        $st_gr = "UPDATE groups SET student_id = :student_id, direction = :direction where student_id = '$st_id';";
        $pr_st_gr=$db->prepare($st_gr);

        $pr_st_gr->execute([
                ':student_id' => $st_id,
                ':direction' => $gr,
        ]);
        ?>
        <script>
        document.location.href = "/index.php"; 
        </script>
        <?php     
    }
?>

</body>
</html>