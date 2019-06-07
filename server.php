<?php
	session_start();

	include("bd.php");
	switch ($_POST['command']) {
		case 'login':
			$login = $_POST['login'];
			$password = $_POST['password'];
			if(!empty($login) && !empty($password) && is_string($login) && is_string($password)){
				$result = mysql_query("SELECT * FROM user WHERE login='$login'",$db);
				$row = mysql_fetch_array($result);
				if(!empty($row['password']) && $row['password'] == $password){
					$_SESSION['id'] = $row['id'];
					echo json_encode("Успешно!");
					exit();
				}else exit(json_encode("Login or password is not pass correct")); 
			}else exit(json_encode("Login or password is not pass correct"));
		break;
		case 'register':
			$login = $_POST['login'];
			$password = $_POST['password'];
			if(!empty($login) && !empty($password) && is_string($login) && is_string($password)){
				$result = mysql_query("SELECT * FROM user WHERE login='$login'",$db);
				$row = mysql_fetch_array($result);
				if(empty($row['login'])){
					$result = mysql_query("INSERT INTO user (login, password) VALUES ('$login','$password')");
					echo (json_encode("Успешно!"));
					exit();
				}else exit(json_encode("Login or password is not pass correct"));
			}else exit(json_encode("Login or password is not pass correct"));
		break;
		case 'load':
			$id = $_POST['id'];
			$result = mysql_query("SELECT * FROM tasks WHERE id_user='$id'", $db);
			$r = array();
		    while($res=mysql_fetch_array($result))
		    {
		      array_push($r, $res['id_user'], $res['task'], $res['id']);
		    }
		    echo json_encode($r);
		break;
		case 'add':
			$new = $_POST['task'];
			$id = $_POST['id_user'];
			if(!empty($new) && !empty($id)){
				$result = mysql_query("INSERT INTO tasks (id_user, task) VALUES ('$id', '$new')");
				echo json_encode($new);
				exit();	
			}else {echo $id;}
		break;
		case 'del':
			$id = $_POST['id'];
			if(!empty($id)){ $result = mysql_query("DELETE FROM tasks WHERE id='$id'", $db); echo exit(json_encode("Успешно!"));}else exit(json_encode("id tasks is not pass correct"));
		break;
	}

?>
