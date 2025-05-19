<?php
    session_start();
    include("database.php");

    if (!isset($_SESSION['fullname']) || !isset($_SESSION['cnic'])) {
        header("Location: login.php");
        exit();
    }

    $name_to_display = $_SESSION['fullname'];
    $cnic_to_display = $_SESSION['cnic'];

    $survey_id = $_GET['survey_id'];
    $title = $_GET['title'];
    
    $sql = "SELECT * FROM questions WHERE survey_id = '$survey_id' ORDER BY question_id";
    $result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Answer Survey</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f7fa;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 800px;
      margin: 50px auto;
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    h2 {
      margin-bottom: 30px;
      color: #003366;
      text-align: center;
    }

    .question-block {
      margin-bottom: 30px;
    }

    .question-label {
      font-weight: bold;
      font-size: 1.1rem;
      margin-bottom: 10px;
      display: block;
    }

    input[type="text"], textarea {
      width: 100%;
      padding: 10px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      resize: vertical;
    }

    .submit-btn {
      background-color: #004880;
      color: white;
      padding: 12px 25px;
      font-size: 1rem;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      display: block;
      margin: 0 auto;
    }

    .submit-btn:hover {
      background-color: #0060a0;
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
    .success-message {
        color: #2e7d32;
        padding: 15px;
        margin: 15px 0;
        text-align: center;
        background-color: #e8f5e9;
        border-radius: 6px;
        border-left: 4px solid #2e7d32;
        position: absolute;
        left: 465px;
        bottom: 66%;
    }
    .error-message {
        color: #c62828;
        padding: 15px;
        margin: 15px 0;
        text-align: center;
        background-color: #ffebee;
        border-radius: 6px;
        border-left: 4px solid #c62828;
        position: absolute;
        left: 465px;
        bottom: 66%;
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
    <h2><?php echo "$title"; ?></h2>

    <form action="answer.php?survey_id=<?php echo $survey_id; ?>&title=<?php echo urlencode($title); ?>" method="POST">
    <input type="hidden" name="survey_id" value="<?php echo $survey_id; ?>">
    <input type="hidden" name="title" value="<?php echo $title; ?>">
      <?php 
      if(mysqli_num_rows($result)>0){
        for($i=1; $i<=mysqli_num_rows($result); $i++){
            $row = mysqli_fetch_assoc($result);

            ${"retrieved_question$i"} = $row['text'];
            ${"retrieved_question_id$i"} = $row['question_id'];
      
      ?>
      <div class="question-block">
        <label class="question-label"><?php echo "$i: ${"retrieved_question$i"}" ?></label>
        <textarea name = "answer<?php echo$i;?>" rows="3" placeholder="Type your answer here..." required></textarea>
      </div>
        <?php }}?>
      <button class="submit-btn" type="submit">Submit Survey</button>
    </form>
  </div>

</body>
</html>

<?php
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $sql = "SELECT * FROM questions WHERE survey_id = '$survey_id' ORDER BY question_id";
        $result = mysqli_query($conn,$sql);
        for($i=1; $i<=mysqli_num_rows($result); $i++){
            $answer_key = "answer$i";
            $answer_value = isset($_POST[$answer_key]) ? $_POST[$answer_key] : '';
            if(!empty($answer_value)){
                try{
                    $sql = "INSERT INTO answers VALUES ('$survey_id','${"retrieved_question_id$i"}', '$answer_value', '$cnic_to_display',
                            '$name_to_display')";
                            mysqli_query($conn,$sql);
                            echo "<div class='success-message'>Your response has been submitted!</div>";
                }
                catch(mysqli_sql_exception){
                    echo "<div class='error-message'>You have already submitted your response!</div>";
                    break;
                }
            }
        }   
    }
?>
