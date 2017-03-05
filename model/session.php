<?php

function make_inferior_key_index($superArray, $inferior_key){
    $new_array = [];
    foreach ($superArray as $key => $array){
        $new_array[$array[$inferior_key]] = $array;
    }
    return $new_array;
}

function find_corresponding_elements($superArray, $needleKey, $needleValue){
    $array_analysed = make_inferior_key_index($superArray, $needleKey);
    foreach ($array_analysed as $key => $array){
        if ((string)$key === (string)$needleValue){
            $ret[] = $array;
        }
    }

    if (!isset($ret)){
        $ret = false;
    }

    return $ret;
}

function upload_file_in_session($fileInformations){
    $fileInformations['id'] = get_last_inserted_id();
    $fileInformations['user_id'] = $_SESSION['currentUser']['data']['id'];
    set_item_in_array(array_merge($_SESSION['location']['array'], [$fileInformations['id']]), $_SESSION, $fileInformations);
    //var_dump($_SESSION['files'][110]['childs'], $_SESSION['location']['array'], $fileInformations);
}

function set_item_in_array($path, &$array, $value){
    $key = array_shift($path);
    if (empty($path)) {
        $array[$key] = $value;
    } else {
        if (!isset($array[$key]) || !is_array($array[$key])) {
            $array[$key] = array();
        }
        set_item_in_array( $path, $array[$key], $value);
    }
}

function get_item_in_array($path, &$array){
    $key = array_shift($path);
    if (empty($path)) {
        if (array_key_exists($key, $array)){
            return $array[$key];
        }else{
            return null;
        }
    } else {
        if (!isset($array[$key]) || !is_array($array[$key])) {
            $array[$key] = array();
        }
        return get_item_in_array( $path, $array[$key]);
    }
}

function unset_item_in_array($path, &$array){
    $key = array_shift($path);
    if (empty($path)) {
        unset($array[$key]);
    } else {
        if (!isset($array[$key]) || !is_array($array[$key])) {
            $array[$key] = array();
        }
        unset_item_in_array( $path, $array[$key]);
    }
}

function updatePath($idParent, $suppressedArray, $key, $path){
    $path = array_merge([$idParent, 'childs'],$path);
    if (array_key_exists($idParent, $suppressedArray)){
        $newData = updatePath($suppressedArray[$idParent], $suppressedArray, $key, $path);
        $suppressedArray = $newData['suppressedArray'];
        $path = $newData['path'];
    }
    $suppressedArray[$key] = $idParent;
    //var_dump($suppressedArray, $path);

    return [
        'suppressedArray' => $suppressedArray,
        'path'            => $path
    ];
}

function format_session_file_as_tree(){
    $suppressedArray = [];
    $arrayAsTree = [];
    $suppressedArray = [];
    foreach ($_SESSION['files'] as $key => $value){
        $path = [$key];
        if ($value['path'][0] !== 'u' && preg_match('/\d+(?=\/)/', $value['path'], $cor) === 1){
            $newData = updatePath((int)$cor[0], $suppressedArray, $key, $path);
            $suppressedArray = $newData['suppressedArray'];
            $path = $newData['path'];
        }

        if (get_item_in_array($path, $arrayAsTree) !== null){
            $value = array_merge(get_item_in_array($path, $arrayAsTree), $value);
        }

        set_item_in_array($path, $arrayAsTree, $value);
    }

    $_SESSION['files'] = $arrayAsTree;
}

function user_session_location_init(){
    $_SESSION['location']['array'] = ['files'];
    $_SESSION['location']['simple'] = 'root';
}

function move_in_session($movedElementData, $destinationFolderData, $newPath){
    $copiedElement = get_item_in_array($_SESSION['location']['array'], $_SESSION)[$movedElementData['id']];
    $copiedElement['path'] = $newPath;
    unset_item_in_array(array_merge($_SESSION['location']['array'], [$movedElementData['id']]), $_SESSION);
    set_item_in_array(array_merge($_SESSION['location']['array'], [$destinationFolderData['id'], 'childs', $movedElementData['id']]), $_SESSION, $copiedElement);
}