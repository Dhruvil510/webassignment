<?php
// database connection file
require_once 'databaseConnection.php';

// product data validation
function validateDescription($productDescription) {
    return !empty($productDescription);
}

function validatePricing($productPrice) {
    return is_numeric($productPrice);
}

function validateShippingCost($productShippingCost) {
    return is_numeric($productShippingCost);
}

// Delete method for delete all product data
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];

    $stmt = $pdo->prepare('DELETE FROM product_data WHERE id=?');
    $stmt->execute([$id]);

    //after successfully delete show the below message
    echo json_encode(['message' => 'Product Deleted with all details']);
}


// Get method for get all product data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->query('SELECT * FROM product_data');
    $product_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($product_data);
}


// Post method for post all product data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $productDescription = $data['product_description'];
    $productImage = $data['product_image'];
    $productPrice = $data['product_pricing'];
    $productShippingCost = $data['product_shippingCost'];

    if (!validateDescription($productDescription) || !validatePricing($productPrice) || !validateShippingCost($productShippingCost)) {
        echo json_encode(['error' => 'Invalid data provided']);
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO product_data (product_description, product_image, product_pricing, product_shippingCost) VALUES (?, ?, ?, ?)');
    $stmt->execute([$productDescription, $productImage, $productPrice, $productShippingCost]);

    //after successfully post show the below message
    echo json_encode(['message' => 'Product added with Required Information']);
}


// Put method for update all product data
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $productDescription = $data['product_description'];
    $productImage = $data['product_image'];
    $productPrice = $data['product_pricing'];
    $productShippingCost = $data['product_shippingCost'];

    if (!validateDescription($productDescription) || !validatePricing($productPrice) || !validateShippingCost($productShippingCost)) {
        echo json_encode(['error' => 'Invalid data provided']);
        exit;
    }

    $stmt = $pdo->prepare('UPDATE product_data SET product_description=?, product_image=?, product_pricing=?, product_shippingCost=? WHERE id=?');
    $stmt->execute([$productDescription, $productImage, $productPrice, $productShippingCost, $id]);

    //after successfully update show the below message
    echo json_encode(['message' => 'Product details Updated']);
}


?>
