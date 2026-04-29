<?php
session_start();

// If already logged in → go to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: pages/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Aidify</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f4f6f8;
        }

        .navbar {
            background: #2c2c2c;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: flex-end;
        }

        .navbar a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
            font-weight: bold;
        }

        .hero {
            text-align: center;
            padding: 80px 20px;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            color: white;
        }

        .hero h1 {
            font-size: 42px;
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 18px;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background: white;
            color: #333;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }

        .features {
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 50px 20px;
        }

        .card {
            background: white;
            padding: 25px;
            width: 250px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
    </style>
    </head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="pages/login.php">Login</a>
    <a href="pages/register.php">Register</a>
</div>

<!-- Hero Section -->
<div class="hero">
    <div class="hero-content">
        <div class="hero-text">
            <h1>Welcome to Aidify</h1>
            <p>
                A platform where people connect, help, and grow together.
                Find rides, request help, and support your community.
            </p>
            <a href="pages/register.php" class="btn">Get Started</a>
        </div>

        <div class="hero-image">
            <img src="assets/images/help.png" alt="Helping People">
        </div>
    </div>
</div>

<!-- Features -->
<div class="features">
    <div class="card">
        <h3>🚗 Ride Sharing</h3>
        <p>Find or offer rides with people around you.</p>
    </div>

    <div class="card">
        <h3>🆘 Help Requests</h3>
        <p>Post your needs and get help quickly.</p>
    </div>

    <div class="card">
        <h3>🤝 Community Support</h3>
        <p>Build a trusted and helpful network.</p>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <p>© 2026 Aidify | Connecting People</p>
</div>

</body>
</html>