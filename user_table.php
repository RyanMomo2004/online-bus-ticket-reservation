<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

require 'config.php';

function fetchAllUsers($conn){
    $stmt = $conn->query("SELECT id, name, email FROM users");
    return $stmt->fetch_all(MYSQLI_ASSOC);
} 

$users = fetchAllUsers($conn);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-sort {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            align-items: center;
        }
        .search-container {
            display: flex;
            align-items: center;
            width: 70%;
        }
        .search-container input {
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
            outline: none;
        }
        .search-container button {
            padding: 10px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }
        .search-container button:hover {
            background-color: #0056b3;
        }
        .sort-btn {
            padding: 10px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .sort-btn:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
        }
        table tbody tr {
            width: 100%;
        }
        .action-btn {
            background-color: #DC3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .action-btn:hover {
            background-color: darkred;
        }
        .footer-buttons {
            display: flex;
            justify-content: space-between;
        }
        .footer-buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .footer-buttons button:hover {
            transform: scale(1.1);
        }
        .add-btn {
            background-color: #007BFF;
            color: white;
        }
        .return-btn {
            background-color: #6C757D;
            color: white;
        }
        @media (max-width: 768px) {
            .search-sort {
            flex-direction: column;
            gap: 10px;
            }
            .search-container {
            width: 100%;
            }
            table th, table td {
            font-size: 14px;
            padding: 8px;
            }
            .footer-buttons {
            flex-direction: column;
            gap: 10px;
            }
        }
        </style>
</head>
    <body>
        <div class="container">
            <h1>User List</h1>
            <div class="search-sort">
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search user by name...">
                    <button onclick="searchUser()">Search</button>
                </div>
                <button class="sort-btn" onclick="sortTable()">Sort</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="userTable">
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><a href="delete-user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')"><button class="action-btn">Delete</button></a></td>
                    </tr>
                    <?php endforeach;?> 
                </tbody>
            </table>
            <div class="footer-buttons">
                <button class="add-btn" onclick="addReserve()">Add User</button>
                <button class="return-btn"  onclick="returnToPrevious()">Return</button>
            </div>
        </div>
    
        <script>
            function searchUser() {
                const input = document.getElementById('searchInput').value.toLowerCase();
                const rows = document.querySelectorAll('#userTable tr');
                rows.forEach(row => {
                    const name = row.cells[0].textContent.toLowerCase();
                    row.style.display = name.includes(input) ? '' : 'none';
                });
            }
    
            function sortTable() {
                const table = document.getElementById('userTable');
                const rows = Array.from(table.rows);
                rows.sort((a, b) => a.cells[0].textContent.localeCompare(b.cells[0].textContent));
                rows.forEach(row => table.appendChild(row));
            }
    
            function deleteRow(button) {
                const row = button.parentElement.parentElement;
                row.remove();
            }
        </script>
    </body>
    </html>
