<?php


require('check_login.php');
require_once('connect.php');



function isValidDate($date) {
    // Regular expression pattern for "YYYY-MM-DD" format
    $pattern = "/^(\d{4})-(\d{2})-(\d{2})$/";
    
    // Check if the date matches the pattern
    if (preg_match($pattern, $date, $matches)) {
        // Check if the date is valid (e.g., not Feb 31 or Apr 31)
        if (checkdate((int)$matches[2], (int)$matches[3], (int)$matches[1])) {
            return true;
        }
    }
    
    return false;
}



$student_name = $father_name = $phone = $email = $class = $gender = $note = $date_of_birth = '';
$errors = array();


if (isset($_POST['register'])) {
    $student_name = filter_input(INPUT_POST, 'student_name', FILTER_SANITIZE_STRING);
    $father_name = filter_input(INPUT_POST, 'father_name', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $class = filter_input(INPUT_POST, 'class', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);
    $date_of_birth = filter_input(INPUT_POST, 'date_of_birth', FILTER_SANITIZE_STRING);

    
    $email_pattern = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
    $student_pattern = '/^[a-zA-Z\s]+$/';

    if (!preg_match($email_pattern,$email)) {
        echo "<script> alert('Email is not valid');   </script>";
        
         exit();
     }
     if(!preg_match($student_pattern,$student_name)){
        echo "<script> alert('Student name is not valid');   </script>";
        
        exit();}
        if(!preg_match($student_pattern,$father_name)){
            echo "<script> alert('Student name is not valid');   </script>";
            
            exit();}

     if (!preg_match("/^\d{10}$/", $phone)) {
        echo "<script> alert('Phone is not valid');   </script>";
        exit();
    }
    
        if(!isValidDate($date_of_birth)){
            echo "<script> alert('Date is not valid');   </script>";
            exit();
        }
    
    

        
        $check_query = $conn->prepare("SELECT phone, email FROM student WHERE phone = ? OR email = ?");
        
        $check_query->bind_param('ss',$phone,$email);
        require 'check_login.php';
         $check_query->execute();

        $check_result=$check_query->get_result();
        if ($check_result) {
            $existing_data = mysqli_fetch_assoc($check_result);

            if ($existing_data['phone'] === $phone) {
              echo "<script> alert('Phone number already exists.');   </script>";
              exit();
            }

            if ($existing_data['email'] === $email) {
              echo "<script> alert('Email already exists');   </script>";
              exit();
            }
        } else {
          echo "<script> alert('An unkwon error occured.');   </script>";
        }

        
        
            $insert_query =$conn->prepare( 'INSERT INTO student (student_name, father_name, phone, email, class, gender, note, date_of_birth,  created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ? )');

            $insert_query->bind_param("sssssssss",$student_name,$father_name,$phone,$email,$class,$gender,$note,$date_of_birth,$_SESSION['user_id']);
            $insert_query->execute();
            
            $insert_result=$insert_query->get_result();

            if ($insert_result) {
                // Successful insertion
                echo "<script> alert('Registered Successfully.');   </script>";
                header("LOCATION:  restricted_page.php");
            } else {
                // Failed to insert
                header("LOCATION:  restricted_page.php");

                echo "<script> alert('Registered Successfully.');   </script>";}
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

    <form action="student_registration.php" method="post" onsubmit="return validateForm()" >
        <label for="student_name">Student Name:</label>
        <input type="text" id="student_name" name="student_name" value="<?php echo htmlspecialchars($student_name); ?>" required>
        
        <label for="father_name">Father Name:</label>
        <input type="text" id="father_name" name="father_name" value="<?php echo htmlspecialchars($father_name); ?>" required>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required maxlength="10" minlength="10"  >
        
        <label for="email">Email:</label>
        <input  id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required >
        
        <label for="class">Class:</label>
        <select id="class" name="class" required>
            <option value="1st" <?php if ($class === '1st') echo 'selected'; ?>>1st</option>
            <option value="2nd" <?php if ($class === '2nd') echo 'selected'; ?>>2nd</option>
            <option value="3rd" <?php if ($class === '3rd') echo 'selected'; ?>>3rd</option>
            <option value="4th" <?php if ($class === '4th') echo 'selected'; ?>>4th</option>
            <option value="5th" <?php if ($class === '5th') echo 'selected'; ?>>5th</option>
            <option value="6th" <?php if ($class === '6th') echo 'selected'; ?>>6th</option>
            <option value="7th" <?php if ($class === '7th') echo 'selected'; ?>>7th</option>
            <option value="8th" <?php if ($class === '8th') echo 'selected'; ?>>8th</option>
            <option value="9th" <?php if ($class === '9th') echo 'selected'; ?>>9th</option>
            <option value="10th" <?php if ($class === '10th') echo 'selected'; ?>>10th</option>
            <option value="1th" <?php if ($class === '2nd') echo 'selected'; ?>>11th</option>
            <option value="12th" <?php if ($class === '12th') echo 'selected'; ?>>12th</option>
        
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
        <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($date_of_birth); ?>" required max="<?php echo date("Y-m-d"); ?>" >
        
        <label for="terms_accepted">I accept the terms and conditions:</label>
        <input type="checkbox" id="terms_accepted" name="terms_accepted" required>

        <input type="submit" name="register" value="Register">
    </form>

    <a href="restricted_page.php">Go back to Restricted Page</a>
    
    <script>
    function validateForm() {
        // Get form elements
        var studentName = document.getElementById("student_name").value;
        var fatherName = document.getElementById("father_name").value;
        var phone = document.getElementById("phone").value;
        var email = document.getElementById("email").value;
        var classSelection = document.getElementById("class").value;
        var gender = document.querySelector('input[name="gender"]:checked');
        var dateOfBirth = document.getElementById("date_of_birth").value;
        var termsAccepted = document.getElementById("terms_accepted").checked;
        var pattern = /^[a-zA-Z\s]+$/;
        // Validate fields
        if (!pattern.test(studentName)) {
            alert("Please enter a valid student's name.");
            return false;
        }
        if (!pattern.test(fatherName)) {
            alert("Please enter a valid father's name.");
            return false;
        }
        if (phone.length !== 10 || !(/^\d+$/.test(phone))) {
            alert("Please enter a valid 10-digit phone number.");
            return false;
        }
        if (email.trim() === "" || !/\S+@\S+\.\S+/.test(email)) {
            alert("Please enter a valid email address.");
            return false;
        }
        if (classSelection.trim() === "") {
            alert("Please select a class.");
            return false;
        }
        if (gender === null) {
            alert("Please select a gender.");
            return false;
        }
        if (dateOfBirth.trim() === "") {
            alert("Please select a valid date of birth.");
            return false;
        }
        if (!termsAccepted) {
            alert("Please accept the terms and conditions.");
            return false;
        }
        
        return true;
    }
    </script>    
</body>
</html>
