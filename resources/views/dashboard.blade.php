<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    @if (session('success'))
    <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 6px; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
@endif
    <h2>Welcome, {{ Auth::user()->name }} </h2>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
