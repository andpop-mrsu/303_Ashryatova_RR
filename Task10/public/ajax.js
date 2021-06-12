function selectGroupInTable(){
    let select = document.getElementById("group");
    let group = select.options[select.selectedIndex].value;
    $.ajax({
        method: "post",
        data:{
            group: group
        },
        success: function(data){
            $('#main_page').html(data);
        }
    });
}

function getStudentIdFromTable(a){
    let studentId = a.parentNode.parentNode.firstChild.textContent;
    document.location.href = 'redact-student-info.php?studentId='+studentId;
}

function getStudentIdFromTable_(a){
    let studentId = a.parentNode.parentNode.firstChild.textContent;
    document.location.href = 'sessions-results.php?studentId='+studentId;
}

function deleteStudent(a){
    let studentId = a.parentNode.parentNode.firstChild.textContent;
    $.ajax({
        method: 'post',
        data:{
            deleteStudentId: studentId
        },
        success:function (data){
            $('#main_page').html(data);
        }
    });
}

function deleteStudent_(){
    let studentId = document.getElementById('deleteStudent').textContent;
    $.ajax({
        method: 'post',
        data:{
            deleteStudent: studentId
        },
        success:function (data){
            $('#main_page').html(data);
        }
    });
}

function newSessionResultID(){
    let studentId = document.getElementById('studentId').textContent;
    document.location.href = 'new-session-result.php?studentId='+studentId;
}

function newSessionResult(){
    let id = document.getElementById('studentId').textContent;
    let course_select = document.getElementById('course');
    let course = course_select.options[course_select.selectedIndex].value;
    let semester_select = document.getElementById('semester');
    let semester = semester_select.options[semester_select.selectedIndex].value;
    let subject_select = document.getElementById('subject');
    let subject = subject_select.options[subject_select.selectedIndex].value;
    let subject_id = subject_select.selectedIndex;
    if(course.length===1 && semester.length===1 && subject_id===0){
        $.ajax({
            method: 'post',
            data:{
                studentId: id,
                course: course,
                semester: semester
            },
            success:function (data){
                $('#new_session_result').html(data);
            }
        });
    }
    if(course.length===1 && semester.length===1 && subject_id!==0){

        $.ajax({
            method: 'post',
            data:{
                subject_id: subject_id,
                subject: subject,
                studentId: id,
                course: course,
                semester: semester
            },
            success:function (data){
                $('#new_session_result').html(data);
            }
        });
    }
}

function sendData(){
    let id = document.getElementById('studentId').textContent;
    let subject_select = document.getElementById('subject');
    let subject = subject_select.options[subject_select.selectedIndex].value;
    let subject_id = subject_select.selectedIndex;
    let points = document.getElementById('points').value;
    let course_select = document.getElementById('course');
    let course = course_select.options[course_select.selectedIndex].value;
    let semester_select = document.getElementById('semester');
    let semester = semester_select.options[semester_select.selectedIndex].value;
    if(course_select.selectedIndex!==0 && semester_select.selectedIndex!==0 && subject_select.selectedIndex!==0) {
        $.ajax({
            method: 'post',
            data: {
                subject_id: subject_id,
                subject: subject,
                studentId: id,
                course: course,
                semester: semester,
                points: points
            },
            success: function (data) {
                $('#new_session_result').html(data);
            }
        });
    }else{
        alert("Введены не все данные!");
    }
}

function deleteSessionResult(a){
    let sessionId = a.parentNode.parentNode.firstChild.textContent;
    $.ajax({
        method: 'post',
        data:{
            deleteSessionResultId: sessionId
        },
        success:function (data){
            $('#session_result').html(data);
        }
    });
}

function deleteSessionResult_(){
    let sessionresultid = document.getElementById('deleteSessionResultId').textContent;
    $.ajax({
        method: 'post',
        data:{
            deleteSessionResult: sessionresultid
        },
        success:function (data){
            $('#session_result').html(data);
        }
    });
}

function getSessionResultIdFromTable(a){
    let sessionresultid = a.parentNode.parentNode.firstChild.textContent;
    $.ajax({
        method: 'post',
        data:{
            edit_session_result: sessionresultid
        },
        success:function (data){
            $('#session_result').html(data);
        }
    });
}

function updateSessionResult(){
    $.ajax({
        method: 'post',
        data:{
            updateSessionResultId: document.getElementById('updateSessionResult').textContent,
            points: document.getElementById('points').value
        },
        success: function (data) {
            $('#session_result').html(data);
        }
    });
}