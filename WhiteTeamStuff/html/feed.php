<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
<?php
$servername = "localhost";
$username = "bankapi";
$password = "ThisIsThe*BankAPI*Password";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
mysqli_select_db($conn,"bank");
$res = mysqli_query($conn,"SELECT * FROM `Audit` ORDER BY `uid` DESC limit 50");
print '<table border="1" class="pure-table">';
?>
    <thead>
        <tr>
            <th>id</th>
            <th>Src</th>
            <th>Dst</th>
	    <th>action</th>
	    <th>data</th>
 	    <th>ip Src<th>
        </tr>
    </thead>
<?php
while($row = $res->fetch_assoc()) {
    print '<tr>';
    print '<td>'.$row["uid"].'</td>';
    if($row["uidSrc"] == "0000000"){
	print '<td>Scoring</td>';
}else{
    print '<td>'.$row["uidSrc"].'</td>';
}
    print '<td>'.$row["uidDst"].'</td>';
    print '<td>'.$row["action"].'</td>';
    print '<td>'.$row["data"].'</td>';
    print '<td>'.$row["ip_addr"]."</td>";
    print '</tr>';
}  
print '</table>';
mysqli_close($con);
?>
