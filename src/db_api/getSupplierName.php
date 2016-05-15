<?php
function getSupplierName($db, $id) {
    $sql = "SELECT name FROM supplier WHERE id={?}";
    return $db->selectCell($sql, array($id));
}

fu
?>