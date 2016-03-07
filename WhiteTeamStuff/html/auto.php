<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>
$( document ).ready(function() {
function alertFunc() {
	$.post( "feed.php", function( data ) {
	  $( "#result" ).html( data );
	});
}
myVar = setInterval(alertFunc, 10000);
alertFunc();
});
</script>
<div id="result"></div>
