<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>@TITLE</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- My CSS -->
	<link href="section.css" rel="stylesheet">
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
  </head>
  <body>
	<header>
		<h2>@NAME</h2>
	</header>
	
	<div class="container">
		<div class="contents-header">
			<h2>登録されました</h2>
		</div>
		<div class="jumbotron">
			<p>
				登録情報
			</p>
			<table class="table">
				<tbody>
					<tr>
						<th scope="row">ニックネーム</th>
						<td>
							<?php
								if(($name = $_POST["name"]) != null){
									print($name);
								}
							?>
						</td>
					</tr>
					<tr>
						<th scope="row">年齢</th>
						<td>
							<?php
								if(($age = $_POST["age"]) != null){
									print($age);
								}
							?>
						</td>
					</tr>
					<tr>
						<th scope="row">性別</th>
						<td>
							<?php
								if(($gender = $_POST["gender"]) != null){
									if($gender == "man"){
										print("男");
									}else if($gender == "woman"){
										print("女");
									}
								}
							?>
						</td>
					</tr>
					<tr>
						<th scope="row">カード識別番号</th>
						<td>
							<?php
								if(($idm = $_POST["idm"]) != null){
									print($idm);
								}
							?>
						</td>
					</tr>
			</table>
			<a class="btn btn-primary" href="register.html" role="button">
				<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
				終了
			</a>
		</div>
		<div class="contents-footer">
			<div class="progress">
				<div class="progress-bar" style="width:60%;" role="progressbar">6/10</div>
			</div>
		</div>
	</div>
	
	<footer>
		<h2>@copy right?</h2>
	</footer>
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
  </body>
</html>