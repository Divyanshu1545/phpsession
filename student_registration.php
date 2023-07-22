<?php



require_once('check_login.php');


if (isset($_POST['register']) && !isset($_POST['terms_accepted'])) {

}

// Include the database connection file
require_once('connect.php');

// Initialize variables for form validation
$student_name = $father_name = $phone = $email = $class = $gender = $note = $date_of_birth = '';
$errors = array();

// Check if the form is submitted
if (isset($_POST['register'])) {
    // Retrieve form data
    $student_name = $_POST['student_name'];
    $father_name = $_POST['father_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    $gender = $_POST['gender'];
    $note = $_POST['note'];
    $date_of_birth = $_POST['date_of_birth'];

    
    

    

        // Check if the phone and email are unique
        $check_query = "SELECT phone, email FROM student WHERE phone = '$phone' OR email = '$email'";
        $check_result = mysqli_query($conn, $check_query);

        if ($check_result) {
            $existing_data = mysqli_fetch_assoc($check_result);

            if ($existing_data['phone'] === $phone) {
              echo "<script> alert('Phone number already exists.');   </script>";
            }

            if ($existing_data['email'] === $email) {
              echo "<script> alert('Email already exists');   </script>";
            }
        } else {
          echo "<script> alert('An unkwon error occured.');   </script>";
        }

        // If there are no errors, insert the student record
        
            $insert_query = "INSERT INTO student (student_name, father_name, phone, email, class, gender, note, date_of_birth,  created_by) VALUES ('$student_name', '$father_name', '$phone', '$email', '$class', '$gender', '$note', '$date_of_birth',  {$_SESSION['user_id']})";

            $insert_result = mysqli_query($conn, $insert_query);

            if ($insert_result) {
                // Successful insertion
                echo "<script> alert('Registered Successfully.');   </script>";
            } else {
                // Failed to insert
                echo "Error: Unable to register the student.";
            }
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <h1>Student Registration</h1>
    <p>Register a new student by filling out the form below:</p>

    <form action="student_registration.php" method="post">
        <label for="student_name">Student Name:</label>
        <input type="text" id="student_name" name="student_name" value="<?php echo htmlspecialchars($student_name); ?>" required>
        
        <label for="father_name">Father Name:</label>
        <input type="text" id="father_name" name="father_name" value="<?php echo htmlspecialchars($father_name); ?>" required>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        
        <label for="class">Class:</label>
        <select id="class" name="class" required>
            <option value="1st" <?php if ($class === '1st') echo 'selected'; ?>>1st</option>
            <option value="2nd" <?php if ($class === '2nd') echo 'selected'; ?>>2nd</option>
            <!-- Add other options for 3rd to 12th classes -->
        </select>
        
        <label>Gender:</label>
        <label>
            <input type="radio" name="gender" value="m" <?php if ($gender === 'm') echo 'checked'; ?> required> Male
        </label>
        <label>
            <input type="radio" name="gender" value="f" <?php if ($gender === 'f') echo 'checked'; ?> required> Female
        </label>
        
        <label for="note">Note:</label>
        <textarea id="note" name="note"><?php echo htmlspecialchars($note); ?></textarea>
        
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($date_of_birth); ?>" required>
        
        <label for="terms_accepted">I accept the terms and conditions:</label>
        <input type="checkbox" id="terms_accepted" name="terms_accepted" required>

        <input type="submit" name="register" value="Register">
    </form>

    <a href="restricted_page.php">Go back to Restricted Page</a>

    
</body>
</html>
