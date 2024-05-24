<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CKEditor 5 Example</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
</head>

<body>
    <button onclick="history.back()">Back</button>
    <button class="btn-home" onclick="location.href='index.php';">Home</button>
    <br><br>

    <?php
    $id = $_GET['id'];

    include("connect.php");

    $sql = "SELECT html_file FROM documents WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($filePath);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    // echo "<p>File Path: " . htmlspecialchars($filePath, ENT_QUOTES, 'UTF-8') . "</p>"; //debug

    if ($filePath && file_exists($filePath)) {
        require 'vendor/autoload.php';

        $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);

        $fullText = '';
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                    $fullText .= $element->getText();
                }
            }
        }
    } else {
        $fullText = '';
    }
    ?>

    <form action="save_doc.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <textarea name="editor_content" id="editor"><?php echo $fullText; ?></textarea>
        <br>
        <input type="submit" value="Save as Word">
    </form>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: 'upload_img.php?command=QuickUpload&type=Files&responseType=json'
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>