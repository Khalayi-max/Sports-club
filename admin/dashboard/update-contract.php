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

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetching data from contracts
    // $stmt = $pdo->query('SELECT * FROM contracts');
    // $contracts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // fetch advertising spaces for this club
    $stmt = $pdo->prepare('SELECT * FROM advertising_spaces WHERE club_id = ?');
    $stmt->execute([$_SESSION['id']]);
    $advertising_spaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare('SELECT * FROM partners WHERE club_id = ?');
    $stmt->execute([$_SESSION['id']]);
    $partners = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    //echo 'Connection failed: ' . $e->getMessage();
    $_SESSION['error'] = 'Connection failed: ' . $e->getMessage();
}
//
// Update data on database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $advertising_space_id = trim($_POST['advertising_space_id']);

    // get advertising space name using advertising_space_id
    $stmt = $pdo->prepare('SELECT advertising_space_name FROM advertising_spaces WHERE id = ?');
    $stmt->execute([$advertising_space_id]);
    $advertising_space_name = $stmt->fetch(PDO::FETCH_ASSOC);

    $type = trim($_POST['type']);
    $duration_start = trim($_POST['duration_start']);
    $duration_end = trim($_POST['duration_end']);
    $partner_id = trim($_POST['partner_id']);

    // get partner email using partner_id
    $stmt = $pdo->prepare('SELECT email FROM partners WHERE id = ?');
    $stmt->execute([$partner_id]);
    $partner_email = $stmt->fetch(PDO::FETCH_ASSOC);

    $note = trim($_POST['note']);
    $status = trim($_POST['contract-status']);

    // Prepare an update statement
    $stmt = $pdo->prepare("UPDATE contracts SET 
        start_date = ?, 
        end_date = ?, 
        partner_id = ?, 
        partner_email = ?, 
        advertising_space_id = ?, 
        advertising_space_name = ?, 
        type = ?, 
        note = ?, 
        status = ? 
        WHERE id = ?");

    $stmt->execute([
        $duration_start, 
        $duration_end, 
        $partner_id, 
        $partner_email, 
        $advertising_space_id, 
        $advertising_space_name, 
        $type, 
        $note, 
        $status, 
        $id
    ]);

    $_SESSION['success'] = 'The Contract updated successfully!';

    // Redirect back to the partners list or display a success message
    header("Location: ./clubs.php"); // ! find a way to go back to club overview
    exit;
}
// End of Update data on database
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
            <a class="nav-link" href="./clubs.php">Clubs</a>
            <a class="nav-link active" href="./update-contract.php">Update Contract</a>
            <a class="nav-link" href="./add-club.php">Add New Clubs</a>
            <a href="../logout.php" class="btn btn-danger">Sign Out</a>
        </nav>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <!--  -->
        <div class="container mt-5">
            <h2>Edit Contract</h2>
            <?php
            // Assuming you have a PDO connection $pdo
            $contractId = $_GET['id']; // Get the partner ID from URL
            $stmt = $pdo->prepare("SELECT * FROM contracts WHERE id = ?");
            $stmt->execute([$contractId]);
            $contract = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($contract) {
                // Display the form with partner's data
            ?>
                <div class="card mt-3">
                    <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($contract['id']); ?>">

                        <div class="form-group">
                        <label for="partnerId">Advertising Space</label>
                        <select class="form-control" id="partnerId" name="partner_id" required>
                            <?php
                            // Assuming $partners contains data from the partners table
                            foreach ($advertising_spaces as $advertising_space) {
                                echo '<option value="' . htmlspecialchars($advertising_space['id']) . '">' . htmlspecialchars($advertising_space['advertising_space_name']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="type">Type of Contract</label>
                        <input type="text" class="form-control" id="type" placeholder="what's the type of this contract?" value="<?php echo htmlspecialchars($contract['type']); ?>" name="type" required>
                    </div>

                    <div class="form-group">
                        <label for="durationStart">Duration Start</label>
                        <input type="date" class="form-control" id="durationStart" value="<?php echo htmlspecialchars($contract['start_date']); ?>" name="duration_start" required>
                    </div>

                    <div class="form-group">
                        <label for="durationEnd">Duration End</label>
                        <input type="date" class="form-control" id="durationEnd" value="<?php echo htmlspecialchars($contract['end_date']); ?>" name="duration_end" required>
                    </div>

                    <div class="form-group">
                        <label for="partnerId">Partner Email</label>
                        <select class="form-control" id="partnerId" name="partner_id" required>
                            <?php
                            // Assuming $partners contains data from the partners table
                            foreach ($partners as $partner) {
                                echo '<option value="' . htmlspecialchars($partner['id']) . '">' . htmlspecialchars($partner['email']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="contract-status">Contract Status</label>
                        <!-- ! update this -->
                        <select class="form-control" id="contract-status" name="contract-status" value="<?php 
                        echo htmlspecialchars($contract['status']);  // ! update this to show current selected status
                        ?>" required>
                            <option value="Pending">Pending</option>    
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="note">Note</label>
                        <input type="text" class="form-control" id="note" placeholder="Key notes related to this contract" value="<?php echo htmlspecialchars($contract['note']); ?>" name="note" required>
                    </div>

                        <button type="submit" class="btn btn-success">Update Contract Details</button>
                    </form>
                    </div>
                </div>
            <?php
            } else {
                echo "<p>Partner not found.</p>";
            }
            ?>
        </div>
        <!--  -->
    </div>


<!-- include dash_footer -->
<?php include '../inc/dash_footer.php'; ?>