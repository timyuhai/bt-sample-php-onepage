<?php
class DBUtil {
	public static function conn() {
		try {
		    /*** connect to SQLite database ***/
		    $dbh = new PDO('sqlite:../db.sqlite3', NULL, NULL, [
		    		PDO::ATTR_PERSISTENT => true
		    	]);
		    self::__initTables($dbh);
		    return $dbh;
	    }
		catch(PDOException $e) {
		    echo $e->getMessage();
	    }
	}	

	private static function __initTables($dbh) {
		$dbh->exec("CREATE TABLE IF NOT EXISTS users ( 
                    email TEXT PRIMARY KEY,
                    bt_customer_id TEXT)");
	}
}

// $conn = DBUtil::conn();

// $sql = "insert into users values (:email, :bt_customer_id)";
// $stmt = $conn->prepare($sql);

// $stmt->bindParam(':email', $email);

// $email = 'test@test2.com';
// $stmt->execute();

// // Select all data from file db messages table 
//     // $result = $conn->query('SELECT * FROM users');
 
//  // foreach ($result as $row)
//  //  	var_dump($row);


// $sql = 'SELECT * FROM users where email = :email';
// $stmt = $conn->prepare($sql);

// $email = 'test@test.com';
// $stmt->bindParam(':email', $email);

// $stmt->execute();

// echo '<hr>';

// $result = $stmt->fetch();
// var_dump($result);
// 	