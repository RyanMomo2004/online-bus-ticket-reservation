<?php
include 'config.php';
session_start();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password, $role);

    if ($stmt->fetch() && password_verify($password, $hashed_password)){
        $_SESSION['user_id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['role'] = $role;

        if ($role == 'admin'){
            header("Location: admin.php");
        }else{
            header("Location: user.php");
        }
    } else{
        $errors[] = "Invalid email or password!";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
        }
        .login-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input-container {
            position: relative;
            margin-bottom: 15px;
        }
        .input-container input {
            width: 100%;
            padding: 10px 40px; /* Adjust padding for icon space */
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .input-container i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #888;
        }
        .checkbox-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .checkbox-container label {
            display: flex;
            align-items: center;
        }
        .checkbox-container input {
            margin-right: 5px;
        }
        .checkbox-container a {
            color: #007BFF;
            text-decoration: none;
        }
        .checkbox-container a:hover {
            text-decoration: underline;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
        }
        .button-container button {
            width: 48%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .button-container button:hover {
            transform: scale(1.05);
        }
        .button-login {
            background-color: #28a745;
        }
        .button-cancel {
            background-color: #dc3545;
        }
        .signup {
            text-align: center;
            margin-top: 20px;
        }
        .signup a {
            color: #007BFF;
            text-decoration: none;
        }
        .signup a:hover {
            text-decoration: underline;
        }
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <form class="login-form" method="post">
        <h2>Sign In Form</h2>
        <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach;?>    
        </div>
       <?php endif; ?>
        <div class="input-container">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" name="email" required>
        </div>
        <div class="input-container">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="password" required>
        </div>
        <div class="checkbox-container">
            <label>
                <input type="checkbox"> Remember me
            </label>
            <a href="#">Forgot password?</a>
        </div>
        <div class="button-container">
            <button type="submit" class="button-login">Login</button>
            <button type="button" class="button-cancel">Cancel</button>
        </div>
        <p class="signup">If you don't have an account, <a href="signup.php">Sign Up</a></p>
    </form>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>