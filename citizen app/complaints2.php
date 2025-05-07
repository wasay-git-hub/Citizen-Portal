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
  <title>Register Complaint</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f3f8ff;
      padding: 0;
      margin: 0;
    }

    h2{
        text-align: center;
    }
    .complaint-form {
      max-width: 500px;
      margin: 0 auto;
      background: #ffffff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .complaint-form h2 {
      margin-bottom: 1.5rem;
      color: #003c8f;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    select, input, textarea {
      width: 100%;
      padding: 0.7rem;
      margin-bottom: 1.2rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
    }

    textarea {
      resize: vertical;
    }

    button {
      background-color: #005ecb;
      color: white;
      padding: 0.8rem 1.5rem;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }

    button:hover {
      background-color: #0047a3;
    }

    nav {
        background-color: #004aad;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
        margin-bottom: 2rem;
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
  <div class="complaint-form">
    <h2>Register a Complaint</h2>
    
    <form action = "complaints2.php" method="post">
      
      <label for="department">Department</label>
      <select id="department" name="department" required>
        <option value="">-- Select Department --</option>
        <option name="CDA">CDA</option>
        <option name="Police">Police</option>
        <option name="Administration">Administration</option>
        <option name="others">Others</option>
      </select>

      <label for="title">Complaint Title</label>
      <input type="text" id="title" name="title" placeholder="Enter complaint title" required>

      <label for="description">Complaint Description</label>
      <textarea id="description" name="description" rows="5" placeholder="Describe your complaint in detail..." required></textarea>

      <label for="location">Location</label>
      <input type="text" id="location" name="location" placeholder="Enter location of issue" required>

      <label for="date">Date of Complaint</label>
      <input type="date" id="date" name="date" required>

      <button type="submit" name="submit" value="submit">Submit Complaint</button>

    </form>
  </div>

</body>
</html>

<?php

    if($_SERVER["REQUEST_METHOD"]== 'POST'){
        $department = $_POST["department"];
        $title = $_POST["title"];
        $description = $_POST["description"];
        $location = $_POST["location"];
        $date = $_POST["date"];

        if(!empty($department) && !empty($title) && !empty($description) && !empty($location)){
            try{
                $sql = "INSERT INTO complaints (department, cnic, title, description, location, date_of_complaint)
                        VALUES ('$department','$cnic_to_display', '$title', '$description', '$location', '$date')";
                mysqli_query($conn,$sql);
                header("Location: registered.html");
            }
            catch(Exception $e){
              echo "Couldn't register complaint.";
            }
        }
    }

    mysqli_close($conn);
?>