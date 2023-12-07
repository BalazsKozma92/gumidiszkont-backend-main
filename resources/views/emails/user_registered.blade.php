<!DOCTYPE html>
<html>
<head>
    <title>Email cím megerősítése</title>
</head>
<body>
    <p>Kedves {{ $name }}!</p>
    <p>Köszönjük, hogy regisztráltál! A megerősítő kódod a következő:</p>
    <br>
    <p><strong>{{ $confirmationToken }}</strong></p>
    <p>Az alábbi linkre kattintva is véghez viheted a megerősítést: 
        <a href={{ $verificationUrl }}>megerősítés link</a>
    </p>
    <br>
    <p>Ha nem te regisztráltál, akkor kérjük hagyd figyelmen kívül ezt az üzenetet.</p>
    <p>Üdvözlettel, Gumidiszkont</p>
</body>
</html>
