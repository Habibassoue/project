function bookRoom($user_id, $room_id, $check_in, $check_out) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, room_id, check_in, check_out) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $user_id, $room_id, $check_in, $check_out);
    
    return $stmt->execute();
}

function cancelBooking($booking_id) {
    global $conn;
    
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    
    return $stmt->execute();
}

function updateBooking($booking_id, $new_check_in, $new_check_out) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE bookings SET check_in = ?, check_out = ? WHERE id = ?");
    $stmt->bind_param("ssi", $new_check_in, $new_check_out, $booking_id);
    
    return $stmt->execute();
}