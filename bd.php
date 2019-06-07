<?php
	/**
	Подключаемся к бд
	*/
	$db = mysql_connect("localhost", "root", "qwertyu");
	mysql_select_db("vlad", $db);
?>
