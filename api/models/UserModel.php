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

        public static function registerUser($firstName, $lastName, $email, $phoneNumber, $password) {
            $sql = "SELECT COUNT(*) FROM User WHERE PhoneNumber = ".$phoneNumber;
            $res = self::$connection->query($sql);
            if($res->fetch_assoc()['COUNT(*)'] > 0){
                return ['success' => false, 'error' => 'User with this phone number already exists'];
            }
            $sql = "SELECT COUNT(*) FROM User WHERE Email = '".$email."'";

            $res = self::$connection->query($sql);
            if($res->fetch_assoc()['COUNT(*)'] > 0){
                return ['success' => false, 'error' => 'User with this email already exists'];
            }
            $query = "INSERT INTO User (FirstName, LastName, Email, PhoneNumber, Password) VALUES (?, ?, ?, ?, ?)";
            $stmt = self::$connection->prepare($query);
            
            if (!$stmt) {
                return ['success' => false, 'error' => 'Failed to prepare statement'];
            }
    
            // Hash the password before storing it
            $password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("sssss", $firstName, $lastName, $email, $phoneNumber, $password);    
            if ($stmt->execute()) {
                $stmt->close();
                return ['success' => true];
            } else {
                $error = $stmt->error;
                $stmt->close();
                return ['success' => false, 'error' => $error];
            }
        }
        
        public static function getUserDetailsWithPhoneNumber($phoneNumber){
        
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

        public static function loginUser($phoneNumber, $password) {
            $query = "SELECT * FROM User WHERE phoneNumber = ?";
            $stmt = self::$connection->prepare($query);

            if (!$stmt) {
                return ['success' => false, 'error' => 'Failed to prepare statement'];
            }

            $stmt->bind_param("s", $phoneNumber);
            $stmt->execute();

            //stores the result to the variable
            $result = $stmt->get_result();

            
            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $stmt->close();

                if (password_verify($password, $user['Password'])) {
                    return ['success' => true, 'user' => $user];
                } else {
                    return ['success' => false, 'error' => 'Invalid credentials'];
                }
            } else {
                $stmt->close();
                return ['success' => false, 'error' => 'User not found'];
            }
        }
    }
    
    UserModel::Initialize();
?>