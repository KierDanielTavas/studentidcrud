<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    // Check if POST variable "first_name$first_name" exists, if not default the value to blank, basically the same for all variables
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $course = isset($_POST['course']) ? $_POST['course'] : '';
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : date('Y-m-d H:i:s');
    
    // Insert new record into the students table
    $stmt = $pdo->prepare('INSERT INTO students VALUES (?, ?, ?, ?, ?, ?,?)');
    $stmt->execute([$id, $first_name,$last_name, $address, $phone, $course, $birthdate]);
    // Output message
    $msg = 'Submitted Successfully!';
}
?>

<?=template_header('Create')?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student ID Form</title>
  <link rel="stylesheet" type="text/css" href="style.css"> 
</head>
<body background=https://scontent.fmnl4-1.fna.fbcdn.net/v/t1.6435-9/200301959_4912187085463602_1201929442734337597_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=e3f864&_nc_eui2=AeEsOEcKUzCDhbnhT42lAbM0PAFgGwI8Wwk8AWAbAjxbCc-6ET6d_Xvc2AtALyu3ljr1GVF0Xy6TSVN9Ulj6FRaH&_nc_ohc=VByhe6NVh0wAX9ah336&_nc_ht=scontent.fmnl4-1.fna&oh=00_AT8vqCiR_l3UCHcCqR6aBVqglPZF3K2LYpjbEy6B3eDXng&oe=63766A33>
<body>
<div class="header">
<h2>Student ID Registration</h2>
</div>
<form action="create.php" method="post">
  <div class="input-group">
  <label for="first_name">First name:</label><br>
  <input type="text" id="first_name" name="first_name" value=" "><br>
  </div>
  <div class="input-group">
  <label for="last_name">Last name:</label><br>
  <input type="text" id="last_name" name="last_name" value=" "><br><br>
  </div>
  <div class="input-group">
  <label for="address">Address:</label><br>
  <input type="text" id="address" name="address" value=" "><br>
  </div>
  <div class="input-group">
  <label for="course">Course:</label><br>
  <select id="course" name="course">
    <option value="Bachelor of Science in Information Technology (BSIT)">Bachelor of Science in Information Technology (BSIT)</option>
    <option value="Bachelor of Science in Computer Science (BSCS)">Bachelor of Science in Computer Science (BSCS)</option>
    <option value="Bachelor of Science in Data Analytics (BSDA)">Bachelor of Science in Data Analytics (BSDA)</option>
    <option value="Bachelor of Library and Information Science (BLIS)">Bachelor of Library and Information Science (BLIS)</option>
  </select><br>
  </div>
  <div class="input-group">
  <label for="birthdate">Birthdate:</label><br>
  <input type="date" id="birthdate" name="birthdate" value="<?=date('Y-m-d\TH:i')?>"   >
  <br>
  </div>
  <div class="input-group">
  <label for="phone">Contact Number:</label><br>
  <input type="tel" id="phone" name="phone"
     placeholder="0912-752-1972"
    pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}">
  <br>
  </div>
  <div class="input-group">
  <label for="id">ID Number:</label><br>
  <input type="tel" id="id" name="id"
     placeholder="19-2452-872"
    pattern="[0-9]{2}-[0-9]{4}-[0-9]{3}"><br>
  <br>
   <div class="container">
  <input type="submit" value="Submit"  class="submit-button">
  </div>
  <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</form> 



</body>
</html>
<?=template_footer()?>