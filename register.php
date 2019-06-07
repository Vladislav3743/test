<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<title>Регистрация</title>
</head>
<body>
	<header>
		<h1>Для успешной регистрации заполните форму снизу</h1>
	</header>
	<section>
		<dir class="form">
			<form>
				<label for="login">Введите ваш логин</label>
				<input type="text" id="login">
				<label for="password">Введите ваш пароль</label>
				<input type="password" id="password"><br>
				<label id="button">ОТПРАВИТЬ</label>
			</form>
		</dir>
	</section>
	<script type="text/javascript">
		$('#button').on("click", ()=>{
			if(!isEmpty($('#login').val()) && !isEmpty($('#password').val())){
				$.ajax({
					url: 'server.php',
					type: 'post',
					dataType: 'json',
					data:{
						command: 'register',
						login: $('#login').val(),
						password: $('#password').val()
					},
					success: (data)=>{
						if(data != "Login or password is not pass correct"){
							window.location.href = "/index.php";
						}
						else alert(data);
					},
					error: (data)=>{
						alert("Ошибка работы сервера");
						console.log(data);
					}
				})
			}else return alert("Вы не все заполнили!");
		})

		function isEmpty(obj){for(var key in obj) return false; return true}
	</script>
</body>
</html>