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
    'password_error' => 'Please enter your password',
    'email_error' => 'Please enter your e-mail address',
    'invalid_password' =>'The password you entered was invalid',
    'invalid_email' =>'No account was found with this email',
    'other_error' => 'Oops! Something went wrong. Please try again later.',
    'login_credentials'=> 'Please fill in your credentials to login.',
    'Password' => 'Password',
    'Login' => 'Login',
    'Email' => 'Email',
    'Dashboard Overview' => 'Dashboard Overview',
    'Welcome' => 'Welcome',
    'Total Members' => 'Total Members',
    'New' => 'New This Month',
    'Hello,' => 'Hello,',
    'Sign Out' => 'Sign Out',
    'Logged in as:' => 'Logged in as:',
    'Advertising Space' => 'Advertising Space',
    'Add Advertising Spaces' => 'Add Advertising Spaces',
    'Advertising Space Name' => 'Advertising Space Name',
    'Unit' => 'Unit', 
    'Number' => 'Number',
    'Price/unit' => 'Price/unit',
    'Inventory-Value' => 'Inventory-Value',
    'Sold' => 'Sold', 
    'Workload' => 'Workload',
    'Value sold' => 'Value Sold',
    'Proceeds' => 'Proceeds',
    'Edit' => 'Edit', 
    'Delete' => 'Delete',
    'Advertising spaces - volume' => 'Advertising spaces - volume', 
    'Close' => 'Close',
    'Add Partner' => 'Add Partner',
    'List of all Partners' => 'List of all Partners',
    'Add New Partner' => 'Add New Partner', 
    'Company Name' => 'Company Name',
    'Contact Person' => 'Contact Person',
    'Address' => 'Address',
    'Telephone' => 'Telephone', 
    'Contracts' => 'Contracts',
    'Update' => 'Update',
    'My Contracts' => 'My Contracts',
    'Add a new contract' => 'Add a new contract',
    'Add New Contract' => 'Add New Contract',
    'Type of Contract' => 'Type of Contract',
    "what's the type of this contract?" => "what's the type of this contract?",
    'Duration Start' => 'Duration Start',
    'Duration End' => 'Duration End',
    'Partner Email' => 'Partner Email', 
    'Contract Status' => 'Contract Status',
    'Pending' => 'Pending',
    'Note' => 'Note',
    'Key notes related to this contract' => 'Key notes related to this contract', 
    'Create Contract' => 'Create Contract',
    'Active' => 'Active',
    'Inactive' => 'Inactive', 
    'Open Contacts' => 'Open Contacts',
    'Partners' => 'Partners', 
    'Advertising Spaces' => 'Advertising Spaces',
    'Dashboard' => 'Dashboard',
    'The Contract was added successfully.' => 'The Contract was added successfully.',
    'success' => 'The Contract updated successfully!',
    'Update Contract Details' => 'Update Contract Details',
    'Edit Contract' => 'Edit Contract',
    'Partner not found.' => 'Partner not found.',
  
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
    'Dashboard Overview' => 'Dashboard-Übersicht',
    'Welcome' => 'Willkommen',
    'stats' => 'Statistiken zur Clubmitgliedschaft',
    'Total Members' => 'Gesamtzahl der Mitglieder',
    'New' => 'Neu in diesem Monat',
    'Hello,' => 'Hallo,',
    'Sign Out' => 'Abmelden',
    'Logged in as:' => 'Angemeldet als:',
    'Advertising Space' => 'Platz für Werbung',
    'Add Advertising Spaces' => 'Werbeflächen hinzufügen',
    'Advertising Space Name' => 'Name der Werbefläche',
    'Unit' => 'Einheit', 
    'Number' => 'Nummer',
    'Price/unit' => 'Preis/einheit',
    'Inventory-Value' => 'Inventarwert',
    'Sold' => 'Verkauft', 
    'Workload' => 'Arbeitsbelastung',
    'Value sold' => 'Verkaufswert',
    'Proceeds' => 'Erlös',
    'Edit' => 'Bearbeiten', 
    'Delete' => 'Löschen',
    'Advertising spaces - volume' => 'Werbeflächen – Volumen',
    'Close' => 'Schließen', 
    'Add Partner' => 'Partner hinzufügen',
    'List of all Partners' => 'Liste aller Partner',
    'Add New Partner' => 'Neuen Partner hinzufügen', 
    'Company Name' => 'Name der Firma',
    'Contact Person' => 'Ansprechpartner',
    'Address' => 'Adresse',
    'Telephone' => 'Telefon', 
    'Contracts' => 'Verträge',
    'Update' => 'Aktualisieren',
    'My Contracts' => 'Meine Verträge',
    'Add a new contract' => 'Fügen Sie einen neuen Vertrag hinzu', 
    'Add New Contract' => 'Neuen Vertrag hinzufügen',
    'Type of Contract' => 'Vertragsart',
    "what's the type of this contract?" => "Um welche Art von Vertrag handelt es sich?",
    'Duration Start' => 'Dauer Beginn',
    'Duration End' => 'Dauer Ende',
    'Partner Email' => 'Partner-E-Mail', 
    'Contract Status' => 'Vertragsstatus',
    'Pending' => 'Ausstehend',
    'Note' => 'Notiz',
    'Key notes related to this contract' => 'Wichtige Anmerkungen zu diesem Vertrag', 
    'Create Contract' => 'Vertrag erstellen',
    'Active' => 'Aktiv',
    'Inactive' => 'Inaktiv',
    'Open Contacts' => 'Öffnen Sie Kontakte',
    'Partners' => 'Partner', 
    'Advertising Spaces' => 'Werbeflächen',
    'Dashboard' => 'Dashboard',
    'The Contract was added successfully.' => 'Der Vertrag wurde erfolgreich hinzugefügt.',
    'success' => 'Der Vertrag wurde erfolgreich aktualisiert!',
    'Edit Contract' => 'Vertrag bearbeiten',
    'Partner not found.' => 'Partner nicht gefunden.',
    'Update Contract Details' => 'Vertragsdetails aktualisieren',

  
  ];
  
  // check session for selected langu and decide on the array to use
  $lang = $_SESSION['lang'] == 'en' ? $english : $german;

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

    $_SESSION['success'] = $lang['The Contract updated successfully!'];

    // Redirect back to the partners list or display a success message
    header("Location: ./contracts.php");
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
            <a class="nav-link" href="./index.php"><?php echo $lang['Dashboard']; ?></a>
            <a class="nav-link" href="./advertising-spaces.php"><?php echo $lang['Advertising Spaces']; ?></a>
            <a class="nav-link" href="./partners.php"><?php echo $lang['Partners']; ?></a>
            <a class="nav-link active" href="./contracts.php"><?php echo $lang['Contracts']; ?></a>
            <a class="nav-link" href="./open-contacts.php"><?php echo $lang['Open Contacts']; ?></a>
            <a href="../logout.php" class="btn btn-danger"><?php echo $lang['Sign Out']; ?></a>
        </nav>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <!--  -->
        <div class="container mt-5">
            <h2><?php echo $lang['Edit Contract']; ?></h2>
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
                        <label for="partnerId"><?php echo $lang['Advertising Space']; ?></label>
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
                        <label for="type"><?php echo $lang['Type of Contract']; ?></label>
                        <input type="text" class="form-control" id="type" placeholder="<?php echo $lang["what's the type of this contract?"]; ?>" value="<?php echo htmlspecialchars($contract['type']); ?>" name="type" required>
                    </div>

                    <div class="form-group">
                        <label for="durationStart"><?php echo $lang['Duration Start']; ?></label>
                        <input type="date" class="form-control" id="durationStart" value="<?php echo htmlspecialchars($contract['start_date']); ?>" name="duration_start" required>
                    </div>

                    <div class="form-group">
                        <label for="durationEnd"><?php echo $lang['Duration End']; ?></label>
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
                    <!--  -->
                    <div class="form-group">
                        <label for="contract-status"><?php echo $lang['Contract Status']; ?></label>
                        <?php
                            // get current status of this contract
                            $stmt = $pdo->prepare('SELECT status FROM contracts WHERE id = ?');
                            $stmt->execute([$contractId]);
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            $contract_status = $result['status']; // Assuming 'status' is the column name
                        ?>
                        <select class="form-control" id="contract-status" name="contract-status" required>
                            <option value="Pending" <?php echo ($contract_status == 'Pending') ? 'selected' : ''; ?>><?php echo $lang['Pending']; ?></option>
                            <option value="Active" <?php echo ($contract_status == 'Active') ? 'selected' : ''; ?>><?php echo $lang['Active']; ?></option>
                            <option value="Inactive" <?php echo ($contract_status == 'Inactive') ? 'selected' : ''; ?>><?php echo $lang['Inactive']; ?></option>
                        </select>
                    </div>
                    <!--  -->

                    <div class="form-group">
                        <label for="note"><?php echo $lang['Note']; ?></label>
                        <input type="text" class="form-control" id="note" placeholder="<?php echo $lang['Key notes related to this contract']; ?>" value="<?php echo htmlspecialchars($contract['note']); ?>" name="note" required>
                    </div>

                        <button type="submit" class="btn btn-success"><?php echo $lang['Update Contract Details']; ?></button>
                    </form>
                    </div>
                </div>
            <?php
            } else {
                echo "<p><?php echo $lang['Partner not found.']; ?></p>";
            }
            ?>
        </div>
        <!--  -->
    </div>


<!-- include dash_footer -->
<?php include '../inc/dash_footer.php'; ?>