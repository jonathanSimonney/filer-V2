<?php
echo "<div class='icon folder'>";
?>
<br><br>
<a href="?action=open&fileId=<?php echo $value['id'] ?>" class="download clickable"><i class="fa fa-folder" aria-hidden="true"></i></a>
<button class="rename clickable">rename</button>
<i class="fa fa-trash delete clickable" aria-hidden="true"></i>

<span class="name"><?php echo $value['name']; ?></span>

<form class="renameForm toHide" action="?action=rename" method="post">
    <label for=<?php
    echo "'name".$numberForId."'";
    ?> >name : </label>
    <input type="number" name="notForUser" class="notForUser" value=<?php echo "".$value['id'].""; ?>>
    <input type="text" name="name" placeholder="type here the name of your file" id=<?php
    echo "'name".$numberForId."'";
    ?>><br>
    <input type="submit" class="button">
</form>


<form class="deleteForm toHide" action="?action=remove" method="post">
    <input type="number" name="notForUser" class="notForUser" value=<?php echo "".$value['id'].""; ?>>
    <p>WARNING : ARE YOU SURE YOU WANT TO DELETE THIS FILE? THIS CAN'T BE UNDONE!</p>
    <input type="submit" class="button">
</form>
</div>