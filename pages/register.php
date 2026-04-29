<!DOCTYPE html>
<html>
<head>
<title>Aidify Register</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(to right, #4facfe, #00f2fe);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .register-container {
        background: white;
        padding: 40px;
        width: 380px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        text-align: center;
    }

    .register-container h2 {
        margin-bottom: 20px;
    }

    input {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    input:focus {
        border-color: #4facfe;
        outline: none;
    }

    .btn {
        width: 100%;
        padding: 12px;
        background: #4facfe;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 10px;
    }

    .btn:hover {
        background: #007bff;
    }

    .link {
        margin-top: 15px;
        display: block;
        text-decoration: none;
        color: #333;
    }

    .link:hover {
        color: #007bff;
    }

    .msg {
        margin-top: 10px;
        font-size: 14px;
    }
</style>
</head>

<body>

<div class="register-container">
    <h2>Create Account</h2>

    <form method="POST">
        <input type="text" name="name" placeholder="Enter your name" required>
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="text" name="phone" placeholder="Enter phone number" required>
        <input type="password" name="password" placeholder="Create password" required>

        <input type="submit" name="register" value="Register" class="btn">
    </form>

    <a href="login.php" class="link">Already have an account? Login</a>

    <div class="msg">
        <?php
        include "../config/db.php";

        if(isset($_POST['register'])){

            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];

            $password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (name,email,phone,password)
                      VALUES ('$name','$email','$phone','$password')";

            $result = mysqli_query($conn,$query);

            if($result){
                echo "<span style='color:green;'>Registration Successful</span>";
            }else{
                echo "<span style='color:red;'>Registration Failed</span>";
            }
        }
        ?>
    </div>

</div>

</body>
</html>