<?php
    include("database.php");
    $sql_for_retrieval = "SELECT title,text,date FROM announcements_admin ORDER BY date DESC";
    $result = mysqli_query($conn,$sql_for_retrieval);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Announcements</title>
  <link rel="stylesheet" href="styles.css"/>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f2f4f8;
      margin: 0;
      padding: 0;
    }

    header {
      /* background-color: #2a4365; */
      color:  #2a4365;
      padding: 20px;
      text-align: center;
      font-size: 1.5rem;
      /* box-shadow: 0 2px 4px rgba(0,0,0,0.1); */
      margin-top: 20px;
      font-weight: bold;
    }

    .container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 0 20px;
    }

    .announcement-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
    }

    .card {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.08);
      padding: 20px;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }

    .card h3 {
      margin-top: 0;
      color: #2a4365;
    }

    .card p {
      color: #4a5568;
      line-height: 1.5;
    }

    .timestamp {
      margin-top: 10px;
      font-size: 0.9rem;
      color: #718096;
    }

    @media (max-width: 600px) {
      header {
        font-size: 1.25rem;
      }
    }
    nav {
  background-color:   #2a4365;
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

  <header>
    📢 Announcements
  </header>
  <?php
    if(mysqli_num_rows($result)>0){
        for($i =1; $i<=mysqli_num_rows($result); $i++){
            $row = mysqli_fetch_assoc($result);

            ${"retrieved_title$i"} = $row['title'];
            ${"retrieved_text$i"} = $row['text'];
            ${"retrieved_date$i"} = $row['date'];
    ?>

  <div class="container">
    <div class="announcement-grid">
      <div class="card">
        <h3><?php echo "${"retrieved_title$i"}";?></h3>
        <p><?php echo "${"retrieved_text$i"}";?></p>
        <div class="timestamp">Posted on:<?php echo " ${"retrieved_date$i"} ";?></div>
      </div>
    </div>
   </div>
   <?php
        }
    }
    else{
  ?>
  <p id="xyz">No announcements made yet.</p>
  <?php
    }
  ?>   
</body>
</html>


