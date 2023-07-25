<?php
require_once('check_login.php');

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
  <h1>Student Page- Welcome, <?php echo $_SESSION['username']; ?></h1>

<!-- Search Form -->
<form action="search_results.php" method="get" onsubmit="return validateSearchForm()">
    <input type="text" name="search_student_name" placeholder="Search by Student Name" id="search_student_name" value="<?php echo htmlspecialchars('');?>"  >
    <input type="text" name="search_father_name" placeholder="Search by Father Name"  id="search_father_name" value="<?php echo htmlspecialchars('');?>" >
    <input type="tel" name="search_phone" placeholder="Search by Phone" id="search_phone"  minlength="10" maxlength="10" value="<?php echo htmlspecialchars('');?>" >
    <input type="text" name="search_email" placeholder="Search by Email"  id="search_email" value="<?php echo htmlspecialchars('');?>" >
    <input type="date" name="date_of_birth" max="<?php echo date("Y-m-d")?>" id="search_date_of_birth" value="<?php echo htmlspecialchars('');?>" >
    <select name="search_class" id="search_class" value="<?php echo htmlspecialchars('');?>" >
        <option value="">-- Select Class --</option>
        <option value="1st">1st</option>
        <option value="2nd">2nd</option>
        <option value="3rd" >3rd</option>
            <option value="4th" >4th</option>
            <option value="5th" >5th</option>
            <option value="6th" >6th</option>
            <option value="7th" >7th</option>
            <option value="8th" >8th</option>
            <option value="9th" >9th</option>
            <option value="10th" >10th</option>
            <option value="1th" >11th</option>
            <option value="12th"  >12th</option>
    </select>
    <select name="search_gender" id="search_gender"  >
        <option value="">-- Select Gender --</option>
        <option value="m">Male</option>
        <option value="f">Female</option>
    </select>
    <select name="status">
        <option value="">-- Select Status --</option>
        <option value="0">Active</option>
        <option value="1">inactive</option>
    </select>
  
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
        <th>Created Date</th>
        <th>Last Updated</th>
      </tr>
      <?php foreach ($students as $student) { ?>
        <tr>
          <td><?php echo $student['student_id']; ?></td>
          
<td>
    <form action="manage_student.php" onsubmit="return validateForm()" method="post" >
        <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
        <input type="text" name="student_name" id="student_name" value="<?php echo $student['student_name']; ?>" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
    </td>
    <td>
        <input type="text" name="father_name" id="father_name" value="<?php echo $student['father_name']; ?>" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
    </td>
    <td>
        <input type="tel" name="phone" id="phone" value="<?php echo $student['phone']; ?>" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>  maxlength="10" minlength="10" >
    </td>
    <td>
        <input type="text" name="email"  id="email" value="<?php echo $student['email']; ?>" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
    </td>
    <td>
        <select name="class" id="class" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
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
        <textarea name="note" id="note" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>><?php echo $student['note']; ?></textarea>
    </td>
    <td>
        <input type="date" name="date_of_birth" id="date_of_birth" value="<?php echo $student['date_of_birth']; ?>" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
    </td>
    <td><select name="status" id="status" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>> 
        <option value="0" <?php if ($student['status'] == 0) echo 'selected'; ?>>Active</option>
        <option value="1" <?php if ($student['status'] == 1) echo 'selected'; ?>>Inactive</option></td>
    <td>
        <input type="submit" name="update"  value="Update" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?>>
    </td>
    <td>
        <input type="submit" name="delete" value="Delete" <?php echo ($student['status'] == 1) ? 'disabled' : ''; ?> onclick="return confirm('Are you sure you want to delete this student?');">
        
     
    </form>
</td>
      <td><?php  echo  $student['created_datetime'] ?></td>
      <td><?php  echo  $student['updated_datetime'] ?></td>
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
  <script>
    function validateForm() {
      console.log("helo world)()");
    var studentName = document.getElementById("student_name").value.trim();
    var fatherName = document.getElementById("father_name").value.trim();
    var phone = document.getElementById("phone").value.trim();
    var email = document.getElementById("email").value.trim();
    var classSelection = document.getElementById("class").value;
    var gender = document.querySelector('input[name="gender"]:checked');
    var dateOfBirth = document.getElementById("date_of_birth").value;

    // Validate fields
    if (studentName === "") {
        alert("Please enter the student's name.");
        return false;
    }
    if (fatherName === "") {
        alert("Please enter the father's name.");
        return false;
    }
    if (phone === "" || phone.toString().length !== 10 || !(/^\d+$/.test(phone))) {
        alert("Please enter a valid 10-digit phone number.");
        return false;
    }
    if (email === "" || !/\S+@\S+\.\S+/.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }
    return true;
}

    function validateSearchForm(){
        var studentName = document.getElementById("search_student_name").value;
        var fatherName = document.getElementById("search_father_name").value;
        var phone = document.getElementById("search_phone").value;
        var email = document.getElementById("search_email").value;
        var classSelection = document.getElementById("search_class").value;
        var gender = document.querySelector('input[name="gender"]:checked');
        var dateOfBirth = document.getElementById("search_date_of_birth").value;
        
        
        // Validate fields
        if (studentName !=="") {
          
        


        if (studentName.length <3) {
            alert("Name should be atleast 3 character long.");
            return false;
        }}
      
        if (phone!=="") {
        
    
        if (phone.length !== 10 || !(/^\d+$/.test(phone))) {
            alert("Please enter a valid 10-digit phone number.");
            return false;
          }  }

          if (email.trim() !== "" ) {
            
          
        if ( !/\S+@\S+\.\S+/.test(email)) {
            alert("Please enter a valid email address.");
            return false;
        }}
      
        
        return true;
    }
    </script>
</body>
</html>
