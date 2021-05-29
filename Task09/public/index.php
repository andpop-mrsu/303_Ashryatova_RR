<?php
    $db = new PDO('sqlite:../data/db.db');
    $sql_q = "SELECT students.id as id, groups.direction AS g, 
        directions.direction as dir, 
        students.surname as f,
        students.name as n, 
        students.lastname as l, case when
        students.sex == 'm' then 'м' else 'ж' end as s,  
        students.date_of_birth as b,
        student_card as c from groups join students on students.id = groups.student_id
        join directions on students.direction_id = directions.id
        order by groups.direction, students.surname;";

    $st = $db->prepare($sql_q);
    $st->execute();
    $all_students = $st->fetchAll(PDO::FETCH_ASSOC);
    $sql_gr = 'SELECT distinct direction as dir from groups order by direction;';
    $gr = $db->prepare($sql_gr);
    $gr->execute();
    $res = $gr->fetchAll(PDO::FETCH_ASSOC);
    $array_groups = array();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Студенты</title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="ajax.js"></script>
<link rel="stylesheet" href="styles.css" type="text/css" />
<body id="body">

<form method="get" action = "<?php $_PHP_SELF ?>" id="form" onchange="changeGroup(this)">
<h1 class = "newStText1" >Студенты
    <select name = "group" id ="group" class="group" >
        <option>Все группы</option>
            <?php
                if(!isset($_REQUEST['group'])){
                    $_REQUEST['group'] = "Все группы";
                }
                foreach($res as $res_string){
                    array_push($array_groups, $res_string['dir']);
                    $groups = $res_string['dir'];
                    if(isset($_REQUEST['group'])){    
                            if($groups == $_REQUEST['group']){
                        ?>
                            <option selected><?=$groups;?></option>
                        <?php
                            }
                            else{
                        ?>
                        <option><?=$groups;?></option>
                        <?php
                            }
                        }
                        else{
                            ?>
                        <option><?=$groups;?></option>
                        <?php
                        }
                }
                ?>
    </select></h1><hr class="hrAllST">
