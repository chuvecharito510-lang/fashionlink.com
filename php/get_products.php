<?php
header("Content-Type: application/json");
require_once("../php/config.php");

$sql = "SELECT id, name, description, price, category, image_url, stock FROM products";
$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode($products);

$conn->close();
?>