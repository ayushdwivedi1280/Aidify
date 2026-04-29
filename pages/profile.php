<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


// FETCH USER
$query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($query);

// ==========================
// REMOVE PROFILE PICTURE
// ==========================
if(isset($_GET['remove_pic']) && !empty($user['profile_pic'])){

    $file_path = "../uploads/" . $user['profile_pic'];

    if(file_exists($file_path)){
        unlink($file_path);
    }

    mysqli_query($conn, "UPDATE users SET profile_pic=NULL WHERE id='$user_id'");

    header("Location: profile.php");
    exit();
}

// ==========================
// UPDATE PROFILE
// ==========================
if(isset($_POST['update'])){

    $name = $_POST['name'];
    $phone = $_POST['phone'];

    if(!empty($_FILES['profile_pic']['name'])){

        $file_name = time() . "_" . $_FILES['profile_pic']['name'];
        $target = "../uploads/" . $file_name;

        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target);

        mysqli_query($conn, "
            UPDATE users 
            SET name='$name', phone='$phone', profile_pic='$file_name' 
            WHERE id='$user_id'
        ");

    } else {

        mysqli_query($conn, "
            UPDATE users 
            SET name='$name', phone='$phone' 
            WHERE id='$user_id'
        ");
    }

    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 400px;
            margin: 60px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #3b82f6;
            margin-bottom: 10px;
        }

        .remove-btn {
            display: inline-block;
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
            text-decoration: none;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #2563eb;
        }
    </style>
</head>

<body>

<div class="container">

<h2>My Profile</h2>

<!-- PROFILE IMAGE -->
<?php if(!empty($user['profile_pic'])){ ?>
    <img src="/aidify1/uploads/<?php echo $user['profile_pic']; ?>" class="profile-img">

    <a href="profile.php?remove_pic=1" 
       class="remove-btn"
       onclick="return confirm('Remove profile picture?')">
       Remove Picture
    </a>

<?php } else { ?>
    <img src="https://img.icons8.com/ios-filled/100/000000/user.png" class="profile-img">
<?php } ?>

<!-- FORM -->
<form method="POST" enctype="multipart/form-data">

<input type="file" name="profile_pic">

<input type="text" name="name" value="<?php echo $user['name']; ?>">

<input type="email" value="<?php echo $user['email']; ?>" disabled>

<input type="text" name="phone" value="<?php echo $user['phone']; ?>">

<button name="update">Update Profile</button>

</form>

</div>

</body>
</html>