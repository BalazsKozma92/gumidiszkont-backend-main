<!DOCTYPE html>
<html>
<head>
    <title>Jelszó megváltoztatása</title>
</head>
<body>
    <p>Kedves {{ $name }}!</p>
    <p>Kattints az alábbi linkre a jelszavad megváltoztatásához:</p>
    <br>
    <p>
        <a href={{ $resetLink }}>jelszóváltoztatás</a>
    </p>
    <br>
    <p>Üdvözlettel, Gumidiszkont</p>
</body>
</html>
