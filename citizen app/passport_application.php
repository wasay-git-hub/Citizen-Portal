<?php
include("database.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data
$sql = "SELECT * FROM passport_applicants";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["allot_date"], $_POST["applicant_cnic"])) {
    $allot_date = $_POST["allot_date"];
    $cnic = $_POST["applicant_cnic"];

    $stmt = $conn->prepare("UPDATE passport_applicants SET date_allotted = ?, status = 'Accepted' WHERE cnic = ?");
    $stmt->bind_param("ss", $allot_date, $cnic);
    $stmt->execute();
    $stmt->close();

    // Refresh the page to show updated data
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passport Application Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px 0;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .logo i {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-right: 15px;
        }

        .logo h1 {
            font-size: 2rem;
            color: #2c3e50;
            font-weight: 700;
        }

        .records-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .records-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .records-header h2 {
            color: #2c3e50;
            font-size: 1.5rem;
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
            padding: 15px;
            text-align: left;
            font-weight: 500;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #eaf7ff;
        }

        .status-pending {
            color: #e67e22;
            font-weight: 500;
        }

        .status-accepted {
            color: #2ecc71;
            font-weight: 500;
        }

        .status-rejected {
            color: #e74c3c;
            font-weight: 500;
        }

        .no-records {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            font-size: 1.1rem;
        }

        footer {
            text-align: center;
            padding: 20px;
            margin-top: 50px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            table {
                display: block;
                overflow-x: auto;
            }

            .logo {
                flex-direction: column;
            }

            .logo i {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
        input[type="datetime-local"] {
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
    max-width: 160px;
  width: 100%;
  box-sizing: border-box;
}

button {
    padding: 5px 10px;
    background-color: #2ecc71;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #27ae60;
}

    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <i class="fas fa-passport"></i>
                <h1>Passport Application Records</h1>
            </div>
        </header>

        <div class="records-container">
            <div class="records-header">
                <h2><i class="fas fa-list"></i> All Applications</h2>
                <span><?php echo $result->num_rows; ?> records found</span>
            </div>

            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>CNIC</th>
                            <th>Father's Name</th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Mobile Number</th>
                            <th>Nationality</th>
                            <th>Address</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Date Allotted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row["fullname"]); ?></td>
                                <td><?php echo htmlspecialchars($row["cnic"]); ?></td>
                                <td><?php echo htmlspecialchars($row["fathername"]); ?></td>
                                <td><?php echo htmlspecialchars($row["date_of_birth"]); ?></td>
                                <td><?php echo htmlspecialchars($row["gender"]); ?></td>
                                <td><?php echo htmlspecialchars($row["mobile_number"]); ?></td>
                                <td><?php echo htmlspecialchars($row["nationality"]); ?></td>
                                <td><?php echo htmlspecialchars($row["address"]); ?></td>
                                <td><?php echo htmlspecialchars($row["category"]); ?></td>
                                <td class="status-<?php echo strtolower(htmlspecialchars($row["status"])); ?>">
                                    <?php echo htmlspecialchars($row["status"]); ?>
                                </td>
                                <td>
                                <?php if (empty($row["date_allotted"])): ?>
                                    <form method="post" action="">
                                    <input type="datetime-local" name="allot_date" required>
                                    <input type="hidden" name="applicant_cnic" value="<?php echo htmlspecialchars($row["cnic"]); ?>">
                                    <button type="submit">Allot</button>
                                    </form>
                                <?php else: ?>
                                <?php echo htmlspecialchars($row["date_allotted"]); ?>
                                <?php endif; ?>
                                </td>
                                
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-records">
                    <i class="fas fa-info-circle" style="font-size: 3rem; margin-bottom: 15px; color: #bdc3c7;"></i>
                    <p>No passport application records found in the database.</p>
                </div>
            <?php endif; ?>
        </div>

        <footer>
            <p>© <?php echo date("Y"); ?> Passport Application System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>

<?php
$conn->close();
?>