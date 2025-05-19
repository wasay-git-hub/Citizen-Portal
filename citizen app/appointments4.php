<?php
    session_start();
    include("database.php");
    if (!isset($_SESSION['fullname']) || !isset($_SESSION['cnic'])) {
      header("Location: login.php");
      exit();
  }

  $name_to_display = $_SESSION['fullname'];
  $cnic_to_display = $_SESSION['cnic'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>License Application</title>
  <style>
    body {
  font-family: 'Segoe UI', sans-serif;
  margin: 0;
  background-color: #eef5ff;
  color: #003366;
}

nav {
  background-color: #004aad;
  padding: 1rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: white;
}

nav .logo {
  font-size: 1.5rem;
  font-weight: bold;
}

nav ul {
  list-style: none;
  display: flex;
  gap: 1.5rem;
}

nav ul li a {
  color: white;
  text-decoration: none;
  font-weight: 500;
}

nav ul li a:hover {
  color: #ffd700;
}

.form-container {
  max-width: 600px;
  margin: 2rem auto;
  background: white;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.form-container h1 {
  text-align: center;
  margin-bottom: 2rem;
  color: #004aad;
}

form label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
}

form input, form select, form textarea {
  width: 100%;
  padding: 0.6rem;
  margin-bottom: 1.5rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
}

form input[type="file"] {
  padding: 0.3rem;
}

form button {
  background-color: #004aad;
  color: white;
  border: none;
  padding: 0.8rem 1.5rem;
  font-size: 1rem;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s;
}

form button:hover {
  background-color: #003b8a;
}
.error-message {
        color: #c62828;
        padding: 5px;
        text-align: center;
        background-color: #ffebee;
        border-radius: 6px;
        position: absolute;
        left: 450px;
        bottom: 74%;
    }

  </style>
</head>
<body>

  <nav>
    <div class="logo">Citizen App</div>
    <ul>
    <li><a href="homepage.php">Home</a></li>
          <li><a href="surveys.php">Surveys</a></li>
          <li><a href="appointments1.html">Appointments</a></li>
          <li><a href="complaints1.html">Complaints</a></li>
          <li><a href="announcements.php">Announcements</a></li>
          <li><a href="transport.php">Transport</a></li>
    </ul>
  </nav>

  <div class="form-container">
    <h1>Driving License Application Form</h1>
    <form action="appointments4.php" method="post">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" required>
    
      <label for="name">Father's Name</label>
      <input type="text" id="fname" name="fname" required>

      <label for="dob">Date of Birth</label>
      <input type="date" id="dob" name="dob" required>

      <label for="gender">Gender</label>
      <select id="gender" name="gender" required>
        <option value="">-- Select Gender --</option>
        <option name="male">Male</option>
        <option name="female">Female</option>
      </select>

      <label for="phone">Mobile Number</label>
      <input type="tel" id="phone" name="phone" pattern="[0-9]{11}" required placeholder="11-digit number">

      <label for="address">Permanent Address</label>
      <textarea id="address" name="address" rows="3" required></textarea>

      <button type="submit">Submit Application</button>
    </form>
  </div>

</body>
</html>

<?php
    if($_SERVER["REQUEST_METHOD"]=='POST'){

        $fullname = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
        $fathername = filter_input(INPUT_POST, "fname", FILTER_SANITIZE_SPECIAL_CHARS);
        $dob = $_POST["dob"];
        $gender = $_POST["gender"];
        $mobileNumber = $_POST["phone"];
        $address = $_POST["address"];

        function eligible($dob){
          $dobDate = new DateTime($dob);
          $today = new DateTime();

          $age = $today->diff($dobDate)->y;
          if($age>=18){
            return true;
          }
          else{
            return false;
          }
        }

      try{
        if(eligible($dob)){
          $sql = "INSERT INTO license_applicants(fullname,fathername,cnic,date_of_birth,gender,mobile_number,
          permanent_address) VALUES ('$fullname','$fathername','$cnic_to_display','$dob', '$gender', '$mobileNumber',
                  '$address')";
          mysqli_query($conn,$sql);
          header("Location: applied.html");
          exit();
        }
        else{
          echo "<div class='error-message'>You are under 18, hence not eligible for a driving license.</div>";
        }
      }
      catch(mysqli_sql_exception){
        echo "<div class='error-message'>Your application couldn't be processed. Maybe you have already applied!</div>";
      }
      
    }

    mysqli_close($conn);
?>