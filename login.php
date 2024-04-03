<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dog Adoption</title>
  <style>
    body {
      background-color: #f4f4f4;
      margin: 10px;
      padding: 0;
      /*display: flex;*/
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      width: 500px;
      max-width: 100%;
      text-align: center;
      padding: 10px;
      height: 500px;
      margin: auto;
      padding: 15px 30px;
      box-sizing: border-box;
      margin-top: 10px;
    }

    h2 {
      color: #333;
    }

    form {
      margin-top: 20px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      color: #555;
    }

    input {
      width: 100%;
      padding: 8px;
      margin-bottom: 16px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      background-color: #4caf50;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background-color: #45a049;
    }

    .switch-form {
      margin-top: 15px;
    }

    .switch-form a {
      text-decoration: none;
      color: #4caf50;
    }

    .switch-form a:hover {
      text-decoration: underline;
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
    <h2>Login</h2>
    <form action="" method="post">
      <label for="username">Email</label>
      <input type="email" id="email" name="email" required />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required />

      <button type="submit" style="margin-top: 10px">Login</button>
    </form>

    <div class="switch-form">
      <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
  </div>

  <?php
  // Database connection
  include 'connect.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $email = $_POST["email"];
    $password = $_POST["password"];



    // Retrieve user data from database
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    // Check if user exists and password is correct
    if ($user && password_verify($password, $user["password"])) {
      // Start session and store user ID
      session_start();
      $_SESSION["user_id"] = $user["id"];
      header("Location: home.php");
      exit();
    } else {
      echo "<script>alert('Invalid credentials.');</script>";
    }
  }
  ?>

</body>

</html>