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

function session_file_update($id,$fieldToUpdateData){
    foreach ($fieldToUpdateData as $modifKey => $newValue){
        $_SESSION['files'][$id][$modifKey] = $newValue;
    }
}

function upload_file_in_session($fileInformations){
    $fileInformations['id'] = get_last_inserted_id();
    $fileInformations['user_id'] = $_SESSION['currentUser']['data']['id'];
    $_SESSION = set_item_in_array(array_merge($_SESSION['location']['array'], [$fileInformations['id']]), $_SESSION, $fileInformations);
    var_dump($_SESSION['files'][110]['childs'], $_SESSION['location']['array'], $fileInformations);
}

function set_item_in_array($arrayPath, $arrayChanged, $value){
    $temp = &$arrayChanged;
    foreach($arrayPath as $key) {
        $temp = &$temp[$key];
    }
    $temp = $value;
    return $arrayChanged;
}

function get_item_in_array($arrayPath, $array){
    $temp = &$array;
    foreach($arrayPath as $key) {
        $temp = &$temp[$key];
    }
    return $temp;
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
        $arrayAsTree = set_item_in_array($path, $arrayAsTree, $value);
    }

    $_SESSION['files'] = $arrayAsTree;
}