<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';
    $ret = "SELECT * FROM colos_products WHERE prod_name LIKE ? OR prod_code = ?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param("ss", $search, $_GET['search']);
} else {
    $ret = "SELECT * FROM colos_products";
    $stmt = $mysqli->prepare($ret);
}

$stmt->execute();
$res = $stmt->get_result();

$products = array();
while ($prod = $res->fetch_object()) {
    $products[] = array(
        'prod_id' => $prod->prod_id,
        'prod_code' => $prod->prod_code,
        'prod_name' => $prod->prod_name,
        'prod_price' => $prod->prod_price,
        'prod_img' => $prod->prod_img
    );
}

header('Content-Type: application/json');
echo json_encode($products);
?>
