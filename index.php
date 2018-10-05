
<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
require('github_search.php'); 
 
if(isset($_GET['str'])){
	$str = $_GET['str'];
	$search  =  new searchGit($str);
	$search = $search->searcher();
	 echo json_encode($search);
	exit();	
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">

	<title>Minimum Bootstrap HTML Skeleton</title>

	<!--  -->

	<style>

	</style>

</head>

<body>

	<div class="container">

<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    
<div class="row">
  <div class="col-lg-12">
  	<h2>Billion, Dollar, Boy </h2>
  	 <label for="formGroupExampleInput">GitHub Repository Search</label>
    <div class="input-group">

      <input type="text" class="form-control" id="search" placeholder="Search for...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">Search</button>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->

    <div class="col-lg-12">

<div id="result"></div>

    </div>
</div><!-- /.row -->
</div>

	</div>

 

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>



	<script>
		$(document).ready(function($){

		$('#search').val('tetris');
		
		$('button').click(function(){
		$('#result').text('Please wait fetching...');
		const searchTerm = $('#search').val();
		var param = {'str':searchTerm};
		$.ajax({
			type: "GET",
			data: param,
			dataType: "json",
			url: "index.php",
			success: function(data) {
				$('#result').html('');
				var options = [];
				$.each(data, function( key, val) {
					options.push('<p>'+key+ ' - ' +val+'</p>');
				})
				$('#result').html(options);
			}
		})

		})


})
	</script>

</body>

</html>
