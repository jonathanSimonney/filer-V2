<?php require('views/inc/head.html');
?>
    <body>
        <?php
            $link = '<a href="?action=logout"><i class="fa fa-power-off" aria-hidden="true"></i>log&nbsp;out</a>';
            require('views/inc/header.php');
        ?>
        <h1 class="message red">use the following to upload your file.</h1>
        <form action="?action=upload" method="post" enctype="multipart/form-data" name="uploadFile">
            <fieldset class="centeredChild">
                <input type="file" name="file">
                <br>
                <label for="name">name : </label>
                <input id="name" type="text" name="name" placeholder="type here the name of your file"><br>
                <input type="submit" id="uploadFile">
            </fieldset>
        </form>

        <p id="message" class="message red">
            <?php echo $_SESSION['errorMessage'] ?>
        </p>


        <script src="assets/JS/files.js"></script>
    </body>

<?php
/*
<!----------------------------------------------------------form to add files----------------------------------------------------------->
    <?php



    try{
        $db = new PDO("mysql:host=localhost;dbname=filer","root","password");

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $request = "SELECT * FROM `files` WHERE `files`.`user_id` = ".$_SESSION["idUser"].";";
        $statement = $db->prepare($request);
        $statement->execute();

        $arrayColumn = $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    catch(PDOException $e){
        echo $e;
    }


    $numberForId = 1;

    echo "<div class='centeringDiv blueBackground'><div class='listFilesUser'>";

    foreach ($arrayColumn as $key => $value) {
        echo "<div class='icon ".$value["fileType"]."'>";
        ?>
        <br><br>
        <a href= <?php echo "'".str_replace('../../..', '../../assets', $value["pathFile"])."'"; ?> download  class="download"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
        <button class="replace">replace</button>
        <button class="rename">rename</button>
        <i class="fa fa-trash delete" aria-hidden="true"></i>

        <span class="nameFile"><?php echo $value["nameFile"]; ?></span><span class="extFile"><?php echo ".".$value["fileType"]; ?></span>

        <form class="replaceForm toHide" action="../../assets/scripts/PHP/managingFiles/replaceFiles.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <br>
            <input type="number" name="notForUser" class="notForUser" value=<?php echo "".$value["id"].""; ?>>
            <input type="submit" class="button">
        </form>

        <form class="renameForm toHide" action="../../assets/scripts/PHP/managingFiles/renameFiles.php" method="post">
            <label for=<?php
            echo "'name".$numberForId."'";
            ?> >name : </label>
            <input type="number" name="notForUser" class="notForUser" value=<?php echo "".$value["id"].""; ?>>
            <input type="text" name="name" placeholder="type here the name of your file" id=<?php
            echo "'name".$numberForId."'";
            $numberForId++;
            ?>><br>
            <input type="submit" class="button">
        </form>


        <form class="deleteForm toHide" action="../../assets/scripts/PHP/managingFiles/deleteFiles.php" method="post">
            <input type="number" name="notForUser" class="notForUser" value=<?php echo "".$value["id"].""; ?>>
            <p>WARNING : ARE YOU SURE YOU WANT TO DELETE THIS FILE? THIS CAN'T BE UNDONE!</p>
            <input type="submit" class="button">
        </form>



        <?php
        echo "</div>";
    }


    ?>

    </div></div>

    <script src="../../assets/scripts/JS/listFiles.js"></script>
*/?>