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

function session_delete($id){
    unset($_SESSION['files'][$id]);
}

function upload_file_in_session($fileInformations){
    $fileInformations['id'] = get_last_inserted_id();
    $fileInformations['user_id'] = $_SESSION['currentUser']['data']['id'];
    set_item_in_array(array_merge($_SESSION['location']['array'], [$fileInformations['id']]), $_SESSION, $fileInformations);
    var_dump($_SESSION['files'][110]['childs'], $_SESSION['location']['array'], $fileInformations);
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
        return $array[$key];
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
        set_item_in_array($path, $arrayAsTree, $value);
    }

    $_SESSION['files'] = $arrayAsTree;
}