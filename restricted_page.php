<?php
// restricted_page.php

// Include the check_login.php file to verify if the user is logged in
require_once('check_login.php');

// Include the database connection file
require_once('connect.php');

// Pagination logic
$records_per_page = 10;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}
$offset = ($current_page - 1) * $records_per_page;

// Fetch 10 records from the student table with pagination
$sql = "SELECT * FROM student LIMIT $offset, $records_per_page";
$result = mysqli_query($conn, $sql);

// Check if any students exist
if (mysqli_num_rows($result) > 0) {
    $students = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $students = array();
}

// Get total number of students for pagination
$total_records_sql = "SELECT COUNT(*) AS total FROM student";
$total_records_result = mysqli_query($conn, $total_records_sql);
$total_records = mysqli_fetch_assoc($total_records_result)['total'];
$total_pages = ceil($total_records / $records_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restricted Page</title>
  <link rel="stylesheet" href="style2.css">
</head>
<body>
  <<h1>Restricted Page - Welcome, <?php echo $_SESSION['username']; ?></h1>

<!-- Search Form -->
<form action="search_results.php" method="get">
    <input type="text" name="search_student_name" placeholder="Search by Student Name">
    <input type="text" name="search_father_name" placeholder="Search by Father Name">
    <input type="text" name="search_phone" placeholder="Search by Phone">
    <input type="text" name="search_email" placeholder="Search by Email">
    <select name="search_class">
        <option value="">-- Select Class --</option>
        <option value="1st">1st</option>
        <option value="2nd">2nd</option>
        <!-- Add other options for 3rd to 12th classes -->
    </select>
    <select name="search_gender">
        <option value="">-- Select Gender --</option>
        <option value="m">Male</option>
        <option value="f">Female</option>
    </select>
    <label for="start_date">Start Date:</label>
    <input type="date" name="start_date" id="start_date">
    <label for="end_date">End Date:</label>
    <input type="date" name="end_date" id="end_date">
    <input type="submit" name="search" value="Search">
</form>

  <a href="logout.php">Logout</a><br><br>
  <a href="student_registration.php">Register a new student</a>

  <h2>Students:</h2>
  <?php if (count($students) > 0) { ?>
    <table>
      <tr>
        <th>ID</th>
        <th>Student Name</th>
        <th>Father Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Class</th>
        <th>Gender</th>
        <th>Note</th>
        <th>Date of Birth</th>
        <th>Status</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
      <?php foreach ($students as $student) { ?>
        <tr>
          <td><?php echo $student['student_id']; ?></td>
          
<td>
    <form action="manage_student.php" method="post">
        <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
        <input type="text" name="student_name" value="<?php echo $student['student_name']; ?>" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
    </td>
    <td>
        <input type="text" name="father_name" value="<?php echo $student['father_name']; ?>" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
    </td>
    <td>
        <input type="text" name="phone" value="<?php echo $student['phone']; ?>" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
    </td>
    <td>
        <input type="text" name="email" value="<?php echo $student['email']; ?>" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
    </td>
    <td>
        <select name="class" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
            <option value="1st" <?php if ($student['class'] === '1st') echo 'selected'; ?>>1st</option>
            <option value="2nd" <?php if ($student['class'] === '2nd') echo 'selected'; ?>>2nd</option>
            <!-- Add other options for 3rd to 12th classes -->
        </select>
    </td>
    <td>
        <label>
            <input type="radio" name="gender" value="m" <?php if ($student['gender'] === 'm') echo 'checked'; ?> <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>> Male
        </label>
        <label>
            <input type="radio" name="gender" value="f" <?php if ($student['gender'] === 'f') echo 'checked'; ?> <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>> Female
        </label>
    </td>
    <td>
        <textarea name="note" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>><?php echo $student['note']; ?></textarea>
    </td>
    <td>
        <input type="date" name="date_of_birth" value="<?php echo $student['date_of_birth']; ?>" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
    </td>
    <td><?php echo $is_active = ($student['status']==0) ? "Active" : "Inactive" ; ?></td>
    <td>
        <input type="submit" name="update" value="Update" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
    </td>
    <td>
        <input type="submit" name="delete" value="Delete" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?> onclick="return confirm('Are you sure you want to delete this student?');">
    </form>
</td>
        </tr>
      <?php } ?>
    </table>


    
    <?php if ($total_pages > 1) { ?>
      <div class="pagination">
        <?php if ($current_page > 1) { ?>
          <a href="?page=<?php echo $current_page - 1; ?>">Previous</a>
        <?php } ?>

        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
          <?php if ($i === $current_page) { ?>
            <span class="current"><?php echo $i; ?></span>
          <?php } else { ?>
            <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
          <?php } ?>
        <?php } ?>

        <?php if ($current_page < $total_pages) { ?>
          <a href="?page=<?php echo $current_page + 1; ?>">Next</a>
        <?php } ?>
      </div>
    <?php } ?>
  <?php } else { ?>
    <p>No students found.</p>
  <?php } ?>

</body>
</html>
