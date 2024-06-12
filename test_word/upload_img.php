<?php
include("connect.php");
$conDB = new db_conn();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $uploadDir = 'test_upload/image/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $uploadPath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $uploadPath;
        
        $sql = "INSERT INTO `test_word` (`image`) VALUES ('$uploadPath')";
        if ($conDB->sqlQuery($sql)) {
            $response = [
                "uploaded" => 1,
                "fileName" => $filename,
                "url" => $uploadPath
            ];
        } else {
            $response = [
                "uploaded" => 0,
                "error" => ["message" => "Failed to save the image URL to the database."]
            ];
        }
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
