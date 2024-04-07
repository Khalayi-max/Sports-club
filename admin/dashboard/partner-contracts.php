<?php
session_start(); // Start the session.

// Check if the user is not logged in, then redirect to the login page.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php'); // Redirect to the login page.
    exit; // Stop further execution of the script.
}

// Include config file
require_once '../../common/inc/database.php';

$host = DB_SERVER;
$dbname = DB_NAME;
$user = DB_USERNAME;
$pass = DB_PASSWORD;

$id = 0;
$the_partner_email = '';
//
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetching contracts data
    $stmt = $pdo->query('SELECT * FROM contracts WHERE partner_id = ' . $id . ' ORDER BY id DESC');
    $contracts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // partner email
    $stmt = $pdo->query('SELECT email FROM partners WHERE id = '.$id.'');
    $stmt->execute();
    $partners_email = $stmt->fetch(PDO::FETCH_ASSOC);
    $the_partner_email = $partners_email['email'];

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
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
            <a class="nav-link" href="./index.php">Dashboard</a>
            <a class="nav-link" href="./advertising-spaces.php">Advertising Spaces</a>
            <a class="nav-link active" href="./partners.php">Partners</a>
            <a class="nav-link" href="./contracts.php">Contracts</a>
            <a class="nav-link" href="./open-contacts.php">Open Contacts</a>
            <a href="../logout.php" class="btn btn-danger">Sign Out</a>
        </nav>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <!--  -->
        <div class="container mt-5">
            <h2> Partner: <b> <?php echo ucfirst($the_partner_email); ?> </b> </h2>
           <div class="card mt-5">
            <!--  -->
            <div class="card-header">
                <h4> List of Contracts</h4>
            </div>
            <!--  -->
            <div class="card-body">
                <!--  -->
                <table class="table mt-5">
                    <thead>
                        <tr>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Partner Email</th>
                        <th scope="col">Advertising Space Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Note</th>
                        <th scope="col">Status</th>
                        <th scope="col">Last Modified</th>
                        </tr>
                    </thead>
                <tbody>
                    <tr>
                        <?php foreach ($contracts as $contract) { ?>
                            <td><?php echo $contract['start_date']; ?></td>
                            <td><?php echo $contract['end_date']; ?></td>
                            <td><?php echo $contract['partner_email']; ?></td>
                            <td><?php echo $contract['advertising_space_name']; ?></td>
                            <td><?php echo $contract['type']; ?></td>
                            <td><?php echo $contract['note']; ?></td>
                            <td><?php echo $contract['status']; ?></td>
                            <td><?php echo $contract['last_modified']; ?></td>
                        <?php } ?>
                    </tr>
                </tbody>
                </table>
                <!--  -->
            </div>
           </div>
        </div>
        <!--  -->
    </div>


<!-- include dash_footer -->
<?php include '../inc/dash_footer.php'; ?>