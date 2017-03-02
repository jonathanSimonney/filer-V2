<?php
echo "<div class='icon folder'>";
?>
<br><br>
<button class="open">open</button>
<button class="rename">rename</button>
<i class="fa fa-trash delete" aria-hidden="true"></i>

<span class="name"><i class="fa fa-folder" aria-hidden="true"></i><?php echo $value['name']; ?></span>

<form class="replaceForm toHide" action="?action=open" method="post">
    <input type="number" name="notForUser" class="notForUser" value=<?php echo "".$value['id'].""; ?>>
    <input type="submit" class="button">
</form>

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