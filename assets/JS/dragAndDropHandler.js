function moveAIntoB(idA, idB) {
    window.location = '?action=move&idMovedElement='+idA+'&idDestination='+idB;
}

function addClassName(element, className) {
    if (element.className.search(className) === -1){
        element.className += ' '+className;
    }
}

function getId(element){
    for (var i in element.childNodes){
        if (element.childNodes[i].name === 'notForUser'){
            return element.childNodes[i].value;
        }
    }
}

function dragFileOrFolder(draggedElement, e){
    e.dataTransfer.setData('text/plain', '');
    idMovedElement = getId(draggedElement);
}

function linkFolderDragAndDropEvent(folder) {
    folder.addEventListener('dragover', function (e) {
        if (getId(folder) !== idMovedElement){
            e.preventDefault();
            addClassName(this, 'dragover');
        }
    });
    
    folder.addEventListener('dragleave', function () {
        this.className = folder.className.replace('dragover', '');
    });

    folder.addEventListener('drop', function () {
        this.className = this.className.replace('dragover', '');
        moveAIntoB(idMovedElement, getId(this));
    })
}

var idMovedElement = 0;