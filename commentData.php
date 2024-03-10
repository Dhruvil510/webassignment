<?php
//database connection file
require_once 'databaseConnection.php';


// comment data validation
function validateProductId($productId) {
    return !empty($productId);
}

function validateUserId($userId) {
    return !empty($userId);
}

function validateRatings($ratings) {
    return is_numeric($ratings) && $rating >= 1 && $rating <= 5;
}

function validateText($text) {
    return !empty($text);
}


//  Delete method for Delete all commented data
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];

    $stmt = $pdo->prepare('DELETE FROM comment_data WHERE id=?');
    $stmt->execute([$id]);

    //after successfully delete show the below message
    echo json_encode(['message' => 'Comment deleted from product']);
}

//  Get method for get all commented data with product and user details
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare('SELECT cd.id AS commentId, cd.product_id, cd.user_id, ud.email AS userEmailData, ud.username AS userNameData, 
                                  pd.id AS productId, pd.product_description AS productDescriptionData, pd.product_image AS productImageData, pd.product_pricing AS productPriceData, pd.product_shippingCost AS productShippingCostsData,
                                  cd.ratings, cd.product_images, cd.text
                           FROM comment_data cd
                           JOIN user_data ud ON cd.user_Id = ud.id
                           JOIN product_data pd ON cd.product_Id = pd.id');
    $stmt->execute();
    $comment_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($comment_data);
}

//  Post method for Post all commented data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['product_id'];
    $userId = $data['user_id'];
    $ratings = $data['ratings'];
    $productImages = $data['product_images'];
    $text = $data['text'];

    if (!validateProductId($productId) || !validateUserId($userId) || !validateRatings($ratings)  || !validateText($text)) {
        echo json_encode(['error' => 'Invalid data provided']);
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO comment_data (product_id, user_id, ratings, product_images, text) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$productId, $userId, $ratings, $productImages, $text]);

    //after successfully Post show the below message
    echo json_encode(['message' => 'Comment posted successfully on product']);
}

//  PUT method for update all commented data
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $productId = $data['product_id'];
    $userId = $data['user_id'];
    $ratings = $data['ratings'];
    $productImages = $data['product_images'];
    $text = $data['text'];

    if (!validateProductId($productId) || !validateUserId($userId) || !validateRatings($ratings)  || !validateText($text)) {
        echo json_encode(['error' => 'Invalid data provided']);
        exit;
    }

    $stmt = $pdo->prepare('UPDATE comment_data SET product_id=?, user_id=?, ratings=?, product_images=?, text=? WHERE id=?');
    $stmt->execute([$productId, $userId, $ratings, $productImages, $text, $id]);

    //after successfully update show the below message
    echo json_encode(['message' => 'Comment updated successfully on product']);
}

?>
