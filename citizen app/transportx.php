<?php
include("database.php");
if(isset($_POST['save'])) {
    // Check if form fields exist before accessing them
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $route = isset($_POST['route']) ? $_POST['route'] : '';
    $timing = isset($_POST['timing']) ? $_POST['timing'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';

    // Validate required fields
    if(empty($id) || empty($route) || empty($timing) || empty($type)) {
        die("All fields are required!");
    }

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Use backticks for column names and match exact case with your database
    $sql = "INSERT INTO transport (id, route, type, timings)
            VALUES (
            '" . mysqli_real_escape_string($conn, $id) . "',
            '" . mysqli_real_escape_string($conn, $route) . "',
            '" . mysqli_real_escape_string($conn, $type) . "',
            '" . mysqli_real_escape_string($conn, $timing) . "'
            )";

    if (mysqli_query($conn, $sql)) {
        $new_id = mysqli_insert_id($conn);
        echo "<div class='success-message'>Transport added successfully!</div>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ADD TRANSPORT</title>
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

    h2{
        text-align: center;
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
</style>

</head>
<body>
    <form action="" method="POST">
        <h2>ADD TRANSPORT</h2>

        <label>VEHICLE ID:</label>
        <input type="number" name="id" placeholder="Enter vehicle id here" required>

        <label>ROTUE:</label>
        <textarea name="route" placeholder="Enter the route" required rows="1"></textarea>

        <label>TYPE:</label>
        <input type="text" name="type" placeholder="Enter the vehicle type" required>

        <label>TIMINGS:</label>
        <input type="text" name="timing" placeholder="Enter the timing" required>

        <input type="submit" name="save" value="ADD TRANSPORT" class="submit-btn">
    </form>
</body>
</html>
