function sessionResults(td){
    var id = td.parentNode.parentNode.childNodes[1].textContent;
    var group = td.parentNode.parentNode.childNodes[3].textContent;
    $.ajax({
        url: '/exam-results.php', 
        data: {
            id: id,
            group: group
        },
        success:function(data){
                document.location.href = "/exam-results.php?id="+id+"&group="+group;
                $('#body2').html(data);
            }
        });
}

function deleteEntry(td){
    var id = td.parentNode.parentNode.childNodes[1].textContent;
    var student = td.parentNode.parentNode.childNodes[7].textContent;
    $.ajax({
        url: '/index.php',
        method: "get",      
        dataType: "html",
        data: {
            delete: id,
            student: student
        },
        success:function(data) {
            $('#body').html(data);
        }       
    });
}
function deleteSR(td){
    var id = document.querySelector('#ent_id').textContent;
    $.ajax({
        url: '/exam-results.php',
        method: "get",      
        dataType: "html",
        data: {
            delete_: id
        },
        success:function(data) {
            location.reload();
        }       
    });
}

function deleteST(td){
    var id = document.querySelector('#stud_id').textContent;
    $.ajax({
        url: '/index.php',
        method: "get",      
        dataType: "html",
        data: {
            delete_: id
        },
        success:function(data) {
            location.reload();
        }       
    });
}

function closeWin1(){
    document.location.reload();
}


function deleteSessionResult(td){
    var id_entry = td.parentNode.parentNode.childNodes[1].textContent;
    var s = td.parentNode.parentNode.childNodes[5].textContent;
    var ids = document.querySelector('#st_id').textContent;
    var gr = document.querySelector('#gr').textContent;
    $.ajax({
        url: '/exam-results.php',
        method: "get",      
        dataType: "html",
        data: {
            delete: id_entry,
            subject: s,
            id: ids,
            group: gr
        },
        success:function(data) {
            $('#body2').html(data);
        }       
    });
}

function deleteSessionResult2(td){
    var id_entry = document.querySelector('#ent_id').textContent;
    $.ajax({
        url: '/exam-results.php',
        method: "get",      
        dataType: "html",
        data: {
            delete_: id_entry
        },
        success:function(data) {
            location.reload();
        }       
    });
}

function redactEntry(td){
    var id = td.parentNode.parentNode.childNodes[1].textContent;
    var group = td.parentNode.parentNode.childNodes[3].textContent;
    $.ajax({
        url: '/edit-student-data.php', 
        data: {
            id: id,
            group: group
        },
        success:function(data){
                document.location.href = "/edit-student-data.php?id="+id+"&group="+group;
                $('#body1').html(data);
            }
        });
}
function redactSessionResult(td){
    var id = td.parentNode.parentNode.childNodes[1].textContent;
    var ids = document.querySelector('#st_id').textContent;
    var gr = document.querySelector('#gr').textContent;
    var subject = td.parentNode.parentNode.childNodes[5].textContent;
    $.ajax({
        url: '/exam-results.php', 
        data: {
            id: ids,
            group: gr,
            redact: id,
            subject: subject
        },
        success:function(data){    
                $('#body2').html(data);
            }
        });
}

function addNewResult(a){
    var id = document.querySelector('#id_subject').textContent;
    var idst = document.querySelector('#id_student').textContent;
    var gr = document.querySelector('#group').textContent;
    var mark = document.querySelector('#mark').value;
    $.ajax({
        url: '/exam-results.php', 
        data: {
            id: idst,
            group: gr,
            entry_id: id,
            mark: mark
        },
        success:function(data){    
                //document.location.href = "/exam-results.php?id="+idst+"&group="+gr;
                $('#body2').html(data);
            }
    });
}
function addSessionResult(a){
    var id = document.querySelector('#st_id').textContent;
    var gr = document.querySelector('#gr').textContent;
    $.ajax({
        url: '/add-session-result.php', 
        data: {
            id: id,
            group: gr
        },
        success:function(data){
                document.location.href = "/add-session-result.php?id="+id+"&group="+gr;
                $('#body4').html(data);
            }
        });
}

