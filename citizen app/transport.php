<?php
    include("database.php");
    $sql_for_retrieval = "SELECT route,type,timings FROM transport ORDER BY id";
    $result = mysqli_query($conn,$sql_for_retrieval);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Transport Information</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f2f4f8;
      margin: 0;
      padding: 0;
    }

    header {
      color: #2a4365;
      padding: 20px;
      text-align: center;
      font-size: 1.5rem;
      font-weight: bold;
    }

    .container {
      max-width: 900px;
      margin: 40px auto;
      padding: 0 20px;
    }

    .accordion-item {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.08);
      margin-bottom: 15px;
      overflow: hidden;
    }

    .accordion-header {
      padding: 18px 24px;
      background-color: #2a4365;
      color: white;
      font-size: 1.2rem;
      cursor: pointer;
      position: relative;
    }

    .accordion-header::after {
      content: "+";
      position: absolute;
      right: 20px;
      font-size: 1.5rem;
      transition: transform 0.2s ease;
    }

    .accordion-header.active::after {
      content: "–";
    }

    .accordion-content {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
      background-color: #f9fafc;
      padding: 0 24px;
    }

    .accordion-content ul {
      margin: 16px 0;
      padding-left: 20px;
      color: #4a5568;
    }

    .accordion-content li {
      margin-bottom: 10px;
    }

    @media (max-width: 600px) {
      .accordion-header {
        font-size: 1rem;
      }
    }
    nav {
  background-color:  #004aad;
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

  <header>🚍 Transport Information</header>
  <?php
    if(mysqli_num_rows($result)>0){
        for($i =1; $i<=mysqli_num_rows($result); $i++){
            $row = mysqli_fetch_assoc($result);

            ${"retrieved_route$i"} = $row['route'];
            ${"retrieved_type$i"} = $row['type'];
            ${"retrieved_timings$i"} = $row['timings'];
    ?>

  <div class="container">
    <div class="accordion-item">
      <div class="accordion-header"><?php echo " ${"retrieved_type$i"}";?></div>
      <div class="accordion-content">
        <ul>
          <li>Route:<?php echo" ${"retrieved_route$i"}";?></li>
          <li>Timings:<?php echo" ${"retrieved_timings$i"}";?></li>
        </ul>
      </div>
    </div>

  </div>
  <?php
        }
    }
    else{
  ?>
  <p id="xyz">No transport available yet. Wait for further updates.</p>
  <?php
    }
  ?>  
  <script src="script8.js"></script>
</body>
</html>
