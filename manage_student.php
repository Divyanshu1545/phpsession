<?php
// manage_student.php

// Include the database connection file
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

if (isset($_POST['update']) && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $father_name = $_POST['father_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    $gender = $_POST['gender'];
    $note = $_POST['note'];
    $status=$_POST['status'];
    $date_of_birth = $_POST['date_of_birth'];
    function sanitize_name($name) {
        // Remove any leading or trailing whitespace
        $name = trim($name);
        // Remove any HTML tags and encode special characters
        $name = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        // You can also use the following line to allow alphabets, spaces, and dashes only
        // $name = preg_replace("/[^a-zA-Z\s-]/", "", $name);
        return $name;
    }
    
    $pattern = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
    $student_pattern = '/^[a-zA-Z\s]+$/';
if (isset($_POST['date_of_birth'])) {
    if(!isValidDate($date_of_birth)){
        echo "<script> alert('Date is not valid');   </script>";
        exit();
    }
}
    if(!preg_match($student_pattern,$student_name)){
        echo "<script> alert('Student name is not valid');   </script>";
        
        exit();}
        if(!preg_match($student_pattern,$father_name)){
            echo "<script> alert('Student name is not valid');   </script>";
            
            exit();}

    if (!preg_match($pattern,$email)) {
        echo "<script> alert('Email is not valid');   </script>";
        
         exit();
     }
 
      if (!preg_match("/^\d{10}$/", $phone)) {
         echo "<script> alert('Phone is not valid');
         
         </script>";
         
         exit();
     }
     $current_page=isset($_GET['page'])?$_GET['page']:1;

    // Update the student record
    $update_query =$conn->prepare( "UPDATE student SET 
                        student_name = ?,
                        father_name = ?,
                        phone = ?,
                        email = ?,
                        class = ?,
                        gender = ?,
                        status = ?,
                        note = ?,
                        date_of_birth = ?
                    WHERE student_id = ? ");
                    $update_query->bind_param("ssssssssss",$student_name, $father_name, $phone, $email, $class, $gender, $status, $note, $date_of_birth, $student_id );
                    require 'check_login.php';
        $update_query->execute();
    $update_result = $update_query->get_result();

    if ($update_result) {
        echo "<script> alert('Record updated Successfully.');   </script>";
        header("Location: restricted_page.php?page=$current_page");
        exit();
    } else {
        echo "<script> alert('Record updated Successfully.');   </script>";
        header("Location: restricted_page.php?page=$current_page");
        exit(); 
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
