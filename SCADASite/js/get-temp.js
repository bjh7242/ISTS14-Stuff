// Script to load temperature values from team temp records
//setInterval(function() {loadDoc(url, getNumber)},3000);

// loadDoc
function loadDoc(url, teamID) {
  var xhttp;
  xhttp=new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      document.getElementById(teamID).innerHTML = xhttp.responseText + "&deg;F";
      var div = document.getElementById("t5box");
      if (xhttp.responseText > 70) {
        div.style.backgroundColor="red";
      }
      else {
        div.style.backgroundColor="green";
      }
    }
  };
  xhttp.open("GET", url, true);
  xhttp.send();
}

//function getNumber(xhttp) {
//  document.getElementById(teamID).innerHTML = xhttp.responseText + "&deg;F";
//}
