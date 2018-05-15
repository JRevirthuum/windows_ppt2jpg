<?php
$mode = (isset($_GET['mode']))?$_GET['mode']:'';
if(!$mode) {
    $endpoint = "https://sandbox.zamzar.com/v1/jobs";
    $apiKey = "597b68e8361f2a01d0aef34bad5f9ea39c77b031";
    $sourceFilePath = "./온라인 수련실태조사 수정사항.pptx";
    $targetFormat = "png";


    // Since PHP 5.5+ CURLFile is the preferred method for uploading files
    if(function_exists('curl_file_create')) {
      $sourceFile = curl_file_create($sourceFilePath);
    } else {
      $sourceFile = '@' . realpath($sourceFilePath);
    }

    $postData = array(
      "source_file" => $sourceFile,
      "target_format" => $targetFormat
    );

    $ch = curl_init(); // Init curl
    curl_setopt($ch, CURLOPT_URL, $endpoint); // API endpoint
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true); // Enable the @ prefix for uploading files
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
    curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ":"); // Set the API key as the basic auth username
    $body = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($body, true);

    echo "Response:\n---------\n";
    print_r($response);
} elseif($mode=='schedule') {
    $jobID = $id;
    $endpoint = "https://sandbox.zamzar.com/v1/jobs/{$jobID}";
    $apiKey = "597b68e8361f2a01d0aef34bad5f9ea39c77b031";

    $ch = curl_init(); // Init curl
    curl_setopt($ch, CURLOPT_URL, $endpoint); // API endpoint
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
    curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ":"); // Set the API key as the basic auth username
    $body = curl_exec($ch);
    curl_close($ch);

    $job = json_decode($body, true);

    echo "Job:\n----\n";
    print_r($job);
} elseif($mode=='download') {
    $fileID = $id;
    $localFilename = "converted.png";
    $endpoint = "https://sandbox.zamzar.com/v1/files/{$fileID}/content";
    $apiKey = "597b68e8361f2a01d0aef34bad5f9ea39c77b031";

    $ch = curl_init(); // Init curl
    curl_setopt($ch, CURLOPT_URL, $endpoint); // API endpoint
    curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ":"); // Set the API key as the basic auth username
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

    $fh = fopen($localFilename, "wb");
    curl_setopt($ch, CURLOPT_FILE, $fh);

    $body = curl_exec($ch);
    curl_close($ch);

    echo "File downloaded\n";
} else {
exit('없음');
}
