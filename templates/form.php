<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trade form</title>
    <link href="css/main.css" rel="stylesheet">
</head>
<body>

<div class="form">
    <form action="/trade/store" method="post">
        <input type="text" name="first_name" class="form-control" placeholder="Имя">
        <input type="text" name="last_name" class="form-control" placeholder="Фамилия">
        <input type="email" name="email" class="form-control" placeholder="Email">
        <input type="tel" name="phone" class="form-control" placeholder="Телефон">
        <input type="number" name="sum" class="form-control" placeholder="Сумма сделки">
        <textarea name="comment" class="form-control" cols="30" rows="10" placeholder="Комментарий"></textarea><br>
        <input type="submit" class="form-control">
    </form>
</div>

</body>
</html>