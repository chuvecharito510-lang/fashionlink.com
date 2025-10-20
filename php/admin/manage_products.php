<?php
require_once("auth.php");
requireAdminLogin();

header("Content-Type: application/json");
require_once("../../php/config.php");

$response = ['success' => false, 'message' => ''];

// Get the POST data
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['action'])) {
    $response['message'] = 'No action specified.';
    echo json_encode($response);
    exit();
}

$action = $data['action'];

try {
    switch ($action) {
        case 'create':
            if (!isset($data['product'])) {
                throw new Exception('Product data not provided.');
            }
            
            $product = $data['product'];
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, category, image_url, stock) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdssi", 
                $product['name'], 
                $product['description'], 
                $product['price'], 
                $product['category'], 
                $product['image_url'], 
                $product['stock']
            );
            
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Producto creado exitosamente.';
            } else {
                throw new Exception('Error al crear el producto: ' . $stmt->error);
            }
            $stmt->close();
            break;

        case 'update':
            if (!isset($data['product']) || !isset($data['product']['product_id'])) {
                throw new Exception('Product data or ID not provided.');
            }
            
            $product = $data['product'];
            $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, category = ?, image_url = ?, stock = ? WHERE id = ?");
            $stmt->bind_param("ssdssii", 
                $product['name'], 
                $product['description'], 
                $product['price'], 
                $product['category'], 
                $product['image_url'], 
                $product['stock'],
                $product['product_id']
            );
            
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = 'Producto actualizado exitosamente.';
                } else {
                    throw new Exception('No se encontró el producto o no se realizaron cambios.');
                }
            } else {
                throw new Exception('Error al actualizar el producto: ' . $stmt->error);
            }
            $stmt->close();
            break;

        case 'delete':
            if (!isset($data['product_id'])) {
                throw new Exception('Product ID not provided.');
            }
            
            $productId = $data['product_id'];
            
            // First, delete any reservations for this product
            $stmt = $conn->prepare("DELETE FROM reservations WHERE product_id = ?");
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $stmt->close();
            
            // Then delete the product
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $productId);
            
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = 'Producto eliminado exitosamente.';
                } else {
                    throw new Exception('No se encontró el producto.');
                }
            } else {
                throw new Exception('Error al eliminar el producto: ' . $stmt->error);
            }
            $stmt->close();
            break;

        default:
            throw new Exception('Acción no válida.');
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    $conn->close();
}

echo json_encode($response);
?>
