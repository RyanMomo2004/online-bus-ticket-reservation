<?php

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 10px 20px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            transition: transform 0.3s;
            display: flex;
            align-items: center;
        }
        .navbar a i {
            margin-right: 5px;
        }
        .navbar a:hover {
            transform: scale(1.1);
        }
        .logout-btn {
            background-color: #f44336;
            border: none;
            color: white;
            padding: 10px 15px;
            cursor: pointer;
            transition: transform 0.3s;
            display: flex;
            align-items: center;
        }
        .logout-btn i {
            margin-right: 5px;
        }
        .logout-btn:hover {
            transform: scale(1.1);
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
            flex: 1;
        }
        .card {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 10px;
            padding: 15px;
            width: 300px;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 100%;
            border-radius: 5px;
        }
        .card button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            margin-top: 10px;
            transition: transform 0.3s;
        }
        .card button:hover {
            transform: scale(1.1);
        }
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
            width: 100%;
        }
        .mobile-menu {
            display: none;
        }
        .sidepanel {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            right: 0;
            background-color: #333;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }
        .sidepanel a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.3s;
        }
        .sidepanel a:hover {
            background-color: #575757;
        }
        .sidepanel .closebtn {
            position: absolute;
            top: 10px;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        @media (max-width: 768px) {
            .navbar a {
                display: none;
            }
            .mobile-menu {
                display: block;
                cursor: pointer;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <span class="mobile-menu" onclick="openNav()">☰</span>
        <a href="user.php"><i class="fas fa-home"></i>Home</a>
        <a href="ticket.php"><i class="fas fa-envelope"></i> 
           Inbox 
        </a>
        <a href="logout.php"><button class="logout-btn"><i class="fas fa-sign-out-alt"></i>Logout</button></a>
    </div>

    <div id="mySidepanel" class="sidepanel">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <a href="users.php"><i class="fas fa-home"></i>Home</a>
        <a href="ticket.php"><i class="fas fa-envelope"></i>Inbox</a>
        <a href="logout.php"><button class="logout-btn"><i class="fas fa-sign-out-alt"></i>Logout</button></a>
    </div>

    <div class="container">
        <div class="card">
            <img src="image/bus 1.png" alt="Image">
            <h3>Standard</h3>
            <p>Source: Douala City</p>
            <p>Destination: Yaounde City</p>
            <p>Price: 5000 CFA</p>
            <p>Ratings: ★★★★☆</p>
            <a href="reserve.php"><button>Click Here to Reserve</button></a>
        </div>
        <div class="card">
            <img src="image/bus 2.png" alt="Image">
            <h3>Standard</h3>
            <p>Source: Buea City</p>
            <p>Destination: Douala City</p>
            <p>Price: 3000 CFA</p>
            <p>Ratings: ★★★★☆</p>
            <a href="reserve.php"><button>Click Here to Reserve</button></a>
        </div>
        <div class="card">
            <img src="image/bus 3.png" alt="Image">
            <h3>Business</h3>
            <p>Source: Yaounde City</p>
            <p>Destination: Douala City</p>
            <p>Price: 9000 CFA</p>
            <p>Ratings: ★★★★★</p>
            <a href="reserve.php"><button>Click Here to Reserve</button></a>
        </div>
    </div>

    <div class="footer">
        &copy; 2025 Bus Reservation System
    </div>

    <script>
        function openNav() {
            document.getElementById("mySidepanel").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }
    </script>
</body>
</html>