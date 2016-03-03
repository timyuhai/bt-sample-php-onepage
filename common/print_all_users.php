<?php

require_once 'db.php';

$conn = DBUtil::conn();

$result = $conn->query('SELECT * FROM users');
 
echo '<table>';
foreach ($result as $row) {
	echo "<tr><td> {$row['email']} </td><td> {$row['bt_customer_id']}";
}
echo '</table>';
