<?php
require_once 'config.php';

function handleLogin($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['email']) || !isset($data['password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing credentials']);
        exit();
    }

    $email = trim($data['email']);
    $password = $data['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
        exit();
    }
    echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
    exit();
}

function handleRegistration($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['names']) || !isset($data['surnames']) || 
        !isset($data['emailCreate']) || !isset($data['passwordCreate'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing registration data']);
        exit();
    }

    $names = trim($data['names']);
    $surnames = trim($data['surnames']);
    $email = trim($data['emailCreate']);
    $password = password_hash($data['passwordCreate'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if($stmt->fetch()) {
            echo json_encode(['status' => 'error', 'message' => 'Email already exists']);
            exit();
        }

        $stmt = $pdo->prepare("INSERT INTO users (names, surnames, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$names, $surnames, $email, $password]);
        
        echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
        exit();
    } catch(PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Registration failed: ' . $e->getMessage()]);
        exit();
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    
    if ($contentType === 'application/json') {
        $data = json_decode(file_get_contents('php://input'), true);
        $action = $data['action'] ?? '';
    } else {
        $action = $_POST['action'] ?? '';
    }

    switch($action) {
        case 'login':
            handleLogin($pdo);
            break;
        case 'register':
            handleRegistration($pdo);
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            exit();
    }
}