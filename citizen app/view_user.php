<?php
include("database.php");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$user_info = null;
$error = null;

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cnic'])) {
    $cnic = $_POST['cnic'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT fullname, cnic, email,dob,gender FROM users WHERE cnic = ?");
    $stmt->bind_param("i", $cnic);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_info = $result->fetch_assoc();
    } else {
        $error = "No citizen found with CNIC: " . htmlspecialchars($cnic);
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Information System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
        }
        .container {
            max-width: 700px;
            margin: 30px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2c3e50;
        }
        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border 0.3s;
        }
        input[type="number"]:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52,152,219,0.2);
        }
        button {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            width: 100%;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #2980b9;
        }
        .citizen-info {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #3498db;
        }
        .error {
            color: #e74c3c;
            padding: 15px;
            background-color: #fadbd8;
            border-radius: 6px;
            margin-top: 20px;
            border-left: 4px solid #e74c3c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 15px;
        }
        th {
            background-color: #3498db;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #eaf2f8;
        }
        .info-label {
            font-weight: 500;
            color: #7f8c8d;
        }
        .highlight {
            color: #2c3e50;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Citizen Information Portal</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="cnic">Enter CNIC Number:</label>
                <input type="number" name="cnic" id="cnic" required placeholder="e.g., 1234567890123" min="1000000000000" max="9999999999999">
            </div>
            <button type="submit">Search Citizen</button>
        </form>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($user_info): ?>
            <div class="citizen-info">
                <h2 style="color: #2c3e50; margin-top: 0;">Citizen Details</h2>
                <table>
                    <tr>
                        <td class="info-label">CNIC Number</td>
                        <td class="highlight"><?php echo htmlspecialchars($user_info['cnic']); ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Full Name</td>
                        <td class="highlight"><?php echo htmlspecialchars($user_info['fullname']); ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Email</td>
                        <td><?php echo htmlspecialchars($user_info['email']); ?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Date of Birth</td><td><?php echo htmlspecialchars($user_info['dob']); ?></td>
                        
                    </tr>
                    <tr>
                        <td class="info-label">Gender</td>
                        <td><?php echo htmlspecialchars($user_info['gender']); ?></td>
                    </tr>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
