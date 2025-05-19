<?php
  session_start();
  include("database.php");
  $issues = [];

  if($_SERVER["REQUEST_METHOD"]=="POST"){
      $entered_cnic = mysqli_real_escape_string($conn, $_POST['CNIC']);
      $entered_password = mysqli_real_escape_string($conn, $_POST['password']);
      
      $sql_passwordAndName = "SELECT password,fullname FROM users WHERE cnic = '$entered_cnic'";
      $retreived_row = mysqli_query($conn, $sql_passwordAndName);
      if(mysqli_num_rows($retreived_row)==1){
         
        $row = mysqli_fetch_assoc($retreived_row);
        $retreived_password = $row['password'];
        $retreived_name = $row['fullname'];

        if(password_verify($entered_password, $retreived_password)){
          $_SESSION['fullname'] = $retreived_name;
          $_SESSION['cnic'] = $entered_cnic;
          header("Location: logged.html");
        }
        else{
          $issues[] = "You entered the wrong password";
        }
      }
      else{
        $issues[] = "CNIC not found";
      }
  }

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Citizen App - Login</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f3f4f6;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .card {
      background-color: white;
      padding: 2rem;
      border-radius: 1.5rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    .card h1 {
      text-align: center;
      color: #1f2937;
      font-size: 2rem;
      margin-bottom: 0.25rem;
    }

    .card p {
      text-align: center;
      color: #6b7280;
      margin-bottom: 2rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      font-size: 0.9rem;
      color: #374151;
      margin-bottom: 0.5rem;
    }

    .form-group input {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #d1d5db;
      border-radius: 0.75rem;
      font-size: 1rem;
      outline: none;
      transition: border-color 0.3s;
    }

    .form-group input:focus {
      border-color: #3b82f6;
    }

    .login-btn {
      width: 100%;
      padding: 0.75rem;
      background-color: #3b82f6;
      color: white;
      font-size: 1rem;
      border: none;
      border-radius: 0.75rem;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .login-btn:hover {
      background-color: #2563eb;
    }

    .signup-link {
      text-align: center;
      margin-top: 1.5rem;
      font-size: 0.95rem;
      color: #6b7280;
    }

    .signup-link a {
      color: #3b82f6;
      text-decoration: none;
      font-weight: 500;
    }

    .signup-link a:hover {
      text-decoration: underline;
    }

    .error-container {
      margin-bottom: 20px;
      padding: 15px;
      background: #ffd7d7;
      border-radius: 8px;
    }

    .error-msg {
      color: #721c24;
      font-size: 14px;
      margin: 5px 0;
    }
  </style>
</head>
<body>
  <div class="card">
  <?php if(!empty($issues)) : ?>
    <div class="error-container">
      <?php foreach($issues as $issue) : ?>
      <div class="error-msg"><?= $issue ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
    <h1>Citizen App</h1>
    <p>Login to your account</p>

    <form action="login.php" method="post">
      <div class="form-group">
        <label for="cnic">CNIC</label>
        <input type="text" id="cnic" name="CNIC" placeholder="Enter your CNIC (without hyphens)" required />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required />
      </div>

      <button type="submit" class="login-btn" name="submit" value="submit">Login</button>
    </form>

    <div class="signup-link">
      Don't have an account? <a href="signup.php">Sign up</a>
    </div>
  </div>
</body>
</html>