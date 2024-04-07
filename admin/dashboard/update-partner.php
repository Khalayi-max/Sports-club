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

    // Fetching data from 'partners' table
    $stmt = $pdo->query('SELECT * FROM partners');
    $partners = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
//
// Update data on database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $company_name = $_POST['company_name'];
    $contact_person = $_POST['contact_person'];
    $address = $_POST['address'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    // $club_id = $_POST['club_id'];

    // Prepare an update statement
    $stmt = $pdo->prepare("UPDATE partners SET company_name = ?, contact_person = ?, address = ?, telephone = ?, email = ? WHERE id = ?");
    $stmt->execute([$company_name, $contact_person, $address, $telephone, $email, $id]);

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
            <a class="nav-link active" href="./update-partner.php">Update Partner</a>
            <a class="nav-link" href="./add-club.php">Add New Clubs</a>
            <a href="../logout.php" class="btn btn-danger">Sign Out</a>
        </nav>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <!--  -->
        <div class="container mt-5">
            <h2>Edit Partner</h2>
            <?php
            // Assuming you have a PDO connection $pdo
            $partnerId = $_GET['id']; // Get the partner ID from URL
            $stmt = $pdo->prepare("SELECT * FROM partners WHERE id = ?");
            $stmt->execute([$partnerId]);
            $partner = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($partner) {
                // Display the form with partner's data
            ?>
                <div class="card mt-3">
                    <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($partner['id']); ?>">

                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo htmlspecialchars($partner['company_name']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="contact_person">Contact Person</label>
                            <input type="text" class="form-control" id="contact_person" name="contact_person" value="<?php echo htmlspecialchars($partner['contact_person']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($partner['address']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="telephone">Telephone</label>
                            <input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo htmlspecialchars($partner['telephone']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($partner['email']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-success">Update Partner Details</button>
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