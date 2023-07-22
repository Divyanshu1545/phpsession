<?php
// manage_student.php

// Include the database connection file
require_once('connect.php');

if (isset($_POST['update']) && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $father_name = $_POST['father_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    $gender = $_POST['gender'];
    $note = $_POST['note'];
    $date_of_birth = $_POST['date_of_birth'];

    // Update the student record
    $update_query = "UPDATE student SET 
                        student_name = '$student_name',
                        father_name = '$father_name',
                        phone = '$phone',
                        email = '$email',
                        class = '$class',
                        gender = '$gender',
                        note = '$note',
                        date_of_birth = '$date_of_birth',
                        updated_date = NOW()
                    WHERE student_id = $student_id";

    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        // Successful update
        header("Location: restricted_page.php");
        exit();
    } else {
        // Failed to update
        echo "Error: Unable to update the student record.";
    }
} elseif (isset($_POST['delete']) && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Check if the student record exists and its status is not 1 (active)
    $check_query = "SELECT status FROM student WHERE student_id = $student_id";
    $check_result = mysqli_query($conn, $check_query);

    if ($check_result) {
        $status = mysqli_fetch_assoc($check_result)['status'];

        if ($status != 1) {
            // Delete the student record if its status is not 1
            $delete_query = "DELETE FROM student WHERE student_id = $student_id";
            $delete_result = mysqli_query($conn, $delete_query);

            if ($delete_result) {
                // Successful deletion
                header("Location: restricted_page.php");
                exit();
            } else {
                // Failed to delete
                echo "Error: Unable to delete the student record.";
            }
        } else {
            // Student record status is 1 (active), cannot delete
            echo "Error: Cannot delete an active student record.";
        }
    } else {
        // Invalid student_id, redirect to restricted_page.php
        header("Location: restricted_page.php");
        exit();
    }
} else {
    // Invalid request, redirect to restricted_page.php
    header("Location: restricted_page.php");
    exit();
}
?>
