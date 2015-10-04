<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>通過状況</title>
	</head>
	<body>
		<table>
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
	</body>
</html>