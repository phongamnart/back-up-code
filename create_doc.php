<?php
session_start();
include("connect.php");
$conDB = new db_conn();

$create_discipline = isset($_SESSION['create_discipline']) ? $_SESSION['create_discipline'] : '';
$create_work = isset($_SESSION['create_work']) ? $_SESSION['create_work'] : '';
$create_type = isset($_SESSION['create_type']) ? $_SESSION['create_type'] : '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("_header.php"); ?>
    <title>Create Document</title>
</head>

<body>
    <div class="full-container-header">
        <form action="create_doc_be.php" method="post" enctype="multipart/form-data">
            <div class="container d-flex justify-content-start">
                <div class="mb-2 col-4">
                    <label for="doc_name" class="form-label">Document Title:</label>
                    <input type="text" name="doc_name" id="doc_name" class="form-control" required>
                </div>
            </div>
            <div class="container d-flex justify-content-start">
                <div class="mb-2 col-4">
                    <label for="create_discipline">Discipline: </label>
                    <select name="discipline" id="discipline" class="form-select" onchange="setFillter('create_discipline',this.value)">
                        <option value="" <?php if ($create_discipline == '') {
                                                echo "selected";
                                            } ?>>แสดงทั้งหมด</option>
                        <?php
                        $sql2 = "SELECT DISTINCT `discipline` FROM `type`";
                        $objQuery = $conDB->sqlQuery($sql2);

                        while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                            <option value="<?php echo $objResult['discipline']; ?>" <?php if ($create_discipline == $objResult['discipline']) {
                                                                                        echo "selected";
                                                                                    } ?>><?php echo $objResult['discipline']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="container d-flex justify-content-start">
                <div class="mb-2 col-4">
                    <label for="create_work">Work: </label>
                    <select name="work" id="work" class="form-select" onchange="setFillter('create_work',this.value)">
                        <option value="" <?php if ($create_work == '') {
                                                echo "selected";
                                            } ?>>แสดงทั้งหมด</option>
                        <?php
                        if ($create_discipline != "") {
                            $condition2 = " AND `discipline` = '$create_discipline'";
                        }
                        $sql2 = "SELECT DISTINCT `work` FROM `type` WHERE `enable` = 1" . $condition2;
                        $objQuery = $conDB->sqlQuery($sql2);

                        while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                            <option value="<?php echo $objResult['work']; ?>" <?php if ($create_work == $objResult['work']) {
                                                                                    echo "selected";
                                                                                } ?>><?php echo $objResult['work']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="container d-flex justify-content-start">
                <div class="mb-2 col-4">
                    <label for="create_type">Type: </label>
                    <select name="type" id="type" class="form-select" onchange="setFillter('create_type',this.value)">
                        <option value="" <?php if ($create_type == '') {
                                                echo "selected";
                                            } ?>>แสดงทั้งหมด</option>
                        <?php
                        if ($create_work != "") {
                            $condition2 = " AND `work` = '$create_work'";
                        }
                        $sql2 = "SELECT DISTINCT `type` FROM `type` WHERE `enable` = 1" . $condition2;
                        $objQuery = $conDB->sqlQuery($sql2);

                        while ($objResult = mysqli_fetch_assoc($objQuery)) { ?>
                            <option value="<?php echo $objResult['type']; ?>" <?php if ($create_type == $objResult['type']) {
                                                                                    echo "selected";
                                                                                } ?>><?php echo $objResult['type']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="container d-flex justify-content-start">
                <div class="mb-2 col-4">
                    <label for="prepared_by" class="form-label">Prepared By:</label>
                    <input type="text" name="prepared_by" id="prepared_by" class="form-control" required>
                </div>
            </div><br>

            <div class="container d-flex justify-content-center">
                <div class="mb-2 col-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Create Document</button>
                </div>
            </div>
        </form>
    </div>
    <?php include("_script.php"); ?>
</body>

</html>