<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>

	<input type="text" placeholder="user id">
	<button type="button">Fetch!</button>

	<script>
		document.querySelector('button[type="button"]').addEventListener('click', async () => {

			const userId = document.querySelector('input').value;

			const user = await (await fetch (`http://localhost/api-eticaret/user/${userId}`, {
				method: 'get',
				headers: {
					'Content-Type': 'application/json',
					'x-api-key': 'hLj7cIOZhMem8mc4fu8CNkbWuruxeNYK'
				}
			})).json();

			await alert(user?.message ?? 'Başarılı, Console u aç');

			console.log(user);
		});
	</script>
</body>
</html>
