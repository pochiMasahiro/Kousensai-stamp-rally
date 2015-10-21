<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>高専祭スタンプラリー</title>

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
		<h2>高専祭スタンプラリー</h2>
	</header>

	<div class="container">
		
		<!-- register database -->
		<?php
		try{
			$pdo = new PDO('mysql:host=localhost;dbname=stamprally;charset=utf8', 'piyo', 'piyopiyo', array(PDO::ATTR_EMULATE_PREPARES => false));
		} catch(PDOEvception $e){
			exit('データベース接続失敗。'.$e->getMessage());
		}
		
		$stmt = $pdo->prepare('INSERT INTO ACCOUNT (name, gender, age, idm, affiliation) VALUES(:name, :gender, :age, :idm, :affiliation)');
		$stmt -> bindParam(':name', $name);
		$stmt -> bindParam(':gender', $gender_eng);
		$stmt -> bindParam(':age', $age);
		$stmt -> bindParam(':idm', $idm);
		$stmt -> bindParam(':affiliation', $affiliation);
		$idm = $_POST["idm"];
		$name = htmlspecialchars($_POST["name"], ENT_QUOTES, 'UTF-8');
		$age = htmlspecialchars($_POST["age"], ENT_QUOTES, 'UTF-8');
		$gender_eng = $_POST["gender"];
		$affiliation = $_POST["affiliation"];
		$state = $stmt -> execute();
		
		$gender = null;
		if($gender_eng === 'male'){
			$gender = '男';
		}else if($gender_eng === 'female'){
			$gender = '女';
		}
		?>
		<?php if($state):?>
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
						<td><?php echo $name;?></td>
					</tr>
					<tr>
						<th scope="row">年齢</th>
						<td><?php echo $age;?></td>
					</tr>
					<tr>
						<th scope="row">性別</th>
						<td><?php echo $gender;?></td>
					</tr>
					<tr>
						<th scope="row">カード識別番号</th>
						<td><?php echo $idm;?></td>
				</tr>
			</table>
		<?php else: ?>
		<div class="contents-header">
			<h2>すでに登録されています</h2>
		</div>
		<div class="jumbotron">
		<?php endif; ?>
			<a class="btn btn-primary" href="register.html" role="button">
				<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
				終了
			</a>
		</div>
	</div>
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
  </body>
</html>