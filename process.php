<?php
print_r($_POST);
print_r($_FILES);

function imageCompressAndUpload( $uploads_dir, $changedName, $array_num, $inputName ){

    $show = "";
    $show = $show."{\"status\":\"";
    // 설정
    $allowed_ext = array('doc','ppt','docx','pptx');

    // 폴더 존재 여부 확인 ( 없으면 생성 )
    if ( !is_dir ( $uploads_dir ) ){
        mkdir( $uploads_dir );
    }

    // 변수 정리
    $error = $_FILES[$inputName]['error'][$array_num];
    $name = $_FILES[$inputName]['name'][$array_num];
    $ext = array_pop(explode('.', $name));

    // 오류 확인
    if( $error != UPLOAD_ERR_OK ) {
        switch( $error ) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $show = $show."파일이 너무 큽니다. ($error)";
                break;
            case UPLOAD_ERR_NO_FILE:
                $show = $show."파일이 첨부되지 않았습니다. ($error)";
                break;
            default:
                $show = $show."파일이 제대로 업로드되지 않았습니다. ($error)";
        }
        $show = ($i+1)."번째 파일을 올릴 수 없습니다.";
        echo $show;
        exit;
    }

    // 확장자 확인
    if( !in_array($ext, $allowed_ext) ) {
        $show = $show.$name."파일은 허용되지 않는 확장자입니다.";
        $show = $show."\"}";
        echo $show;
        exit;
    }

    $url = "{$uploads_dir}/{$changedName}.{$ext}";
    $filename="";
    if ( $_FILES[$inputName]['size'] > 500000 ){
        $filename = compress( $_FILES["upload"]["tmp_name"][$array_num] , $url, 80 );
    }else{
        move_uploaded_file( $_FILES[$inputName]['tmp_name'][$array_num] , $url );
    }

    $show = $show."OK\",";
    $show = $show."\"파일명\" : \"{$name}\", ";
    $show = $show."\"확장자\" : \"{$ext}\", ";
    $show = $show."\"파일형식\" : \"{$_FILES[$inputName]['type']}\", ";
    $show = $show."\"파일크기\" : \"{$_FILES[$inputName]['size']} 바이트\", ";
    $show = $show."\"url\" : \"{$url}\", ";
    $show = $show."\"filename\" : \"{$filename}\"}";

    echo $show;
}

// 파일 압축 메소드
function compress($source, $destination, $quality) {

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

    return $destination;
}

function safeCount($array) {
if (isset($array)) return count($array);
return -1;
}
?>
