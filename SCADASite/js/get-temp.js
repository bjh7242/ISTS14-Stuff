// Script to load temperature values from team temp records
//setInterval(function() {loadDoc(url, getNumber)},3000);

// loadDoc
function loadDoc(url, teamID) {
  var xhttp;
  xhttp=new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      document.getElementById(teamID).innerHTML = xhttp.responseText + "&deg;F";
    }
  };
  xhttp.open("GET", url, true);
  xhttp.send();
}

//function getNumber(xhttp) {
//  document.getElementById(teamID).innerHTML = xhttp.responseText + "&deg;F";
//}
