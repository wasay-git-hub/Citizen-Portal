<?php
include("database.php");
if(isset($_POST['save'])) {
    $cnic = isset($_POST['cnic']) ? $_POST['cnic'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $fathername = isset($_POST['fathername']) ? $_POST['fathername'] : '';
    $contact = isset($_POST['contact']) ? $_POST['contact'] : '';

    if(empty($cnic) || empty($name) || empty($gender) || empty($dob) || empty($address) || empty($fathername) || empty($contact)) {
        die("All fields are required!");
    }
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Use backticks for column names and match exact case with your database
    $sql = "INSERT INTO nadra_database (`cnic`, `fullname`, `fathername`, `gender`, `dob`, `address`, `contact`)
            VALUES (
            '" . mysqli_real_escape_string($conn, $cnic) . "',
            '" . mysqli_real_escape_string($conn, $name) . "',
            '" . mysqli_real_escape_string($conn, $fathername) . "',
            '" . mysqli_real_escape_string($conn, $gender) . "',
            '" . mysqli_real_escape_string($conn, $dob) . "',
            '" . mysqli_real_escape_string($conn, $address) . "',
            '" . mysqli_real_escape_string($conn, $contact) . "'
)";

    if (mysqli_query($conn, $sql)) {
        $new_id = mysqli_insert_id($conn);
        echo "<div class='success-message'>Citizen registered successfully!</div>";
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
    <title>Add Citizen to NADRA</title>
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

    #ccc{text-align: center;}
</style>

</head>
<body>
    <form action="new_citizen.php" method="POST">
        <h2 id="ccc">CITIZEN REGISTRATION FORM</h2>

        <label>CNIC:</label>
        <input type="text" name="cnic" placeholder="Enter the Citizen's CNIC here" required>

        <label>Full Name:</label>
        <input type="text" name="name" placeholder="Write the Citizen's fullname here" required>

        <label>Father's Name:</label>
        <input type="text" name="fathername" placeholder="Write Father's full name here" required>

        <label>Gender:</label>
<select name="gender" required>
    <option value="" disabled selected>Select gender</option>
    <option value="male">Male</option>
    <option value="female">Female</option>
</select>
        <label>Date of Birth:</label>
        <input type="date" name="dob" required>

        <label>Address:</label>
        <input type="text" name="address" placeholder="Enter the permanent address here" required>

        <label>Contact Number:</label>
        <input type="text" name="contact" placeholder="Enter the emergency Contact Number here (without dashes)" required pattern="\d{11}" maxlength="11" required>

        <input type="submit" name="save" value="Register the citizen" class="submit-btn">
    </form>
</body>
</html>
