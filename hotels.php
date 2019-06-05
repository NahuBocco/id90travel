<?php
session_start();
if(!isset($_SESSION['user'])){
	header('Location: index.php');
}
require_once("./tools/functions.php");

?>

<!doctype html>
<html lang="en" style="background: rgba(14,71,161,1);">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">

    <title>ID90 Travel</title>
  </head>
  <body style="background: rgba(14,71,161,1);">
  	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <div class="container">
	    <a class="navbar-brand" href="#">
	    	<img class="nav-logo" src="./img/logo.png">
	    </a>
	    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	      <ul class="navbar-nav ml-auto">
	        <li class="nav-item dropdown">
	          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          <?=$_SESSION['user']['email']?>
	        </a>
	          <!-- Here's the magic. Add the .animate and .slide-in classes to your .dropdown-menu and you're all set! -->
	          <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
	            <a class="dropdown-item" href="#" id="signout">Sign Out</a>
	          </div>
	        </li>
	      </ul>
	    </div>
	  </div>
	</nav>

	<div class="container">
	    <div class="row">
	      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto" style="flex: 0 0 90%; max-width: 90%">
	        <div class="card card-signin my-5">
	          <div class="card-body">
	            <form method="post">

	              <div class="form-label-group">
	                <input type="text" id="inputDest" name="destination" class="form-control" placeholder="Destination" required>
	                <label for="inputDest">Destination</label>
	              </div>

	              <div class="row">
		            <div class="col-md-4">
		            	<div class="form-label-group">
							<input type="date" id="inputCheckin" name="checkin" class="form-control" required>
							<label for="inputCheckin">Check-in</label>
						</div>
		            </div>
		            <div class="col-md-4">
		            	<div class="form-label-group">
							<input type="date" id="inputCheckout" name="checkout" class="form-control" required>
							<label for="inputCheckout">Check-Out</label>
						</div>
		            </div>
		            <div class="col-md-4">
		            	<div class="form-label-group">
							<input type="number" id="inputGuests" name="guests" class="form-control" required>
							<label for="inputGuests">Guests</label>
						</div>
		            </div>
	              </div>

	              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Search</button>
	            </form>
	          </div>
	        </div>
	      </div>
	    </div>

	    <?if(isset($_POST['destination']) && isset($_POST['checkin']) && isset($_POST['checkout']) && isset($_POST['guests'])){
	    	$hotels = search_hotel($_POST['guests'], $_POST['checkin'], $_POST['checkout'], $_POST['destination']);
	    	?>




			<div class="card-columns">

			<?foreach($hotels['hotels'] as $h){?>
			  <div class="card">
			    <img class="card-img-top" src="<?=$h[image]?>">
			    <div class="card-body">
			      <h5 class="card-title"><?=$h['name']?></h5>
			      <p class="card-text">Rating <?=$h['review_rating']?>/10</p>
			      <a href="https://www.google.com/maps/search/?api=1&query=<?=$h[location][latitude]?>,<?=$h[location][longitude]?>" target="_blank"><img class="map" src="./img/map.svg"></a>
			    </div>
			  </div>
			<?}?>

			</div>





	    <?}?>
	  </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>

  <script type="text/javascript">
  	$("#signout").click(function(){
	  $.ajax({url: "./include/signout.php", success: function(result){
	    window.location = "./";
	  }});
	});
  </script>
</html>