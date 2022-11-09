<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the students id exists, for example update.php?id=1 will get the students with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $course = isset($_POST['course']) ? $_POST['course'] : '';
        $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : date('Y-m-d H:i:s');
        // Update the record
        $stmt = $pdo->prepare('UPDATE students SET id = ?, first_name = ?, last_name = ?, address = ?, phone = ?, course = ?, birthdate = ? WHERE id = ?');
        $stmt->execute([$id, $first_name, $last_name,$address, $phone, $course, $birthdate, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the students from the students table
    $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $students = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$students) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
    <h2>Update Contact #<?=$students['id']?></h2>
    <form action="update.php?id=<?=$students['id']?>" method="post">
    <div class="input-group">
  <label for="first_name">First name:</label><br>
  <input type="text"  name="first_name"  value="<?=$students['first_name']?>"id="first_name"><br>
  </div>
  <div class="input-group">
  <label for="last_name">Last name:</label><br>
  <input type="text"  name="last_name"  value="<?=$students['last_name']?>"id="last_name"><br>
  </div>
  <div class="input-group">
  <label for="address">Address:</label><br>
  <input type="text"  name="address"  value="<?=$students['address']?>"id="address"><br>
  </div>
  <div class="input-group">
  <label for="course">Course:</label><br>
  <select id="course" name="course">
    <option value="bsit">Bachelor of Science in Information Technology (BSIT)</option>
    <option value="bscs">Bachelor of Science in Computer Science (BSCS)</option>
    <option value="bsda">Bachelor of Science in Data Analytics (BSDA)</option>
    <option value="blis">Bachelor of Library and Information Science (BLIS)</option>
  </select><br>
  </div>
  <div class="input-group">
  <label for="birthdate">Birthdate:</label><br>
  <input type="datetime-local" name="birthdate" value="<?=date('Y-m-d\TH:i', strtotime($students['birthdate']))?>" id="birthdate">
  <br>
  </div>
  <div class="input-group">
  <label for="phone">Contact Number:</label><br>
  <input type="tel" id="phone" name="phone"
     placeholder="0912-752-1972"
    pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}" value="<?=$students['phone']?>" id="phone">
  <br>
  </div>
  <div class="input-group">
  <label for="id">ID Number:</label><br>
  <input type="tel"  name="id"
     placeholder="19-2452-872"
    pattern="[0-9]{2}-[0-9]{4}-[0-9]{3}" value="<?=$students['id']?>" id="id"><br>
  <br>
  <div class="container">
  <input type="submit" value="Update"  class="submit-button">
  </div>
  <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>