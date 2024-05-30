<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CKEditor 5 Example</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .btn-custom {
            padding: 0.5rem 1rem;
            background-color: transparent !important;
            border: none;
        }
    </style>
</head>

<body>
    <?php
    include("connect.php");
    $conDB = new db_conn();

    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $strSQLl =  "SELECT * FROM `documents` WHERE md5(`id`) = '$id' LIMIT 1";
    $objQuery = $conDB->sqlQuery($strSQLl);

    while ($objResult = mysqli_fetch_assoc($objQuery)) {
        $tag_html = $objResult['tag_html'];
        $pdf_file = $objResult['pdf_file'];
    }

    ?>
    <div class="full-container-header">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-custom" onclick="history.back()" title="Back">
                <i class="bi bi-arrow-left fs-2"></i>
            </button>
            <button class="btn btn-custom" onclick="location.href='index.php';" title="Home">
                <!-- <i class="bi bi-house fs-4"></i> -->
                <img src="insert_img/ite_logo.png" alt="home" width="150" height="45">
            </button>
            <button class="btn btn-custom" onclick="window.location.href='edit_doc.php?id=<?php echo $id ?>'" title="Refresh">
                <i class="bi bi-arrow-clockwise fs-2"></i>
            </button>
        </div>
        <div class="d-flex justify-content-end">
            <button onclick="window.location.href='download.php?id=<?php echo $id ?>'" title="Download .docx file" class="btn custom">
                <img src="insert_img/word.png" alt="home" width="50" height="50">
            </button>
            <button onclick="window.open('<?php echo $pdf_file; ?>', '_blank');" title="Download .pdf file" class="btn custom">
                <img src="insert_img/pdf.png" alt="home" width="50" height="50">
            </button>
        </div>
        <div class="row mt-3">
            <div class="col">
                <form action="save_doc.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <textarea name="editor_content" id="editor"><?php echo $tag_html; ?></textarea>
                    <br>
                    <input type="submit" value="Save as Word" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
    <script>
        var documentId = "<?php echo $id; ?>";

        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: "upload_img.php?id=" + documentId + "&command=QuickUpload&type=Files&responseType=json"
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>