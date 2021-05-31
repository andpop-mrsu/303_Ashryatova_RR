<?php
    $db = new PDO('sqlite:../data/db.db');
    $student = "";
    $student_id = "";
    if(isset($_REQUEST['id']) && isset($_REQUEST['group'])){
        $query = 'SELECT id, surname, name, lastname from students where id="'.$_REQUEST['id'].'";';
        $res = $db->prepare($query);
        $res->execute();
        $student = $res->fetchAll(PDO::FETCH_ASSOC);
        $student_id = $student[0]['id'];
        $student = $student[0]['surname']." ".$student[0]['name']." ".$student[0]['lastname'];
    }
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
<body id="body2">
<div>
        <a class="but" href="index.php">Назад</a>
</div>
<div>
<label id="st_id" style="visibility: hidden;"><?=$student_id;?></label>
<form method="get" action = "<?php $_PHP_SELF ?>" id="form" onchange="changeGroupSessions(this)">
<h1 class = "newStText1" >Результаты экзаменов</h1>
<hr class="ses1">
    <h4>Студент: 
        <label><?=$student;?></label>
    </h4>
    <h4>Группа: 
        <?php if(isset($_REQUEST['group'])){?>
        <label id="gr"><?=$_REQUEST['group'];?></label>
        <?php
        }
        ?>
    </h4>
</form>
<hr class="seshr">
        <table class="tableST">
            <tbody class="tbodyST">
                <tr class="trST">
                    <td style="visibility: hidden;"></td>
                    <td class="tdST">Курс</td>
                    <td class="tdST">Предмет</td>
                    <td class="tdST">Баллы</td>
                    <td class="tdST">Редактировать</td>
                    <td class="tdST">Удалить</td>
                </tr>
            
        <?php
        $directon = "";
        $course = "";
        if(isset($_REQUEST['group'])){
        $directon = $_REQUEST['group'][2];
        $course = $_REQUEST['group'][0];
        }
        $subjects_query = "SELECT sr.id as i, `subject` as s, sr.points as p, su.course as c from subjects as su join session_results as sr on sr.student_id = '$student_id' where sr.subject_id = su.id order by c;";
        $sub = $db->prepare($subjects_query);
        $sub->execute();
        $subject = $sub->fetchAll(PDO::FETCH_ASSOC);
        foreach($subject as $subj){            
            ?>     

            <tr class="trST2">
                <td style="visibility: hidden;" id="ent_id"><?=$subj['i'];?></td>
                <td class="tdST2"><?=$subj['c'];?></td>
                <td class="tdST2"><?=$subj['s'];?></td>
                <td class="tdST2"><?=$subj['p'];?></td>
                <td class="tdST2"><a class="red" onclick="redactSessionResult(this)"><u>Редактировать<u></a></td>
                <td class="tdST2"><a class="red" onclick="deleteSessionResult(this)"><u>Удалить<u></a></td>
            </tr>
            <?php
        }
        ?>
            </tbody>
        </table>
        
</div>
<?php
    if(isset($_REQUEST['delete'])){?>
        <label style="visibility: hidden;" id="id_student"><?=$_REQUEST['id'];?></label>
        <label style="visibility: hidden;" id="group"><?=$_REQUEST['group'];?></label>
        <div class="modal">
        <div class="modal__content">
            <h1 class="modal__title">Удалить результат сессии по предмету "<?=$_REQUEST['subject'];?>"?</h1>
            <hr>
        </div>
        <input type="submit" style="background-color: rgb(255, 162, 162);" value="Отмена" onclick="closeWin1(this)"/>
        <input type="submit" style="background-color: rgb(77, 255, 100);" value="Да" onclick="deleteSR(this)"/>
        </div><?php
    }
    if(isset($_REQUEST['delete_'])){
        $sql_delete_sessions_results = 'DELETE from session_results where id = "'.$_REQUEST['delete_'].'";';
        $st_gr3 = $db->prepare($sql_delete_sessions_results);
        $st_gr3->execute();
    }
?>
<div style="padding: 30px 55px">
<a class="top_a" style="cursor: pointer; " onclick="addSessionResult(this)">Добавить</a>
</div>
<?php
    if(isset($_REQUEST['redact']) && isset($_REQUEST['subject']) && isset($_REQUEST['id']) && isset($_REQUEST['group'])){
    ?>
    <label style="visibility: hidden;" id="id_subject"><?=$_REQUEST['redact'];?></label>
    <label style="visibility: hidden;" id="id_student"><?=$_REQUEST['id'];?></label>
    <label style="visibility: hidden;" id="group"><?=$_REQUEST['group'];?></label>
    <div class="modal">
    <div class="modal__content">
        <h1 class="modal__title">Изменить количество баллов</h1>
        <hr>
        <h4>
            Предмет:
            <label ><?=$_REQUEST['subject']?></label>
        </h4>
        <h4> Количество баллов:
                    <input require class="modal__aboba__mark" name="new_mark" id="mark" required type="text" id="new_mark">
        </h4>
    </div>
    <input type="submit" style="background-color: rgb(255, 162, 162);" value="Отмена" onclick="closeWin(this)"/>
    <input type="submit" style="background-color: rgb(77, 255, 100);" value="Изменить" onclick="addNewResult(this)"/>
    </div>
    <?php
    }
    if(isset($_REQUEST['mark']) && isset($_REQUEST['id']) && isset($_REQUEST['group']) && isset($_REQUEST['entry_id'])){
        $newres = 'UPDATE session_results SET points = :points where id = "'.$_REQUEST['entry_id'].'";';
        $pr_st_gr=$db->prepare($newres);

        $pr_st_gr->execute([
                ':points' => $_REQUEST['mark']
        ]);
        ?>
        <script>
        document.location.reload();
        </script>
        <?php
    }
    ?>
</body>
</html>