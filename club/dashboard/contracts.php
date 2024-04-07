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
    'The Contract was added successfully.' => 'The Contract was added successfully.'
  
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
    'The Contract was added successfully.' => 'Der Vertrag wurde erfolgreich hinzugefügt.'
    
  
  ];
  
  // check session for selected langu and decide on the array to use
  $lang = $_SESSION['lang'] == 'en' ? $english : $german;

  
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

    // fetch partners for this club
    $stmt = $pdo->prepare('SELECT * FROM partners WHERE club_id = ?');
    $stmt->execute([$_SESSION['id']]);
    $partners = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // fetch advertising spaces for this club
    $stmt = $pdo->prepare('SELECT * FROM advertising_spaces WHERE club_id = ?');
    $stmt->execute([$_SESSION['id']]);
    $advertising_spaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // fetch contracts for this club
    $stmt = $pdo->prepare('SELECT * FROM contracts WHERE club_id = ?');
    $stmt->execute([$_SESSION['id']]);
    $contracts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    //echo 'Connection failed: ' . $e->getMessage();
    $_SESSION['error'] = 'Connection failed: ' . $e->getMessage();
}
// End of Getting All Contracts

// Creating new Contracts
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_contract'])) {
    // Retrieve form data
    $advertising_space_id = trim($_POST['advertising_space_id']);

    // get advertising space name using advertising_space_id
    $stmt = $pdo->prepare('SELECT advertising_space_name FROM advertising_spaces WHERE id = ?');
    $stmt->execute([$advertising_space_id]);
    $advertising_space_name = $stmt->fetch(PDO::FETCH_ASSOC);
    $ad_space_name = $advertising_space_name['advertising_space_name'];

    $type = trim($_POST['type']);
    $duration_start = trim($_POST['duration_start']);
    $duration_end = trim($_POST['duration_end']);
    $partner_id = trim($_POST['partner_id']);

    // get partner email using partner_id
    $stmt = $pdo->prepare('SELECT email FROM partners WHERE id = ?');
    $stmt->execute([$partner_id]);
    $partner_email = $stmt->fetch(PDO::FETCH_ASSOC);
    $p_email = $partner_email['email'];

    $note = trim($_POST['note']);
    $status = trim($_POST['contract-status']);
    $club_id = $_SESSION['id'];

    // Prepare an INSERT statement
    $sql = "INSERT INTO contracts (start_date, end_date, club_id, partner_id, partner_email, advertising_space_id, advertising_space_name, type, note, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // in the advertising table, add 1 to the sold
    $stmt2 = $pdo->prepare('UPDATE advertising_spaces SET sold = sold + 1 WHERE id = ?');
    $stmt2->execute([$advertising_space_id]);

    // get price per_unit for this advertising space
    $stmt3 = $pdo->prepare('SELECT price_unit FROM advertising_spaces WHERE id = ?');
    $stmt3->execute([$advertising_space_id]);
    $price_per_unit = $stmt3->fetch(PDO::FETCH_ASSOC);

    // get sold for this advertising space
    $stmt4 = $pdo->prepare('SELECT sold FROM advertising_spaces WHERE id = ?');
    $stmt4->execute([$advertising_space_id]);
    $sold = $stmt4->fetch(PDO::FETCH_ASSOC);

    // new value_sold = sold multiplied by price_per_unit
    $value_sold = $sold['sold'] * $price_per_unit['price_unit'];

    // update value_sold in advertising_spaces table
    $stmt5 = $pdo->prepare('UPDATE advertising_spaces SET value_sold = ? WHERE id = ?');
    $stmt5->execute([$value_sold, $advertising_space_id]);

    // calculate the total number of advertising spaces
    $stmt6 = $pdo->prepare('SELECT COUNT(*) FROM advertising_spaces WHERE club_id = ?');
    $stmt6->execute([$_SESSION['id']]);
    $total_advertising_spaces = $stmt6->fetch(PDO::FETCH_ASSOC);

    // upadate the workload in advertising_spaces table: sold / $total_advertising_spaces * 100
    $workload = $sold['sold'] / $total_advertising_spaces['COUNT(*)'] * 100;

    // update workload in advertising_spaces table
    $stmt7 = $pdo->prepare('UPDATE advertising_spaces SET workload = ? WHERE id = ?');
    $stmt7->execute([$workload, $advertising_space_id]);

    // Execute the statement with form data
    $stmt->execute([$duration_start, $duration_end, $club_id, $partner_id, $p_email, $advertising_space_id, $ad_space_name, $type, $note, $status]);

    $_SESSION['success'] = $lang['The Contract was added successfully.'];

    // Redirect or perform other actions after successful insertion
    header("Location: ./contracts.php");
    exit;
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

        i{
            color: white;
        }
    </style>
    <div class="side-panel">
    <h6><?php echo $lang['Logged in as:']; ?> <?php echo $_SESSION['email']; ?></h6>
    <hr>
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
        <style>
    i {
        color: white;
    }
