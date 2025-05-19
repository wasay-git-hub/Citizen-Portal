<?php
    include("database.php");
    $email_check = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $fullname = filter_input(INPUT_POST, "fullname", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST["password"] ?? "";
    $errors = [];
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $CNIC = $_POST["CNIC"];
        $dob = $_POST["dob"];
        $gender = $_POST["gender"];        
        if(empty($email_check)){
          $errors[] = "Invalid email address";
            
        }
        if (!preg_match("/^\d{13}$/", $CNIC)) {
          $errors[] = "Invalid CNIC number (must be 13 digits)";
            
        }
        if (!preg_match("/^(?=.*\d)(?=.*[\W_]).{8,}$/", $password)){
          $errors[] = "Password must be at least 8 characters with 1 digit and 1 special character";
            
        }        
        else if(!empty($email_check)){
            $email = $_POST["email"];
        }
        if(!empty($email) && !empty($fullname) && !empty($CNIC) && !empty($password) && !empty($dob) && !empty($gender)){
            try{
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                // $sql2 = "SELECT cnic FROM nadra_database";
                // $result2 = mysqli_query($conn, $sql2);

                // for($i=1; $i<=mysqli_num_rows($result2); $i++){
                //   $row = mysqli_fetch_assoc($result2);
                //   $retrieved_cnic = $row["cnic"];
                  // if($CNIC==$retrieved_cnic){
                    $sql = "INSERT INTO users (fullname, email, cnic, password, dob, gender) 
                    VALUES ('$fullname', '$email', '$CNIC', '$hashed_password', '$dob', '$gender')";
    
                    mysqli_query($conn, $sql);
                    header("Location: signed.html");
                    // break;
                //   }
                // }
              //  echo "<div class='error-message'>This CNIC doesn't exists. Get yourself registered by the admin first.</div>";
                }
                catch(mysqli_sql_exception $e){
                  $errors[] = "Registration failed: "  . $e->getMessage();
                }
            }
        }
        
    

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Citizen App - Sign Up</title>
  <style>
  body {
    margin: 0;
    padding: 40px 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    min-height: 100vh;
    color: white;
    display: flex;
    justify-content: center;
    overflow-y: auto;
  }

    .signup-container {
      background-color: rgba(255, 255, 255, 0.1);
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 400px;
    }

    .signup-container h2 {
      text-align: center;
      margin-bottom: 25px;
      font-size: 28px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-size: 14px;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 8px;
      font-size: 14px;
    }

    .form-group input:focus {
      outline: none;
      box-shadow: 0 0 5px #00c6ff;
    }

    .signup-btn {
      width: 100%;
      padding: 12px;
      background-color: #00c6ff;
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .signup-btn:hover {
      background-color: #008ecf;
    }

    .login-link {
      margin-top: 15px;
      text-align: center;
      font-size: 14px;
    }

    .login-link a {
      color: #00c6ff;
      text-decoration: none;
    }

    .login-link a:hover {
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
    .form-group select {
  width: 105%;
  padding: 10px;
  border: none;
  border-radius: 8px;
  font-size: 14px;
  background-color: #fff;
  color: #333;
}

.form-group select:focus {
  outline: none;
  box-shadow: 0 0 5px #00c6ff;
}
.error-message {
        color: #c62828;
        padding: 5px;
        text-align: center;
        background-color: #ffebee;
        border-radius: 6px;
        position: absolute;
        left: 394px;
        bottom: 85%;
    }
  </style>
</head>
<body>
  <div class="signup-container">
    <h2>Sign Up to Citizen App</h2>
    <!-- Error Messages Container -->
  <?php if(!empty($errors)) : ?>
    <div class="error-container">
      <?php foreach($errors as $error) : ?>
      <div class="error-msg"><?= $error ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

    <form action="signup.php" method="post">
      <div class="form-group">
        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
      </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>

      <div class="form-group">
        <label for="CNIC">CNIC</label>
        <input type="text" id="CNIC" name="CNIC" placeholder="Enter your 13 digit CNIC number (without hyphens)" required>
      </div>

      <div class="form-group">
      <label for="gender">Gender</label>
      <select id="gender" name="gender" required>
      <option value="" disabled selected>Select your gender</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
      </select>
      </div>

      <div class="form-group">
        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" value="dob" required>
      </div>
      
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Create a password" required>
      </div>

      <button type="submit" class="signup-btn" name="submit" value="submit">Create Account</button>

      <div class="login-link">
        Already have an account? <a href="login.php"> Log in as citizen</a>
        <br>
        Are you an admin?<a href="loginx.php"> Log in as admin</a>
      </div>
    </form>
  </div>
</body>
</html>