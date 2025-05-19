<?php
    session_start();
    include("database.php");
    if (!isset($_SESSION['fullname']) || !isset($_SESSION['cnic'])) {
      header("Location: login.php");
      exit();
    }

  $name_to_display = $_SESSION['fullname'];
  $cnic_to_display = $_SESSION['cnic'];

  $sql_for_retrieval = "SELECT * FROM license_applicants WHERE cnic = '$cnic_to_display'";
  $result = mysqli_query($conn, $sql_for_retrieval);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>License Appointments</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f6ff;
    }

    .container {
      max-width: 900px;
      margin: 3rem auto;
      padding: 1.5rem 2rem;
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #004aad;
      margin-bottom: 2rem;
    }

    .card {
      background-color: #eaf2ff;
      padding: 1.5rem;
      border-left: 6px solid #004aad;
      margin-bottom: 1.5rem;
      border-radius: 10px;
    }

    .card p {
      margin: 0.3rem 0;
      color: #333;
      line-height: 1.5;
    }

    .card strong {
      color: #004aad;
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
#xyz{
      background-color: white;
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
      transition: transform 0.2s ease;
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

    <h2>Appointments for License</h2>
    <?php
    if(mysqli_num_rows($result)>0){
        for($i =1; $i<=mysqli_num_rows($result); $i++){
            $row = mysqli_fetch_assoc($result);

            ${"retrieved_fullname$i"} = $row['fullname'];
            ${"retrieved_fathername$i"} = $row['fathername'];
            ${"retrieved_gender$i"} = $row['gender'];
            ${"retrieved_dob$i"} = $row['date_of_birth'];
            ${"retrieved_mobileNumber$i"} = $row['mobile_number'];
            ${"retrieved_address$i"} = $row['permanent_address'];
            ${"retrieved_date_allotted$i"} = $row['date_allotted'];
            ${"retrieved_status$i"} = $row['status'];
  ?>
    <div class="container">
    <div class="card">
      <p><strong>Name of Applicant:</strong><?php echo" ${"retrieved_fullname$i"}" ?></p>
      <p><strong>Father's Name:</strong><?php echo" ${"retrieved_fathername$i"}" ?></p>
      <p><strong>Gender:</strong><?php echo" ${"retrieved_gender$i"}" ?></p>
      <p><strong>Date of Birth:</strong><?php echo" ${"retrieved_dob$i"}" ?></p>
      <p><strong>Mobile Number:</strong><?php echo" ${"retrieved_mobileNumber$i"}" ?></p>
      <p><strong>Permanent Address:</strong><?php echo" ${"retrieved_address$i"}" ?></p>
      <p><strong>Status</strong><?php echo" ${"retrieved_status$i"}" ?></p>
      <p><strong>Date Allotted:</strong><?php echo" ${"retrieved_date_allotted$i"}" ?></p>
    </div>

  </div>
  <?php
        }
    }
    else{
  ?>
  <p id="xyz">You haven't applied for License.</p>
  <?php
    }
  ?>
</body>
</html>
