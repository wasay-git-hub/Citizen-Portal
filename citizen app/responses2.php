<?php
    include("database.php");
    $survey_id = $_GET['survey_id'];
    $title = $_GET['title'];
    $sql = "SELECT a.cnic_of_user, a.name_of_user, a.answer_text, q.question_id, q.text
        FROM answers a
        JOIN questions q ON a.question_id = q.question_id
        WHERE a.survey_id = '$survey_id'
        ORDER BY a.cnic_of_user,q.question_id";
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Citizen Survey Responses</title>
    <style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #eef2f5;
    color: #333;
    line-height: 1.6;
}

.container {
    max-width: 900px;
    margin: 50px auto;
    padding: 20px 30px;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

h1 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 2rem;
    color: #1a237e;
}

.response-card {
    background-color: #fdfdfd;
    border: 1px solid #dcdcdc;
    border-radius: 10px;
    padding: 20px 25px;
    margin-bottom: 25px;
    transition: box-shadow 0.3s ease;
}

.response-card:hover {
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.responder-info {
    background-color: #f1f3f4;
    padding: 10px 15px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.question-section p {
    margin-bottom: 12px;
}

strong {
    color: #0d47a1;
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
<div class="container">
        <h1>Responses for <?php echo "$title"; ?></h1>
        <?php
        if (mysqli_num_rows($result) > 0) {
            $current_cnic = null;

            while ($row = mysqli_fetch_assoc($result)) {
                $cnic = $row["cnic_of_user"];
                $name = $row["name_of_user"];
                $qid = $row["question_id"];
                $qtext = $row["text"];
                $answer = $row["answer_text"];
                $identity = $cnic . $name;

                if ($identity !== $current_cnic) {
                    if ($current_cnic !== null) {
                        echo "</div>";
                    }
                    echo '<div class="response-card">';
                    echo "<p><strong>Responded by:</strong> $name</p>";
                    echo "<p><strong>CNIC:</strong> $cnic</p>";
                    echo "<hr>";
                    $current_cnic = $identity;
                }

                echo "<p><strong>Question ID:</strong> $qid</p>";
                echo "<p><strong>Question:</strong> $qtext</p>";
                echo "<p><strong>Answer:</strong> $answer</p>";
                echo "<hr>";
            }

            echo "</div>"; 
        } else {
            echo '<p id="xyz">None of the registered citizens have responded yet.</p>';
        }
        ?>
    </div>
</body>
</html>
