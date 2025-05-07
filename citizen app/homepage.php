<?php
    session_start();

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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Citizen App</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: #f4f7fa;
      color: #333;
    }

    nav {
      background-color: #004aad;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: white;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    nav .logo {
      font-size: 1.5rem;
      font-weight: 600;
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
      transition: color 0.3s ease;
    }

    nav ul li a:hover {
      color: #ffd700;
    }

    .hero {
      text-align: center;
      padding: 3rem 2rem 2rem;
      background: linear-gradient(135deg, #004aad, #3c91e6);
      color: white;
    }

    .hero h1 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }

    .hero p {
      font-size: 1.1rem;
      max-width: 600px;
      margin: 0 auto;
    }

    .features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      padding: 3rem 2rem;
    }

    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
      overflow: hidden;
      text-align: center;
      transition: transform 0.3s ease;
      color: black;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .card h3 {
      margin: 1rem 0 0.5rem;
      font-size: 1.25rem;
      color: #004aad;
    }

    .card p {
      padding: 0 1rem 1rem;
      font-size: 0.95rem;
    }

    @media (max-width: 600px) {
      .hero h1 {
        font-size: 2rem;
      }

      nav ul {
        flex-direction: column;
        gap: 1rem;
      }
    }

    .lines{
        text-decoration: none;
    }

    .info{
        position: relative;
        text-align: center;
        right: 15px;
        bottom: 115px;
        width: 150px;
        height: 80px;
        border-radius: 12px;
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

  <section class="hero">
    <h1>Welcome to Your Citizen Dashboard</h1>
    <p>Access services, stay informed, and participate in making your city better.</p>
    <div class = "info">
        <?php
        echo "$name_to_display <br>";
        echo "Your CNIC: {$cnic_to_display}";
        ?>
    </div>
  </section>


  <section class="features">
  <a href="surveys.php" class = "lines">
    <div class="card">
      <img src="https://freeonlinesurveys.com/wp-content/uploads/2024/01/Surveys-For-Companies.png" alt="Surveys">
      <h3>Surveys</h3>
      <p>Share your feedback to help shape better policies and city services.</p>
    </div></a>

    <a href="appointments1.html" class = "lines">
    <div class="card">
      <img src="https://static.vecteezy.com/system/resources/previews/005/051/418/non_2x/appointment-scheduling-illustration-concept-flat-illustration-isolated-on-white-background-vector.jpg" alt="Appointments">
      <h3>Appointments</h3>
      <p>Book slots with local government officers or public service providers.</p>
    </div></a>

    <a href="complaints1.html" class = "lines">
    <div class="card">
      <img src="https://media.istockphoto.com/id/1494742638/vector/%D1%81omplaint-form-online-concept-vector-illustration.jpg?s=612x612&w=0&k=20&c=cEFqNxHTsYiIgOdPdQ7fQ3BYXj7Rq6Mp0sKDAWRA9Eo=" alt="Complaints">
      <h3>Complaints</h3>
      <p>Report issues like potholes, water leaks, or street light outages easily.</p>
    </div></a>

    <a href="announcements.php" class = "lines">
    <div class="card">
      <img src="https://media.istockphoto.com/id/1132789086/vector/digital-marketing-flat-design-style-colorful-illustration.jpg?s=612x612&w=0&k=20&c=1wzQNX8HYiHnm9GxuQc_GAg6huuYdXnyYon1KToV44c=" alt="Announcements">
      <h3>Announcements</h3>
      <p>Get real-time updates on local events, alerts, and announcements.</p>
    </div></a>

    <a href="transport.php" class = "lines">
    <div class="card">
      <img src="https://img.freepik.com/free-vector/autonomous-public-transport-abstract-concept-vector-illustration-self-driving-bus-urban-transport-services-smart-taxi-automatic-road-service-public-bus-city-train-traffic-abstract-metaphor_335657-1771.jpg?semt=ais_hybrid&w=740" alt="Transport">
      <h3>Transport</h3>
      <p>Access transport schedules, routes, and updates from your city.</p>
    </div></a>
  </section>

</body>
</html>