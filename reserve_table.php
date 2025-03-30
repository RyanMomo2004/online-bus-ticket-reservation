<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

require 'config.php';

function fetchAllReservations($conn){
    $stmt = $conn->query("SELECT id, name, email, destination, bus_type FROM reservations");
    return $stmt->fetch_all(MYSQLI_ASSOC);
} 

$reservations = fetchAllReservations($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-sort-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .search-sort-container input[type="text"] {
            padding: 10px;
            width: calc(100% - 110px);
            max-width: 300px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .search-sort-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            background-color: #007BFF;
            transition: transform 0.2s;
        }
        .search-sort-container button:hover {
            transform: scale(1.05);
        }
        .reserve-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            overflow-x: auto;
        }
        .reserve-table th, .reserve-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .reserve-table th {
            background-color: #f4f4f4;
        }
        .reserve-table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
        .delete-btn {
            background-color: #DC3545;
        }
        .footer-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .footer-buttons .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .footer-buttons .add-btn {
            background-color: #007BFF;
        }
        .footer-buttons .return-btn {
            background-color: #6C757D;
        }
        .footer-buttons .btn:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reserve List</h1>
        <div class="search-sort-container">
            <input type="text" id="searchInput" placeholder="Search by name">
            <button onclick="searchTable()">Search</button>
            <button onclick="sortTable()">Sort</button>
        </div>
        <table class="reserve-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Destination</th>
                    <th>Bus Class</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="reserveTableBody">
                <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['destination']; ?></td>
                    <td><?php echo $user['bus_type']; ?></td>
                    <td><a href="delete-reserve.php?id=<?php echo $reservation['id']; ?>" onclick="return confirm('Are you sure you want to delete this reservation?')"><button class="action-btn delete-btn">Delete</button></a></td>
                </tr>
                <?php endforeach; ?>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
        <div class="footer-buttons">
            <button class="btn add-btn" onclick="addReserve()">Add Reserve</button>
            <button class="btn return-btn" onclick="returnToPrevious()">Return</button>
        </div>
    </div>

    <script>
        function searchTable() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#reserveTableBody tr');
            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                row.style.display = name.includes(input) ? '' : 'none';
            });
        }

        function sortTable() {
            const tableBody = document.getElementById('reserveTableBody');
            const rows = Array.from(tableBody.rows);
            rows.sort((a, b) => {
                const nameA = a.cells[0].textContent.toLowerCase();
                const nameB = b.cells[0].textContent.toLowerCase();
                return nameA.localeCompare(nameB);
            });
            rows.forEach(row => tableBody.appendChild(row));
        }

        function deleteRow(button) {
            const row = button.closest('tr');
            row.remove();
        }

        function addReserve() {
            alert('Add Reserve button clicked!');
            // Add your logic here
        }

        function returnToPrevious() {
            alert('Return button clicked!');
            // Add your logic here
        }
    </script>
</body>
</html>
