<?php
session_start();
include 'config.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $destination = $_POST['destination'];
    $bus_type = $_POST['bus_type'];
    $seats = $_POST['seats'];
    $date = $_POST['date'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("INSERT INTO reservations (name, email, address, destination, bus_type, seats, date, phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssi", $name, $email, $address, $destination, $bus_type, $seats, $date, $phone);

    if ($stmt->execute()){
        $errors[] = "Registration Successfully done!";
        header("Location: ticket.php");
    } else{
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Reservation Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            position: relative;
            margin-bottom: 15px;
        }
        .form-group input, .form-group select {
            width: calc(100% - 50px); /* Ensures consistent width for all inputs */
            padding: 10px 10px 10px 40px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Ensures padding doesn't affect width */
        }
        .form-group i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #555;
        }
        .payment-methods {
            display: flex;
            justify-content: space-around;
            margin: 15px 0;
        }
        .payment-methods img {
            width: 50px;
            margin: 5px;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .payment-methods img:hover {
            transform: scale(1.1);
        }
        .buttons {
            display: flex;
            justify-content: space-between;
        }
        .buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .buttons .reserve-btn {
            background-color: #28a745;
            color: #fff;
        }
        .buttons .reserve-btn:hover {
            transform: scale(1.1);
        }
        .buttons .cancel-btn {
            background-color: #dc3545;
            color: #fff;
        }
        .buttons .cancel-btn:hover {
            transform: scale(1.1);
        }

        .error{
            color: red;
        }
        @media (max-width: 768px) {
            .container {
            padding: 15px;
            }
            .buttons button {
            width: 48%;
            }
    </style>
</head>
    <body>
        <div class="container">
        <h1>Reserve Your Bus Ticket</h1>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach;?>    
            </div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Name" name="name" required>
            </div>
            <div class="form-group">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" name="email" required>
            </div>
            <div class="form-group">
            <i class="fas fa-map-marker-alt"></i>
            <input type="text" placeholder="Address" name="address" required>
            </div>
            <div class="form-group">
            <i class="fas fa-map-signs"></i>
            <input type="text" placeholder="Destination" name="destination" required>
            </div>
            <div class="form-group">
            <i class="fas fa-bus"></i>
            <select name="bus_type" required>
            <option value="" disabled selected>Bus Class</option>
            <option value="economy">Economy</option>
            <option value="business">Business</option>
            </select>
            </div>
            <div class="form-group">
            <i class="fas fa-chair"></i>
            <input type="number" placeholder="Reserve Seats" name="seats" required>
            </div>
            <div class="form-group">
            <i class="fas fa-calendar-alt"></i>
            <input type="date" name="date" required>
            </div>
            <label for="payment-methods" style="font-weight: bold; display: block; margin-bottom: 10px;">Choose Your Payment Method</label>
            <div class="payment-methods" id="payment-methods">
            <img src="image/OIP.jpg" alt="Payment Method 1" onclick="showPhoneInput()">
            <img src="image/OIP1.jpg" alt="Payment Method 2" onclick="showPhoneInput()">
            </div>
            <div class="form-group" id="phone-input" style="display: none;">
            <i class="fas fa-phone"></i>
            <input type="tel" placeholder="Enter your telephone (+237)" name="phone" required>
            </div>
            <div class="buttons">
            <button type="submit" class="reserve-btn">Reserve</button>
            <button type="reset" class="cancel-btn">Cancel</button>
            </div>
        </form>
        </div>
        <script>
        function showPhoneInput() {
            const phoneInput = document.getElementById('phone-input');
            phoneInput.style.display = 'block';
        }
        </script>
    </body>
</html>