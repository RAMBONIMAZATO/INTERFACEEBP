<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<a href="abstract.php?manuscript_id=' . $manuscript_id . '" class="clickMe">
<div id="results"></div>

<script type="text/javascript">
$('a.clickMe').click(function(e){
   // Stop default click action in browser
   e.preventDefault();

   // Make ajax call
   $.ajax($(e.target).attr("href"), {
     cache:false,
     success:function(data){
         $("#results").html(data);
     }
   });
})
</script>
</body>
</html>