// $doc_file_path = '';
    // if (isset($_FILES['doc_file']) && $_FILES['doc_file']['error'] == UPLOAD_ERR_OK) {
    //     $timestamp = date('YmdHis');
    //     $random_number = uniqid();
    //     $doc_extension = pathinfo($_FILES['doc_file']['name'], PATHINFO_EXTENSION);
    //     $doc_new_name = $timestamp . '_' . $random_number . '.' . $doc_extension;
    //     $doc_file_path = $doc_dir . $doc_new_name . '_document.docx';

    //     if (!move_uploaded_file($_FILES['doc_file']['tmp_name'], $doc_file_path)) {
    //         echo "Failed to upload DOC file.";
    //         exit();
    //     }
    // }

    // $html_file_path = '';
    // if (isset($_FILES['html_file']) && $_FILES['html_file']['error'] == UPLOAD_ERR_OK) {
    //     $timestamp = date('YmdHis');
    //     $random_number = uniqid();
    //     $html_extension = pathinfo($_FILES['html_file']['name'], PATHINFO_EXTENSION);
    //     $html_new_name = $timestamp . '_' . $random_number . '.' . $html_extension;
    //     $html_file_path = $html_dir . $html_new_name . '_html.docx';

    //     if (!move_uploaded_file($_FILES['html_file']['tmp_name'], $html_file_path)) {
    //         echo "Failed to upload HTML file.";
    //         exit();
    //     }
    // }

    // $pdf_file_path = '';
    // if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] == UPLOAD_ERR_OK) {
    //     $timestamp = date('YmdHis');
    //     $random_number = uniqid();
    //     $pdf_extension = pathinfo($_FILES['pdf_file']['name'], PATHINFO_EXTENSION);
    //     $pdf_new_name = $timestamp . '_' . $random_number . '.' . $pdf_extension;
    //     $pdf_file_path = $pdf_dir . $pdf_new_name;

    //     if (!move_uploaded_file($_FILES['pdf_file']['tmp_name'], $pdf_file_path)) {
    //         echo "Failed to upload PDF file.";
    //         exit();
    //     }
    // }