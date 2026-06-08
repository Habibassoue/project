function validateRegistration($username, $email, $password, $confirm_password) {
    $errors = [];
    
    if (strlen($username) < 4) {
        $errors[] = "Username must be at least 4 characters long";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    return $errors;
}
function registerUser($username, $email, $password) {
    global $conn;
    
    // Hash password using SHA-256
    $hashed_password = hash('sha256', $password);
    
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    
    return $stmt->execute();
}