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

function session_storage_delete($id){
    unset($_SESSION['files'][$id]);
}

function session_storage_file_update($id,$fieldToUpdateData){
    foreach ($fieldToUpdateData as $modifKey => $newValue){
        $_SESSION['files'][$id][$modifKey] = $newValue;
    }
}

function upload_file_in_session_storage($fileInformations){
    $fileInformations['id'] = get_last_inserted_id();
    $fileInformations['user_id'] = $_SESSION['currentUser']['data']['id'];
    $_SESSION['files'][$fileInformations['id']] = $fileInformations;
}