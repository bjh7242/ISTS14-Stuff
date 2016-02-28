// Script to load temperature values from team temp records
//setInterval(function() {loadDoc(url, getNumber, teamDivID)},3000);

// loadDoc
function loadDoc(url, teamID, teamDivID) {
  var xhttp;
  xhttp=new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      document.getElementById(teamID).innerHTML = xhttp.responseText + "&deg;F";
      var div = document.getElementById(teamDivID);
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


// loadDoc
function loadDoc1(url, teamID, teamDivID) {
  var xhttp;
  xhttp=new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      document.getElementById(teamID).innerHTML = xhttp.responseText + "&deg;F";
      var div = document.getElementById(teamDivID);
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

function loadDoc11(url, teamID, teamDivID) {
  var xhttp;
  xhttp=new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      document.getElementById(teamID).innerHTML = xhttp.responseText + "&deg;F";
      var div = document.getElementById(teamDivID);
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
