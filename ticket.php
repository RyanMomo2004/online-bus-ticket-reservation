<?php

session_start();
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables
$user_id = $_SESSION['user_id'];
$ticket_info = null;
$errors = [];

// Fetch user's reservation information
try {
    // First get user's email from users table
    $user_stmt = $conn->prepare("SELECT email, name FROM users WHERE id = ?");
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();
    $user_data = $user_result->fetch_assoc();
    $user_stmt->close();
    
    if ($user_data) {
        // Then get reservation using either email or name
        $reservation_stmt = $conn->prepare("SELECT * FROM reservations WHERE email = ? OR name = ? ORDER BY date DESC LIMIT 1");
        $reservation_stmt->bind_param("ss", $user_data['email'], $user_data['name']);
        $reservation_stmt->execute();
        $reservation_result = $reservation_stmt->get_result();
        $ticket_info = $reservation_result->fetch_assoc();
        $reservation_stmt->close();
        
        if (!$ticket_info) {
            $errors[] = "No reservation found for your account";
        }
    } else {
        $errors[] = "User not found";
    }
} catch (Exception $e) {
    $errors[] = "Database error: " . $e->getMessage();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Ticket</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .ticket-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 25px;
            text-align: center;
        }
        
        h1 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 22px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 8px;
            display: inline-block;
        }
        
        .ticket-info {
            text-align: left;
            margin: 15px 0;
            padding: 0 10px;
        }
        
        .ticket-info p {
            margin: 8px 0;
            font-size: 14px;
            color: #34495e;
            line-height: 1.3;
        }
        
        .ticket-info strong {
            color: #2c3e50;
            min-width: 100px;
            display: inline-block;
            font-size: 13px;
        }
        
        #barcode {
            margin: 15px auto;
            display: block;
            height: 50px;
            width: 100%;
        }
        
        .print-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 15px;
            transition: background-color 0.3s;
        }
        
        .print-btn:hover {
            background-color: #2980b9;
        }
        
        @media print {
            body {
                background-color: white;
                padding: 0;
                margin: 0;
                display: block;
            }
            
            .ticket-container {
                width: 88mm !important;
                height: 51mm !important;
                padding: 5mm !important;
                margin: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                page-break-after: always;
            }
            
            h1 {
                font-size: 16px !important;
                margin-bottom: 8px !important;
                padding-bottom: 4px !important;
            }
            
            .ticket-info p {
                font-size: 11px !important;
                margin: 5px 0 !important;
            }
            
            .ticket-info strong {
                min-width: 70px !important;
                font-size: 11px !important;
            }
            
            #barcode {
                height: 30px !important;
                margin: 8px auto !important;
            }
            
            .print-btn {
                display: none !important;
            }
            
            /* Hide URL and page info when printing */
            @page {
                size: 88mm 51mm;
                margin: 0;
            }
            
            body, html {
                width: 88mm !important;
                height: 51mm !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ozana Agency Ticket</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php elseif ($ticket_info): ?>
            <div class="ticket">
                <div class="ticket-info">
                    <p><strong>Ticket ID:</strong> <?php echo htmlspecialchars($ticket_info['id']); ?></p>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($ticket_info['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($ticket_info['email']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($ticket_info['address']); ?></p>
                    <p><strong>Destination:</strong> <?php echo htmlspecialchars($ticket_info['destination']); ?></p>
                    <p><strong>Bus Class:</strong> <?php echo htmlspecialchars($ticket_info['bus_type']); ?></p>
                    <p><strong>Number of Seats:</strong> <?php echo htmlspecialchars($ticket_info['seats']); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($ticket_info['date']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($ticket_info['phone']); ?></p>
                </div>
                
                <svg id="barcode"></svg>
                <button class="print-btn" onclick="window.print()">Print Ticket</button>
            </div>
            
            <script>
                // Generate barcode using the ticket ID
                JsBarcode("#barcode", "<?php echo $ticket_info['id']; ?>", {
                    format: "CODE128",
                    lineColor: "#2c3e50",
                    width: 1.5,
                    height: 30,
                    displayValue: false,
                    fontSize: 16,
                    margin: 10
                });
            </script>
        <?php endif; ?>
    </div>
</body>
</html>