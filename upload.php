<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <title>파일첨부</title>
        <script src='/bower_components/jquery/dist/jquery.min.js'></script>
        <style>
            #dropzone
            {
                border:2px dotted #3292A2;
                width:90%;
                height:50px;
                color:#92AAB0;
                text-align:center;
                font-size:24px;
                padding-top:12px;
                margin-top:10px;
            }
        </style>
    </head>
    <body>
        <h1>TEST Upload</h1>
        <div id="dropzone">[SYSTEM:BEAVER] 파일을 드래그 해서 여기에 넣어주세요</div>

        <script>
            $(function () {
                 var obj = $("#dropzone");

                 obj.on('dragenter', function (e) {
                      e.stopPropagation();
                      e.preventDefault();
                      $(this).css('border', '2px solid #5272A0');
                 });

                 obj.on('dragleave', function (e) {
                      e.stopPropagation();
                      e.preventDefault();
                      $(this).css('border', '2px dotted #8296C2');
                 });

                 obj.on('dragover', function (e) {
                      e.stopPropagation();
                      e.preventDefault();
                 });

                 obj.on('drop', function (e) {
                      e.preventDefault();
                      $(this).css('border', '2px dotted #8296C2');

                      var files = e.originalEvent.dataTransfer.files;
                      if(files.length < 1)
                           return;
                      F_FileMultiUpload(files, obj);
                 });


                 // 파일 멀티 업로드
                 function F_FileMultiUpload(files, obj) {
                      if(confirm(files.length + "개의 파일을 업로드 하시겠습니까?") ) {
                          var data = new FormData();
                          for (var i = 0; i < files.length; i++) {
                             data.append('file', files[i]);
                          }

                          var url = 'process.php';
                          $.ajax({
                             url: url,
                             method: 'post',
                             data: data,
                             dataType: 'json',
                             processData: false,
                             contentType: false,
                             success: function(res) {
                                 F_FileMultiUpload_Callback(res.files);
                             }
                          });
                      }
                 }

                 // 파일 멀티 업로드 Callback
                 function F_FileMultiUpload_Callback(files) {
                      for(var i=0; i < files.length; i++)
                          console.log(files[i].file_nm + " - " + files[i].file_size);
                 }
            });
        </script>
    </body>
</html>
