<?php
session_start();
include "../config/db.php";

$error = "";

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE LOWER(email)=LOWER(?)");
    $stmt->bind_param("s",$email);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){

        $user = $result->fetch_assoc();

        if(password_verify($password,$user['password'])){

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Invalid Password";
        }

    } else {
        $error = "User Not Found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Aidify Login</title>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: linear-gradient(to right, #4facfe, #00f2fe);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-container {
    background: white;
    padding: 40px;
    width: 350px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    text-align: center;
}

input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 6px;
    border: 1px solid #ccc;
}

.btn {
    width: 100%;
    padding: 12px;
    background: #4facfe;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.link {
    display: block;
    margin-top: 15px;
}

.error {
    color: red;
    margin-top: 10px;
}
</style>
</head>

<body>

<div class="login-container">
    <h2>Login to Aidify</h2>

    <form method="POST">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <input type="submit" name="login" value="Login" class="btn">
    </form>

    <?php if($error != ""): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <a href="register.php" class="link">Don't have an account? Register</a>
</div>

</body>
</html>