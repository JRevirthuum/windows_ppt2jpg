<?php
// 긴 내용 읽어 들이기 위해 set_time_limit 추가
set_time_limit(0);

require 'vendor/autoload.php';
// PPT 라이브러리를 호출한다.
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Slide;
use PhpOffice\PhpPresentation\Shape\RichText;
use PhpOffice\PhpPresentation\Shape\Drawing\File;

$file = './온라인 수련실태조사 수정사항.pptx';

$ppt = IOFactory::createReader('PowerPoint2007');
if(!$ppt->canRead($file)) {
    exit('없는 파일');
} else {
    $data = $ppt->load($file);
    // 설정가져오기
    $property = $data->getDocumentProperties();
    $slides = $data->getAllSlides();

    foreach ($slides as $slide_k => $slide_v) {
      $shapes = $slides[$slide_k]->getShapeCollection();
      foreach ($shapes as $shape_k => $shape_v) {
        $shape = $shapes[$shape_k];
        echo get_class($shape).'</br>';

        if($shape instanceof PhpOffice\PhpPresentation\Shape\RichText){
           $paragraphs = $shapes[$shape_k]->getParagraphs();
           foreach ($paragraphs as $paragraph_k => $paragraph_v) {
             $text_elements = $paragraph_v->getRichTextElements();
             foreach ($text_elements as $text_element_k => $text_element_v) {
               $text = $text_element_v->getText();
               $new_text = str_replace('${name}', 'Esfera', $text);
               $text_element_v->setText($new_text);
             }
           }
        }
      }
    }




}