</style>
<!-- settings.html -->
<div class="container-fluid">
    <h2 class="mt-4"><?php echo $lang['My Contracts']; ?></h2>
    <!--  -->
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
    <!--  -->
    <div class="row mt-5">
        <!--  -->
        <div class="col-md-3 mb-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header">
                <?php echo $lang['Add a new contract']; ?>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <!-- Modal Trigger Button -->
                    <button type="button" class="btn btn-secondary btn-lg" data-toggle="modal" data-target="#addContractModal">
                    <i class="fas fa-plus fa-2x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!--  -->
        <?php 
            $count = 1;
            foreach ($contracts as $contract) { //$contract['first_name']
                echo '
                <div class="col-md-3 mb-4 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-header">
                            <div class="row">
                                <div class="col d-flex justify-content-start"> Contract '.$count. '</div>
                                <div class="col d-flex justify-content-end">';

                                    echo "<button class='btn btn-warning mr-3'>
                                        <a href='./update-contract.php?id=" . $contract['id'] . "'>
                                            <i class='fas fa-edit fa-2x'></i>
                                        </a>
                                    </button>";

                                    echo"<button class='btn btn-danger mr-3'>
                                        <a href='./delete-contract.php?id=" . $contract['id'] . "'>
                                            <i class='fas fa-trash fa-2x'></i>
                                        </a>
                                    </button>";

                                    echo' 
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p> Name of AD Space: <span> '.$contract['advertising_space_name'].'</span> </p>
                            <p> Type of Contract: <span>'.$contract['type'].' €</span></p>
                            <p> Partner Email: <span>'.$contract['partner_email'].'</span></p>';
                            //
                            if($contract['status'] == 'Pending'){
                                echo '<p> Contract Status: <span class="text-warning">'.$contract['status'].'</span></p>';
                            } elseif($contract['status'] == 'Active'){
                                echo '<p> Contract Status: <span class="text-success">'.$contract['status'].'</span></p>';
                            } elseif($contract['status'] == 'Inactive'){
                                echo '<p> Contract Status: <span class="text-danger">'.$contract['status'].'</span></p>';
                            } else {
                                echo '<p> Contract Status: <span>'.$contract['status'].'</span></p>';
                            }
                            //
                            echo '<p> Key Notes: <span>'.$contract['note'].'</span></p>';
                            //
                            echo'<p> Duration: <span> '.$contract['start_date'] ." - ".$contract['end_date'].'</span> </p>
                        </div>
                    </div>
                </div>';
                $count++;
            } 
        ?>
        <!--  -->
    </div>
    <!--  -->
</div>
<!-- Modal for adding contracts -->
<!-- Add Contract Modal -->
<div class="modal fade" id="addContractModal" tabindex="-1" role="dialog" aria-labelledby="addContractModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContractModalLabel"><?php echo $lang['Add New Contract']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="partnerId"><?php echo $lang['Advertising Space']; ?></label>
                        <select class="form-control" id="partnerId" name="advertising_space_id" required>
                            <?php
                            // Assuming $partners contains data from the partners table
                            foreach ($advertising_spaces as $advertising_space) {
                                echo '<option value=" '. htmlspecialchars($advertising_space['id']) .' ">' . htmlspecialchars($advertising_space['advertising_space_name']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="type"><?php echo $lang['Type of Contract']; ?></label>
                        <input type="text" class="form-control" id="type" placeholder="<?php echo $lang["what's the type of this contract?"]; ?>" name="type" required>
                    </div>

                    <div class="form-group">
                        <label for="durationStart"><?php echo $lang['Duration Start']; ?></label>
                        <input type="date" class="form-control" id="durationStart" name="duration_start" required>
                    </div>

                    <div class="form-group">
                        <label for="durationEnd"><?php echo $lang['Duration End']; ?></label>
                        <input type="date" class="form-control" id="durationEnd" name="duration_end" required>
                    </div>

                    <div class="form-group">
                        <label for="partnerId"><?php echo $lang['Partner Email']; ?></label>
                        <select class="form-control" id="partnerId" name="partner_id" required>
                            <?php
                            // Assuming $partners contains data from the partners table
                            foreach ($partners as $partner) {
                                echo '<option value="'. htmlspecialchars($partner['id']) .'">' . htmlspecialchars($partner['email']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="contract-status"><?php echo $lang['Contract Status']; ?></label>
                        <select class="form-control" id="contract-status" name="contract-status" required>
                            <option value="Pending"><?php echo $lang['Pending']; ?></option>    
                            <option value="Active"><?php echo $lang['Active']; ?></option>
                            <option value="Inactive"><?php echo $lang['Inactive']; ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="note"><?php echo $lang['Note']; ?></label>
                        <input type="text" class="form-control" id="note" placeholder="<?php echo $lang['Key notes related to this contract']; ?>" name="note" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $lang['Close']; ?></button>
                    <button type="submit" name="create_contract" class="btn btn-info"><?php echo $lang['Create Contract']; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- include dash_footer -->
<?php include '../inc/dash_footer.php'; ?>