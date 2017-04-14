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
    //dv for fat
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
    }); //end of cholesterolDVChart

}); //end of page load