</form>
<?php
    if(isset($_REQUEST['group'])){
        $gru = $_REQUEST['group'];
        ?>
        <table class="tableST" id="table" name="table">
        
        <tbody class="tbodyST" id="tbody">     
            <tr class="trST">
                <td style="visibility: hidden;"></td>
                <td class="tdST">Группа</td>
                <td class="tdST">Направление подготовки</td>
                <td class="tdST">Фамилия</td>
                <td class="tdST">Имя</td>
                <td class="tdST">Отчество</td>
                <td class="tdST">Пол</td>
                <td class="tdST">Дата рождения</td>
                <td class="tdST">Студенческий билет</td>
                <td class="tdST">Редактировать</td>
                <td class="tdST">Удалить</td>
                <td class="tdST">Результаты экзаменов</td>
            </tr>
        
        <?php
        if($gru!="Все группы"){
            $sql_find_students = "SELECT students.id as id, groups.direction AS g, 
                    directions.direction as dir, 
                    students.surname as f,
                    students.name as n, 
                    students.lastname as l, case when
                    students.sex == 'm' then 'м' else 'ж' end as s, 
                    students.date_of_birth as b,
                    student_card as c from groups
                    join students on students.id = groups.student_id
                    join directions on students.direction_id = directions.id
                    where g = '$gru' order by f;";
            $st_gr = $db->prepare($sql_find_students);
            $st_gr->execute();
            $results_st_gr = $st_gr->fetchAll(PDO::FETCH_ASSOC);
            foreach($results_st_gr as $res_string){
                $value0 = $res_string['id'];
                $value1 = $res_string['g'];
                $value2 = $res_string['dir'];
                $value3 = $res_string['f'];
                $value4 = $res_string['n'];
                $value5 = $res_string['l'];
                $value6 = $res_string['s'];
                $value7 = $res_string['b'];
                $value8 = $res_string['c'];
            ?>
            <tr class="trST2" id="tr_id">
                <td style="visibility: hidden;"><?=$value0;?></td>
                <td class="tdST2"><?=$value1;?></td>
                <td class="tdST2"><?=$value2;?></td>
                <td class="tdST2"><?=$value3;?></td>
                <td class="tdST2"><?=$value4;?></td>
                <td class="tdST2"><?=$value5;?></td>
                <td class="tdST2"><?=$value6;?></td>
                <td class="tdST2"><?=$value7;?></td>
                <td class="tdST2" name="td" id="td"><?=$value8;?></td>
                <td class="tdST2" id="td_id2"><a class="red" name="redact" id="redact" onclick="redactEntry(this)"><u>Редактировать</u></a></td>
                <td class="tdST2" id="td_id"><a class="red" name="del" id="del" onclick="deleteEntry(this)"><u>Удалить</u></a></td>
                <td class="tdST2"><a class="red" onclick="sessionResults(this)"><u>Результаты экзаменов</u></a></td>
            </tr></tbody>
            <?php
                }
            ?>
            
        </table>
        <?php
        }
        else{

                foreach($all_students as $res_string){
                    $value0 = $res_string['id'];
                    $value1 = $res_string['g'];
                    $value2 = $res_string['dir'];
                    $value3 = $res_string['f'];
                    $value4 = $res_string['n'];
                    $value5 = $res_string['l'];
                    $value6 = $res_string['s'];
                    $value7 = $res_string['b'];
                    $value8 = $res_string['c'];
                ?>
            <tr class="trST2" id="tr_id">
                <td style="visibility: hidden;" id="stud_id"><?=$value0;?></td>
                <td class="tdST2"><?=$value1;?></td>
                <td class="tdST2"><?=$value2;?></td>
                <td class="tdST2"><?=$value3;?></td>
                <td class="tdST2"><?=$value4;?></td>
                <td class="tdST2"><?=$value5;?></td>
                <td class="tdST2"><?=$value6;?></td>
                <td class="tdST2"><?=$value7;?></td>
                <td class="tdST2" name="td_" id="td_"><?=$value8;?></td>
                <td class="tdST2" id="td_id2"><a class="red" name="redact" id="redact" onclick="redactEntry(this)"><u>Редактировать</u></a></td>
                <td class="tdST2" id="td_id"><a class="red" name="del" id="del" onclick="deleteEntry(this)"><u>Удалить</u></a></td>
                <td class="tdST2"><a class="red" onclick="sessionResults(this)"><u>Результаты экзаменов</u></a></td>
            </tr>
            <?php
                }
            ?>
            </tbody>
        </table>
        <?php
        }
    }
?>
<div style="padding: 30px 55px">
        <a class="top_a" href="newStudent.php">Добавить</a>
</div>

<?php
    if(isset($_REQUEST['delete']) && isset($_REQUEST['student'])){?>
        <div class="modal">
        <div class="modal__content">
            <h1 class="modal__title">Удалить студента <?=$_REQUEST['student'];?>?</h1>
            <hr>
        </div>
        <input type="submit" style="background-color: rgb(255, 162, 162);" value="Отмена" onclick="closeWin1(this)"/>
        <input type="submit" style="background-color: rgb(77, 255, 100);" value="Да" onclick="deleteST(this)"/>
        </div><?php
    }
    if(isset($_REQUEST['delete_']))
    {
        $id = $_REQUEST['delete_'];

        $sql_delete_student = "DELETE from students where id = '$id';";
        $st_gr2 = $db->prepare($sql_delete_student);
        $st_gr2->execute();
    
        $sql_delete_sessions_results = "DELETE from session_results where student_id = '$id';";
        $st_gr3 = $db->prepare($sql_delete_sessions_results);
        $st_gr3->execute();

        $sql_delete_groups = "DELETE from groups where student_id = '$id';";
        $st_gr3 = $db->prepare($sql_delete_groups);
        $st_gr3->execute();
    }
?>

</body>
</html>