<?php
// session
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
    'admin_title' => 'Dashboard Overview',
    'welcome' => 'Welcome',
    'dashboard_l' => 'Dashboard',
    'clubs_l' => 'Clubs',
    'addclubs_l' => 'Add New Clubs',
    'total_clubs' => 'Total Clubs',
    'logout' => 'Sign Out',
    //
];

$german = [
    'title' => 'Admin Dashboard',
    'admin_title' => 'Dashboard Übersicht',
    'welcome' => 'Willkommen',
    'dashboard_l' => 'Dashboard',
    'clubs_l' => 'Clubs',
    'addclubs_l' => 'Neue Clubs hinzufügen',
    'total_clubs' => 'Gesamtvereine',
    'logout' => 'Abmelden',
    //
];
//
// check session for selected langu and decide on the array to use
$lang = $_SESSION['lang'] == 'en' ? $english : $german;

// Include config file
require_once '../../common/inc/database.php';

$host = DB_SERVER;
$dbname = DB_NAME;
$user = DB_USERNAME;
$pass = DB_PASSWORD;
//
$clubs_count = 0;
// count clubs
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Prepare a SELECT statement to count advertising spaces
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM clubs");
    $stmt->execute();

    // Fetch the count result
    $count = $stmt->fetchColumn();

    $clubs_count = $count;

} catch (PDOException $e) {
    // Handle any errors
    $_SESSION['error'] = 'Connection failed: ' . $e->getMessage();
}
//
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
        <nav class="nav flex-column">
            <!--  -->
        <div>
            <!-- Language selection buttons -->
            <a href="?lang=en"><img style="margin: 10px;" width="40" src="../../common/images/us.webp" alt="English"></a>
            <a href="?lang=de"><img style="margin: 10px;" width="40" src="../../common/images/de.webp" alt="German"></a>
        </div>
        <!--  -->
            <a class="nav-link active" href="./index.php"><?php echo $lang['dashboard_l']; ?></a>
            <a class="nav-link" href="./clubs.php"><?php echo $lang['clubs_l']; ?></a>
            <a class="nav-link" href="./add-club.php"><?php echo $lang['addclubs_l']; ?></a>
            <a href="./club-reset.php" class="btn btn-warning">Club Password Reset</a>
            <a href="../logout.php" class="btn btn-danger mt-2"><?php echo $lang['logout']; ?></a>
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
            <h2 class="mt-4"><?php echo $lang['admin_title']; ?></h2>
            <p><?php echo $lang['welcome']; ?> <?php echo $_SESSION["email"]; ?></p>
        </div>
        <!--  -->
            <div class="card-body">
                <div class="container mt-4">
                <div class="circle-container">
                    <div class="mb-4">
                        <div class="circle1"><?php echo $clubs_count; ?></div>
                        <h3 class="circle-heading"><?php echo $lang['total_clubs']; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- -->
    <div class="card mt-3">
        <div class="card-body">
        </div>
    </div>
    <!--  -->
</div>
    </div>
</div>

<!-- include dash_footer -->
<?php include '../inc/dash_footer.php'; ?>