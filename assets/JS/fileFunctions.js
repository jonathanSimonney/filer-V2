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
        openedFileId = 0;
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

function writeInFile(id, newContent){
    asynchronousTreatment('?action=write&id='+id+'&newContent='+encodeURIComponent(newContent), function (request) {
        //document.write(request.responseText);
    }, function (request) {
        //document.write(request.responseText);
    });
}

function allowModif(textField, button){
    button.innerHTML = 'save modifications';
    textField.childNodes[0].contentEditable = true;
    textField.childNodes[0].focus();
    addClassName(textField, 'changeAllowed');
    button.onclick = function () {
        console.log(textField.childNodes[0].innerText);
        writeInFile(openedFileId, textField.childNodes[0].innerText);
    }
}

function getTextDiv(path){
    var ret = document.createElement('div');
    var innerText = document.createElement('p');
    asynchronousTreatment(path, function (request) {
        //document.write(request.responseText);
        var result = request.responseText;
        result = result.replace(/&/g, '&amp;');
        result = result.replace(/</g, '&lt;');
        innerText.innerHTML =  '<pre>'+result+'</pre>';
    }, function (request){
        innerText.innerText = 'An error '+request.status+ ' occurred.';
    }, "GET");

    var buttonModif = document.createElement('button');
    buttonModif.innerHTML = 'allow change';

    ret.appendChild(innerText);
    ret.appendChild(buttonModif);

    buttonModif.onclick = function(){
        allowModif(innerText, buttonModif);
    };
    return ret;
}

function getDivInModale(fileData){
    switch (fileData['type']){
        case 'txt' :
            return getTextDiv(fileData['path']);
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
                openedFileId = getId(elementToShow.childNodes[i]);
                break;
            }
        }
    }

    asynchronousTreatment('?action=show&id='+openedFileId, function(request){
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