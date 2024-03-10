<?php
//Database connection file
require_once 'databaseConnection.php';


// order data validation
function validateProductId($productId) {
    return !empty($productId);
}

function validateUserId($userId) {
    return !empty($userId);
}

function validateQuantity($quantity) {
    return is_numeric($quantity) && $quantity > 0;
}

function validateTotalAmount($totalAmount) {
    return is_numeric($totalAmount) && $totalAmount > 0;
}

//  Delete method for Delete all order data
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];

    $stmt = $pdo->prepare('DELETE FROM order_data WHERE id=?');
    $stmt->execute([$id]);

    //after successfully delete show the below message
    echo json_encode(['message' => 'Order deleted successfully with all details']);
}

//  GET method for GET all order data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare('SELECT od.id AS orderId, od.product_id, od.user_id, ud.email AS userEmailData, ud.username AS userNameData,
                                  pd.id AS productId, pd.product_description AS productDescriptionData, pd.product_image AS productImageData, pd.product_pricing AS productPrice, pd.product_shippingCost AS shippingCosts,
                                  od.quantities, od.totalAmount
                           FROM order_data od
                           JOIN user_data ud ON od.user_id = ud.id
                           JOIN product_data pd ON od.product_id = pd.id');
    $stmt->execute();
    $order_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($order_data);
}

//  POST method for POST all order data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['product_id'];
    $userId = $data['user_id'];
    $quantityData = $data['quantities'];
    $totalAmountData = $data['totalAmount'];


    if (!validateProductId($productId) || !validateUserId($userId) || !validateQuantity($quantityData) || !validateTotalAmount($totalAmountData)) {
        echo json_encode(['error' => 'Invalid data entered']);
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO `order_data` (product_id, user_id, quantities, totalAmount) VALUES (?, ?, ?, ?)');
    $stmt->execute([$productId, $userId, $quantityData, $totalAmountData]);

    //after successfully Post show the below message
    echo json_encode(['message' => 'Order created successfully with all data']);
}

//  PUT method for Update all order data
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $productId = $data['product_id'];
    $quantityData = $data['quantities'];
    $totalAmountData = $data['totalAmount'];

    if (!validateProductId($productId) || !validateQuantity($quantityData) || !validateTotalAmount($totalAmountData)) {
        echo json_encode(['error' => 'Invalid data Entered']);
        exit;
    }

    $stmt = $pdo->prepare('UPDATE `order_data` SET product_id=?, quantities=?, totalAmount=? WHERE id=?');
    $stmt->execute([$productId, $quantityData, $totalAmountData, $id]);

    //after successfully update show the below message
    echo json_encode(['message' => 'Order updated with all data']);
}


?>
