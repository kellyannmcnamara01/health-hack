$(document).ready(function(){

    var context = document.getElementById('nutritionChart').getContext('2d');
    var nutritionChart = new Chart(context, {
        type: 'doughnut',
        data: {
            labels: ["1", "2", "3"],
            datasets: [{
                backgroundColor: [
                    "#333",
                    "#666",
                    "#999"
                ],
                data: [25, 25, 50]
            }] //end datasets
        } //end data
    }); //end nutritionChart var

}); //end of page load



