<?php
require '../vendor/autoload.php';
class_alias('RedBeanPHP\R', 'RB');
RB::setup('sqlite:../data/db.db');
RB::freeze(false);

if(!RB::testConnection()){
    die('No DB Connection');
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="ajax.js"></script>
<script src="check.input.data.js"></script>
<?php
function getAllStudents($selectedGroup){
    if($selectedGroup=="Все группы") {
        return RB::getAll("SELECT students.id as id, groups.direction as g, 
            directions.direction as d, 
            students.surname as f,
            students.name as n, 
            students.lastname as l, case when
            students.sex == 'm' then 'м' else 'ж' end as s,  
            students.date_of_birth as b,
            student_card as c from groups join students on students.id = groups.student_id
            join directions on students.direction_id = directions.id
            order by groups.direction, students.surname;");
    }
    else{
        return RB::getAll("SELECT students.id as id, groups.direction as g, 
            directions.direction as d, 
            students.surname as f,
            students.name as n, 
            students.lastname as l, case when
            students.sex == 'm' then 'м' else 'ж' end as s,  
            students.date_of_birth as b,
            student_card as c from groups join students on students.id = groups.student_id
            join directions on students.direction_id = directions.id where g=='$selectedGroup'
            order by groups.direction, students.surname;");
    }
}

function getAllExistGroups(){
    return RB::getAll("SELECT DISTINCT direction as g FROM groups ORDER BY direction;");
}

function getAllGroups(){
    return RB::getAll("SELECT DISTINCT group_name as g from all_groups order by group_name;");
}

function createTableForStudentsData($all_students){
            foreach ($all_students as $student){
                echo '<tr>';
                echo '<td style="display: none" id="studentId">'.$student['id'].'</td>';
                echo '<td>'.$student['g'].'</td>';
                echo '<td>'.$student['d'].'</td>';
                echo '<td>'.$student['f'].'</td>';
                echo '<td>'.$student['n'].'</td>';
                echo '<td>'.$student['l'].'</td>';
                echo '<td>'.$student['s'].'</td>';
                echo '<td>'.$student['b'].'</td>';
                echo '<td>'.$student['c'].'</td>';
                echo '<td><a class="icons" data-info="Редактировать" onclick="getStudentIdFromTable(this)"><img width="15" height="15" src="images/redact.png"></a>
                          <a class="icons" data-info="Результаты сессий" onclick="getStudentIdFromTable_(this)"><img width="15" height="15" src="images/session.png"></a>
                          <a class="icons" data-info="Удалить" onclick="deleteStudent(this)"><img width="15" height="15" src="images/delete.png"></a>
                      </td>';
                echo '</tr>';
            }
}

function addNewStudentToDataBase(){
    $admission = (date("Y") - $_POST['group'][0])."-09-01";
    $table_students = RB::dispense('students');
    $table_students->surname = $_POST['surname'];
    $table_students->name = $_POST['name'];
    $table_students->lastname = $_POST['lastname'];
    $table_students->date_of_birth = $_POST['birthday'];
    $table_students->sex = $_POST['sex'];
    $table_students->date_of_admission = $admission;
    $table_students->direction_id = $_POST['group'][2];
    $table_students->student_card = $_POST['student_card'];
    $last_id = RB::store($table_students);

    $table_existing_groups = RB::dispense('groups');
    $table_existing_groups->student_id = $last_id;
    $table_existing_groups->direction = $_POST['group'];
    RB::store($table_existing_groups);
}

function redactStudentInfo(){

    $admission = (date("Y") - $_POST['group'][0])."-09-01";
    $table_students = RB::findOne('students', 'id=?', [$_GET['studentId']]);
    $table_students->surname = $_POST['surname'];
    $table_students->name = $_POST['name'];
    $table_students->lastname = $_POST['lastname'];
    $table_students->sex = $_POST['sex'];
    $table_students->date_of_birth = $_POST['birthday'];
    $table_students->date_of_admission = $admission;
    $table_students->direction_id = $_POST['group'][2];
    $table_students->student_card = $_POST['student_card'];
    $last_id = RB::store($table_students);

    $table_existing_groups = RB::findOne('groups', 'id=?', [$_GET['studentId']]);
    $table_existing_groups->student_id = $last_id;
    $table_existing_groups->direction = $_POST['group'];
    RB::store($table_existing_groups);
    header("location: index.php");
}

function deleteStudentFromDataBase(){
    RB::hunt('sessionresults', 'student_id=?',[$_POST['deleteStudent']]);
    RB::hunt('students', 'id=?',[$_POST['deleteStudent']]);
}

function course($groupStudent){
    echo '<select id="course" onchange="newSessionResult()">';
    echo '<option>Выбрать</option>';
            for($i=1; $i<=$groupStudent['direction'][0];$i++){
                if(isset($_POST['course']) && $i==$_POST['course']){
                echo '<option selected>'.$i.'</option>';

                }
                else{
                echo '<option>'.$i.'</option>';

                    }
            }
    echo '</select>';
}

function semester(){
    echo '<select id="semester" onchange="newSessionResult()">';
    echo '<option>Выбрать</option>';

            if(isset($_POST['semester']) && $_POST['semester']==1){
                echo '<option selected>1</option>';
                echo '<option>2</option>';
            }
            else if(isset($_POST['semester']) && $_POST['semester']==2){
                echo '<option>1</option>';
                echo '<option selected>2</option>';
            }
            else{
                echo '<option>1</option>';
                echo '<option>2</option>';
            }
    echo '</select>';
}

function getSubjects($group){
    $direction = (int)$group[2];
    $c = $_REQUEST['course'];
    $temp_s = $_REQUEST['semester'];
    $s = 's.cert_type'.$temp_s;
    $all_subject = RB::getAll("SELECT s.subject as subj, s.id as sub_id from subjects as s 
                                   join(SELECT sd.subject_id as i from subjects_directions as sd where sd.direction_id='$direction') 
                                   where s.course =$c and $s>=-1 and $s<=1 and i=s.id;");
    $id = [];
    for($i=0;$i<count($all_subject);$i++){
        $su = $all_subject[$i]["subj"];
        array_push($id, $all_subject[$i]["sub_id"]);
        if(isset($_REQUEST['subject'])){
            if($su==$_REQUEST['subject']){
            echo '<option selected>'.$su.'</option>';
            }
            else{
                echo '<option>'.$su.'</option>';
            }
        }
        else{
            echo '<option>'.$su.'</option>';
        }
    }
    return $id;
}

function addNewSessionResult($subject){
    $session_results = RB::dispense('sessionresults');
    $session_results->student_id = $_POST['studentId'];
    $session_results->subject_id = (integer)$subject;
    $session_results->points = $_POST['points'];
    RB::store($session_results);

}

function sessionResults(){
    $sessions_results = RB::getAll('select * from sessionresults where student_id=? order by subject_id', [$_GET['studentId']]);
    foreach($sessions_results as $session_results ){
        $subject = RB::findOne('subjects','id=?',[$session_results['subject_id']]);
        echo '<tr>';
        echo '<td style="visibility: hidden;" id="res">'.$session_results['id'].'</td>';
        echo '<td>'.$subject['course'].'</td>';
        echo '<td>'.$subject['subject'].'</td>';
        echo '<td>'.$session_results['points'].'</td>';
        echo '<td><a class="icons" data-info="Редактировать" onclick="getSessionResultIdFromTable(this)"><img width="15" height="15" src="images/redact.png"></a>
                  <a class="icons" data-info="Удалить" onclick="deleteSessionResult(this)"><img width="15" height="15" src="images/delete.png"></a>
              </td>';
        echo '</tr>';
    }

}

function deleteSessionResult(){
    $delete_session_result = RB::load('sessionresults', $_POST['deleteSessionResult']);
    RB::trash($delete_session_result);
}

function updateSessionResults(){
    $update = RB::findOne('sessionresults','id=?', [$_POST['updateSessionResultId']]);
    $update->points = $_POST['points'];
    RB::store($update);
}