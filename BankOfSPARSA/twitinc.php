<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>

function explode(){
$.get("twit.php", function( data ) {
  $( "#twit" ).html( data );
});
}
setInterval(explode, 5000);
</script>
<div id="twit" ><?php include("twit.php");?></div>
