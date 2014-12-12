<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Administrative Login Page</title>
	<link rel="stylesheet" type="text/css" href="/assets/css/login_style.css">
</head>
<body>
<div id="container">
<?php 	if($this->session->flashdata('msg')){	?>
		<div id='message'>
			<h1 class='red'><?=$this->session->flashdata('msg')?></h1>
		</div>
<?php	} 										?>
	<h1>Welcome! Please login for administrative access.</h1>
	<div id="main">
		<form action='/admin' method='post'>
			Email: <input type='text' name='email'>
			Password: <input type='password' name='password'>
			<input type='submit' value='Submit'>
		</form>
	</div>
	<p class="footer"><strong>Product and Orders</strong></p>
</div>
</body>
</html>