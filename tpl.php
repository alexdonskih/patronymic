<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Анализ отчества</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>

<div id="container">
	<h2>Укажите отчество, чтобы получить имя от которого оно образовано</h2>
	<?=(empty($result))? "" : $result.'<br><br>'?>
	<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
		<input type="text" name="patronymic" id="patronymic">
		<br>
		<input type="submit" id="submit" value="Анализировать">
	</form>
</div>
</body>
</html>