function toggleFormState(form){
    var showForm = true;
    if (form.className.search('appearingSlowly') !== -1){
        showForm = false;
    }
    var toHide = document.querySelectorAll('.appearingSlowly');
    for (var i in toHide){
        if (typeof toHide[i].style != 'undefined') {
            toHide[i].className = toHide[i].className.replace('appearingSlowly','');
        }
    }
    if (showForm){
        form.className += " appearingSlowly";
    }
}

window.onload = function(){
    var buttonReplace = document.querySelectorAll('.replace');
    var buttonRename = document.querySelectorAll('.rename');
    var buttonDelete = document.querySelectorAll('.delete');
    var buttonUpload = document.getElementById('upload');
    var buttonFolder = document.getElementById('folder');

    buttonFolder.onclick = function () {
        toggleFormState(document.querySelector('.addFolder'));
    };

    buttonUpload.onclick = function(){
        toggleFormState(document.querySelector('.uploadForm'));
    };

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

                toggleFormState(toShowForm);
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

                toggleFormState(toShowForm);
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

                toggleFormState(toShowForm);
            }
        }
    }
}