$(document).ready(function(){

    //nutrition chart
    //get nutrition numbers
    var totalCals = document.getElementById("totalCals");
    var cals = parseInt(totalCals.innerHTML, 10);

    var totalFat = document.getElementById("totalFat");
    var fat = parseInt(totalFat.innerHTML, 10);

    var totalCholesterol = document.getElementById("totalCholesterol");
    var cholesterol = parseInt(totalCholesterol.innerHTML, 10);

    var totalSodium = document.getElementById("totalSodium");
    var sodium = parseInt(totalSodium.innerHTML, 10);

    var totalCarbs = document.getElementById("totalCarbs");
    var carbs = parseInt(totalCarbs.innerHTML, 10);

    var totalProtein = document.getElementById("totalProtein");
    var protein = parseInt(totalProtein.innerHTML, 10);

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
                data: [cals, fat, cholesterol, sodium, carbs, protein]
            }] //end datasets
        } //end data
    }); //end nutritionChart var

    //---------------------------
    //dv chart
    //get dv numbers
    var totalFatDV = document.getElementById("fatDV");
    var fatDV = parseInt(totalFatDV.innerHTML, 10);

    var totalCholesterolDV = document.getElementById("cholesterolDV");
    var cholesterolDV = parseInt(totalCholesterolDV.innerHTML, 10);

    var totalSodiumDV = document.getElementById("sodiumDV");
    var sodiumDV = parseInt(totalSodiumDV.innerHTML, 10);

    var totalCarbsDV = document.getElementById("carbsDV");
    var carbsDV = parseInt(totalCarbsDV.innerHTML, 10);

    //function to inout the data into chat js canvas called dvChart
    var dvContext = document.getElementById("dvChart").getContext('2d');
    var dvChart = new Chart(dvContext, {
        type: 'doughnut',
        data: {
            labels: ["Fat DV%", "Cholesterol DV%", "Sodium DV%", "Carbohydrates DV%"],
            datasets: [{
                backgroundColor: ["#e04152", "#35adda", "#ffcf48", "#8cc34b"],
                data: [fatDV, cholesterolDV, sodiumDV, carbsDV]
            }] //end datasets
        } //end data
    }); //end of dvChart

}); //end of page load



