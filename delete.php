<?php
include("connect.php");
$conDB = new db_conn();

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    
    $sql_select_files = "SELECT `doc_file`, `pdf_file` FROM `documents` WHERE `id` = '$id'";
    $result_select_files = $conDB->sqlQuery($sql_select_files);
    if($result_select_files && $result_select_files->num_rows > 0) {
        $row = $result_select_files->fetch_assoc();
        $doc_file_name = $row['doc_file'];
        $pdf_file_name = $row['pdf_file'];
        
        $doc_file_path = "saved_docx_files/" . $doc_file_name;
        $pdf_file_path = "saved_pdf_files/" . $pdf_file_name;

        if(file_exists($doc_file_path)) {
            unlink($doc_file_path);
        }

        if(file_exists($pdf_file_path)) {
            unlink($pdf_file_path);
        }
    }
    
    $sql_delete = "DELETE FROM `documents` WHERE `id` = '$id'";
    if($conDB->sqlQuery($sql_delete)){
        header("location: list_doc.php");
        exit();
    } else {
        echo "Error: ";
    }
} else {
    echo "Invalid request";
}

?>