function closeWin(a){
    var id = document.querySelector('#st_id').textContent;
    var gr = document.querySelector('#gr').textContent;
    $.ajax({
        url: '/exam-results.php', 
        data: {
            id: id,
            group: gr
        },
        success:function(data){
                document.location.href = "/exam-results.php?id="+id+"&group="+gr;
                $('#body4').html(data);
            }
        });
}
function checkData(form){
    var surname = form.surname.value;
    var name = form.name.value;
    var lastname = form.lastname.value;
    var student_card = form.student_card.value;

    if(!/^[а-яё]*$/i.test(surname)){
        alert("Фамилия должна содержать только русские символы!");
        form.surname.value = "";
    }
    if(!/^[а-яё]*$/i.test(name)){
        alert("Имя должно содержать только русские символы!");
        form.name.value = "";
    }
    if(!/^[а-яё]*$/i.test(lastname)){
        alert("Отчество должно содержать только русские символы!");
        form.lastname.value = "";
    }
    if(student_card.length!=0){
        if(!/^\d*$/.test(student_card) || student_card.length!=6){
            alert("Студенческий билет должен быть 6-значным числом!");
            form.student_card.value = "";
        }
    }

}

function changeForm(form){
    var id = document.querySelector('#id').value;
    var gr = document.querySelector('#gr').textContent;
    var st = document.querySelector('#stud').textContent;
    var course_index = form.course.selectedIndex;
    var course_ = form.course.options[course.selectedIndex].value;
    var semester_index = form.semester.selectedIndex;
    var semester_ = form.semester.options[semester.selectedIndex].value;
    var subject_index = form.subject.selectedIndex;
    var subject_ = form.subject.options[subject.selectedIndex].value;
    var mark_ = form.mark.value;

    if(course_index!=0 && semester_index==0){
        $.ajax({
            url: '/add-session-result.php',
            method: "get",      
            dataType: "html",
            data: {
                id: id,
                student: st,
                group: gr,
                course: course_
            },
            success:function(data) {
                $('#body4').html(data);
            }       
        });
    }
    if(semester_index!=0 && subject_index==0){
        $.ajax({
            url: '/add-session-result.php',
            method: "get",      
            dataType: "html",
            data: {
                id: id,
                student: st,
                group: gr,
                course: course_,
                semester: semester_
            },
            success:function(data) {
                $('#body4').html(data);
            }       
        });
    }
    if(subject_index!=0 && mark_==""){
        $.ajax({
            url: '/add-session-result.php',
            method: "get",      
            dataType: "html",
            data: {
                id: id,
                student: st,
                group: gr,
                course: course_,
                semester: semester_,
                subject: subject_
            },
            success:function(data) {
                $('#body4').html(data);
            }       
        });                
    }
    if(subject_index!=0 && mark_!=""){
        if(/^\d*$/.test(mark_) && mark_>=0 && mark_<=100)
        {
            $.ajax({
                url: '/add-session-result.php',
                method: "get",      
                dataType: "html",
                data: {
                    id: id,
                    student: st,
                    group: gr,
                    course: course_,
                    semester: semester_,
                    subject: subject_,
                    mark: mark_
                },
                success:function(data) {
                    $('#body4').html(data);
                }       
            });              
        } 
        else{
            alert("Количество баллов - целое число от 0 до 100");
            form.mark.value = "";
        }   
    }
}

function changeGroup(form){
    var group_ = form.group.options[group.selectedIndex].value;
    $.ajax({
        url: '/index.php',
        method: "get",      
        dataType: "html",
        data: {
            group: group_
        },
        success:function(data) {
            $('#body').html(data);
        }
    });
}

function changeGroupSessions(form){
    var group_index = form.group.selectedIndex;
    var group_ = form.group.options[group.selectedIndex].value;
    var student_index = form.student.selectedIndex;
    var student_ = form.student.options[student.selectedIndex].value;
    if(group_index!=0 && student_index==0){
        $.ajax({
            url: '/session_results.php',
            method: "get",      
            dataType: "html",
            data: {
                group: group_
            },
            success:function(data) {
                $('#body').html(data);
            }
        });
    }
    if(student_index!=0){
        $.ajax({
            url: '/session_results.php',
            method: "get",      
            dataType: "html",
            data: {
                group: group_,
                student: student_
            },
            success:function(data) {
                $('#body').html(data);
            }
        });
    }
}

function sendClear(){
    location.reload();
}