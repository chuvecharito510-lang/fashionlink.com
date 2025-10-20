<?php
header("Content-Type: application/json");
require_once("../php/config.php");

$response = ['success' => false, 'message' => ''];

// Get the POST data
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['reservations']) || !is_array($data['reservations']) || empty($data['reservations'])) {
    $response['message'] = 'No reservation data provided.';
    echo json_encode($response);
    exit();
}

// Start transaction
$conn->begin_transaction();

try {
    foreach ($data['reservations'] as $reservation) {
        $productId = $reservation['product_id'];
        $customerName = $reservation['customer_name'];
        $customerEmail = $reservation['customer_email'];
        $customerPhone = $reservation['customer_phone'];
        $additionalNotes = $reservation['additional_notes'];

        // Check product stock first
        $stmt = $conn->prepare("SELECT stock FROM products WHERE id = ? FOR UPDATE"); // FOR UPDATE locks the row
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new Exception("Product with ID {$productId} not found.");
        }
        $product = $result->fetch_assoc();
        if ($product['stock'] <= 0) {
            throw new Exception("Product '{$reservation['product_name']}' is out of stock.");
        }
        $stmt->close();

        // Decrement stock
        $stmt = $conn->prepare("UPDATE products SET stock = stock - 1 WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        if ($stmt->affected_rows === 0) {
            throw new Exception("Failed to update stock for product ID {$productId}.");
        }
        $stmt->close();

        // Insert reservation
        $stmt = $conn->prepare("INSERT INTO reservations (product_id, customer_name, customer_email, customer_phone, additional_notes) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $productId, $customerName, $customerEmail, $customerPhone, $additionalNotes);
        $stmt->execute();
        if ($stmt->affected_rows === 0) {
            throw new Exception("Failed to insert reservation for product ID {$productId}.");
        }
        $stmt->close();
    }

    // Commit transaction
    $conn->commit();
    $response['success'] = true;
    $response['message'] = 'Reservations made successfully.';

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    $response['message'] = 'Transaction failed: ' . $e->getMessage();
} finally {
    $conn->close();
}

echo json_encode($response);
?>
