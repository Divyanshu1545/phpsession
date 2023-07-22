<?php


// Include the database connection file
require_once('connect.php');
require_once('check_login.php');
// Function to sanitize user input for the search
function sanitize_input($input) {
    return htmlspecialchars(trim($input));
}

// Retrieve search criteria from the URL parameters
$search_student_name = isset($_GET['search_student_name']) ? sanitize_input($_GET['search_student_name']) : '';
$search_father_name = isset($_GET['search_father_name']) ? sanitize_input($_GET['search_father_name']) : '';
$search_phone = isset($_GET['search_phone']) ? sanitize_input($_GET['search_phone']) : '';
$search_email = isset($_GET['search_email']) ? sanitize_input($_GET['search_email']) : '';
$search_class = isset($_GET['search_class']) ? sanitize_input($_GET['search_class']) : '';
$search_gender = isset($_GET['search_gender']) ? sanitize_input($_GET['search_gender']) : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Construct the search query
$search_query = "SELECT * FROM student WHERE 
    student_name LIKE '%$search_student_name%' AND 
    father_name LIKE '%$search_father_name%' AND 
    phone LIKE '%$search_phone%' AND 
    email LIKE '%$search_email%' AND 
    class LIKE '%$search_class%' AND 
    gender LIKE '%$search_gender%'";

// Add date range to the query if provided
if (!empty($start_date) && !empty($end_date)) {
    $search_query .= " AND created_date BETWEEN '$start_date' AND '$end_date'";
}

// Execute the search query
$search_result = mysqli_query($conn, $search_query);

// Pagination
$results_per_page = 10;
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
$start_from = ($page - 1) * $results_per_page;

// Modify the search query to include LIMIT for pagination
$search_query .= " ORDER BY student_id LIMIT $start_from, $results_per_page";

// Execute the modified search query for pagination
$search_result_paginated = mysqli_query($conn, $search_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <h1>Search Results</h1>

    <!-- Display Search Results -->
    <table>
        <tr>
            <th>Student ID</th>
            <th>Student Name</th>
            <th>Father Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Class</th>
            <th>Gender</th>
            <th>Note</th>
            <th>Date of Birth</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($search_result_paginated)) {
            echo '<tr>';
            echo '<td>' . $row['student_id'] . '</td>';
            echo '<td>' . $row['student_name'] . '</td>';
            echo '<td>' . $row['father_name'] . '</td>';
            echo '<td>' . $row['phone'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['class'] . '</td>';
            echo '<td>' . $row['gender'] . '</td>';
            echo '<td>' . $row['note'] . '</td>';
            echo '<td>' . $row['date_of_birth'] . '</td>';
            echo '<td>' . ($row['status'] == 0 ? 'Active' : 'Inactive') . '</td>';
            echo '<td><a href="update_student.php?id=' . $row['student_id'] . '">Update</a> | <a href="delete_student.php?id=' . $row['student_id'] . '" onclick="return confirm(\'Are you sure you want to delete this student?\')">Delete</a></td>';
            echo '</tr>';
        }
        ?>
    </table>

    
    <div class="pagination">
        <?php
        // Calculate total number of pages for pagination
        $total_students = mysqli_num_rows($search_result);
        $total_pages = ceil($total_students / $results_per_page);
if($total_pages>1){
        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<a href="search_results.php?page=' . $i . '">' . $i . '</a>';
        }}
        ?>
    </div>

    <a href="restricted_page.php">Back to Restricted Page</a>
</body>
</html>
