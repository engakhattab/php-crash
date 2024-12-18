<!-- new version -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Employee Records</h2>
        
        <?php
        include 'indexLogic.php';
        

        if ($result) {
            echo "
                <div class='table-responsive'>
                    <table class='table table-hover table-bordered align-middle'>
                        <thead class='custom-table-header'>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>National ID</th>
                                <th>Birthdate</th>
                                <th>Religion</th>
                                <th>Gender</th>
                                <th class='text-center'>Actions</th>
                            </tr>
                        </thead>
                        <tbody>";
            foreach ($result as $row) {
                echo "
                    <tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phonenumber']}</td>
                        <td>{$row['nationalid']}</td>
                        <td>{$row['birthdate']}</td>
                        <td>{$row['religion']}</td>
                        <td>{$row['gender']}</td>
                        <td class='text-center'>
                            <a href='form.php?id={$row['id']}' class='btn btn-outline-primary btn-sm'>Edit</a>
                            <a href='index.php?delete_id={$row['id']}' class='btn btn-outline-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>
                        </td>
                    </tr>";
            }
            echo "
                        </tbody>
                    </table>
                </div>";
        } else {
            echo "<p class='text-center'>No records found.</p>";
        }
        ?>

        <div class="text-center mt-4">
            <a href="form.php" class="btn btn-success btn-lg">Add New Employee</a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
