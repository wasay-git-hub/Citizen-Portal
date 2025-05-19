<?php
session_start();
include("database.php");


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$login_error = "";

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {
    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT NAME, PASSWORD FROM admin WHERE NAME = ?");
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($input_password === $row['PASSWORD']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['department'] = $row['NAME'];

            // Redirect based on department
            if ($row['NAME'] == 'POLICE') {
                header("Location: logged1.html");
                exit;
            } elseif ($row['NAME'] == 'CDA') {
                header("Location: logged2.html");
                exit;
            }
            elseif ($row['NAME'] == 'ADMIN') {
                header("Location: logged3.html");
                exit;
            }

            elseif ($row['NAME'] == 'NADRA') {
                header("Location: logged4.html");
               
                exit;
            }
        } else {
            $login_error = "Invalid password";
        }
    } else {
        $login_error = "Department not found";
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
    <title>Department Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: #ff4444;
            margin-bottom: 15px;
        }
        .department-logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            background-color: #eee;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="department-logo">LOGIN</div>
        <h1>Department Portal</h1>

        <?php if ($login_error): ?>
            <p class="error"><?php echo htmlspecialchars($login_error); ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Department:</label>
                <input type="text" name="username" id="username" placeholder="Enter Department Name " required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Enter password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
