<?php

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

require 'config.php';

function countUsers($conn) {
    $sql = 'SELECT COUNT(*) as user_count FROM users';
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['user_count'] ?? 0;
}

function countReservations($conn) {
    $sql = 'SELECT COUNT(*) as reservation_count FROM reservations';
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['reservation_count'] ?? 0;
}

$userCount = countUsers($conn);
$reservationCount = countReservations($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar {
            background-color: #333;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        .navbar-links {
            display: flex;
            gap: 15px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .navbar a:hover {
            color: #00bcd4;
        }
        .navbar a i {
            margin-right: 5px;
        }
        .container {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            flex: 1 1 calc(50% - 20px);
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .card h3 {
            margin: 0;
            font-size: 24px;
        }
        .chart-container {
            flex: 1 1 100%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 768px) {
            .card {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="navbar-links">
            <a href="user_table.php"><i class="fas fa-users"></i> Users</a>
            <a href="reserve_table.php"><i class="fas fa-calendar-check"></i> Reserve</a>
        </div>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
    </div>
    <div class="container">
        <div class="card">
            <h3>Total Users</h3>
            <p id="total-users"><?php echo $userCount; ?></p>
        </div>
        <div class="card">
            <h3>Total Reserves</h3>
            <p id="total-reserves"><?php echo $reservationCount; ?></p>
        </div>
        <div class="chart-container">
            <canvas id="myChart" ></canvas>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
       fetch("user_vs_reservation.php")
    .then(response => response.json())
    .then(data => {
        const xValues = data.users;
        const yValues = data.reservations;

        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: "rgba(0,0,255,0.1)",
                    borderColor: "rgba(0,0,255,1.0)",
                    data: yValues
                }]
            },
            options: {
                legend: { display: false },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                            stepSize: 1
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            stepSize: 1
                        }
                    }]
                },
                title: {
                    display: true,
                    text: "User vs Reservation Over Time"
                }
            }
        });
    });
    </script>
</body>
</html>