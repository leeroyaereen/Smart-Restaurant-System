<?php
require_once "../../../config/constants.php";
header("Content-Type: application/javascript");
session_start();

// Check if user is logged in and set constants accordingly
$loggedIn = isset($_SESSION['phoneNumber']) && isset($_SESSION['firstName']) && isset($_SESSION['lastName']);
?>

const BASE_PATH = "<?php echo BASE_PATH; ?>";

// Check if the user is logged in and provide the appropriate values
<?php if ($loggedIn): ?>
    const user_isAuthenticated = TRUE;
<?php else: ?>
    const user_isAuthenticated = FALSE;
<?php endif; ?>
