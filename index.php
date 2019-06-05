<?php
session_start();
require_once("./tools/functions.php");
if(isset($_POST['airline']) && isset($_POST['user']) && isset($_POST['pass'])){
	$login = longin_user($_POST['airline'], $_POST['user'], $_POST['pass'], $_POST['rememberme']);
	if(count($login['member']) != 0 && $login['error'] == ''){
		unset($_SESSION['error']);
		$_SESSION['user'] = $login['member'];
		header('Location: hotels.php');
	}
	else{
		$_SESSION['error'] = $login['error'];
		header('Location: index.php');
	}
}
else{
$airlines = get_airlines();

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">

    <title>ID90 Travel</title>
  </head>
  <body>
    <div class="container">
	    <div class="row">
	      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
	        <div class="card card-signin my-5">
	          <div class="card-body">
	          	<div class="row">
	          		<img class="logo" src="./img/logo.png">
	          	</div>
	            <form method="post">
	              <div class="form-label-group">
	                <select id="inputAirline" name="airline" class="form-control" required autofocus>
	                	<?
	                	foreach ($airlines as $a) {
	                		?>
	                		<option value="<?=$a[display_name]?>"><?=$a['display_name']?></option>
	                		<?
	                	}
	                	?>
	                </select>
	                <label for="inputAirline">Airline</label>
	              </div>

	              <div class="form-label-group">
	                <input type="text" id="inputUser" name="user" class="form-control" placeholder="Username" required>
	                <label for="inputUser">Username</label>
	              </div>

	              <div class="form-label-group">
	                <input type="password" id="inputPassword" name="pass" class="form-control" placeholder="Password" required>
	                <label for="inputPassword">Password</label>
	              </div>

	              <div class="custom-control custom-checkbox mb-3">
	                <input type="checkbox" class="custom-control-input" id="customCheck1" name="rememberme" value="1">
	                <label class="custom-control-label" for="customCheck1">Remember password</label>
	              </div>
	              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Sign in</button>
	            </form>
	          </div>
	          <?
	              if(isset($_SESSION['error'])){
	              ?>
	              	<div class="alert alert-danger alert-dismissible fade show" role="alert">
					  <?=$_SESSION['error']?>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
	          	  <?
	          	  	session_destroy();
	          	  }
	          	  ?>
	        </div>
	      </div>
	    </div>
	  </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
<?}?>
