<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Code Executor</title>
</head>
<body>
    <h1>Welcome to Code Executor</h1>
    <form action="/execute-code" method="post">
        @csrf
        <textarea name="code" rows="10" cols="40" placeholder="Enter your code here"></textarea><br>
        <textarea name="input" ></textarea><br>
        <button type="submit">Execute Code</button>
    </form>
</body>
</html>
