<?php
session_start();
include("connect.php");
$conDB = new db_conn();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['editor_content'])) {
    $id = $_POST['id'];
    $combined_content = '';

    if (isset($_POST['editor_content']) && isset($_POST['sections'])) {
        $editor_content = $_POST['editor_content'];
        $sections = $_POST['sections'];

        foreach ($editor_content as $index => $content) {
            if (!empty($content) && isset($sections[$index])) {
                $section = htmlspecialchars($sections[$index]);
                // $combined_content .= "<b>$section</b><span>$content</span>";
                $combined_content .= "$content";
            }
        }
    }

    $sql1 = "UPDATE `documents` SET `tag_html` = '$combined_content'";
    $objQuery = $conDB->sqlQuery($sql1);
    if( $objQuery) {
        header("Location: list_doc.php");
    } else {
        echo "Error saving data";
    }

} else {
    echo "Invalid request method or missing data.";
}
