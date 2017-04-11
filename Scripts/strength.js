$(document).ready(function() {
    var monthNames = ["January", "February", "March", "April", "May", "June", 
    "July", "August", "September", "October", "November", "December"];
    var d = new Date();
    var year = d.getFullYear();
    var years = [year - 1, year, year + 1];

    var monthControl = $("#strengthControls > div:nth-child(1) select");
    var yearControl = $("#strengthControls > div:nth-child(2) select");

    function formatMonth(month) {
        if (month < 10) return "0"+month;
        else return month;
    }

    $.each(monthNames, function(index) {
        monthControl.append($("<option />").val(formatMonth(index+1)).text(monthNames[index]));
    });

    $.each(years, function(index) {
        yearControl.append($("<option />").val(years[index]).text(years[index]));
    })

    var selmonth = monthControl.val();
    var selyear = yearControl.val();

    monthControl.change(function() {
        selmonth = monthControl.val();
    });

    yearControl.change(function() {
        selyear = yearControl.val();
    });

    $('#strengthControls input').click(function() {
        console.log(selyear + ":" +selmonth);
        $.getJSON('completedExerciseData.php', {month : selmonth, year: selyear}, function (data) {
            var result = "";
            $.each(data, function(index,exercise){
                console.log(exercise.exercise_name + ":" + exercise.weight);
            });    
        });
    });

});