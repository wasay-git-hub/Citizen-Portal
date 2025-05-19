<?php
    session_start();
    include ("database.php");
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
  <title>Apply for Passport</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f9ff;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 700px;
      margin: 3rem auto;
      background-color: white;
      padding: 2rem 3rem;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      color: #004aad;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    form label {
      display: block;
      margin-top: 1rem;
      font-weight: 600;
      color: #333;
    }

    form input, form select, form textarea {
      width: 100%;
      padding: 0.7rem;
      margin-top: 0.3rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
    }

    form button {
      margin-top: 2rem;
      padding: 0.8rem 2rem;
      background-color: #004aad;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    form button:hover {
      background-color: #003080;
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

  <div class="container">
    <h2>Passport Application Form</h2>
    <form action="appointments5.php" method="POST">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" required>

      <label for="fname">Father's Name</label>
      <input type="text" id="fname" name="fname" required>

      <label for="dob">Date of Birth</label>
      <input type="date" id="dob" name="dob" required>

      <label for="gender">Gender</label>
      <select id="gender" name="gender" required>
        <option value="">Select gender</option>
        <option>Male</option>
        <option>Female</option>
      </select>

      <label for="nationality">Nationality</label>
      <input type="text" id="nationality" name="nationality" required>

      <label for="phone">Mobile Number</label>
      <input type="tel" pattern="[0-9]{11}" id="phone" name="phone" placeholder="11 digit number" required>
     
      <label for="category">Category</label>
      <select id="category" name="category" required>
        <option value="">Select a category</option>
        <option>Basic (takes 2-3 months)</option>
        <option>Intermediate (takes almost 1 month)</option>
        <option>Premium (passport gets ready within 14 days)</option>
      </select>

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
        $category = $_POST["category"];
        $nationality = $_POST["nationality"];

        try{
            $sql = "INSERT INTO passport_applicants (fullname, fathername, cnic, date_of_birth, gender, nationality,
                    mobile_number, category, address) VALUES ('$fullname', '$fathername','$cnic_to_display', '$dob', '$gender',
                   '$nationality', '$mobileNumber', '$category', '$address')";
            mysqli_query($conn, $sql);
            header("Location: applied.html");
        }
        catch(mysqli_sql_exception){
            echo "<div class='error-message'>Your application couldn't be processed. Try again later.</div>";
        }
    }

    mysqli_close($conn);
?>