//Created By Rahul Malik
 $(document).ready(function() {

    var FromLatitude = document.getElementById("FromLatitude");
	var FromLongitude = document.getElementById("FromLongitude");
	var ToLatitude = document.getElementById("ToLatitude");
	var ToLongitude = document.getElementById("ToLongitude");
	$('#CalculateButton').hide();
    $('#StartButton').click(
     // Handles the start click event
    function () {
        if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showFromPosition);
		} else {
			alert("Geolocation is not supported by this browser.");
		}
        
     }
     );
     $('#EndButton').click(
     // Handles the start click event
    function () {
        if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showEndPosition);
		} else {
			alert("Geolocation is not supported by this browser.");
		}
		
        
     }
     ); 
	 $('#CalculateButton').click(
     // Handles the start click event
    function () {
		var FromLatitude = document.getElementById("FromLatitude");
		var FromLongitude = document.getElementById("FromLongitude");
		var ToLatitude = document.getElementById("ToLatitude");
		var ToLongitude = document.getElementById("ToLongitude");
		var url='Tracking.php?FromLatitude='+FromLatitude.value+'&FromLongitude='+FromLongitude.value+'&ToLatitude='+ToLatitude.value+'&ToLongitude='+ToLongitude.value;
			LoadDoc(url, CalculateDistance);
        
        
     }
     ); 
});
function CalculateDistance(xhttp)
{
		
		if(isNaN(xhttp.responseText))
		{
			alert("You are still at same place.");
	    }
		else
		{
			alert(xhttp.responseText);
		}
		
}
function LoadDoc(url, cFunction) {
  var xhttp;
  xhttp=new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      cFunction(this);
    }
  };
  xhttp.open("GET", url, true);
  xhttp.send();
}

function showFromPosition(position) {
    FromLatitude.value=position.coords.latitude;
    FromLongitude.value=position.coords.longitude; 
	
}
function showEndPosition(position) {
    ToLatitude.value=position.coords.latitude;
    ToLongitude.value=position.coords.longitude; 
	$('#CalculateButton').show();
}