function validateRegistration() {
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    if (username.length < 4) {
        alert('Username must be at least 4 characters long');
        return false;
    }

    if (!email.includes('@')) {
        alert('Please enter a valid email address');
        return false;
    }

    if (password.length < 8) {
        alert('Password must be at least 8 characters long');
        return false;
    }

    if (password !== confirmPassword) {
        alert('Passwords do not match');
        return false;
    }

    return true;
}

function checkRoomAvailability(roomId, checkIn, checkOut) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/requests.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status === 200) {
            const response = JSON.parse(this.responseText);
            if (response.available) {
                document.getElementById('availability-message').innerHTML =
                    '<span style="color:green">Room is available!</span>';
            } else {
                document.getElementById('availability-message').innerHTML =
                    '<span style="color:red">Room is not available for selected dates</span>';
            }
        }
    };

    const params = `action=check_room_availability&room_id=${roomId}&check_in=${checkIn}&check_out=${checkOut}`;
    xhr.send(params);
}