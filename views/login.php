<?php require('views/inc/head.html');
?>
    <body>
        <?php
            $link = '<p> </p><a href="?action=register"><i class="fa fa-sign-in" aria-hidden="true"></i>register</a>';
            require('views/inc/header.php');
        ?>
        <button id="buttonDisplay">log in</button>
        <br><br>

        <form name="connect" method="POST" action="logIn.php" class="toHide">
            <fieldset>
                <label for="username">username</label>
                <input type="text" name="username" id="username" placeholder="username">
                <label for="password">password : </label>
                <input type="password" name="password" id="password" placeholder="*******">
                <br>
                <button>Send</button>
            </fieldset>
        </form>

        <p id="message" class="message red">
            <?php echo $_SESSION['errorMessage'];?>
        </p>

        <script src="assets/JS/login.js"></script>
    </body>
</html>