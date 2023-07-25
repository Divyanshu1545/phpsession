<?php
// Include the database connection file
require_once('connect.php');
require_once('check_login.php');

// Function to sanitize user input for the search
function preparedQuery($sql,$params) {
    for ($i=0; $i<count($params); $i++) {
      $sql = preg_replace('/\?/',$params[$i],$sql,1);
    }}
// Construct the base search query
$sql = "SELECT * FROM student WHERE 1=1";

// Define an array to hold the parameters and their corresponding types
$params = array();
$types = "";

// Add search conditions and parameters for student_name
if (isset($_GET['search_student_name'])) {
    $sql .= " AND student_name LIKE ?";
    $params[] = '%' . $_GET['search_student_name'] . '%';
    $types .= 's';
}

// Add search conditions and parameters for father_name
if (isset($_GET['search_father_name'])) {
    $sql .= " AND father_name LIKE ?";
    $params[] = '%' . $_GET['search_father_name'] . '%';
    $types .= 's';
}

// Add search conditions and parameters for phone
if (isset($_GET['search_phone'])) {
    $sql .= " AND phone LIKE ?";
    $params[] = '%' . $_GET['search_phone'] . '%';
    $types .= 's';
}

// Add search conditions and parameters for email
if (isset($_GET['search_email'])) {
    $sql .= " AND email LIKE ?";
    $params[] = '%' . $_GET['search_email'] . '%';
    $types .= 's';
}

// Add search conditions and parameters for class
if (isset($_GET['search_class'])) {
    $sql .= " AND class LIKE ?";
    $params[] = '%' . $_GET['search_class'] . '%';
    $types .= 's';
}

// Add search conditions and parameters for status
if ($_GET['status']==0 ||$_GET['status']==1) {
    $sql .= " AND status = ?";
    $params[] = (int)$_GET['status'];
    $types .= 'i';
} else {
    // If status is not set, search for both 1 and 0 in the status column
    $sql .= " AND (status = 0 OR status = 1)";
}

// Prepare and bind the search query
$search_query = $conn->prepare($sql);

if (count($params) > 0) {
    $search_query->bind_param($types, ...$params);
}

$search_query->execute();
$search_result = $search_query->get_result();

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
        while ($student = mysqli_fetch_assoc($search_result)) { ?>
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

            <option value="3rd" <?php if ($student['class'] === '3rd') echo 'selected'; ?>>3rd</option>
            <option value="4th" <?php if ($student['class'] === '4th') echo 'selected'; ?>>4th</option>
            <option value="5th" <?php if ($student['class'] === '5th') echo 'selected'; ?>>5th</option>
            <option value="6th" <?php if ($student['class'] === '6th') echo 'selected'; ?>>6th</option>
            <option value="7th" <?php if ($student['class'] === '7th') echo 'selected'; ?>>7th</option>
            <option value="8th" <?php if ($student['class'] === '8th') echo 'selected'; ?>>8th</option>
            <option value="9th" <?php if ($student['class'] === '9th') echo 'selected'; ?>>9th</option>
            <option value="10th"<?php if ($student['class'] === '10th') echo 'selected'; ?>>10th</option>
            <option value="1th" <?php if ($student['class'] === '2nd') echo 'selected'; ?>>11th</option>
            <option value="12th"<?php if ($student['class'] === '12th') echo 'selected'; ?>>12th</option>
        </select>
    </td>
    <td>
      <div class="gender-div">
        
        <div class="gender">
          <label>
            <input type="radio" name="gender" id="gender" value="m" <?php if ($student['gender'] === 'm') echo 'checked'; ?> <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>> Male
          </label>
        </div>
        <div class="gender">
          <label>
            <input type="radio" name="gender" value="f" <?php if ($student['gender'] === 'f') echo 'checked'; ?> <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>> Female
          </label>
        </div>

      </div>
      </td>
    <td>
        <textarea name="note" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>><?php echo $student['note']; ?></textarea>
    </td>
    <td>
        <input type="date" name="date_of_birth" value="<?php echo $student['date_of_birth']; ?>" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
    </td>
    <td><select name="status" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>> 
        <option value="0" <?php if ($student['status'] == 0) echo 'selected'; ?>>Active</option>
        <option value="1" <?php if ($student['status'] == 1) echo 'selected'; ?>>Inactive</option></td>
    <td>
        <input type="submit" name="update" value="Update" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
   
        <input type="submit" name="delete" value="Delete" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?> onclick="return confirm('Are you sure you want to delete this student?');">
    </form>
</td>
        </tr>
      <?php  }
        ?>
        <?php 
if ($search_result->num_rows === 0) {
    echo 'No results found.';
} ?>
    </table>
    

    <a href="restricted_page.php">Back to Restricted Page</a>
</body>
</html>
