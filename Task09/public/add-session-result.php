<?php
    $db = new PDO('sqlite:../data/db.db');
    $id = "";
    $group = "";
    $student = "";
    $sub_id="";
    if(isset($_REQUEST['id']) && isset($_REQUEST['group'])){
        $id = $_REQUEST['id'];
        $group = $_REQUEST['group'];
        $query = "SELECT surname, name, lastname from students where id = '$id';";
        $res = $db->prepare($query);
        $res->execute();
        $student = $res->fetchAll(PDO::FETCH_ASSOC);
        $student = $student[0]['surname']." ".$student[0]['name']." ".$student[0]['lastname'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head id="head">
    <meta charset="UTF-8">
    <title>Добавить результат сессии</title>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="ajax.js"></script>
<link rel="stylesheet" href="styles.css" type="text/css" />
<body id="body4">
<div>
    <?php
if(isset($_REQUEST['id']) && isset($_REQUEST['group'])){?>
        <a class="but" href="exam-results.php?id=<?=$_REQUEST['id'];?>&group=<?=$_REQUEST['group'];?>">Назад</a><?php }?>
</div>

<div class= "refsSes" id="refs">
<form class = "form_ses" method="get" action = "" id="form" onchange="changeForm(this)">

    <h1 class = "newStText">Новый результат сессии</h1>

            <fieldset class="fieldset_class" id="fieldset_class">
            <h4>Студент:
                <?php if(!isset($_REQUEST['student'])){?>
                <label id="stud"><?=$student;?></label>
                <?php
                }else{
                    ?>
                    <label id="stud"><?=$_REQUEST['student'];?></label><?php
                }
                ?>
            </h4>
            <h4> Группа:
            <?php if(!isset($_REQUEST['group'])){?>
                <label id="gr"><?=$group;?></label>
                <?php
                }else{
                    ?>
                        <label id="gr"><?=$_REQUEST['group'];?></label>
                    <?php
                }
                ?>
            </h4>
            <hr>
                <?php
                if(isset($_REQUEST['id'])){?>
                <input id="id" name="id" style="visibility: hidden;" value="<?=$_REQUEST['id'];?>">
                <?php
                }
                else{?>
            <input id="id" name="id" style="visibility: hidden;" value="<?=$id;?>"><?php
                }?>
                    <h4> Курс: 
                    <select name="course" id="course" class="course">
                           <option class="option_st">Выбрать</option>
                           <?php
                           if(isset($_REQUEST['group'])){
                               $group = $_REQUEST['group'];
                           
                                for($i=1;$i<=$group[0];$i++){
                                    if(isset($_REQUEST['course'])){
                                        if($i==$_REQUEST['course']){
                                            ?>
                                                <option id = "sel_val" selected><?=$i;?></option>
                                            <?php
                                            }
                                        else{
                                            ?>
                                            <option id = "sel_val"><?=$i;?></option>
                                            <?php
                                        }
                                    }
                                    else{
                                        ?>
                                        <option id = "sel_val"><?=$i;?></option>
                                        <?php   
                                    } 
                            
                                }
                           }
                            ?>
                    </select>
                    </h4>
                    <hr>
                    <h4> Семестр:
                    <select name="semester" id="semester" class="semester">
                           <option class="option_st" selected>Выбрать</option>
                           <?php
                                if(isset($_REQUEST['semester'])){
                                    if($_REQUEST['semester']==1){
                                    ?>
                                    <option class="option_st" selected>1</option>
                                    <option class="option_st">2</option>
                                    <?php
                                    }
                                    else{
                                        ?>
                                        <option class="option_st">1</option>
                                        <option class="option_st" selected>2</option>
                                        <?php
                                    }
                                }
                                else{
                                    ?>
                                    <option class="option_st">1</option>
                                    <option class="option_st">2</option>
                                    <?php
                                }
                           ?>
                           
                    </select>
                    </h4>
                    <hr>
                    <h4> Предмет:
                    <select name="subject" id="subject" class="subject">
                           <option class="option_st">Выбрать</option>
                           <?php
                                if(isset($_REQUEST['semester']) && isset($_REQUEST['group']) && isset($_REQUEST['course'])){                                    
                                    $c = $_REQUEST['course'];
                                    $temp_s = $_REQUEST['semester'];
                                    $s = 'cert_type'.$temp_s;
                                    $d = $_REQUEST['group'][2];
                                    $set_res = $db->prepare("SELECT s.subject as subj, s.id as sub_id from subjects as s join(SELECT sd.subject_id as i from subjects_directions as sd where sd.direction_id='$d') where s.course = '$c' and s.'$s'>=-1 and s.'$s'<=1 and i=s.id;");
                                    $set_res->execute();
                                    $subj = $set_res->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($subj as $temp){
                                            $su = $temp['subj'];
                                            if(isset($_REQUEST['subject'])){
                                                if($su==$_REQUEST['subject']){
                                                    $sub_id = $temp['sub_id'];
                                                ?>
                                                        <option selected><?=$su;?></option>
                                                <?php
                                                        }
                                                else{
                                                    ?>
                                                <option><?=$su;?></option>
                                                <?php
                                                    }
                                                }
                                            else{
                                                ?>
                                                <option><?=$su;?></option>
                                                <?php
                                            }
                                    }  
                                }      
                           ?>                           
                    </select>
                    </h4>
                    <hr>
                    <h4> Количество баллов:
                    <input required class = "mark" type="text" name="mark" value="" id="mark">
                    </h4>

            </fieldset>
            <input class = "sendInfoNewStudent" type = "submit" value="Добавить" onclick="sendClear()"/>
</form>
</div>

<?php
    if(isset($_REQUEST['course']) && isset($_REQUEST['semester']) && isset($_REQUEST['subject']) && isset($_REQUEST['mark']) && isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];
        $aboba=$_REQUEST['subject'];
        $d = $_REQUEST['group'][2];
        $c = $_REQUEST['course'];
        $s = 'cert_type'.$_REQUEST['semester'];
        $set_res = $db->prepare("SELECT s.id as sub_id from subjects as s join(SELECT sd.subject_id as i from subjects_directions as sd where sd.direction_id='$d') where s.course = '$c' and s.'$s'>=-1 and s.'$s'<=1 and i=s.id and s.subject='$aboba';");
        $set_res->execute();
        $subj = $set_res->fetchAll(PDO::FETCH_ASSOC);
        $sub_id = $subj[0]['sub_id'];
        $ins2=$db->prepare("INSERT INTO session_results (student_id, subject_id, points) VALUES (:student_id, :subject_id, :points);");
        $ins2->execute([
        ':student_id' => $id,
        ':subject_id' => $sub_id,
        ':points' => $_REQUEST['mark'], 
        ]);
        //echo ' <script type="text/javascript"> location.reload(); </script>';
        ?>
        <script>
        location.href = "/exam-results.php?id="+<?=$id;?>+"&group="+<?=$_REQUEST['group'];?>; 
        </script>
        <?php
    }
?>


</body>
</html>