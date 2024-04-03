<?php
include 'connect.php';
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION["user_id"];

// Retrieve user data from database
$query = "SELECT * FROM form WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Handle profile picture upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
  $file_name = $_FILES["file"]["name"];
  $file_tmp = $_FILES["file"]["tmp_name"];
  $file_type = $_FILES["file"]["type"];
  move_uploaded_file($file_tmp, "uploads/" . $file_name);

  // Update profile picture in database
  $query = "UPDATE form SET file='uploads/$file_name' WHERE user_id='$user_id'";
  mysqli_query($conn, $query);

  // Update user variable with new profile picture
  $user["file"] = "uploads/$file_name";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Page</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" href="dog icon.jpeg" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Smooch+Sans:wght@100..900&display=swap" rel="stylesheet" />
  <script>
    function validateForm() {
      // Reset error messages
      document.getElementById("nameError").innerHTML = "";
      document.getElementById("emailError").innerHTML = "";
      document.getElementById("phoneError").innerHTML = "";
      document.getElementById("dobError").innerHTML = "";
      document.getElementById("fileError").innerHTML = "";
      document.getElementById("genderError").innerHTML = "";
      document.getElementById("breedError").innerHTML = "";

      let nameInput = document.getElementById("name").value;
      let emailInput = document.getElementById("email").value;
      let phoneInput = document.getElementById("phone").value;
      let dobInput = document.getElementById("date").value;
      let fileInput = document.getElementById("file");
      let genderInput = document.getElementById("gender").value;
      let breedInput = document.getElementById("breed").value;

      if (
        nameInput == "" ||
        emailInput == "" ||
        phoneInput == "" ||
        dobInput == "" ||
        genderInput == "" ||
        breedInput == ""
      ) {
        document.getElementById("nameError").innerHTML = "Name is required.";
        document.getElementById("emailError").innerHTML =
          "Email is required.";
        document.getElementById("phoneError").innerHTML =
          "Phone number is required.";
        document.getElementById("dobError").innerHTML =
          "Date of birth is required.";
        document.getElementById("fileError").innerHTML = "File is required.";
        document.getElementById("genderError").innerHTML =
          "Gender is required.";
        document.getElementById("breedError").innerHTML =
          "Breed is required.";

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

      // Validate File size
      if (fileInput.files.length > 0) {
        let fileSize = fileInput.files[0].size; // in bytes
        let maxSize = 10 * 1024 * 1024; // 10 MB
        if (fileSize > maxSize) {
          document.getElementById("fileError").innerHTML =
            "File size should not exceed 10MB.";
          return false;
        }
      } else {
        document.getElementById("fileError").innerHTML = "File is required.";
        return false;
      }

      // Display success message
      alert(
        "You, " +
        nameInput +
        ", have successfully filled the dog adoption form and your request is being processed. We will send you the result soon."
      );
      return true;
    }
  </script>
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
  <h1 style="text-align: center; text-decoration: underline">
    DOG ADOPTION FORM
  </h1>
  <div class="form">
    <p id="openstat" style="font-weight: bold; font-style: italic; border-radius: 5px">
      Welcome to our Form Page. Please fill in the form below.
    </p>
    <form id="myForm" onsubmit="return validateForm()" method="post">
      <div>
        <label for="name">Full names: </label>
        <input type="text" id="name" name="name" placeholder="Enter your name" required />
        <span id="nameError" class="error"></span>
      </div>

      <p></p>
      <div>
        <label>Email: </label>
        <input type="email" id="email" name="email" placeholder="Enter your email" />
        <span id="emailError" class="error"></span>
      </div>

      <p></p>
      <div>
        <label>Phone number: </label>
        <input type="tel" name="phone" id="phone" placeholder="Enter phone number" />
        <span id="phoneError" class="error"></span>
      </div>

      <p></p>
      <div>
        <label>Date of birth: </label>
        <input type="date" name="dob" id="dob" placeholder="Enter date" />
        <span id="dobError" class="error"></span>
      </div>

      <p class="width">
        Please attach a file of a copy of the birth certificate or ID below:
      </p>
      <div>
        <label>File: </label>
        <input type="file" id="file" name="file" placeholder="Enter file" />
        <span id="fileError" class="error"></span>
      </div>

      <p></p>
      <p></p>
      <div>
        <label>Gender: </label>
        <select name="gender" id="gender">
          <option disabled>--Select Gender--</option>
          <option>Male</option>
          <option>Female</option>
        </select>
        <span id="genderError" class="error"></span>
      </div>

      <p></p>
      <div>
        <label>What breed of dog would you like to adopt: </label>
        <select name="breed" id="breed">
          <option disabled>--Dog breeds--</option>
          <option>German Shepherd</option>
          <option>Golden Retriever</option>
          <option>Alaskan Malamute</option>
          <option>Bichon Frise</option>
          <option>Beagle</option>
        </select>
        <span id="breedError" class="error"></span>
      </div>

      <br />
      <input type="submit" name="submit" value="Adopt" style="text-align: center" />
    </form>
    <p>
      By clicking the Adopt button, you agree to our
      <a href="#">Dog Adoption Terms and Conditions</a>
    </p>
  </div>
  <hr />

  <?php
  include 'connect.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"]; // Encrypt password
    $breed = $_POST["breed"];

    // Insert user data into database
    $query = "INSERT INTO form (name, email, phone, dob, gender, breed) VALUES ('$name', '$email', '$phone', '$dob',  '$gender', '$breed')";
    if (!mysqli_query($conn, $query)) {
      die(mysqli_error($conn));
    }
  }
  ?>
</body>

</html>