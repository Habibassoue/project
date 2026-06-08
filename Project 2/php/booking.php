<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Veuillez vous connecter.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    // Vérifie si la chambre est disponible
    $check = $pdo->prepare("SELECT status FROM rooms WHERE id = ?");
    $check->execute([$room_id]);
    $room = $check->fetch();

    if ($room && $room['status'] === 'available') {
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, room_id, check_in, check_out) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $room_id, $check_in, $check_out]);

        $update = $pdo->prepare("UPDATE rooms SET status = 'booked' WHERE id = ?");
        $update->execute([$room_id]);

        echo "Chambre réservée avec succès.";
    } else {
        echo "Chambre non disponible.";
    }
}
?>
