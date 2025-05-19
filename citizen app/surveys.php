<?php
    include("database.php");
    $sql = "SELECT * FROM surveys WHERE expiry_date > NOW()";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Answer Survey</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f4f8;
      margin: 0;
      padding: 0;
    }

    header {
      color:  #004aad;
      padding: 1rem 2rem;
      text-align: center;
    }

    .container {
      max-width: 1000px;
      margin: 2rem auto;
      padding: 0 1rem;
    }

    .survey-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
    }

    .survey-card {
      background: white;
      padding: 1rem 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
      cursor: pointer;
      transition: 0.3s ease;
    }

    .survey-card:hover {
      transform: translateY(-5px);
      background-color: #f3faff;
    }

    .survey-title {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 0.3rem;
    }

    .survey-dates {
      font-size: 0.9rem;
      color: #666;
    }

    .questions-section {
      margin-top: 2rem;
      background-color: #ffffff;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      display: none;
    }

    .question {
      margin-bottom: 1.5rem;
    }

    .question p {
      margin-bottom: 0.5rem;
      font-weight: 500;
    }

    textarea, input[type="text"] {
      width: 100%;
      padding: 0.6rem;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .submit-btn {
      background-color: #004880;
      color: white;
      padding: 0.7rem 1.5rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 1rem;
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
    .survey-id {
  font-size: 0.85rem;
  color: #0077aa;
  font-weight: bold;
  margin-bottom: 4px;
}
.answer-btn {
  background-color: #004880;
  color: white;
  border: none;
  padding: 6px 14px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 0.9rem;
  margin-top: 0.5rem;
  transition: background-color 0.3s ease;
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
  <h1>Answer the Survey(s)</h1>
</header>
<?php
    if(mysqli_num_rows($result)>0){
        for($i =1; $i<=mysqli_num_rows($result); $i++){
            $row = mysqli_fetch_assoc($result);

            ${"retrieved_title$i"} = $row['title'];
            ${"retrieved_survey_id$i"} = $row['survey_id'];
            ${"retrieved_date_of_creation$i"} = $row['date_of_creation'];
            ${"retrieved_expiry_date$i"} = $row['expiry_date'];            
?>
<div class="container">

<div class="survey-grid">
  <div class="survey-card">
  <div class="survey-id">Survey ID: <?php echo "${"retrieved_survey_id$i"}" ?></div>
    <div class="survey-title"><?php echo "${"retrieved_title$i"}" ?></div>
    <div class="survey-dates">Created: <?php echo "${"retrieved_date_of_creation$i"}" ?>| Expires: <?php echo "${"retrieved_expiry_date$i"}" ?></div>

    <form action="answer.php" method="GET" style="margin-top: 10px;">
  <input type="hidden" name="survey_id" value="<?php echo ${"retrieved_survey_id$i"}; ?>">
  <input type="hidden" name="title" value="<?php echo ${"retrieved_title$i"}; ?>">
  <button class="answer-btn" type="submit" name="submit">Answer Survey</button>
</form>

  </div>
</div>
    <?php }
            }
            else{ 
    ?>
      <p id="xyz">No surveys available yet.</p>
      <?php
      }?>
</body>
</html>