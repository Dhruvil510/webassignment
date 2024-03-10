<?php
//database connection file
require_once 'databaseConnection.php';

//User Validation 
function validateUserEmail($userEmail) {
    return filter_var($userEmail, FILTER_VALIDATE_EMAIL);
}

function validateUserPassword($userPassword) {
    return !empty($userPassword);
}

function validateUsername($username) {
    return !empty($username);
}


// Delete method for delete all user data
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];

    $stmt = $pdo->prepare('DELETE FROM user_data WHERE id = ?');
    $stmt->execute([$id]);

    //after successfully delete show the below message
    echo json_encode(['message' => 'User data deleted successfully']);
}


// Get method for get all user data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->query('SELECT * FROM user_data');
    $user_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($user_data);
}

//  Post method for post all user data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $userEmail = $data['email'];
    $userPassword = $data['password'];
    $username = $data['username'];
    $userPurchaseHistory = $data['purchaseHistory'];
    $userShippingAddress = $data['shippingAddress'];

    if (!validateUserEmail($userEmail) || !validateUserPassword($userPassword) || !validateUsername($username)) {
        echo json_encode(['error' => 'Invalid data Entered']);
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO user_data (email, password, username, purchaseHistory, shippingAddress) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$userEmail, $userPassword, $username, $userPurchaseHistory, $userShippingAddress]);

    //after successfully post show the below message
    echo json_encode(['message' => 'User data created successfully']);
}

//  Update method for Update all user data
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];
    $userEmail = $data['email'];
    $userPassword = $data['password'];
    $username = $data['username'];
    $userPurchaseHistory = $data['purchaseHistory'];
    $userShippingAddress = $data['shippingAddress'];

    if (!validateUserEmail($userEmail) || !validateUserPassword($userPassword) || !validateUsername($username)) {
        echo json_encode(['error' => 'Invalid data Entered']);
        exit;
    }

    $stmt = $pdo->prepare('UPDATE user_data SET email=?, password=?, username=?, purchaseHistory=?, shippingAddress=? WHERE id=?');
    $stmt->execute([$userEmail, $userPassword, $username, $userPurchaseHistory, $userShippingAddress, $id]);

    //after successfully update show the below message
    echo json_encode(['message' => 'User data updated successfully']);
}

?>
