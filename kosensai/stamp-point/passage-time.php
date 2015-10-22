<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="0" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>通過状況</title>

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- My CSS -->
		<link href="section.css" rel="stylesheet">
		
		<!-- play audio and move previous page -->
		<script type="text/javascript">
			function move(){
				var link = "<?php echo $_POST["link"];?>";
				document.location.href = link;
			}
			
			window.onload = (function(){
				document.getElementById('sound-file').play();
				setTimeout("move()", 20000);
			});
			
		</script>
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<audio id="sound-file" preload="auto">
			<source src="decision4.mp3" type="audio/mp3">
		</audio>
		<div class="container">
		<?php
			try{
				$pdo = new PDO('mysql:host=localhost;dbname=stamprally;charset=utf8', 'piyo', 'piyopiyo', array(PDO::ATTR_EMULATE_PREPARES => false));
			} catch(PDOEvception $e){
				exit('データベース接続失敗。'.$e->getMessage());
			}
			$idm = $_POST['idm'];
			$point = $_POST['point'];
			
			$chk_account = $pdo -> prepare('select name from account where idm = :idm ');
			$chk_account -> bindValue(':idm', $idm);
			$chk_account -> execute();
		?>
		<?php if(($row_name = $chk_account -> fetchColumn()) != null): ?>
			<span class="lead"><?php echo $row_name; ?></span>さん
			<table class="table">
			<tr>
				<th>記号</th>
				<th>場所</th>
				<th>時間</th>
				<th>チェック</th>
			</tr>
			<?php
			$chk_point = $pdo -> prepare('select count(*) from passage_time where idm = :idm and point = :point');
			$chk_point -> bindValue(':idm', $idm);
			$chk_point -> bindValue(':point', $point);
			$chk_point -> execute();
			if($chk_point -> fetchColumn() == 0){
				$smtp = $pdo -> prepare('INSERT INTO PASSAGE_TIME (IDM, POINT) VALUES(:IDM, :POINT)');
				$smtp -> bindValue(':IDM', $idm);
				$smtp -> bindValue(':POINT', $point);
				$smtp -> execute();
			}
			
			$get_passage = $pdo -> prepare('SELECT check_point.sign, check_point.name, passage_time.time FROM check_point LEFT JOIN passage_time ON check_point.point = passage_time.point and passage_time.idm = :idm order by check_point.point asc');
			$get_passage -> bindValue(':idm', $idm);
			$get_passage -> execute();
			?>
			<?php while($row = $get_passage -> fetch(PDO::FETCH_ASSOC)): ?>
				<tr>
					<td><?php echo $row["sign"]; ?></td>
					<td><?php echo $row["name"]; ?></td>
					<td><?php
						if($row["time"] != null){
							echo $row["time"];
						}
						?>
					</td>
					<td><?php
						if($row["time"] != null){
							echo "<span class=\"glyphicon glyphicon-ok\"></span>";
						}?>
					</td>
				</tr>
		<?php endwhile; echo '</table>'	?>
		<?php else: ?>
			<h1>アカウントが登録されていません</h1>
		<?php endif; ?>
		</div>
	</body>
</html>