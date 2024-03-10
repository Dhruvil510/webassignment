<?php
//database connection file
require_once 'databaseConnection.php';

// validation of cart
function validateProductId($productIdData) {
    return !empty($productIdData);
}

function validateQuantity($quantityData) {
    return is_numeric($quantityData) && $quantityData > 0;
}

function validateUserId($userIdData) {
    return !empty($userIdData);
}


//  Delete method for Delete all cart data
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];

    $stmt = $pdo->prepare('DELETE FROM cart_data WHERE id=?');
    $stmt->execute([$id]);

    //after successfully delete show the below message
    echo json_encode(['message' => 'Cart deleted successfully with all the details']);
}


//  Get method for get all the cart data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare('SELECT cd.id AS cartId, cd.user_id, ud.email AS userEmailData, ud.username AS userNameData, 
                                  pd.id AS productId, pd.product_description AS productDescriptionData, pd.product_image AS productImageData, pd.product_pricing AS productPriceData, pd.product_shippingCost AS shippingCostsData, 
                                  cd.quantities
                           FROM cart_data cd
                           JOIN user_data ud ON cd.user_id = ud.id
                           JOIN product_data pd ON cd.product_id = pd.id');
    $stmt->execute();
    $cart_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // store data in one result variable
    $result = [];
    foreach ($cart_data as $cart) {
        $cartId = $cart['cartId'];
        if (!isset($result[$cartId])) {
            $result[$cartId] = [
                'cartId' => $cartId,
                'userId' => $cart['user_id'],
                'userEmail' => $cart['userEmailData'],
                'userName' => $cart['userNameData'],
                'product_data' => [],
            ];
        }
        $result[$cartId]['product_data'][] = [
            'productId' => $cart['productId'],
            'productDescription' => $cart['productDescriptionData'],
            'productPrice' => $cart['productPriceData'],
            'quantity' => $cart['quantities'],
        ];
    }

    //print the result
    echo json_encode(array_values($result));
}


//  POST method for POST the all cart data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $newProductId = $data['product_id'];
    $newQuantity = $data['quantities'];
    $newUserId = $data['user_id']; 
    $user = null;

    if (!validateProductId($newProductId) || !validateQuantity($newQuantity) || !validateUserId($newUserId)) {
        echo json_encode(['error' => 'Invalid data entered']);
        exit;
    }

    // take out the data from user database
    $stmt = $pdo->prepare('SELECT * FROM user_data WHERE id = ?');
    $stmt->execute([$newUserId]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        echo json_encode(['message' => 'User not found']);
        http_response_code(404);
        exit();
    }

    // take out data from the product database
    $stmt = $pdo->prepare('SELECT * FROM product_data WHERE id = ?');
    $stmt->execute([$newProductId]);
    $productData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$productData) {
        echo json_encode(['message' => 'Product not found']);
        http_response_code(404);
        exit();
    }

    $stmt = $pdo->prepare('INSERT INTO cart_data (product_id, quantities, user_id) VALUES (?, ?, ?)');
    $stmt->execute([$newProductId, $newQuantity, $newUserId]);

    //after successfully post show the below message
    echo json_encode(['message' => 'Cart created successfully with all the details']);
}



//  PUT method for Update all the cart data
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $newProductId = $data['product_id'];
    $newQuantity = $data['quantities'];

    if (!validateProductId($newProductId) || !validateQuantity($newQuantity)) {
        echo json_encode(['error' => 'Invalid data entered']);
        exit;
    }

    // take out the cart data
    $stmt = $pdo->prepare('SELECT * FROM cart_data WHERE id = ?');
    $stmt->execute([$id]);
    $cartData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cartData) {
        echo json_encode(['message' => 'Cart data not found']);
        http_response_code(404);
        exit();
    }

    // take out the product details through id
    $stmt = $pdo->prepare('SELECT * FROM product_data WHERE id = ?');
    $stmt->execute([$newProductId]);
    $productData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$productData) {
        echo json_encode(['message' => 'Product data not found']);
        http_response_code(404);
        exit();
    }

    $stmt = $pdo->prepare('UPDATE cart_data SET product_id = ?, quantities = ? WHERE id = ?');
    $stmt->execute([$newProductId, $newQuantity, $id]);

    //after successfully PUT show the below message
    echo json_encode(['message' => 'Cart data updated successfully with all the details']);
}

?>
