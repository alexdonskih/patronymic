<?php
header('content-type: text/html; charset=utf-8');

require_once('name_parse.class.php');

$patronymic = trim($_POST['patronymic']);

if(!empty($patronymic)){
	$np = new name_parse();

	$np->init_name_db('name_db.txt');

	$name = $np->analyze($patronymic);

	$result = $np->print_result($name);
}

require_once('tpl.php');