<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>通過状況</title>

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
		<div class="container">
		<table class="table">
			<tr>
				<th>ナンバー</th>
				<th>場所</th>
				<th>時間</th>
				<th>チェック</th>
			</tr>
		<?php
			try{
				$pdo = new PDO('mysql:host=localhost;dbname=stamprally;charset=utf8', 'piyo', 'piyopiyo', array(PDO::ATTR_EMULATE_PREPARES => false));
			} catch(PDOEvception $e){
				exit('データベース接続失敗。'.$e->getMessage());
			}
			$idm = $_POST['idm'];
			$point = $_POST['point'];
			$chk = $pdo -> prepare('select count(*) from passage_time where idm = :idm and point = :point');
			$chk -> bindValue(':idm', $idm);
			$chk -> bindValue(':point', $point);
			$chk -> execute();
			if($chk -> fetchColumn() == 0){
				$smtp = $pdo -> prepare('INSERT INTO PASSAGE_TIME (IDM, POINT) VALUES(:IDM, :POINT)');
				$smtp -> bindValue(':IDM', $idm);
				$smtp -> bindValue(':POINT', $point);
				$smtp -> execute();
			}
			
			$get_passage = $pdo -> prepare('SELECT check_point.point, check_point.name, passage_time.time FROM check_point LEFT JOIN passage_time ON check_point.point = passage_time.point and passage_time.idm = :idm order by check_point.point asc');
			$get_passage -> bindValue(':idm', $idm);
			$get_passage -> execute();
			?>
			<?php while($row = $get_passage -> fetch(PDO::FETCH_ASSOC)): ?>
			<tr>
				<td><?php echo $row["point"]; ?></td>
				<td><?php echo $row["name"]; ?></td>
				<td><?php
					if($row["time"] != null){
						echo $row["time"];
					}
					?>
				</td>
				<td><?php
					if($row["time"] != null){
						echo 'CHECK';
					}?>
				</td>
			</tr>
			<?php endwhile; ?>
		</table>
		</div>
	</body>
</html>