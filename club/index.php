<?php
// Start the session
session_start();

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
    'password_error' => 'Please enter your password',
    'email_error' => 'Please enter your e-mail address',
    'invalid_password' =>'The password you entered was invalid',
    'invalid_email' =>'No account was found with this email',
    'other_error' => 'Oops! Something went wrong. Please try again later.',
    'login_credentials'=> 'Please fill in your credentials to login.',
    'Password' => 'Password',
    'Login' => 'Login',
    'Email' => 'Email',
    

    //
];

$german = [
    'password_error'=> 'Bitte geben Sie Ihr Passwort ein',
    'email_error' => 'Bitte geben Sie Ihre E-Mail-Adresse ein',
    'invalid_password' => 'Das von Ihnen eingegebene Passwort war ungültig',
    'invalid_email' => 'Mit dieser E-Mail wurde kein Konto gefunden',
    'other_error' => 'Hoppla! Etwas ist schief gelaufen. Bitte versuchen Sie es später noch einmal.',
    'login_credentials' => 'Bitte geben Sie Ihre Zugangsdaten ein, um sich anzumelden.',
    'Password' => 'Passwort',
    'Login' => 'Anmeldung',
    'Email' => 'Email',
    
    

];

// check session for selected langu and decide on the array to use
$lang = $_SESSION['lang'] == 'en' ? $english : $german;


// Include config file
require_once '../common/inc/database.php';

// Define variables and initialize with empty values
$email = $password = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $_SESSION['email_error'] = "Please enter your e-mail address.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $_SESSION['password_error'] = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($_SESSION['email_error']) && empty($_SESSION['password_error'])) {
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM clubs WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["cloggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            
                            // Redirect user to welcome page
                            header("location: ./dashboard/index.php");
                        } else {
                            // Display an error message if password is not valid
                            $_SESSION['invalid_password'] = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // Display an error message if email doesn't exist
                    $_SESSION['email_error'] = "No account found with that email.";
                }
            } else {
                $_SESSION['other_error'] = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <style>
         html, body {
            height: 85%;
        }
        body {
            font: 14px sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 0;
            padding-bottom: 0;
        }
        .wrapper {
            width: 360px;
            padding: 20px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
    <div>
            <!-- Language selection buttons -->
            <a href="?lang=en"><img style="margin: 10px;" width="40" src="../common/images/us.webp" alt="English"></a>
            <a href="?lang=de"><img style="margin: 10px;" width="40" src="../common/images/de.webp" alt="German"></a>
        </div>
        <!--  -->
        <h2>Club Sign In</h2>
        <p><?php echo $lang['login_credentials']; ?></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label><?php echo $lang['Email']; ?></label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <!--  -->
                <?php 
                    if(isset($_SESSION['invalid_email'])){
                        echo '<div class="alert alert-danger mt-3" role="alert">
                            '.$lang['invalid_email'].'
                        </div>';
                        unset($_SESSION['invalid_email']);
                    }
                ?>
                <!--  -->
            </div>    
            <div class="form-group">
                <label><?php echo $lang['Password']; ?></label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <!--  -->
                <?php 
                    if(isset($_SESSION['invalid_password'])){
                        echo '<div class="alert alert-danger mt-3" role="alert">
                            '.$lang['invalid_password'].'
                        </div>';
                        unset($_SESSION['invalid_password']);
                    }
                ?>
                <!--  -->
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="<?php echo $lang['Login']; ?>">
                <!--  -->
                <?php 
                    if(isset($_SESSION['other_error'])){
                        echo '<div class="alert alert-danger mt-3" role="alert">
                            '.$lang['other_error'].'
                        </div>';
                        unset($_SESSION['other_error']);
                    }
                ?>
                <!--  -->
            </div>
        </form>
    </div>    
    <!-- Bootstrap and jQuery libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>