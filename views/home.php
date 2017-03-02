<?php require('views/inc/head.html');
?>
    <body>
        <?php
            $link = '<a href="?action=logout"><i class="fa fa-power-off" aria-hidden="true"></i>log&nbsp;out</a>';
            require('views/inc/header.php');
        ?>

        <div class="creationSpace">
            <div class="creationButtons">
                <button id="upload">upload file</button>
                <button id="folder">create folder</button>
            </div>

            <form class="toHide uploadForm" action="?action=upload" method="post" enctype="multipart/form-data" name="uploadFile">
                <div class="centeredChild">
                    <input type="file" name="file">
                    <br>
                    <label for="name">name : </label>
                    <input id="name" type="text" name="name" placeholder="type here the name of your file"><br>
                    <input type="submit" id="uploadFile">
                </div>
            </form>

            <form class="toHide addFolder" action="?action=add_folder" method="post"  name="addFolder">
                <div class="centeredChild">
                    <!--<input type="file" name="file" webkitdirectory directory multiple>
                    <br> POSSIBLY USEFUL IF IMPLEMENT A DIRECT UPLOAD OF FOLDER.-->
                    <label for="name">name : </label>
                    <input id="name" type="text" name="name" placeholder="type here the name of your folder"><br>
                    <input type="submit" id="addFolder">
                </div>
            </form>

            <!--TODO give better style for these two forms. No time right now.-->

            <p id="message" class="message red">
                <?php echo $_SESSION['errorMessage'] ?>
            </p>
        </div class="creationSpace">

        <script src="assets/JS/files.js"></script>

        <div class='centeringDiv blueBackground'><div class='listFilesUser'>