<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload']) && isset($_POST['id'])) {
    $file = $_FILES['upload'];
    $id = $_POST['id'];
    $uploadDirectory = 'uploads/';

    // $idDirectory = $uploadDirectory . $id . '/';
    // if (!is_dir($idDirectory)) {
    //     mkdir($idDirectory, 0777, true);
    // }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . $id . '.' . $ext;
    $uploadPath = $idDirectory . $filename;

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
        "error"=> ["message"=> "Invalid request"]
    ];
    echo json_encode($response);
}
?>