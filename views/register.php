<?php require('views/inc/head.html');?>
    <body>
        <?php
            $link = '<p> </p><a href="?action=login"><i class="fa fa-home" aria-hidden="true"></i>log in</a>';
            require('views/inc/header.php');
        ?>
        <form name="signUp" method="POST" action="register.php">
            <fieldset>
                <label for="username">login : </label>
                <input type="text" name="username" id="username" placeholder="login"><br>

                <label for="email">email : </label>
                <input type="email" name="email" id="email" placeholder="xyz@example.com"><br>

                <label for="password">password : </label>
                <input type="password" name="password" id="password" placeholder="password">
                <br>

                <label for="confirmationOfPassword">confirm your password : </label>
                <input type="password" name="confirmationOfPassword" id="confirmationOfPassword" placeholder="confirm your password"><!--BONUS : add button show password -->
                <br>

                <label for="indic">password indication</label>
                <input type="text" name="indic" id="indic" placeholder="this will be displayed if you don't remember your password"><br>
                <!--TODO : include capcha if have time-->
                <button>send</button>
            </fieldset>
        </form>


        <p id='message'></p>




        <script type="text/javascript" src="assets/JS/signUpScript.js"></script>
    </body>
</html>
