<?php
include 'connect.php';
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Retrieve user data from database
$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Handle profile picture upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_picture"])) {
    $file_name = $_FILES["profile_picture"]["name"];
    $file_tmp = $_FILES["profile_picture"]["tmp_name"];
    $file_type = $_FILES["profile_picture"]["type"];
    move_uploaded_file($file_tmp, "uploads/" . $file_name);

    // Update profile picture in database
    $query = "UPDATE users SET profile_picture='uploads/$file_name' WHERE id='$user_id'";
    mysqli_query($conn, $query);

    // Update user variable with new profile picture
    $user["profile_picture"] = "uploads/$file_name";
}

function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to verify password
function verifyPassword($password, $hashedPassword)
{
    return password_verify($password, $hashedPassword);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            /*display: flex; */
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 500px;
            max-width: 100%;
            padding: 20px;
            box-sizing: border-box;
            margin: auto;
            padding: 15px 30px;
            height: 1500px;
            margin-top: 10px;
        }


        h1 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        #profile {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            display: block;
            margin: 0 auto 20px;
        }

        form {
            text-align: center;
        }

        label {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        label:hover {
            background-color: #45a049;
        }

        button[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        #logout {
            display: block;
            text-align: center;
            margin-top: 20px;
            background-color: #4caf50;
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
        }

        #logout:hover {
            background-color: #45a049;
        }
    </style>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="dog icon.jpeg" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Smooch+Sans:wght@100..900&display=swap" rel="stylesheet" />
</head>

<body>
    <ol id="topnav">
        <img id="dogicon" src="dog icon.jpeg" alt="" />
        <li><a href="home.php">Home</a></li>
        <li><a href="form.php">Dog Adoption Form</a></li>
        <li><a href="review.php">Review</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="profile.php">Profile</a></li>
    </ol>
    <div class="container">
        <h1>Welcome, <?php echo $user["username"]; ?></h1>
        <img id="profile" src="<?php echo $user["profile_picture"]; ?>" alt="Profile Picture">
        <form method="post" enctype="multipart/form-data">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo $user["username"]; ?>" required><br>
            <!-- Display other profile fields here, such as email, phone, date of birth, etc. -->
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $user["email"]; ?>" required><br>

            <label for="phone">Phone </label>
            <input type="phone" id="phone" name="phone" value="<?php echo $user["phone"]; ?>" required><br>

            <label for="dob">Date of Birth </label>
            <input type="date" id="dob" name="dob" value="<?php echo $user["dob"]; ?>" required><br>

            <label for="password">Password </label>
            <input type="password" id="password" name="password" value="<?php echo $user["password"]; ?>" required><br>

            <label for="">Insert a profile picture </label>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*" required><br>

            <button type="submit">Upload Profile Picture</button>
            <button type="submit">Save Changes</button>
        </form>
        <!-- Other profile details and update form -->
        <a id="logout" href="logout.php">Logout</a>
        <?php
        //run this code only when the user click register
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Pick data user has entered
            $username = $_POST['username'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $hashedPassword = hashPassword($password);
            // create operation/insert
            $sql = "UPDATE users SET username='$username', email='$email', phone='$phone', password='$hashedPassword' WHERE id=$user_id";
            // execute query
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "Update successful";
                //header("location: profile.php");
                exit();
            } else {
                die(mysqli_error($conn));
            }
        }

        ?>
    </div>
</body>

</html>