<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home page</title>
        <link rel="stylesheet" href="web/style.css">
    </head>
    <body>
        <?php if (!empty($error)): ?>
        <p>Error : <?php echo $error ?></p>
        <?php endif; ?>
        <form action="?action=register" method="POST">
            Login : <input type="text" name="username"><br>
            Email : <input type="text" name="email"><br>
            Password : <input type="password" name="password"><br>
            <input type="submit">
        </form>
    </body>
</html>
