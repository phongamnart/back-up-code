<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CKEditor 5 Example</title>
    <?php include("_header.php");?>
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
        $doc_no = $objResult['doc_no'];
        $doc_name = $objResult['doc_name'];
    }

    ?>
    <div class="full-container-header">
        <div class="row">
            <div class="col">
                <form action="save_doc.php" method="post">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="inline-elements">
                            <h2 id="docNo"><?php echo $doc_no; ?></h2>
                            <h2><?php echo $doc_name; ?></h2>
                        </div>
                        <div>
                            <button onclick="window.location.href='download.php?id=<?php echo $id ?>'" title="Download .docx file" class="btn custom">
                                <img src="insert_img/word.png" alt="home" width="50" height="50">
                            </button>
                            <button onclick="window.open('<?php echo $pdf_file; ?>', '_blank');" title="Download .pdf file" class="btn custom">
                                <img src="insert_img/pdf.png" alt="home" width="50" height="50">
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <textarea name="editor_content" id="editor"><?php echo $tag_html; ?></textarea>
                    <br>
                    <input type="submit" value="Save as Word" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
    <div id="container">
        <div id="editor">
        </div>
    </div>
    <?php include("_script.php");?>
    <?php include("_ckeditor.php");?>
</body>

</html>