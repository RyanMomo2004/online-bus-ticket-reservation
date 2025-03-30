<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Reservation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar Styles */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 0.5rem 1rem;
        }

        .navbar .nav-links {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.5rem;
            transition: background-color 0.3s;
        }

        .navbar .nav-links a:hover {
            background-color: #555;
            border-radius: 5px;
        }

        .navbar .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .navbar .nav-buttons button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s, background-color 0.3s;
        }

        .navbar .nav-buttons button:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }

        .navbar .menu-toggle {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Container Styles */
        .container {
            flex: 1;
            padding: 2rem;
            text-align: center;
        }

        .container h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .container p {
            font-size: 1.2rem;
            color: #555;
        }

        /* Footer Styles */
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: auto;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .navbar .nav-links {
                display: none;
                flex-direction: column;
                background-color: #333;
                position: fixed;
                top: 0;
                right: -100%;
                height: 100%;
                width: 250px;
                z-index: 1000;
                background-color: #333;
                box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
                transition: right 0.3s ease;
                padding-top: 2rem;
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .navbar .nav-links.active {
                right: 0;
            }

            .navbar .menu-toggle {
                display: block;
                color: white;
            }

            .navbar .nav-links a {
                padding: 1rem;
                text-align: left;
                color: white;
                text-decoration: none;
                border-bottom: 1px solid #555;
                transition: background-color 0.3s;
            }

            .navbar .nav-links a:hover {
                background-color: #444;
            .navbar .nav-buttons {
                flex-direction: column;
                gap: 1rem;
                margin-top: 1rem;
            }

            .navbar .nav-buttons button {
                width: 80%;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="menu-toggle" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </div>
        <div class="nav-links">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="#"><i class="fas fa-envelope"></i> Inbox</a>
        </div>
        <div class="nav-buttons">
            <button onclick="location.href='login.php'"><i class="fas fa-sign-in-alt"></i> Login</button>
            <button onclick="location.href='register.php'"><i class="fas fa-user-plus"></i> Register</button>
        </div>
    </div>
    <div class="container">
        <h1>Welcome to Online Bus Reservation</h1>
        <p>Book your bus tickets easily and conveniently.</p>
    </div>
    <div class="footer">
        <p>&copy; 2025 Online Bus Reservation. All rights reserved.</p>
    </div>
    <script>
        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('active');
        }
    </script>
</body>
</html>