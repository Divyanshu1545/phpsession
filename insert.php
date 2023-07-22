<?php
// Insert 100 records into the student table with unique email and phone values
require_once('connect.php'); // Include the database connection file

$genders = ['m', 'f']; // Array of possible gender values ('m' for male, 'f' for female')

for ($i = 0; $i < 100; $i++) {
    $student_name = "Student" . ($i + 1);
    $father_name = "Father" . ($i + 1);
    $phone = "123456789" . str_pad($i, 2, '0', STR_PAD_LEFT); // Generate a unique phone number for each student
    $email = "student" . ($i + 1) . "@example.com";
    $class = '10th'; // Assuming all students are in 10th class
    $gender = $genders[array_rand($genders)]; // Randomly select 'm' or 'f' as the gender
    $term_and_condition = 1; // Assume all students accepted the terms and conditions
    $note = "Note for Student" . ($i + 1);
    $date_of_birth = date('Y-m-d', strtotime("-" . rand(3650, 7000) . " days")); // Generate random date of birth within 10 to 20 years ago
    $created_by = 1; // Assuming user with ID 1 created the records

    // Check if the email and phone do not exist in the student table
    $exists_sql = "SELECT 1 FROM student WHERE email='$email' OR phone='$phone' LIMIT 1";
    $result = mysqli_query($conn, $exists_sql);

    if (mysqli_num_rows($result) === 0) {
        // Insert the record into the student table
        $sql = "INSERT INTO student (student_name, father_name, phone, email, class, gender, term_and_condition, note, date_of_birth, created_by) VALUES ('$student_name', '$father_name', '$phone', '$email', '$class', '$gender', $term_and_condition, '$note', '$date_of_birth', $created_by)";
        mysqli_query($conn, $sql);
    } else {
        // Duplicate email or phone, generate new values for email and phone
        $i--;
    }
}

echo "Records inserted successfully!";
?>
