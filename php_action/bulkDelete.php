<?php
include('../constant/connect.php');

if (isset($_POST['selected_ids'])) {
    $idsToDelete = $_POST['selected_ids'];
    
    if (!empty($idsToDelete)) {
        // Convert array to a comma-separated string
        $ids = implode(',', $idsToDelete);
        
        // Delete records from the database
        $sql = "DELETE FROM `calls` WHERE `id` IN ($ids)";
        $result = $connect->query($sql);
        
        if ($result) {
            header("Location: ../brand.php?filter=all&msg=deleted");
            exit();
        } else {
            header("Location: ../brand.php?filter=all&msg=error");
            exit();
        }
    }
} else {
    header("Location: ../brand.php?filter=all&msg=noselection");
    exit();
}
?>
