<?php include 'formLogic.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Employee Registration Form</h2>

        <form id="userForm" method="POST" class="p-4 shadow rounded custom-form">
            <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Employee Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="mb-3">
                <label for="phonenumber" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phonenumber" name="phonenumber" value="<?php echo htmlspecialchars($phonenumber); ?>" required>
            </div>
            <div class="mb-3">
                <label for="nationalid" class="form-label">National ID</label>
                <input type="text" class="form-control" id="nationalid" name="nationalid" value="<?php echo htmlspecialchars($nationalid); ?>" required>
            </div>
            <div class="mb-3">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($birthdate); ?>" required>
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
                <div class="btn-group mt-3">
                    <button type="button" class="btn btn-outline-info" id="prevBtn">Previous</button>
                    <button type="button" class="btn btn-outline-info" id="nextBtn">Next</button>
                </div>
                <a href="form.php?id=<?php echo $id; ?>&delete_id=<?php echo $id; ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                    <button type="button" class="btn btn-outline-warning" onclick="document.getElementById('name').value='';document.getElementById('email').value='';document.getElementById('phonenumber').value='';document.getElementById('nationalid').value='';document.getElementById('birthdate').value='';document.getElementById('religion').value='Muslim';document.getElementById('gender').value='Male';">Clear</button>
            </div>
            <?php endif; ?>
        </form>
        <div id="responseMessage"></div>
    </div>

    <script>
        $(document).ready(function () {
            // Handle form submission
            $('#userForm').submit(function (event) {
                event.preventDefault(); // Prevent default form submission
                
                $.ajax({
                    url: 'formLogic.php', // Backend logic file
                    type: 'POST',
                    data: $(this).serialize(), // Serialize form data
                    success: function (response) {
                        $('#responseMessage').html(response); // Display response
                        $('#userForm')[0].reset(); // Reset form
                    },
                    error: function () {
                        $('#responseMessage').html('<p style="color:red;">An error occurred. Please try again.</p>');
                    }
                });
            });

            // Handle Next and Previous buttons
            function loadEmployee(action) {
                let currentId = $('#id').val(); // Get the current employee ID
                
                $.ajax({
                    url: 'formLogic.php',
                    type: 'GET',
                    data: { id: currentId, action: action },
                    success: function (response) {
                        let employee = JSON.parse(response); // Parse JSON response

                        if (employee.error) {
                            $('#responseMessage').html(`<p style="color:red;">${employee.error}</p>`);
                        } else {
                            // Update form fields with the new employee data
                            $('#id').val(employee.id);
                            $('#name').val(employee.name);
                            $('#email').val(employee.email);
                            $('#phonenumber').val(employee.phonenumber);
                            $('#nationalid').val(employee.nationalid);
                            $('#birthdate').val(employee.birthdate);
                            $('#religion').val(employee.religion);
                            $('#gender').val(employee.gender);
                        }
                    },
                    error: function () {
                        $('#responseMessage').html('<p style="color:red;">An error occurred while loading data.</p>');
                    }
                });
            }

            $('#nextBtn').click(function () {
                loadEmployee('next');
            });

            $('#prevBtn').click(function () {
                loadEmployee('prev');
            });
        });
    </script>
</body>
</html>
