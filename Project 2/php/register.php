<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username && $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

        try {
            $stmt->execute([$username, $hashedPassword]);
            echo "Inscription réussie.";
        } catch (PDOException $e) {
            echo "Nom d'utilisateur déjà utilisé.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>
