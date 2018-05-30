<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>기본 오피스 애플리케이션 이용</title>
</head>
<body>
<?php
/**
 * CASE 1 . SaveAs 를 이용한 변환방법
 * @author beaver <beaver@inforang.com;revirthuum@gmail.com>
 * @todo 한글로 파일명을 호출 시 안되는 문제 해결 필요.
 */
$thisPath = realpath(basename(getenv($_SERVER['SCRIPT_NAME'])));
$dirName = 'ppt_image_'.time();
$pptFile = 'PPTtest.pptx';
$savePath = $thisPath.DIRECTORY_SEPARATOR.$dirName;
try {
    $ppt = new COM('PowerPoint.Application') or die('Unable to instantiate Powerpoint');;
    $ppt->visible = true;
    $ppt->Presentations->Open(realpath($pptFile), false, false, false) or die('Unable to open presentation');
    $ppt->ActivePresentation->SaveAs($savePath,17);  //'*18=PNG, 19=BMP*'
    $ppt->Quit;
} catch(Exception $e) {
    echo '<xmp>';print_r($e);echo '</xmp>';
    exit;
}
$ppt = null;
?>
폴더를 생성해서 저장한다 <strong><?=$dirName?></strong>
</body>
</html>
