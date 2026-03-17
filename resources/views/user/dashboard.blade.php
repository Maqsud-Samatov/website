<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
</head>
<body>
    <h1>👤 User Dashboard</h1>
    <p>Salom, {{ auth()->user()->name }}!</p>
    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Chiqish</button>
    </form>
</body>
</html>