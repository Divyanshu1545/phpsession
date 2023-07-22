<!DOCTYPE html>
<html>
<head>
<title>Student Registration Form</title>
<style>
body {
  font-family: sans-serif;
}

form {
  width: 500px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
}

input {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
}

label {
  font-weight: bold;
}

select {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
}

textarea {
  width: 100%;
  height: 150px;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
}

input[type="submit"] {
  background-color: #000;
  color: #fff;
  padding: 10px;
  border: none;
  cursor: pointer;
}
</style>
</head>
<body>
<form action="/student/create" method="post">
  <h1>Student Registration Form</h1>
  <label for="student_id">Student ID</label>
  <input type="text" name="student_id" id="student_id">
  <label for="student_name">Student Name</label>
  <input type="text" name="student_name" id="student_name">
  <label for="father_name">Father Name</label>
  <input type="text" name="father_name" id="father_name">
  <label for="phone">Phone</label>
  <input type="text" name="phone" id="phone">
  <label for="email">Email</label>
  <input type="email" name="email" id="email">
  <label for="class">Class</label>
  <select name="class" id="class">
    <option value="1">1st</option>
    <option value="2">2nd</option>
    <option value="3">3rd</option>
    <option value="4">4th</option>
    <option value="5">5th</option>
    <option value="6">6th</option>
    <option value="7">7th</option>
    <option value="8">8th</option>
    <option value="9">9th</option>
    <option value="10">10th</option>
    <option value="11">11th</option>
    <option value="12">12th</option>
  </select>
  <label for="gender">Gender</label>
  <input type="radio" name="gender" id="male" value="male">
  <label for="male">Male</label>
  <input type="radio" name="gender" id="female" value="female">
  <label for="female">Female</label>
  <label for="term_condition">Term & Condition</label>
  <input type="checkbox" name="term_condition" id="term_condition">
  <label for="note">Note</label>
  <textarea name="note" id="note"></textarea>
  <label for="date_of_birth">Date of Birth</label>
  <input type="date" name="date_of_birth" id="date_of_birth">
  <input type="submit" value="Submit">
</form>
</body>
</html>
