<?php
	session_start();
	if(empty($_SESSION['id'])){ header("Location: /index.php"); exit();}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Главная страница</title>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="./style/main.css">
</head>
<body>
	<header>
		<h1 style="text-align: center">Список ваших задач</h1>
	</header>
	<section>
		<div class="tasks">
			<input type="text" id="new">
			<label id="button">Добавить</label>
			<ul id="tasks"></ul>
		</div>
	</section>
	<footer>
		<a href="/exit.php">Выйти</a>
	</footer>
	<script type="text/javascript">
		const id = <?php echo $_SESSION['id']; ?>;
		$.ajax({
			url: 'server.php',
			type: 'post',
			dataType: 'json',
			data:{command: 'load', id: id},
			success: data =>{
				let body = document.getElementById('tasks');
				for(let i = 0; i < data.length / 3; i++){
					let li = document.createElement('li');
					li.id = Number(data[i * 3 + 2]);
					li.onclick = ()=>{
						let answer = confirm(`Вы точно хотите удалить этот таск?`);
						if(answer){
							$.ajax({
								url: 'server.php',
								type: 'post',
								dataType: 'json',
								data: {command: 'del', id: li.id},
								success: data =>{
									$(`#${li.id}`).remove();
								},
								error: data =>{
									alert("Ошибка работы сервера");
									console.log(data);
								}
							})
						}
					};
					li.innerHTML = data[i * 3 + 1];
					body.appendChild(li);
				}

			},
			error: data =>{
				alert("Ошибка работы сервера");
				return console.log(data);
			}
		});
		$('#button').on("click", ()=>{
			if(!isEmpty($('#new').val())){
				$.ajax({
				url: 'server.php',
				type: 'post',
				dataType: 'json',
				data: {command: 'add', task: $('#new').val(), id_user: id},
				success: data=>{
					console.log(data);
					let body = document.getElementById('tasks');
					let li = document.createElement('li');
					li.id = Number(data.responseText);
					li.onclick = ()=>{
						let answer = confirm(`Вы точно хотите удалить этот таск?`);
						if(answer){
							$.ajax({
								url: 'server.php',
								type: 'post',
								dataType: 'json',
								data: {command: 'del', id: data.responseText},
								success: data =>{
									$(`#${li.id}`).remove();
								}
							})
						}
					}
					li.innerHTML = $('#new').val();
					body.appendChild(li);
					return;
				},
				error: data =>{
					alert("Ошибка работы сервера");
					return console.log(data);
				}
			})
			}else return alert("Чтобы добавить новую задачу - заполните отведенное поле!");
		});

		function isEmpty(obj){for(var key in obj) return false; return true}
	</script>
</body>
</html>