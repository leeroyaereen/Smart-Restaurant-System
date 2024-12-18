<?php 
    require_once __DIR__.'/../../config/databaseConnector.php';
    use Src\Helpers\UserClass;

    class UserModel{
        private static $connection;

        // Constructor to fetch the connection
        public static function Initialize() {
            self::$connection = getConnection();
            if (!self::$connection) {
                self::$connection = changeDatabaseConnection('ACHS canteen');
                if (!self::$connection) {
                    return 'no connection';
                }
            }
        }

        public function registerUser($firstName, $lastName, $email, $phoneNumber, $password) {
            $query = "INSERT INTO User (FirstName, LastName, Email, PhoneNumber, Password) VALUES (?, ?, ?, ?, ?)";
            $stmt = self::$connection->prepare($query); // Prepare the query
        
            if (!$stmt) {
                // Handle preparation error
                return false;
            }

            // Hash the password before storing it in the database
            $password = password_hash($password, PASSWORD_DEFAULT);
        
            // Bind the parameters to the placeholders in the query
            $stmt->bind_param("sssss", $firstName, $lastName, $email, $phoneNumber, $password);
        
            // Execute the prepared statement
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
        public function getUserDetailsWithPhoneNumber($phoneNumber){
        
            $query = "SELECT * FROM User WHERE phoneNumber = ?";
            $stmt = self::$connection->prepare($query);
            if (!$stmt) {
                return null; // Returns null to indicate failure in retrieving data
            }
        
            // Bind parameters and execute the query
            $stmt->bind_param("s", $phoneNumber);
            $stmt->execute();
        
            // Fetch the result
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0){
                $user = $result->fetch_assoc();
                return new UserClass($user['FirstName'],$user['LastName'],$user['Email'],$user['PhoneNumber'],$user['Password'],$user['Password']);
            }else{
                return null;
            }
        }

        public function loginUser($phoneNumber, $password) {
            // Use prepared statements to prevent SQL injection
            $query = "SELECT * FROM User WHERE phoneNumber = ?";
            $stmt = self::$connection->prepare($query);
            if (!$stmt) {
                return false; // Return false if the statement fails to prepare
            }
        
            // Bind parameters and execute the query
            $stmt->bind_param("s", $phoneNumber);
            $stmt->execute();
        
            // Fetch the result
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
        
                // Verify the password
                if ($password === $user['Password']) {
                    return $user; // Return user data on successful login
                } else {
                    return false; // Password mismatch
                }
            } else {
                return false; // No matching user found
            }
        }


    }
    UserModel::Initialize();
?>