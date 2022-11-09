<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;


$stmt = $pdo->prepare('SELECT * FROM students ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of students, this is so we can determine whether there should be a next and previous button
$num_students = $pdo->query('SELECT COUNT(*) FROM students')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
	<h2>List of Registered Students ID</h2>
	<table>
        <thead>
            <tr>
                <td>ID Number</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Address</td>
                <td>Phone Number</td>
                <td>Course</td>
                <td>Birthdate</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $students): ?>
            <tr>
                <td><?=$students['id']?></td>
                <td><?=$students['first_name']?></td>
                <td><?=$students['last_name']?></td>
                <td><?=$students['address']?></td>
                <td><?=$students['phone']?></td>
                <td><?=$students['course']?></td>
                <td><?=$students['birthdate']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$students['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$students['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_students): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>