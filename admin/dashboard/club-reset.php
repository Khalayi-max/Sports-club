<?php
// Start a new session
session_start();

// Check if the user is not logged in, then redirect to the login page.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../index.php'); // Redirect to the login page.
    exit; // Stop further execution of the script.
}

// Default language is German
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'de';
}

// Language switch logic
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] == 'en' ? 'en' : 'de';
}

// Translation arrays
$english = [
    'title' => 'Admin Dashboard',
    'admin_title' => 'Reset a Club\'s Password',
    'dashboard_l' => 'Dashboard',
    'clubs_l' => 'Clubs',
    'addclubs_l' => 'Add New Clubs',
    'view_club' => 'View Club Overview',
    'logout' => 'Sign Out',
    'email' => 'Email Address',
    'password' => 'Password',
    'enter_email' => 'Enter Club\'s Email',
    'enter_password' => 'Enter Club\'s Password',
    'create_btn' => 'Reset Club Password',
    //
];

$german = [
    'title' => 'Admin Dashboard',
    'admin_title' => 'Club Passwort zurücksetzen',
    'dashboard_l' => 'Dashboard',
    'clubs_l' => 'Clubs',
    'addclubs_l' => 'Neue Clubs hinzufügen',
    'view_club' => 'Club Übersicht anzeigen',
    'logout' => 'Abmelden',
    'email' => 'E-Mail-Addresse',
    'password' => 'Passwort',
    'enter_email' => 'Geben Sie die E-Mail-Adresse des Clubs ein',
    'enter_password' => 'Geben Sie das Passwort des Clubs ein',
    'create_btn' => 'Club Passwort zurücksetzen', 
    //
];
//
// check session for selected langu and decide on the array to use
$lang = $_SESSION['lang'] == 'en' ? $english : $german;
//$lang["view_club"]
//

// Include database configuration
require_once '../../common/inc/database.php'; // Adjust the path as needed

// Check if reset form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $password = trim($password);

    // Create a connection to the database
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Assume new password is received from a form
    $newPassword = $password;

    // Hash the new password
    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

    // Prepare an update statement
    $sql = "UPDATE clubs SET password = ? WHERE email = ?";

    // Use prepared statements to prevent SQL Injection
    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ss", $passwordHash, $email);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $_SESSION['success'] = "Success! Password updated successfully. New Password is: $newPassword";
        } else {
            // echo "Error: " . $stmt->error;
            $_SESSION['error'] = "Error! Please try again later.";
        }

        // Close statement
        $stmt->close();
    } else {
        $_SESSION['error'] = "Error! Please try again later.";
    }

    // Close connection
    $conn->close();
} else {
    // echo "Invalid request";
    $_SESSION['error'] = "Please Fill and Submit the form.";
}
?>
<!-- Front End -->
<!-- include dash_header -->
<?php include '../inc/dash_header.php'; ?>

<div class="dashboard-wrap">
    <!-- Side Panel -->
    <style>
        .side-panel nav a{
            border-bottom: 1px solid #ccc;
        }
    </style>
    <div class="side-panel">
        <nav class="nav flex-column">
            <a class="nav-link" href="./index.php"><?php echo $lang["dashboard_l"]; ?></a>
            <a class="nav-link" href="./clubs.php"><?php echo $lang["clubs_l"]; ?></a>
            <a class="nav-link active" href="./add-club.php"><?php echo $lang["addclubs_l"]; ?></a>
            <a href="../logout.php" class="btn btn-danger"><?php echo $lang["logout"]; ?></a>
        </nav>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <!--  -->
        <div class="container mt-5">
            <h2><?php echo $lang["admin_title"]; ?></h2>
            <div class="card">
                <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="email"><?php echo $lang["email"]; ?>:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo $lang["enter_email"]; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd"><?php echo $lang["password"]; ?>:</label>
                        <input type="text" class="form-control" id="pwd" name="password" placeholder="<?php echo $lang["enter_password"]; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo $lang["create_btn"]; ?></button>
                </form>
                </div>
                <?php
                if (isset($_SESSION['error']))
                {
                    echo '<div class="card-footer">
                    <div class="alert alert-danger">
                    '.$_SESSION['error'].'
                    </div>
                    </div>';
                    // clear the message
                    unset($_SESSION['error']);
                }

                if (isset($_SESSION['success']))
                {
                    echo '<div class="card-footer">
                    <div class="alert alert-success">
                    '.$_SESSION['success'].'
                    </div>
                    </div>';
                    // clear the message
                    unset($_SESSION['success']);
                }
                ?>
            </div>
        </div>
        <!--  -->
    </div>
</div>

<!-- include dash_footer -->
<?php include '../inc/dash_footer.php'; ?>