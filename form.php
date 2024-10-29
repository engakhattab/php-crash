<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Employee Registration Form</h2>

        <?php
        include 'db.php';

        $id = $name = $email = $phonenumber = $nationalid = $birthdate = $religion = $gender = "";

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $result = $conn->query("SELECT * FROM users WHERE id = $id");

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $name = $row['name'];
                $email = $row['email'];
                $phonenumber = $row['phonenumber'];
                $nationalid = $row['nationalid'];
                $birthdate = $row['birthdate'];
                $religion = $row['religion'];
                $gender = $row['gender'];
            }
        }

        // Form submission logic
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $phonenumber = filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $nationalid = filter_input(INPUT_POST, 'nationalid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $birthdate = $_POST['birthdate'];
            $religion = $_POST['religion'];
            $gender = $_POST['gender'];
            
            if (!empty($_POST['id'])) {  
                $id = $_POST['id'];
                $sql = "UPDATE users SET name='$name', email='$email', phonenumber='$phonenumber', nationalid='$nationalid', birthdate='$birthdate', religion='$religion', gender='$gender' WHERE id=$id";
                $conn->query($sql);
                echo "<div class='alert alert-success'>Employee updated successfully</div>";
            } else {  
                $sql = "INSERT INTO users (name, email, phonenumber, nationalid, birthdate, religion, gender) VALUES ('$name', '$email', '$phonenumber', '$nationalid', '$birthdate', '$religion', '$gender')";
                $conn->query($sql);
                echo "<div class='alert alert-success'>New employee added successfully</div>";
            }
        }

        // Delete button logic
        if (isset($_GET['delete_id'])) {
            $id = $_GET['delete_id'];
            $conn->query("DELETE FROM users WHERE id = $id");
            header("Location: index.php");
        }

        // Next and Previous button logic
        if (isset($_GET['action']) && $_GET['action'] == 'next') {
            $result = $conn->query("SELECT * FROM users WHERE id > $id ORDER BY id ASC LIMIT 1");
            if ($result->num_rows > 0) {
                $nextRow = $result->fetch_assoc();
                header("Location: form.php?id=" . $nextRow['id']);
            }
        }
        if (isset($_GET['action']) && $_GET['action'] == 'prev') {
            $result = $conn->query("SELECT * FROM users WHERE id < $id ORDER BY id DESC LIMIT 1");
            if ($result->num_rows > 0) {
                $prevRow = $result->fetch_assoc();
                header("Location: form.php?id=" . $prevRow['id']);
            }
        }
        ?>

        <form method="POST" action="form.php" class="p-4 shadow rounded custom-form">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Employee Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="mb-3">
                <label for="phonenumber" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phonenumber" name="phonenumber" value="<?php echo $phonenumber; ?>" required>
            </div>
            <div class="mb-3">
                <label for="nationalid" class="form-label">National ID</label>
                <input type="text" class="form-control" id="nationalid" name="nationalid" value="<?php echo $nationalid; ?>" required>
            </div>
            <div class="mb-3">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $birthdate; ?>" required>
            </div>
            <div class="mb-3">
                <label for="religion" class="form-label">Religion</label>
                <select class="form-select" id="religion" name="religion" required>
                    <option value="Muslim" <?php if ($religion == 'Muslim') echo 'selected'; ?>>Muslim</option>
                    <option value="Christian" <?php if ($religion == 'Christian') echo 'selected'; ?>>Christian</option>
                    <option value="Other" <?php if ($religion == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if ($gender == 'Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="index.php" class="btn btn-secondary">View Users</a>
                <?php if ($id): ?>
                    <div class="btn-group">
                    <a href="form.php?id=<?php echo $id; ?>&action=prev" class="btn btn-outline-info">Previous</a>
                    <a href="form.php?id=<?php echo $id; ?>&action=next" class="btn btn-outline-info">Next</a>
                    </div>
                    <a href="form.php?id=<?php echo $id; ?>&delete_id=<?php echo $id; ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                    <button type="button" class="btn btn-outline-warning" onclick="document.getElementById('name').value='';document.getElementById('email').value='';document.getElementById('phonenumber').value='';document.getElementById('nationalid').value='';document.getElementById('birthdate').value='';">Clear</button>
                    
                <?php endif; ?>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
