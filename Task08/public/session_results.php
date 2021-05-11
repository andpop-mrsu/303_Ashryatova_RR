<?php
    $db = new PDO('sqlite:../data/db.db')
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
<div class = "back_to_main">
        <a href="index.php">Назад</a>
</div>
<div>

<form method="get" action = "<?php $_PHP_SELF ?>" id="form" onchange="changeGroupSessions(this)">
<h1 class = "newStText1" >Результаты сессий</h1>
<hr class="ses1">
<h4>Группа: 
    <select id="group" name="group">
        <option>Выбрать</option>
        <?php
            $group_ses_result_query = "SELECT distinct direction as dir from groups as g join session_results as sr on sr.student_id = g.student_id order by dir;";
            $groups_with_results = $db->prepare($group_ses_result_query);
            $groups_with_results->execute();
            $gwr = $groups_with_results->fetchAll(PDO::FETCH_ASSOC);
            foreach($gwr as $temp){
                $g = $temp['dir'];
                if(isset($_REQUEST['group'])){
                    if($g==$_REQUEST['group']){
                    ?>
                    <option selected><?=$g;?></option>
                    <?php
                    }
                    else{
                        ?>
                        <option><?=$g;?></option>
                        <?php
                    }
                }
                else{
                    ?>
                        <option><?=$g;?></option>
                    <?php
                }
            }
        ?>
    </select></h3>
    <h4>Студент: 
    <select id="student" name="student">
        <option>Выбрать</option>
        <?php
        if(isset($_REQUEST['group'])){
            $student_id_sel = 0;
            $grp = $_REQUEST['group'];
            $search_students = "SELECT distinct st.surname as s, st.name as n, st.id as st_id from students as st join session_results as sr, groups as g on sr.student_id = st.id and g.student_id = st.id where g.direction = '$grp';";
            $students = $db->prepare($search_students);
            $students->execute();
            $st = $students->fetchAll(PDO::FETCH_ASSOC);
            foreach($st as $temp){
                if(isset($_REQUEST['student'])){
                    if($temp['s']." ".$temp['n']==$_REQUEST['student']){
                        $student_id_sel = $temp['st_id'];
                    ?>
                        <option selected><?=$temp['s']." ".$temp['n'];?></option>
                    <?php
                    }
                    else{
                        ?>
                        <option><?=$temp['s']." ".$temp['n'];?></option>
                        <?php
                    }
                }
                else{
                    ?>
                        <option><?=$temp['s']." ".$temp['n'];?></option>
                    <?php
                }
            }
        }
        ?>
    </select></h3>

</form>
<hr class="seshr">
<?php
    if(isset($_REQUEST['student'])){
        ?>
        <table class="tableST">
            <tbody class="tbodyST">
                <tr class="trST">
                    <td class="tdST">Курс</td>
                    <td class="tdST">Предмет</td>
                    <td class="tdST">Баллы</td>
                </tr>
            
        <?php
        $directon = $_REQUEST['group'][2];
        $course = $_REQUEST['group'][0];
        $subjects_query = "SELECT `subject` as s, sr.points as p, su.course as c from subjects as su join session_results as sr on sr.student_id = '$student_id_sel' where sr.subject_id = su.id order by c;";
        $sub = $db->prepare($subjects_query);
        $sub->execute();
        $subject = $sub->fetchAll(PDO::FETCH_ASSOC);
        foreach($subject as $subj){            
            ?>     
            <tr class="trST2">
                <td class="tdST2"><?=$subj['c'];?></td>
                <td class="tdST2"><?=$subj['s'];?></td>
                <td class="tdST2"><?=$subj['p'];?></td>
            </tr>
            <?php
        }
        ?>
            </tbody>
        </table>
        <?php
    }
?>
</div>
</body>
</html>