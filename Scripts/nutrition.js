$(document).ready(function(){


    //-------------------
    //-------------------
    //-------------------
    //-------------------

    //JSON call to todaysArrCall.php to grab today's input
    var todaysArr = [];
    $.getJSON('todaysArrCall.php', function(data){
        todaysArr.push(data.calories);
        todaysArr.push(data.carbs);
        todaysArr.push(data.cholesterol);
        todaysArr.push(data.fat);
        todaysArr.push(data.protein);
        todaysArr.push(data.sodium);
    }); //end of json call

    //function to input data into chart js canvas called nutritionChart
    var nutritionContext = document.getElementById('nutritionChart').getContext('2d');
    var nutritionChart = new Chart(nutritionContext, {
        type: 'doughnut',
        data: {
            labels: ["Calories", "Fat", "Cholesterol", "Sodium", "Carbohydrates", "Protein"],
            datasets: [{
                backgroundColor: [
                    "#e04152",
                    "#434a54",
                    "#35adda",
                    "#ffcf48",
                    "#8cc34b",
                    "#ccd0d9"
                ],
                data: todaysArr//[cals, fat, cholesterol, sodium, carbs, protein]
            }] //end datasets
        }, //end data
        options: {
            legend: {
                display: true,
                position: 'bottom'
            }
        }//end options
        }); //end nutritionChart var

    //--------------------------

    //JSON call to weeklyArrCall.php to grab weekly input
    var weeklyArr = [];
    $.getJSON('weeklyArrCall.php', function(data){
        console.log(data.calories);
        weeklyArr.push(data.calories);
        weeklyArr.push(data.carbs);
        weeklyArr.push(data.cholesterol);
        weeklyArr.push(data.fat);
        weeklyArr.push(data.protein);
        weeklyArr.push(data.sodium);
    }); //end of json call

    console.log(weeklyArr);

    //function to input data into chart js canvas called nutritionChart
    var weeklyContext = document.getElementById('weeklyNutritionChart').getContext('2d');
    var weeklyNutritionChart = new Chart(weeklyContext, {
        type: 'doughnut',
        data: {
            labels: ["Calories", "Fat", "Cholesterol", "Sodium", "Carbohydrates", "Protein"],
            datasets: [{
                backgroundColor: [
                    "#e04152",
                    "#434a54",
                    "#35adda",
                    "#ffcf48",
                    "#8cc34b",
                    "#ccd0d9"
                ],
                data: weeklyArr//[cals, fat, cholesterol, sodium, carbs, protein]
            }] //end datasets
        } //end data
    }); //end nutritionChart var

    //--------------------------

    /*//week nutrition chart
    var totalWeekCals = document.getElementById("totalWeekCals");
    var weekCals = parseInt(totalWeekCals.innerHTML, 10);

    var totalWeekFat = document.getElementById("totalWeekFat");
    var weekFat = parseInt(totalWeekFat.innerHTML, 10);

    var totalWeekCholesterol = document.getElementById("totalWeekCholesterol");
    var weekCholesterol = parseInt(totalWeekCholesterol.innerHTML, 10);

    var totalWeekSodium = document.getElementById("totalWeekSodium");
    var weekSodium = parseInt(totalWeekSodium.innerHTML, 10);

    var totalWeekCarbs = document.getElementById("totalWeekCarbs");
    var weekCarbs = parseInt(totalWeekCarbs.innerHTML, 10);

    var totalWeekProtein = document.getElementById("totalWeekProtein");
    var weekProtein = parseInt(totalWeekProtein.innerHTML, 10);

    var totalSixDaysCals = document.getElementById("totalSixDaysCals");
    var sixDaysCals = parseInt(totalSixDaysCals.innerHTML, 10);

    var totalSixDaysFat = document.getElementById("totalSixDaysFat");
    var sixDaysFat = parseInt(totalSixDaysFat.innerHTML, 10);

    var totalSixDaysCholesterol = document.getElementById("totalSixDaysCholesterol");
    var sixDaysCholesterol = parseInt(totalSixDaysCholesterol.innerHTML, 10);

    var totalSixDaysSodium = document.getElementById("totalSixDaysSodium");
    var sixDaysSodium = parseInt(totalSixDaysSodium.innerHTML, 10);

    var totalSixDaysCarbs = document.getElementById("totalSixDaysCarbs");
    var sixDaysCarbs = parseInt(totalSixDaysCarbs.innerHTML, 10);

    var totalSixDaysProtein = document.getElementById("totalSixDaysProtein");
    var sixDaysProtein = parseInt(totalSixDaysProtein.innerHTML, 10);

    var totalFiveDaysCals = document.getElementById("totalFiveDaysCals");
    var fiveDaysCals = parseInt(totalFiveDaysCals.innerHTML, 10);

    var totalFiveDaysFat = document.getElementById("totalFiveDaysFat");
    var fiveDaysFat = parseInt(totalFiveDaysFat.innerHTML, 10);

    var totalFiveDaysCholesterol = document.getElementById("totalFiveDaysCholesterol");
    var fiveDaysCholesterol = parseInt(totalFiveDaysCholesterol.innerHTML, 10);

    var totalFiveDaysSodium = document.getElementById("totalFiveDaysSodium");
    var fiveDaysSodium = parseInt(totalFiveDaysSodium.innerHTML, 10);

    var totalFiveDaysCarbs = document.getElementById("totalFiveDaysCarbs");
    var fiveDaysCarbs = parseInt(totalFiveDaysCarbs.innerHTML, 10);

    var totalFiveDaysProtein = document.getElementById("totalFiveDaysProtein");
    var fiveDaysProtein = parseInt(totalFiveDaysProtein.innerHTML, 10);

    var totalFourDaysCals = document.getElementById("totalFourDaysCals");
    var fourDaysCals = parseInt(totalFourDaysCals.innerHTML, 10);

    var totalFourDaysFat = document.getElementById("totalFourDaysFat");
    var fourDaysFat = parseInt(totalFourDaysFat.innerHTML, 10);

    var totalFourDaysCholesterol = document.getElementById("totalFourDaysCholesterol");
    var fourDaysCholesterol = parseInt(totalFourDaysCholesterol.innerHTML, 10);

    var totalFourDaysSodium = document.getElementById("totalFourDaysSodium");
    var fourDaysSodium = parseInt(totalFourDaysSodium.innerHTML, 10);

    var totalFourDaysCarbs = document.getElementById("totalFourDaysCarbs");
    var fourDaysCarbs = parseInt(totalFourDaysCarbs.innerHTML, 10);

    var totalFourDaysProtein = document.getElementById("totalFourDaysProtein");
    var fourDaysProtein = parseInt(totalFourDaysProtein.innerHTML, 10);

    var totalThreeDaysCals = document.getElementById("totalThreeDaysCals");
    var threeDaysCals = parseInt(totalThreeDaysCals.innerHTML, 10);

    var totalThreeDaysFat = document.getElementById("totalThreeDaysFat");
    var threeDaysFat = parseInt(totalThreeDaysFat.innerHTML, 10);

    var totalThreeDaysCholesterol = document.getElementById("totalThreeDaysCholesterol");
    var threeDaysCholesterol = parseInt(totalThreeDaysCholesterol.innerHTML, 10);

    var totalThreeDaysSodium = document.getElementById("totalThreeDaysSodium");
    var threeDaysSodium = parseInt(totalThreeDaysSodium.innerHTML, 10);

    var totalThreeDaysCarbs = document.getElementById("totalThreeDaysCarbs");
    var threeDaysCarbs = parseInt(totalThreeDaysCarbs.innerHTML, 10);

    var totalThreeDaysProtein = document.getElementById("totalThreeDaysProtein");
    var threeDaysProtein = parseInt(totalThreeDaysProtein.innerHTML, 10);

    var totalTwoDaysCals = document.getElementById("totalTwoDaysCals");
    var twoDaysCals = parseInt(totalTwoDaysCals.innerHTML, 10);

    var totalTwoDaysFat = document.getElementById("totalTwoDaysFat");
    var twoDaysFat = parseInt(totalTwoDaysFat.innerHTML, 10);

    var totalTwoDaysCholesterol = document.getElementById("totalTwoDaysCholesterol");
    var twoDaysCholesterol = parseInt(totalTwoDaysCholesterol.innerHTML, 10);

    var totalTwoDaysSodium = document.getElementById("totalTwoDaysSodium");
    var twoDaysSodium = parseInt(totalTwoDaysSodium.innerHTML, 10);

    var totalTwoDaysCarbs = document.getElementById("totalTwoDaysCarbs");
    var twoDaysCarbs = parseInt(totalTwoDaysCarbs.innerHTML, 10);

    var totalTwoDaysProtein = document.getElementById("totalTwoDaysProtein");
    var twoDaysProtein = parseInt(totalTwoDaysProtein.innerHTML, 10);

    var weeklyChartContext = document.getElementById("weeklyChart").getContext('2d');
    /*var weeklyChart = new Chart(weeklyChartContext, {
        type: 'line',
        data: {
            labels: ["6 Days Ago", "5 Days Ago", "4 Days Ago", "3 Days Ago", "2 Days Ago", "Today"],
            datasets: [{
                label: "Calories",
                data: [sixDaysCals, fiveDaysCals, fourDaysCals, threeDaysCals, twoDaysCals, cals],
                backgroundColor: "blue"
            }] // end datasets
        } //end data for cals
    }); //end weeklyChart*/

    /*var myChart = new Chart(weeklyChartContext, {
        type: 'line',
        data: {
            labels: ["6 Days Ago", "5 Days Ago", "4 Days Ago", "3 Days Ago", "2 Days Ago", "Today"],
            datasets: [{
                label: 'Calories',
                data: [sixDaysCals, fiveDaysCals, fourDaysCals, threeDaysCals, twoDaysCals, cals],
                borderColor: "green",
                backgroundColor: "transparent"
            }, {
                label: 'Fat',
                data: [sixDaysFat, fiveDaysFat, fourDaysFat, threeDaysFat, twoDaysFat, fat],
                borderColor: "blue",
                backgroundColor: "transparent"
            }, {
                label: 'Cholesterol',
                data: [sixDaysCholesterol, fiveDaysCholesterol, fourDaysCholesterol, threeDaysCholesterol, twoDaysCholesterol, cholesterol],
                borderColor: "yellow",
                backgroundColor: "transparent"
            }, {
                label: 'Sodium',
                data: [sixDaysSodium, fiveDaysSodium, fourDaysSodium, threeDaysSodium, twoDaysSodium, sodium],
                borderColor: "orange",
                backgroundColor: "transparent"
            }, {
                label: 'Carbs',
                data: [sixDaysCarbs, fiveDaysCarbs, fourDaysCarbs, threeDaysCarbs, twoDaysCarbs, carbs],
                borderColor: "red",
                backgroundColor: "transparent"
            }, {
                label: 'Protein',
                data: [sixDaysProtein, fiveDaysProtein, fourDaysProtein, threeDaysProtein, twoDaysProtein, protein],
                borderColor: "purple",
                backgroundColor: "transparent"
            }]
        }
    });



    /*---------------------------
    //dv chart
    //get dv numbers
    /*var totalFatDV = document.getElementById("fatDV");
    var fatDV = parseInt(totalFatDV.innerHTML, 10);

    var totalCholesterolDV = document.getElementById("cholesterolDV");
    var cholesterolDV = parseInt(totalCholesterolDV.innerHTML, 10);

    var totalSodiumDV = document.getElementById("sodiumDV");
    var sodiumDV = parseInt(totalSodiumDV.innerHTML, 10);

    var totalCarbsDV = document.getElementById("carbsDV");
    var carbsDV = parseInt(totalCarbsDV.innerHTML, 10);
    console.log(carbsDV);

    //function to inout the data into chat js canvas called fatDVChart
    var fatdvContext = document.getElementById("fatDVChart").getContext('2d');
    /*var dvChart = new Chart(dvContext, {
        type: 'doughnut',
        data: {
            labels: ["Fat DV%", "Cholesterol DV%", "Sodium DV%", "Carbohydrates DV%"],
            datasets: [{
                backgroundColor: ["#e04152", "#35adda", "#ffcf48", "#8cc34b"],
                data: [fatDV, cholesterolDV, sodiumDV, carbsDV]
            }] //end datasets
        } //end data
    }); //end of dvChart*/
    /*//dv for fat
    var fatDVChart = new Chart(fatdvContext, {
        type: 'doughnut',
        data: {
            labels: ["Daily Fat DV%"],
            datasets: [{
                backgroundColor: ["#35adda", "#ccd0d9"],
                data: [fatDV, ( 100 - fatDV)]
            }] //end datasets
        }//end data
    }); //end of fatDVChart

    //--------------------------

    var choldvContext = document.getElementById("cholesterolDVChart").getContext('2d');
    var cholesterolDVChart = new Chart(choldvContext, {
        type: 'doughnut',
        data: {
            labels: ["Daily Cholesterol DV%"],
            datasets: [{
                backgroundColor: ["#35adda", "#ccd0d9"],
                data: [cholesterolDV, ( 100 - cholesterolDV)]
            }] //end datasets
        }//end data
    }); //end of cholesterolDVChart

    //--------------------------

    var sodiumdvContext = document.getElementById("sodiumDVChart").getContext('2d');
    var sodiumDVChart = new Chart(sodiumdvContext, {
        type: 'doughnut',
        data: {
            labels: ["Daily Sodium DV%"],
            datasets: [{
                backgroundColor: ["#35adda", "#ccd0d9"],
                data: [sodiumDV, ( 100 - sodiumDV)]
            }] //end datasets
        }//end data
    }); //end of cholesterolDVChart

    //--------------------------

    var carbsdvContext = document.getElementById("carbsDVChart").getContext('2d');
    var carbsDVChart = new Chart(carbsdvContext, {
        type: 'doughnut',
        data: {
            labels: ["Daily Carbs DV%"],
            datasets: [{
                backgroundColor: ["#35adda", "#ccd0d9"],
                data: [carbsDV, (100 - carbsDV)]
            }] //end datasets
        }//end data
    }); //end of cholesterolDVChart*/

}); //end of page load



