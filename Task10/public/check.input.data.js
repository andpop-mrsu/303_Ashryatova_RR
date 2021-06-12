function checkDataStudent(form){
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
    if(student_card.length!==0){
        if(!/^\d*$/.test(student_card) || student_card.length!==6){
            alert("Студенческий билет должен быть 6-значным числом!");
            form.student_card.value = "";
        }
    }
}

function checkValuePoints(){
    let points = document.getElementById('points').value;
    if(points.length!==0){
        if(!/^\d*$/.test(points) || points.length<0 || points.length>100){
            alert("Количество баллов - целое число от 0 до 100!");
            document.getElementById('points').value = "";
        }
    }
}