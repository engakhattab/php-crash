<?php
include('db.php');

$current_id = isset($_GET['id']) ? $_GET['id'] : 1;

// Fetch the current record
$sql = "SELECT * FROM users WHERE id = $current_id";
$current_record = $conn->query($sql)->fetch_assoc();

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
    $conn->query($sql);
    $current_id = $conn->insert_id;
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sql = "UPDATE users SET name = '$name', email = '$email' WHERE id = $current_id";
    $conn->query($sql);
}

if (isset($_POST['delete'])) {
    $sql = "DELETE FROM users WHERE id = $current_id";
    $conn->query($sql);
    $current_id = 1;
}
if (isset($_POST['next'])) {
    $sql = "SELECT * FROM users WHERE id > $current_id ORDER BY id ASC LIMIT 1";
    $next_record = $conn->query($sql)->fetch_assoc();
    if ($next_record) {
        $current_id = $next_record['id'];
        $current_record = $next_record;
    }
}

if (isset($_POST['prev'])) {
    $sql = "SELECT * FROM users WHERE id < $current_id ORDER BY id DESC LIMIT 1";
    $prev_record = $conn->query($sql)->fetch_assoc();
    if ($prev_record) {
        $current_id = $prev_record['id'];
        $current_record = $prev_record;
    }
}

$sql = "SELECT * FROM users WHERE id = $current_id";
$current_record = $conn->query($sql)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2>User Management Form</h2>
        <a href="index.php" class="btn btn-custom">View All Users</a>
    </div>

    <form method="post" action="?id=<?php echo $current_id; ?>" class="border p-4 rounded shadow-sm mt-4">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo $current_record['name'] ?? ''; ?>" class="form-control" placeholder="Enter your name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $current_record['email'] ?? ''; ?>" class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="text-center">
            <button type="submit" name="add" class="btn btn-primary">Add New</button>
            <button type="submit" name="update" class="btn btn-warning">Update</button>
            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
            <button type="submit" name="prev" class="btn btn-secondary">Previous</button>
            <button type="submit" name="next" class="btn btn-secondary">Next</button>
            <button type="button" onclick="clearForm()" class="btn btn-light">Clear</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function clearForm() {
        document.querySelector('input[name="name"]').value = '';
        document.querySelector('input[name="email"]').value = '';
    }
</script>
</body>
</html>
<?php
$conn->close();
?>
