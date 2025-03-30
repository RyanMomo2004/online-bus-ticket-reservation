<?php
include 'config.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT ); 
    $role = 'user';   
        
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()){
        $errors[] = "Registration Successful!";
        header("Location: login.php");
    } else{
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .signup-form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .signup-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            position: relative;
            margin-bottom: 15px;
        }
        .form-group input {
            width: 100%;
            padding: 10px 40px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #888;
        }
        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }
        .form-group .checkbox-label {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .form-group .checkbox-label input {
            width: auto;
            margin-right: 10px;
        }
        .form-buttons {
            display: flex;
            justify-content: space-between;
        }
        .form-buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .form-buttons button:hover {
            transform: scale(1.05);
        }
        .btn-signup {
            background-color: #28a745;
            color: #fff;
        }
        .btn-cancel {
            background-color: #dc3545;
            color: #fff;
        }
        .form-footer {
            text-align: center;
            margin-top: 15px;
        }
        .form-footer a {
            color: #007bff;
            text-decoration: none;
        }
        .form-footer a:hover {
            text-decoration: underline;
        }
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <form class="signup-form" method="post">
        <h2>Sign Up Form</h2>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach;?>    
            </div>
        <?php endif; ?>
        <div class="form-group">
            <i class="fas fa-user"></i>
            <input type="text" placeholder=" Name" name="name" required>
        </div>
        <div class="form-group">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder=" Email" name="email" required>
        </div>
        <div class="form-group">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="password" required>
        </div>
        <div class="form-group checkbox-label">
            <input type="checkbox" name="role" value="user" required>
            <label>Check if you are a user</label>
        </div>
        <div class="form-buttons">
            <button type="submit" class="btn-signup">Sign Up</button>
            <button type="button" class="btn-cancel">Cancel</button>
        </div>
        <div class="form-footer">
            <p>If you have an account, <a href="login.php">Log In</a></p>
        </div>
    </form>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html></div>