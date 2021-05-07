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
    var group_index = form.group.selectedIndex;
    var group_ = form.group.options[group.selectedIndex].value;
    var surname_index = form.surname.selectedIndex;
    var surname_ = form.surname.options[surname.selectedIndex].value;
    var course_index = form.course.selectedIndex;
    var course_ = form.course.options[course.selectedIndex].value;
    var semester_index = form.semester.selectedIndex;
    var semester_ = form.semester.options[semester.selectedIndex].value;
    var subject_index = form.subject.selectedIndex;
    var subject_ = form.subject.options[subject.selectedIndex].value;
    var mark_ = form.mark.value;
    if(group_index!=0 && surname_index==0){
        $.ajax({
            url: '/newSessionResult.php',
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

    if(surname_index!=0 && course_index==0){
        $.ajax({
            url: '/newSessionResult.php',
            method: "get",      
            dataType: "html",
            data: {
                group: group_,
                surname: surname_
            },
            success:function(data) {
                $('#body').html(data);
            }       
        });
    }
    if(course_index!=0 && semester_index==0){
        $.ajax({
            url: '/newSessionResult.php',
            method: "get",      
            dataType: "html",
            data: {
                group: group_,
                surname: surname_,
                course: course_
            },
            success:function(data) {
                $('#body').html(data);
            }       
        });
    }
    if(semester_index!=0 && subject_index==0){
        $.ajax({
            url: '/newSessionResult.php',
            method: "get",      
            dataType: "html",
            data: {
                group: group_,
                surname: surname_,
                course: course_,
                semester: semester_
            },
            success:function(data) {
                $('#body').html(data);
            }       
        });
    }
    if(subject_index!=0 && mark_==""){
        $.ajax({
            url: '/newSessionResult.php',
            method: "get",      
            dataType: "html",
            data: {
                group: group_,
                surname: surname_,
                course: course_,
                semester: semester_,
                subject: subject_
            },
            success:function(data) {
                $('#body').html(data);
            }       
        });                
    }
    if(mark_!=""){
        if(/^\d*$/.test(mark_) && mark_>=0 && mark_<=100)
        {
            $.ajax({
                url: '/newSessionResult.php',
                method: "get",      
                dataType: "html",
                data: {
                    group: group_,
                    surname: surname_,
                    course: course_,
                    semester: semester_,
                    subject: subject_,
                    mark: mark_
                },
                success:function(data) {
                    $('#body').html(data);
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
        url: '/all_students.php',
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