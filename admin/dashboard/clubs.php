<?php
// session
session_start();

// Check if the user is not logged in, then redirect to the login page.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../index.php'); // Redirect to the login page.
    exit; // Stop further execution of the script.
}
//
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
    'admin_title' => 'List of all Clubs',
    'dashboard_l' => 'Dashboard',
    'clubs_l' => 'Clubs',
    'addclubs_l' => 'Add New Clubs',
    'view_club' => 'Club Overview',
    'logout' => 'Sign Out',
    //
];

$german = [
    'title' => 'Admin Dashboard',
    'admin_title' => 'Liste aller Clubs',
    'dashboard_l' => 'Dashboard',
    'clubs_l' => 'Clubs',
    'addclubs_l' => 'Neue Clubs hinzufügen',
    'view_club' => 'Club Übersicht',
    'logout' => 'Abmelden',
    //
];
//
// check session for selected langu and decide on the array to use
$lang = $_SESSION['lang'] == 'en' ? $english : $german;
//$lang["view_club"]
//

// Include config file
require_once '../../common/inc/database.php';

$host = DB_SERVER;
$dbname = DB_NAME;
$user = DB_USERNAME;
$pass = DB_PASSWORD;

// Getting All Contracts
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // fetch all clubs
    $stmt = $pdo->prepare('SELECT * FROM clubs');
    $stmt->execute();
    $clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
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
        <nav class="nav flex-column">
            <a class="nav-link" href="./index.php"><?php echo $lang['dashboard_l']; ?></a>
            <a class="nav-link active" href="./clubs.php"><?php echo $lang['clubs_l']; ?></a>
            <a class="nav-link" href="./add-club.php"><?php echo $lang['addclubs_l']; ?></a>
            <a href="../logout.php" class="btn btn-danger"><?php echo $lang['logout']; ?></a>
        </nav>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <!--  -->
        <h2> <?php echo $lang['admin_title']; ?></h2>
        <hr>
        <div class="container-fluid mt-5">
        <div class="row">
            <!--  -->
            <?php 
                if (empty($clubs)) {
                    echo '<div class="alert alert-warning" role="alert">There are No clubs available yet. Click <a href="./add-club.php">here</a> to add some.</div>';
                } else {
                    $count = 1;
                    foreach ($clubs as $club) { 
                        echo '
                        <div class="col-md-4 col-lg-3 mb-4">
                            <div class="card">
                                <div class="card-header" style="background-color: orangered; color: white;">
                                    Name: '. $club['clubName'].'
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Email: '.$club['email'].'</p>
                                    <img height="100px" src="../../assets/images/'.$club['clubImagePath'].'" alt="club logo" class="img-fluid">
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="./view-club.php?id='.$club['id'].'" class="btn btn-primary btn-block">'.$lang['view_club'].'</a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="./edit-club.php?id='.$club['id'].'" class="btn btn-warning btn-block">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                        $count++;
                    }
                }
            ?>
            <!-- end of php -->
            </div>
        </div>
        <!--  -->
    </div>
</div>

<!-- include dash_footer -->
<?php include '../inc/dash_footer.php'; ?>