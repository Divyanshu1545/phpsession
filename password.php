<?php   
$password= "password";
$password=password_hash($_POST['password'], PASSWORD_BCRYPT); 
print($password);


?>