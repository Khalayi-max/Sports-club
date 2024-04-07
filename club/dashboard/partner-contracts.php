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
    'Open Contacts' => 'Open Contacts',
    'Partners' => 'Partners', 
    'Advertising Spaces' => 'Advertising Spaces',
    'Dashboard' => 'Dashboard',
    'success' => 'Partner added successfully.',
    'Start Date' => 'Start Date', 
    'End Date' => 'End Date',
    'List of Contracts' => 'List of Contracts',
    'Note' => 'Note',
    'Last Modified' => 'Last Modified',
    'Type' => 'Type', 
    'Status' => 'Status',
    '' => '',
    '' => '',
    '' => '', 
    '' => '',
    '' => '',
    '' => '',
    '' => '', 
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
    'Open Contacts' => 'Öffnen Sie Kontakte',
    'Partners' => 'Partner', 
    'Advertising Spaces' => 'Werbeflächen',
    'Dashboard' => 'Dashboard',
    'success' => 'Partner erfolgreich hinzugefügt.',
    'Start Date' => 'Startdatum',
    'End Date' => 'Endtermin', 
    'Type' => 'Typ',
    'Last Modified' => 'Zuletzt bearbeitet', 
    'Note' => 'Notiz',
    'List of Contracts' => 'Liste der Verträge',
    'Status' => 'Status',
    '' => '', 
    '' => '',
    '' => '',
    '' => '',
    '' => '', 
    '' => '',
    '' => '',
    '' => '',
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
            <a class="nav-link" href="./index.php"><?php echo $lang['Dashboard']; ?></a>
            <a class="nav-link" href="./advertising-spaces.php"><?php echo $lang['Advertising Spaces']; ?></a>
            <a class="nav-link active" href="./partners.php"><?php echo $lang['Partners']; ?></a>
            <a class="nav-link" href="./contracts.php"><?php echo $lang['Contracts']; ?></a>
            <a class="nav-link" href="./open-contacts.php"><?php echo $lang['Open Contacts']; ?></a>
            <a href="../logout.php" class="btn btn-danger"><?php echo $lang['Sign Out']; ?></a>
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
                <h4> <?php echo $lang['List of Contracts']; ?></h4>
            </div>
            <!--  -->
            <div class="card-body">
                <!--  -->
                <table class="table mt-5">
                    <thead>
                        <tr>
                        <th scope="col"><?php echo $lang['Start Date']; ?></th>
                        <th scope="col"><?php echo $lang['End Date']; ?></th>
                        <th scope="col">'Partner Email</th>
                        <th scope="col"><?php echo $lang['Advertising Space Name']; ?></th>
                        <th scope="col"><?php echo $lang['Type']; ?></th>
                        <th scope="col"><?php echo $lang['Note']; ?></th>
                        <th scope="col"><?php echo $lang['Status']; ?></th>
                        <th scope="col"><?php echo $lang['Last Modified']; ?></th>
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