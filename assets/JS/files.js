Element.prototype.hasClassName = function(className){
    for (var i in this.classList){
        if (this.classList[i] === className){
            return true;
        }
    }

    return false;
}

function createElementWithClass(tagName,arrayClassname){
    var createdElement = document.createElement(tagName);
    for (var i in arrayClassname){
        createdElement.className += arrayClassname[i]+' ';
    }
    return createdElement;
}

function linkButtonOnclickEvent(button){
    button.domElement.onclick = function(){
        button.domElement.parentNode.parentNode.removeChild(button.domElement.parentNode);
    };
}

function buttonInit(elementToAppend){
    var button = {};
    button.domElement = createElementWithClass('span', ['closeButton']);
    button.father = elementToAppend;

    return button;
}

function buttonDisplay(button) {
    button.domElement.innerHTML = 'x';

    button.father.appendChild(button.domElement);

    if (window.getComputedStyle(button.father).getPropertyValue('position') === 'static'){
        button.father.className += ' positioned';
    }
}

function addCloseButton(elementToAppend){
    var button = buttonInit(elementToAppend);

    buttonDisplay(button);

    linkButtonOnclickEvent(button);
    return button;
}

function asynchronousTreatment(path, successFunction, failureFunction, method){
    var request = new XMLHttpRequest();
    if (method === "POST"){
        request.open("POST", path, true);
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    }else{
        request.open("GET", path, true);
    }

    request.onload = function(e) {
        //document.write(request.responseText);
        if (request.status === 200){
            successFunction(request);
        }else{
            failureFunction(request);
        }
    };
    request.send();
}

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

function getDivInModale(fileData){
    switch (fileData['type']){
        case 'txt' :
            var innerText = document.createElement('p');
            asynchronousTreatment(fileData['path'], function (request) {
                //document.write(request.responseText);
                innerText.innerText =  request.responseText;
            }, function (request){
                innerText.innerText = 'An error '+request.status+ ' occurred.';
            }, "GET");
            //add button to allow modification.
            return innerText;
            break;
        case 'jpg' :
        case 'jpeg':
        case 'gif' :
        case 'ani' :
        case 'bmp' :
        case 'cal' :
        case 'fax' :
        case 'img' :
        case 'jbg' :
        case 'jpe' :
        case 'mac' :
        case 'pbm' :
        case 'pcd' :
        case 'pcx' :
        case 'pct' :
        case 'pgm' :
        case 'png' :
        case 'ppm' :
        case 'psd' :
        case 'ras' :
        case 'tga' :
        case 'tiff':
        case 'wmf' :
            var picture = new Image();
            picture.src = fileData['path'];
            picture.alt = 'Picture deleted. Please contact us at jonathan.simonney@supinternet.fr.';
            return picture;
            break;
        case 'mp3':
            var audio = document.createElement('audio');
            audio.src = fileData['path'];
            audio.controls = true;
            audio.autoplay = true;
            return audio;
            break;
        case 'avi':
        case 'asf':
        case 'mov':
        case 'qt':
        case 'avchd':
        case 'slv':
        case 'fwf':
        case 'mpg':
        case 'mp4':
            console.log(fileData['debug']);
            var video = document.createElement('video');
            video.src = fileData['path'];
            video.controls = true;
            video.autoplay = true;
            var source = document.createElement('source');
            source.src = fileData['path'];
            video.appendChild(source);
            return video;
            break;

        default :
            var div = document.createElement('div');
            div.innerHTML = 'This type can\'t be displayed. Please send a mail at jonathan.simonney@supinternet for possible implementation.';
            return div;
    }
}

function showInFullScreen(elementToShow){
    for (var i in elementToShow.childNodes){
        if (elementToShow.childNodes[i].className !== undefined){
            if (elementToShow.childNodes[i].hasClassName('name')){
                var name = elementToShow.childNodes[i];
                break;
            }
        }
    }

    asynchronousTreatment('?action=show&id='+getId(name), function(request){
        var fileData = JSON.parse(request.responseText);
        var fullScreenDiv = createElementWithClass('div', ['fullScreen']);
        addCloseButton(fullScreenDiv);
        var childDiv = getDivInModale(fileData);
        fullScreenDiv.appendChild(childDiv);
        document.body.appendChild(fullScreenDiv);
    }, function (request) {
        console.log(request.status);
    }, 'POST');
}

window.onload = function(){
    var buttonReplace = document.querySelectorAll('.replace');
    var buttonRename = document.querySelectorAll('.rename');
    var buttonDelete = document.querySelectorAll('.delete');
    var buttonUpload = document.getElementById('upload');
    var buttonFolder = document.getElementById('folder');
    var buttonShowing = document.querySelectorAll('.show');

    //D&D handler

    var fileName = document.querySelectorAll('.name');
    var folder = document.querySelectorAll('.folder');
    var precedent = document.querySelector('.precedent');

    for (var i in fileName){
        if (fileName[i].style !== undefined){
            fileName[i].draggable = true;
            fileName[i].addEventListener('dragstart', function (e) {
                dragFileOrFolder(this, e);
            })
        }
    }

    for (var i in folder){
        if (folder[i].style !== undefined){
            linkFolderDragAndDropEvent(folder[i]);
        }
    }

    if (precedent !== null){
        linkArrowDragAndDropEvent(precedent);
    }

    //D&D handler

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

    for (var i in buttonShowing){
        if (typeof buttonShowing[i].style !== 'undefined'){
            buttonShowing[i].onclick = function (e) {
                e.preventDefault();
                showInFullScreen(this.parentNode);
            }
        }
    }
}