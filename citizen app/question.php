<?php
include("database.php");
if(isset($_POST['save'])) {
    // Check if form fields exist before accessing them
    $text = isset($_POST['text']) ? $_POST['text'] : '';
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $sid = isset($_POST['sid']) ? $_POST['sid'] : '';

    // Validate required fields
    if(empty($text) || empty($id) || empty($sid)) {
        die("All fields are required!");
    }

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Use backticks for column names and match exact case with your database
    $sql = "INSERT INTO questions (`question_id`,`survey_id`,`text`)
            VALUES (
            '" . mysqli_real_escape_string($conn, $id) . "',
            '" . mysqli_real_escape_string($conn, $sid) . "',
            '" . mysqli_real_escape_string($conn, $text) . "'
            )";
    try{
        if(mysqli_query($conn, $sql)) {

            echo "<div class='success-message'>Question added successfully! ID: $id</div>";
    
        } 
    }
    catch(mysqli_sql_exception $e){
        if(strpos($e -> getMessage(), 'foreign key constraint') !== false){
            echo "<div class='error-message'>Error: Survey ID does not exist. Please enter a valid survey.</div>";
        }
        else {echo "Error adding question, please try again later!";}
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add a Question</title>
    <style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
        background-color: #f5f5f5;
        line-height: 1.6;
        color: #2c3e50;
    }
    form {
        background-color: white;
        padding: 25px;
        border: 1px solid #ddd;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    input, textarea, select {
        width: 100%;
        margin: 12px 0;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        box-sizing: border-box;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }
    input:focus, textarea:focus, select:focus {
        border-color: #2c3e50;
        outline: none;
        box-shadow: 0 0 0 2px rgba(255, 0, 0, 0.1);
    }
    .submit-btn {
        background-color: #2c3e50;
        color: white;
        border: none;
        padding: 12px 20px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 600;
        border-radius: 6px;
        width: 100%;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .submit-btn:hover {
        background-color:rgb(0, 17, 204);
        transform: translateY(-2px);
    }
    .submit-btn:active {
        transform: translateY(0);
    }
    .success-message {
        color: #2e7d32;
        padding: 15px;
        margin: 15px 0;
        text-align: center;
        background-color: #e8f5e9;
        border-radius: 6px;
        border-left: 4px solid #2e7d32;
    }
    .error-message {
        color: #c62828;
        padding: 15px;
        margin: 15px 0;
        text-align: center;
        background-color: #ffebee;
        border-radius: 6px;
        border-left: 4px solid #c62828;
    }
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }
    .form-group {
        margin-bottom: 15px;
    }
    #bbb{
        text-align: center;
    }
</style>

</head>
<body>
    <form action="question.php" method="POST">
        <h2 id="bbb">SURVEY QUESTIONS</h2>

        <label>Survey ID:</label>
        <textarea type="number" name="sid" placeholder="Enter SURVEY ID" required rows="1"></textarea>

        <label>Question ID:</label>
        <textarea type="number" name="id" placeholder="Enter QUESTION ID" required rows="1"></textarea>

        <label>Text:</label>
        <input type="text" name="text" placeholder="Write the description of question here" required>

        <input type="submit" name="save" value="ADD QUESTION" class="submit-btn">
    </form>
</body>
</html>
