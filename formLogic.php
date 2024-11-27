<?php
        include 'db.php';
        include 'mailer.php';
        // Initialize variables
        $id = $name = $email = $phonenumber = $nationalid = $birthdate = $religion = $gender = "";

        // Fetch existing user data if ID is provided
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
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
            // Sanitize input
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $phonenumber = filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $nationalid = filter_input(INPUT_POST, 'nationalid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $birthdate = $_POST['birthdate'];
            $religion = $_POST['religion'];
            $gender = $_POST['gender'];

            try {
                if (!empty($_POST['id'])) {  
                    // Update existing record
                    $id = $_POST['id'];
                    $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, phonenumber = :phonenumber, nationalid = :nationalid, birthdate = :birthdate, religion = :religion, gender = :gender WHERE id = :id");
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                } else {  
                    // Insert new record
                    $stmt = $conn->prepare("INSERT INTO users (name, email, phonenumber, nationalid, birthdate, religion, gender) VALUES (:name, :email, :phonenumber, :nationalid, :birthdate, :religion, :gender)");
                }

                // Bind parameters
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phonenumber', $phonenumber);
                $stmt->bindParam(':nationalid', $nationalid);
                $stmt->bindParam(':birthdate', $birthdate);
                $stmt->bindParam(':religion', $religion);
                $stmt->bindParam(':gender', $gender);
                $stmt->execute();

                $notificationResult = sendNotificationEmail('rahman.khattab02@gmail.com', $name);

                if ($notificationResult === true) {
                    echo "<div class='alert alert-success'>Operation successful, and notification sent.</div>";
                } else {
                    echo "<div class='alert alert-warning'>Operation successful, but email not sent. Error: $notificationResult</div>";
                }
               // echo "<div class='alert alert-success'>Operation successful</div>";
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
            }
        }

        // Delete button logic
        if (isset($_GET['delete_id'])) {
            $id = $_GET['delete_id'];
            $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            header("Location: index.php");
            exit;
        }

        // Next and Previous button logic
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
            $operator = $action === 'next' ? '>' : '<';
            $order = $action === 'next' ? 'ASC' : 'DESC';
        
            $stmt = $conn->prepare("SELECT * FROM users WHERE id $operator :id ORDER BY id $order LIMIT 1");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $nextRow = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($nextRow) {
                echo json_encode($nextRow); // Send employee data as JSON
            } else {
                echo json_encode(['error' => 'This is the limit of Employees']);
            }
            exit;
        }

        
        ?>