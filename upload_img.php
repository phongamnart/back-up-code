<?php
include("connect.php");
$conDB = new db_conn();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload'])) {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    } elseif (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $response = [
            "uploaded" => 0,
            "error" => ["message" => "ID not specified."]
        ];
        echo json_encode($response);
        exit;
    }

    $sql = "SELECT `doc_no` FROM `documents` WHERE md5(`id`) = '$id' LIMIT 1";
    $result = $conDB->sqlQuery($sql);
    $docNo = mysqli_fetch_assoc($result);

    if (!$docNo) {
        echo "Document not found";
        exit;
    }

    $doc_no = $docNo['doc_no'];

    $file = $_FILES['upload'];
    $uploadDir = 'uploads/';

    $idDir = $uploadDir . $doc_no . '/';
    if (!is_dir($idDir)) {
        mkdir($idDir, 0777, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' .$id . '.' . $ext;
    $uploadPath = $idDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/method_statement/' . $uploadPath;
        $response = [
            "uploaded" => 1,
            "fileName" => $filename,
            "url" => $url
        ];
    } else {
        $response = [
            "uploaded" => 0,
            "error" => ["message" => "File upload failed."]
        ];
    }

    echo json_encode($response);
} else {
    $response = [
        "uploaded" => 0,
        "error" => ["message" => "Invalid request"]
    ];
    echo json_encode($response);
}
?>
