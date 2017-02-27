<?php
    echo "<div class='icon ".$value['type']."'>";
?>
    <br><br>
    <a href= <?php echo "'".$value['path']."'"; ?> download  class="download"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
    <button class="replace">replace</button>
    <button class="rename">rename</button>
    <i class="fa fa-trash delete" aria-hidden="true"></i>

    <span class="name"><?php echo $value['name']; ?></span><span class="extFile"><?php echo ".".$value["type"]; ?></span>

    <form class="replaceForm toHide" action="../../assets/scripts/PHP/managingFiles/replaceFiles.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <br>
        <input type="number" name="notForUser" class="notForUser" value=<?php echo "".$value['id'].""; ?>>
        <input type="submit" class="button">
    </form>

    <form class="renameForm toHide" action="../../assets/scripts/PHP/managingFiles/renameFiles.php" method="post">
        <label for=<?php
        echo "'name".$numberForId."'";
        ?> >name : </label>
        <input type="number" name="notForUser" class="notForUser" value=<?php echo "".$value['id'].""; ?>>
        <input type="text" name="name" placeholder="type here the name of your file" id=<?php
        echo "'name".$numberForId."'";
        ?>><br>
        <input type="submit" class="button">
    </form>


    <form class="deleteForm toHide" action="../../assets/scripts/PHP/managingFiles/deleteFiles.php" method="post">
        <input type="number" name="notForUser" class="notForUser" value=<?php echo "".$value['id'].""; ?>>
        <p>WARNING : ARE YOU SURE YOU WANT TO DELETE THIS FILE? THIS CAN'T BE UNDONE!</p>
        <input type="submit" class="button">
    </form>
</div>