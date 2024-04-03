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
      text-align: center;
      padding: 10px;
      height: 800px;
      margin: auto;
      padding: 15px 30px;
      box-sizing: border-box;
      margin-top: 10px;
    }

    h2 {
      color: #333;
    }

    form {
      margin-top: 10px;
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

  <script>
    function validateRegistration() {
      document.getElementById("nameError").innerHTML = "";
      document.getElementById("emailError").innerHTML = "";
      document.getElementById("phoneError").innerHTML = "";
      document.getElementById("dobError").innerHTML = "";
      document.getElementById("passwordError").innerHTML = "";
      document.getElementById("confirmPasswordError").innerHTML = "";

      let nameInput = document.getElementById("username").value;
      let emailInput = document.getElementById("email").value;
      let phoneInput = document.getElementById("phone").value;
      let dobInput = document.getElementById("date").value;
      let passwordInput = document.getElementById("password").value;
      let confirmPasswordInput =
        document.getElementById("confirm-password").value;

      if (
        nameInput == "" ||
        emailInput == "" ||
        phoneInput == "" ||
        dobInput == "" ||
        passwordInput == "" ||
        confirmPasswordInput == ""
      ) {
        document.getElementById("nameError").innerHTML = "Name is required.";
        document.getElementById("emailError").innerHTML =
          "Email is required.";
        document.getElementById("phoneError").innerHTML =
          "Phone number is required.";
        document.getElementById("dobError").innerHTML =
          "Date of birth is required.";
        document.getElementById("passwordError").innerHTML =
          "Password is required.";

        return false;
      }

      // Validate Name (should only contain alphabets)
      let nameRegex = /^[A-Za-z\s]+$/;
      if (!nameRegex.test(nameInput)) {
        document.getElementById("nameError").innerHTML =
          "Enter a valid name(only alphabets allowed).";
        return false;
      }

      // Validate Email
      if (!emailInput.includes("@")) {
        document.getElementById("emailError").innerHTML =
          "Enter a valid email address.";
        return false;
      }

      // Validate Phone number
      if (
        phoneInput.length !== 10 ||
        phoneInput[0] !== "0" ||
        (phoneInput[1] !== "7" && phoneInput[1] !== "1")
      ) {
        document.getElementById("phoneError").innerHTML =
          "Enter a valid phone number(phone number shoould be 10 digits long and should start with '07' or '01')";
        return false;
      }

      // Validate date of birth
      let dobValue = new Date(dobInput);
      let today = new Date();
      let age = today.getFullYear() - dobValue.getFullYear();
      let monthDiff = today.getMonth() - dobValue.getMonth();
      if (
        monthDiff < 0 ||
        (monthDiff === 0 && today.getDate() < dobValue.getDate())
      ) {
        age--;
      }
      if (age < 18) {
        document.getElementById("dobError").innerHTML =
          "You must be at least 18 years old to register.";
        return false;
      }
      if (
        !/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).{8,}/.test(
          passwordInput
        )
      ) {
        document.getElementById("passwordError").innerHTML =
          "Password must contain at least one digit, one lowercase and one uppercase letter, one special character and be at least 8 characters long.";
        return false;
      }

      if (passwordInput !== confirmPasswordInput) {
        alert("Passwords do not match.");
        return false;
      }

      // Display success message
      alert("You, " + nameInput + ", have successfully registered.");
      return true;
    }
  </script>
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
    <h2 style="text-align: center">Register</h2>
    <form onsubmit="return validateRegistration()" method="post">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Enter username" required /><br />
      <span id="nameError" class="error"></span>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required />
      <span id="emailError" class="error"></span>

      <label for="phone">Phone number: </label>
      <input type="tel" name="phone" id="phone" placeholder="Enter phone number" />
      <span id="phoneError" class="error"></span>

      <label for="dob">Date of Birth</label>
      <input type="date" id="dob" name="dob" placeholder="Enter date of birth" required />
      <span id="dobError" class="error"></span>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter password" required />
      <span id="passwordError" class="error"></span>

      <label for="confirm-password">Confirm Password</label>
      <input type="password" id="confirm-password" name="confirm-password" placeholder="Please confirm password" required />

      <button type="submit" style="margin-top: 10px">Register</button>
    </form>

    <div class="switch-form">
      <p>Already have an account? <a href="login.html">Log in here</a></p>
    </div>
  </div>

  <?php
  include 'connect.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $dob = $_POST["dob"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Encrypt password

    // Insert user data into database
    $query = "INSERT INTO users (username, email, phone, dob, password) VALUES ('$username', '$email', '$phone', '$dob', '$password')";
    if (mysqli_query($conn, $query)) {
      echo "<script>alert('You have successfully signed up.');</script>";
    } else {
      die(mysqli_error($conn));
    }
  }
  ?>

</body>

</html>