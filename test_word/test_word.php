<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CKEditor 5 Example</title>
    <?php include("_header.php"); ?>
    <?php include("_navbar.php"); ?>
</head>

<body>
    <div class="full-container-header">
        <div class="row">
            <div class="col">
                <form action="save_file.php" method="post">
                    <textarea name="editor_content" id="editor"></textarea>
                    <br>
                    <input type="submit" value="Save as Word" class="btn btn-success">
                </form><br>
                <form id="uploadForm" enctype="multipart/form-data">
                    <a href="#" id="filePicker" class="btn btn-primary">Add Image</a>
                </form>
                <div id="uploadStatus"></div>
                <div id="imageContainer"></div>
            </div>
        </div>
    </div>
    <div id="container">
        <div id="editor">
        </div>
    </div>
    <?php include("_script.php"); ?>
    <?php include("_test_ck.php"); ?>

    <script>
        document.getElementById('filePicker').addEventListener('click', function(event) {
            event.preventDefault(); // หยุดการกระทำที่เป็นเหตุให้กับลิงก์

            var fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = 'image/*'; // กำหนดให้เฉพาะไฟล์ภาพ
            fileInput.style.display = 'none'; // ซ่อน input element ไว้

            // เมื่อผู้ใช้เลือกไฟล์ ให้ทำการอัปโหลด
            fileInput.addEventListener('change', function() {
                var formData = new FormData();
                formData.append('image', fileInput.files[0]); // เพิ่มไฟล์ที่เลือกลงใน FormData

                // ส่งข้อมูลไปยัง upload_img.php ด้วย XMLHttpRequest
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload_img.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.uploaded) {
                            document.getElementById('uploadStatus').innerHTML = '';
                            var imageContainer = document.getElementById('imageContainer');
                            var img = document.createElement('img');
                            img.src = response.url;
                            img.style.maxWidth = '100%';
                            imageContainer.appendChild(img);
                        } else {
                            document.getElementById('uploadStatus').innerHTML = '<p style="color: red;">Error: ' + response.error.message + '</p>';
                        }
                    } else {
                        document.getElementById('uploadStatus').innerHTML = '<p style="color: red;">An error occurred while uploading the image.</p>';
                    }
                };
                xhr.send(formData);
            });

            // คลิกที่ input element โดยอัตโนมัติ
            fileInput.click();
        });
    </script>

</body>

</html>