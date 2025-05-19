<?php
    session_start();
    include("database.php");

    if (!isset($_SESSION['fullname']) || !isset($_SESSION['cnic'])) {
        header("Location: login.php");
        exit();
    }

    $name_to_display = $_SESSION['fullname'];
    $cnic_to_display = $_SESSION['cnic'];

    $sql_for_retrieval = "SELECT * FROM complaints WHERE cnic = '$cnic_to_display' ORDER BY date_of_complaint DESC";
    $result = mysqli_query($conn, $sql_for_retrieval);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Complaints</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f6ff;
      margin: 0;
      padding: 0;
    }

    h1 {
      text-align: center;
      color: #003c8f;
      margin-bottom: 2rem;
    }

    .complaint-card {
      background-color: white;
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
      transition: transform 0.2s ease;
    }

    .complaint-card:hover {
      transform: scale(1.01);
    }

    .title {
      font-size: 1.3rem;
      font-weight: bold;
      color: #004aad;
      margin-bottom: 0.5rem;
    }

    .details {
      display: flex;
      flex-wrap: wrap;
      font-size: 0.95rem;
      color: #444;
      margin-bottom: 1rem;
    }

    .details span {
      margin-right: 1.5rem;
      margin-bottom: 0.5rem;
    }

    .label {
      font-weight: 600;
      color: #003c8f;
    }

    .description {
      margin-top: 0.5rem;
      color: #333;
      line-height: 1.5;
    }

    #xyz{
      background-color: white;
      border-radius: 12px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
      transition: transform 0.2s ease;
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
  <h1>Your Registered Complaints</h1>

  <?php
    if(mysqli_num_rows($result)>0){
        for($i =1; $i<=mysqli_num_rows($result); $i++){
            $row = mysqli_fetch_assoc($result);

            ${"retrieved_department$i"} = $row['department'];
            ${"retrieved_cnic$i"} = $row['cnic'];
            ${"retrieved_title$i"} = $row['title'];
            ${"retrieved_description$i"} = $row['description'];
            ${"retrieved_location$i"} = $row['location'];
            ${"retrieved_date_of_complaint$i"} = $row['date_of_complaint'];
            ${"retrieved_date_of_resolving$i"} = $row['date_of_resolving'];
            ${"retrieved_status$i"} = $row['status'];
  ?>
    <div class="complaint-card">
    <div class="title"><?php echo "${"retrieved_title$i"}" ?></div>

    <div class="details">
      <span><span class="label">Department:</span><?php echo "${"retrieved_department$i"}" ?></span>
      <span><span class="label">Submitted on:</span><?php echo " ${"retrieved_date_of_complaint$i"}" ?></span>
      <span><span class="label">Resolved on:</span><?php echo "${"retrieved_date_of_resolving$i"} " ?></span>
      <span><span class="label">Status:</span><?php echo "${"retrieved_status$i"}" ?></span>
      <span><span class="label">Location:</span><?php echo "${"retrieved_location$i"}" ?></span>
    </div>

    <div class="description">
    <?php echo "${"retrieved_description$i"}" ?>
    </div>
  </div>
  <?php
        }
    }
    else{
  ?>
  <p id="xyz">You haven't registered any complaints.</p>
  <?php
    }
  ?>
</body>
</html>
