<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	ini adalah halaman tes <br>
	<table>
		<tr>
			<th>No</th>
			<th>Nama</th>
		</tr>
		<?php foreach ($kelompok as $row) : ?>
		<tr>
			<td><?= $row['kelompok_id'] ?></td>
			<td><?= $row['kelompok_nama'] ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
		
	</pre>
</body>
</html>