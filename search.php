<?php
include("connect.php");
$conDB = new db_conn();

if (isset($_GET['major']) || isset($_GET['searchText'])) {
    $major = isset($_GET['major']) ? $_GET['major'] : '';
    $searchText = isset($_GET['searchText']) ? $_GET['searchText'] : '';
    $sql = "SELECT * FROM documents WHERE 1=1";

    if (!empty($major) && !empty($searchText)) {
        $sql .= " AND major = '$major' AND (doc_no LIKE '%$searchText%' OR doc_name LIKE '%$searchText%' OR date LIKE '%$searchText%' OR owner LIKE '%$searchText%')";
    } elseif (!empty($major)) {
        $sql .= " AND major = '$major'";
    } elseif (!empty($searchText)) {
        $sql .= " AND (doc_no LIKE '%$searchText%' OR doc_name LIKE '%$searchText%' OR date LIKE '%$searchText%' OR owner LIKE '%$searchText%')";
    }

    $result = $conDB->sqlQuery($sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered'>";
        echo "<thead class='table-dark'>";
        echo "<tr>";
        echo "<th>Item</th>";
        echo "<th>Discipline</th>";
        echo "<th>Document No.</th>";
        echo "<th>Document Title</th>";
        echo "<th>Date</th>";
        echo "<th>Prepared By</th>";
        echo "<th>Edit .docx</th>";
        echo "<th>Download .docx</th>";
        echo "<th>PDF</th>";
        echo "<th>Delete</th>";
        echo "</tr>";
        echo "</thead>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['major']}</td>";
            echo "<td>{$row['doc_no']}</td>";
            echo "<td>{$row['doc_name']}</td>";
            echo "<td>{$row['date']}</td>";
            echo "<td>{$row['owner']}</td>";
            echo "<td><button onclick=\"location.href='edit_doc.php?id=" . md5($row['id']) . "'\" class='btn btn-primary'>Edit .docx</button></td>";

            if (!empty($row['doc_file'])) { //download docx
                echo "<td><button onclick=\"window.open('download.php?file={$row['doc_file']}')\" class='btn btn-secondary'>Download .docx</button></td>";
            } else {
                echo "<td>-</td>";
            }

            if (!empty($row['pdf_file'])) { ?>
                <td><button onclick="window.open('<?php echo $row['pdf_file']; ?>', '_blank');" class='btn btn-success'>PDF</button></td>
<?php } else {
                echo "<td>-</td>";
            }

            echo "<td><button onclick='showDeleteModal({$row['id']})' class='btn btn-danger'>Delete</button></td>";
            echo "</tr>";
            echo "</div>";
            echo "<script>
            function showDeleteModal(id) { //confirm delete
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                document.getElementById('confirmDeleteButton').onclick = function() {
                    location.href = 'delete.php?id=' + id;
                };
                deleteModal.show();
            }
          </script>";
        }
    } else {
        echo "<tr><td colspan='10'>No documents found</td></tr>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Confirm Delete</title>
</head>

<body>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true"> <!--confirm delete style-->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this document?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>

</html>