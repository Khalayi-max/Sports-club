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

// Ensure the club_id is set in the session
$clubId = isset($_SESSION['id']) ? $_SESSION['id'] : '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetching all partners
    // $stmt = $pdo->query('SELECT * FROM partners');
    // $partners = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get partners for a specific club
    $stmt = $pdo->prepare('SELECT * FROM partners WHERE club_id = :clubID');
    $stmt->execute(['clubID' => $clubId]);
    $partners = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare('SELECT * FROM contracts WHERE club_id = :clubID');

} catch (PDOException $e) {
    //echo 'Connection failed: ' . $e->getMessage();
    $_SESSION['error'] = 'Connection failed: ' . $e->getMessage();
}
// 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_partner'])) {
    // Retrieve form data
    $company_name = $_POST['company_name'] ?? '';
    $contact_person = $_POST['contact_person'] ?? '';
    $address = $_POST['address'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $email = $_POST['email'] ?? '';
    $club_id = $clubId;

    // Prepare an INSERT statement
    $sql = "INSERT INTO partners (company_name, contact_person, address, telephone, email, club_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // Execute the statement with form data
    $stmt->execute([$company_name, $contact_person, $address, $telephone, $email, $club_id]);

    $_SESSION['success'] = $lang['Partner added successfully.']; 

    // Redirect or perform other actions after successful insertion
    header("Location: ./partners.php");
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
    </style>
    <div class="side-panel">
    <h6><?php echo $lang['Logged in as:']; ?> <?php echo $_SESSION['email']; ?></h6>
    <hr>
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
        <style>
    i {
        color: white;
    }
</style>
<!-- settings.html -->
<div class="container-fluid">
    <h2 class="mt-4"><?php echo $lang['List of all Partners']; ?></h2>
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
    <div class="card mt-5">
        <div class="card-header">
            <!--  -->
            <!-- Trigger Button for Modal -->
            <button type="button" class="btn btn-secondary  mr-2" data-toggle="modal" data-target="#addPartnerModal">
                 <i class="fas fa-plus fa-2x"></i>
            </button>
            <!--  -->
            <?php echo $lang['Add New Partner']; ?>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"><?php echo $lang['Company Name']; ?></th>
                        <th scope="col"><?php echo $lang['Contact Person']; ?></th>
                        <th scope="col"><?php echo $lang['Email']; ?></th>
                        <th scope="col"><?php echo $lang['Address']; ?></th>
                        <th scope="col"><?php echo $lang['Telephone']; ?></th>
                        <th scope="col"><?php echo $lang['Contracts']; ?></th>
                        <th scope="col"><?php echo $lang['Update']; ?></th>
                        <th scope="col"><?php echo $lang['Delete']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <!--  -->
                    <tr>
                        <?php 
                        $counter = 1; // initialize the counter
                        foreach ($partners as $partner) {
                            echo "<tr>";
                            echo "<td>" . $counter . "</td>"; // Displaying the counter
                            echo "<td>" . htmlspecialchars($partner['company_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($partner['contact_person']) . "</td>";
                            echo "<td>" . htmlspecialchars($partner['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($partner['address']) . "</td>";
                            echo "<td>" . htmlspecialchars($partner['telephone']) . "</td>";
                            //
                            echo '<td>
                                    <button class="btn btn-success btn-sm">';
                            echo "<a class='dashboard-link' href='./partner-contracts.php?id=" . $partner['id'] . "' class='btn btn-success btn-sm'>
                                        <i class='fas fa-eye fa-2x'></i>
                                    </a>
                                    </button>
                                </td>";
                            // 
                            //
                            echo '<td>
                                    <button class="btn btn-success btn-sm">';
                            echo "<a class='dashboard-link' href='./update-partner.php?id=" . $partner['id'] . "' class='btn btn-success btn-sm'>
                                        <i class='fas fa-edit fa-2x'></i>
                                    </a>
                                    </button>
                                </td>";
                            // 
                            echo '<td>
                                    <button class="btn btn-danger btn-sm">';
                            echo "<a class='dashboard-link' href='./delete_partner.php?id=" . $partner['id'] . "' class='btn btn-success btn-sm'>
                                        <i class='fas fa-trash fa-2x'></i>
                                    </a>
                                    </button>
                                </td>";
                            // 
                            echo "</tr>";
                            $counter++; // Increment the counter
                        } 
                        
                        // endforeach;
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!--  -->
    <br>
    <!-- -->
</div>

<!-- Moodal -->
<!-- Modal -->
<div class="modal fade" id="addPartnerModal" tabindex="-1" role="dialog" aria-labelledby="addPartnerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPartnerModalLabel"><?php echo $lang['Add New Partner']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="modal-body">
                    <div class="form-group">
                            <label for="company_name"><?php echo $lang['Company Name']; ?></label>
                            <input type="text" class="form-control" id="company_name" name="company_name" required>
                        </div>

                    <div class="form-group">
                            <label for="contact_person"><?php echo $lang['Contact Person']; ?></label>
                            <input type="text" class="form-control" id="contact_person" name="contact_person" required>
                        </div>

                    <div class="form-group">
                            <label for="email"><?php echo $lang['Email']; ?></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="address"><?php echo $lang['Address']; ?></label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>

                        <div class="form-group">
                            <label for="telephone"><?php echo $lang['Telephone']; ?></label>
                            <input type="text" class="form-control" id="telephone" name="telephone" required>
                        </div>
                    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $lang['Close']; ?></button>
                        <button type="submit" name="add_partner" class="btn btn-primary"><?php echo $lang['Add Partner']; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <!--  -->
    </div>
</div>

<!-- include dash_footer -->
<?php include '../inc/dash_footer.php'; ?>