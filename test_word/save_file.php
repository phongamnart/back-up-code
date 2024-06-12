<?php
require 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;

include("connect.php");
$conDB = new db_conn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['editor_content'];
    $id = $_POST['id'];

    $sql = "SELECT image FROM test_word ORDER BY id DESC LIMIT 1";
    $result = $conDB->sqlQuery($sql);
    while ($objResult = mysqli_fetch_assoc($result)) {
        $imagePath = $objResult['image'];
    }

    $phpWord = new PhpWord();
    $section = $phpWord->addSection();

    $section->addImage($imagePath, array('width' => 200, 'height' => 200));

    $plainTextContent = htmlspecialchars_decode(strip_tags($content)); //decode html to text
    $encodedText = htmlspecialchars($plainTextContent, ENT_QUOTES, 'UTF-8'); //encode special characters
    $section->addText($encodedText);

    $currentTime = date("YmdHis");
    $randomNum = uniqid();
    $doc_file = 'test_upload/word/' . $currentTime . '_' . $randomNum . '.docx';
    $phpWord->save($doc_file);

    $sql = "INSERT INTO `test_word` (`content`) VALUES ('$encodedText')";
    $conDB->sqlQuery($sql);

    echo "<script>alert('Files saved successfully as " . basename($doc_file) . "'); window.location.href = 'test_word.php';</script>";
} else {
    echo "Invalid request method.";
}
