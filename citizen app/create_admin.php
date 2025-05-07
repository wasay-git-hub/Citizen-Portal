<?php
include("database.php");
if(isset($_POST['save'])) {
    // Check if form fields exist before accessing them
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $pass = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate required fields
    if(empty($name) || empty($pass)) {
        echo "<div class='error-message'>All fields are required!</div>";
    } else {

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        try{
        $sql = "INSERT INTO admin ( `NAME`, `PASSWORD`) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $name, $pass);

            if (mysqli_stmt_execute($stmt)) {
                $new_id = mysqli_insert_id($conn);
                echo "<div class='success-message'>Department added successfully!</div>";
            } else {
                echo "<div class='error-message'>Error adding department, please try again later.</div>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='error-message'>Error preparing statement: " . mysqli_error($conn) . "</div>";
        }
    }
    catch(mysqli_sql_exception){
        echo "<div class='error-message'>Error adding department, this department already exists.</div>";
    }
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ADD ADMIN</title>
    <style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        max-width: 600px;
        margin: 40px auto;
        padding: 20px;
        background-color: #f5f5f5;
        line-height: 1.6;
        color: #333;
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
        box-shadow: 0 0 0 2px rgba(44, 62, 80, 0.1);
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
        background-color: #1a252f;
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
    h2 {
        color: #2c3e50;
        text-align: center;
        margin-bottom: 20px;
    }
</style>
</head>
<body>
    <form action="" method="POST">
        <h2>ADD A NEW DEPARTMENT</h2>


        <label>Name:</label>
        <input type="text" name="name" placeholder="Name of the new department (in capital letters)" required>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Password" required>

        <input type="submit" name="save" value="ADD THIS DEPARTMENT" class="submit-btn">
    </form>
</body>
</html>
