<?php
include("database.php");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Hardcoded to only show Police Department complaints
$sql = "SELECT * FROM complaints WHERE department = 'Police'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Department Complaints</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f7fa;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .status-pending {
            color: #e67e22;
            font-weight: bold;
        }
        .status-resolved {
            color: #27ae60;
            font-weight: bold;
        }
        .no-complaints {
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
        }
        .action-btns {
            display: flex;
            gap: 5px;
        }
        .action-btn {
            padding: 5px 10px;
            border-radius: 3px;
            border: none;
            cursor: pointer;
            font-size: 12px;
        }
        .resolve-btn {
            background-color: #2ecc71;
            color: white;
        }
        .view-btn {
            background-color: #3498db;
            color: white;
        }
        .police-banner {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="police-banner">POLICE DEPARTMENT COMPLAINTS</div>
    <div class="container">
        <h1>Complaint Management System</h1>

        <table>
            <thead>
                <tr>
                    <th>CNIC</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Date of Complaint</th>
                    <th>Status</th>
                    <th>Date Resolved</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['cnic']) ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <?php $retrievedDep = $row['description']?>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><?= htmlspecialchars($row['location']) ?></td>
                            <td><?= ($row['date_of_complaint']) ?></td>
                            <td class="status-<?= strtolower($row['status']) ?>">
                                <?= htmlspecialchars($row['status']) ?>
                            </td>
                            <td>
                                <?= $row['date_of_resolving'] ?($row['date_of_resolving']) : 'Not resolved' ?>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <!-- <button class="action-btn view-btn">View</button> -->
                                    <?php if($row['status'] != 'Resolved'): ?>
                                        <form method="post">
                                        <button class="action-btn resolve-btn" name="resolve-btn" type="submit">Resolve</button>
                                        </form>
                                    <?php
                                    
                                         if(isset($_POST['resolve-btn'])){
                                            $current_date = date('Y-m-d'); 
                                            $sql = "UPDATE complaints SET status = 'Resolved', date_of_resolving = '$current_date'
                                            WHERE description = '$retrievedDep' ";
                                            mysqli_query($conn,$sql);
                                        }
                                    endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="no-complaints">
                            No police complaints found in the system.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php 

    mysqli_close($conn); 
?>