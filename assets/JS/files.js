window.onload = function(){
    var buttonReplace = document.querySelectorAll('.replace');
    var buttonRename = document.querySelectorAll('.rename');
    var buttonDelete = document.querySelectorAll('.delete');
    var nameFileSelected = "";
    var formReplaceButton = document.querySelectorAll('.replaceForm>.button');
    var formRenameButton = document.querySelectorAll('.renameForm>.button');

    for (var i in buttonReplace){
        if (typeof buttonReplace[i].style != 'undefined') {
            buttonReplace[i].onclick = function(){
                var arrayElements = this.parentNode.childNodes;
                for (var i in arrayElements){
                    if (typeof arrayElements[i].style != 'undefined') {
                        if (arrayElements[i].className.indexOf("replaceForm") != -1) {
                            var toShowForm = arrayElements[i];
                            break;
                        }
                    }
                }

                var toHide = document.querySelectorAll('.appearingSlowly');
                for (var i in toHide){
                    if (typeof toHide[i].style != 'undefined') {
                        toHide[i].className = toHide[i].className.replace('appearingSlowly','');
                    }
                }
                toShowForm.className += " appearingSlowly";
            }
        }
    }

    for (var i in buttonRename){
        if (typeof buttonRename[i].style != 'undefined') {
            buttonRename[i].onclick = function(){
                var arrayElements = this.parentNode.childNodes;
                for (var i in arrayElements){
                    if (typeof arrayElements[i].style != 'undefined') {
                        if (arrayElements[i].className.indexOf("renameForm") != -1) {
                            var toShowForm = arrayElements[i];
                            break;
                        }
                    }
                }

                var toHide = document.querySelectorAll('.appearingSlowly');
                for (var i in toHide){
                    if (typeof toHide[i].style != 'undefined') {
                        toHide[i].className = toHide[i].className.replace('appearingSlowly','');
                    }
                }
                toShowForm.className += " appearingSlowly";
            }
        }
    }

    for (var i in buttonDelete){
        if (typeof buttonDelete[i].style != 'undefined') {
            buttonDelete[i].onclick = function(){
                var arrayElements = this.parentNode.childNodes;
                for (var i in arrayElements){
                    if (typeof arrayElements[i].style != 'undefined') {
                        if (arrayElements[i].className.indexOf("deleteForm") != -1) {
                            var toShowForm = arrayElements[i];
                            break;
                        }
                    }
                }

                var toHide = document.querySelectorAll('.appearingSlowly');
                for (var i in toHide){
                    if (typeof toHide[i].style != 'undefined') {
                        toHide[i].className = toHide[i].className.replace('appearingSlowly','');
                    }
                }
                toShowForm.className += " appearingSlowly";
            }
        }
    }
}//todo close opened form when user clicks again on button.