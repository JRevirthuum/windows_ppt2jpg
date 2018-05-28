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
$savePath = realpath(basename(getenv($_SERVER['SCRIPT_NAME'])));
$dirName = 'ppt_image_'.time();
$pptFile = 'PPTtest.pptx';
$ppt = new COM('PowerPoint.Application');
$ppt->Presentations->Open(realpath($pptFile));
$ppt->ActivePresentation->SaveAs("{$savePath}/{$dirName}",17);  //'*18=PNG, 19=BMP*'
$ppt->Quit;
$ppt = null;
?>
폴더를 생성해서 저장한다 <b><?=$dirName?></b>
</body>
</html>
