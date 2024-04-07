<?php
session_start(); // Start the session.

// Check if the user is not logged in, then redirect to the login page.
if (!isset($_SESSION['cloggedin']) || $_SESSION['cloggedin'] !== true) {
    header('Location: index.php'); // Redirect to the login page.
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
    
    'Password' => 'Password',
    'Login' => 'Login',
    'Email' => 'Email',
    'Dashboard Overview' => 'Dashboard Overview',
    'Welcome' => 'Welcome',
    'Total Members' => 'Total Members',
    'New' => 'New This Month',
    'Hello,' => 'Hello,',
    'Sign Out' => 'Sign Out',
    'Open Contacts' => 'Open Contacts',
    'Partners' => 'Partners', 
    'Advertising Spaces' => 'Advertising Spaces',
    'Dashboard' => 'Dashboard',
    'Contracts' => 'Contracts',
    '' => '',
    

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
    'Contracts' => 'Verträge',
    'Login' => 'Anmeldung',
    'Email' => 'Email',
    'Dashboard Overview' => 'Dashboard-Übersicht',
    'Welcome' => 'Willkommen',
    'stats' => 'Statistiken zur Clubmitgliedschaft',
    'Total Members' => 'Gesamtzahl der Mitglieder',
    'New' => 'Neu in diesem Monat',
    'Hello,' => 'Hallo,',
    'Sign Out' => 'Abmelden',
    'Open Contacts' => 'Öffnen Sie Kontakte',
    'Partners' => 'Partner', 
    'Advertising Spaces' => 'Werbeflächen',
    'Dashboard' => 'Dashboard',
    '' => '',
    '' => '',

];

// check session for selected langu and decide on the array to use
$lang = $_SESSION['lang'] == 'en' ? $english : $german;



// Include config file
require_once '../../common/inc/database.php';

$host = DB_SERVER;
$dbname = DB_NAME;
$user = DB_USERNAME;
$pass = DB_PASSWORD;

$partner_count = 0;
$advertising_spaces_count = 0;
$contracts_count = 0;
$open_contacts_count = 0;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    //echo 'Connection failed: ' . $e->getMessage();
    $_SESSION['error'] = 'Connection failed: ' . $e->getMessage();
}
// Count partners
try {
    // Prepare a SELECT statement to count partners
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM partners WHERE club_id = ?");
    $stmt->execute([$_SESSION['id']]);

    // Fetch the count result
    $count = $stmt->fetchColumn();

    $partner_count = $count;

} catch (PDOException $e) {
    // Handle any errors
    $_SESSION['error'] = 'Connection failed: ' . $e->getMessage();
}
// count advertising spaces
try {
    // Prepare a SELECT statement to count advertising spaces
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM advertising_spaces WHERE club_id = ?");
    $stmt->execute([$_SESSION['id']]);

    // Fetch the count result
    $count = $stmt->fetchColumn();

    $advertising_spaces_count = $count;

} catch (PDOException $e) {
    // Handle any errors
    $_SESSION['error'] = 'Connection failed: ' . $e->getMessage();
}
// count contracts
try {
    // Prepare a SELECT statement to count contracts
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM contracts WHERE club_id = ?");
    $stmt->execute([$_SESSION['id']]);

    // Fetch the count result
    $count = $stmt->fetchColumn();

    $contracts_count = $count;

} catch (PDOException $e) {
    // Handle any errors
    $_SESSION['error'] = 'Connection failed: ' . $e->getMessage();
}
//
// Count Open Contacts
try {
    // Prepare a SELECT statement to count open contacts
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM open_contacts WHERE club_id = ?");
    $stmt->execute([$_SESSION['id']]);

    // Fetch the count result
    $count = $stmt->fetchColumn();

    $open_contacts_count = $count;

} catch (PDOException $e) {
    // Handle any errors
    $_SESSION['error'] = 'Connection failed: ' . $e->getMessage();
}
?>
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

    <h6><?php echo $lang['Hello,']; ?>  <?php echo $_SESSION['email']; ?></h6>
    <hr>

        <nav class="nav flex-column">
            <a class="nav-link active" href="./index.php"><?php echo $lang['Dashboard']; ?></a>
            <a class="nav-link" href="./advertising-spaces.php"><?php echo $lang['Advertising Spaces']; ?></a>
            <a class="nav-link" href="./partners.php"><?php echo $lang['Partners']; ?></a>
            <a class="nav-link" href="./contracts.php"><?php echo $lang['Contracts']; ?></a>
            <a class="nav-link" href="./open-contacts.php"><?php echo $lang['Open Contacts']; ?></a>
            <a href="../logout.php" class="btn btn-danger"><?php echo $lang['Sign Out']; ?></a>
        </nav>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
    <div class="main dashboard">
    <!--  -->
    <style>
        .circle-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 1rem;
        }
        .circle1 {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: lightBlue;
            color: white;
            margin: 0 auto; /* Centers the circle in the flex container */
            font-size: 2.0rem;
        }

        .circle2 {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: grey;
            color: white;
            margin: 0 auto; /* Centers the circle in the flex container */
            font-size: 2.0rem;
        }

        .circle3 {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: orangered;
            color: white;
            margin: 0 auto; /* Centers the circle in the flex container */
            font-size: 2.0rem;
        }

        .circle4 {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: green;
            color: white;
            margin: 0 auto; /* Centers the circle in the flex container */
            font-size: 2.0rem;
        }
        .circle-heading {
            text-align: center;
            margin-top: 0.5rem;
        }
        /* Responsive sizing */
        @media (max-width: 768px) {
            .circle {
                width: 80px;
                height: 80px;
                font-size: 1.2rem;
            }
        }
    </style>
    <!--  -->
    <div class="card">
        <div class="card-header">
            <h2 class="mt-4"><?php echo $lang['Dashboard Overview']; ?></h2>
            <p><?php echo $lang['Welcome']; ?> <?php echo $_SESSION["email"]; ?></p>
        </div>
        <!--  -->
            <div class="card-body">
                <div class="container mt-4">
                <div class="circle-container">
                    <div class="mb-4">
                        <div class="circle1"><?php echo $advertising_spaces_count; ?></div>
                        <h3 class="circle-heading"><?php echo $lang['Advertising Spaces']; ?></h3>
                    </div>
                    <div class="mb-4">
                        <div class="circle2"><?php echo $partner_count; ?></div>
                        <h3 class="circle-heading"><?php echo $lang['Partners']; ?></h3>
                    </div>
                    <div class="mb-4">
                        <div class="circle3"><?php echo $contracts_count; ?></div>
                        <h3 class="circle-heading"><?php echo $lang['Contracts']; ?></h3>
                    </div>
                    <div class="mb-4">
                        <div class="circle4"><?php echo $open_contacts_count; ?></div>
                        <h3 class="circle-heading"><?php echo $lang['Open Contacts']; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- -->
    <div class="card mt-3">
        <div class="card-body">
            <!-- Club Membership Stats -->
            <div class="row">
                <div class="col-md-4 d-flex justify-content-center align-items-center">
                    <h4><?php echo $lang['stats']; ?></h4>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center" style="background-color:lightgrey;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $lang['Total Members']; ?></h5>
                            <h5 class="card-text"><b> 452 </b></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center" style="background-color:#b2bec3;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $lang['New']; ?></h5>
                            <h5 class="card-text"><b> 15 </b></h5>
                        </div>
                    </div>
                </div>
                <!-- ... More cards ... -->
            </div>
        <!--  -->
        </div>
    </div>
    <!--  -->
</div>
    </div>
</div>

<!-- include dash_footer -->
<?php include '../inc/dash_footer.php'; ?>