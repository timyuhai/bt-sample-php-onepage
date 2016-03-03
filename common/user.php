<?
require_once 'db.php';

class User {
	public $email;
	public $bt_customer_id;

    public function __construct($email, $bt_customer_id=NULL) {
       $this->email = $email;
       $this->bt_customer_id = $bt_customer_id;
    }


	public static function create($user) {
		$conn = DBUtil::conn();
		$sql = "insert into users values (:email, :bt_customer_id)";
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':email', $user->email);

		$stmt->execute();

		return self::find($user->email);
	}

	public static function find($id) {
		$conn = DBUtil::conn();
	    $sql = 'SELECT * FROM users where email = :email';
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':email', $id);

		$stmt->execute();
		$result = $stmt->fetch();
		if ($result)
			return new User($result['email'], $result['bt_customer_id']);
	}

	public static function update($user) {
		$conn = DBUtil::conn();
	    $sql = 'update users set bt_customer_id = :bt_customer_id where email = :email';
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':email', $user->email);
		$stmt->bindParam(':bt_customer_id', $user->bt_customer_id);
		$stmt->execute();

		return self::find($user->email);
	}

	public static function all() {
		$conn = DBUtil::conn();
	    $sql = 'SELECT * FROM users';
		$stmt = $conn->prepare($sql);

		$stmt->execute();
		$result = $stmt->fetchAll();
		var_dump($result);
		if ($result)
			foreach ($result as $row) {
				var_dump($row);
				echo "<br>";
			}
	}

}