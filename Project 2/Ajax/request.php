<?php
require_once '../config/database.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'check_room_availability':
            $room_id = $_POST['room_id'];
            $check_in = $_POST['check_in'];
            $check_out = $_POST['check_out'];
            
            $stmt = $conn->prepare("SELECT COUNT(*) FROM bookings WHERE room_id = ? AND 
                                   ((check_in <= ? AND check_out >= ?) OR 
                                   (check_in <= ? AND check_out >= ?))");
            $stmt->bind_param("issss", $room_id, $check_out, $check_in, $check_out, $check_in);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            
            echo json_encode(['available' => $count === 0]);
            break;
            
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
}
?>