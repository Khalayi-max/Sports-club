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
  'Open Contacts' => 'Open Contacts',
  'Partners' => 'Partners', 
  'Advertising Spaces' => 'Advertising Spaces',
  'Dashboard' => 'Dashboard',
  'Contracts' => 'Contracts',
  'Create New Advertising Space' => 'Create New Advertising Space',
  'Enter proceeds' => 'Enter proceeds',
  'Enter value sold' => 'Enter value sold',
  'Enter workload' => 'Enter workload',
  'Enter inventory value' => 'Enter inventory value', 
  'Enter price per unit' => 'Enter price per unit',
  'Enter name' => 'Enter name', 
  'Enter number' => 'Enter number',
  'Close' => 'Close',
  'Add Advertising Space' => 'Add Advertising Space',
  'Enter unit' => 'Enter unit',
  'Advertising Space Name cannot be empty' => 'Advertising Space Name cannot be empty',
  'Proceeds cannot be empty' => 'Proceeds cannot be empty',
  'Value sold cannot be empty' => 'Value sold cannot be empty',
  'Workload cannot be empty' => 'Workload cannot be empty',
  'Inventory value cannot be empty' => 'Inventory value cannot be empty',
  'Price per unit cannot be empty' => 'Price per unit cannot be empty',
  'Number cannot be empty' => 'Number cannot be empty',
  'Unit cannot be empty' => 'Unit cannot be empty',
  'Advertising Space added successfully!' => 'Advertising Space added successfully!',
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
  'Add Advertising Space' => 'Werbefläche hinzufügen',
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
  'Open Contacts' => 'Öffnen Sie Kontakte',
  'Partners' => 'Partner', 
  'Advertising Spaces' => 'Werbeflächen',
  'Dashboard' => 'Dashboard',
  'Contracts' => 'Verträge',
  'Create New Advertising Space' => 'Schaffen Sie neue Werbeflächen', 
  'Enter proceeds' => 'Erlös eintragen',
  'Enter value sold' => 'Geben Sie den verkauften Wert ein',
  'Enter workload' => 'Arbeitsbelastung eingeben',
  'Enter inventory value' => 'Geben Sie den Lagerwert ein', 
  'Enter price per unit' => 'Geben Sie den Preis pro Einheit ein',
  'Enter name' => 'Name eingeben', 
  'Enter number' => 'Nummer eingeben',
  'Close' => 'Schließen',
  'Enter unit' => 'Geben Sie die Einheit ein', 
  'Advertising Space Name cannot be empty' => 'Der Name der Werbefläche darf nicht leer sein',
  'Proceeds cannot be empty' => 'Der Erlös darf nicht leer sein',
  'Value sold cannot be empty' => 'Der verkaufte Wert darf nicht leer sein',
  'Workload cannot be empty' => 'Die Arbeitslast darf nicht leer sein',
  'Inventory value cannot be empty' => 'Der Inventarwert darf nicht leer sein',
  'Price per unit cannot be empty' => 'Der Preis pro Einheit darf nicht leer sein',
  'Number cannot be empty' => 'Die Zahl darf nicht leer sein',
  'Unit cannot be empty' => 'Die Einheit darf nicht leer sein',
  'Advertising Space added successfully!' => 'Werbefläche erfolgreich hinzugefügt',
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

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetching data from 'partners' table
    // $stmt = $pdo->query('SELECT * FROM advertising_spaces');
    // $advertising_spaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get only advertising spaces for this club
    $stmt = $pdo->prepare('SELECT * FROM advertising_spaces WHERE club_id = ?');
    $stmt->execute([$_SESSION['id']]);
    $advertising_spaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    //echo 'Connection failed: ' . $e->getMessage();
    $_SESSION['error'] = 'Connection failed: ' . $e->getMessage();
}
// 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add-advertising-space'])) {
    // Retrieve form data
    $advertisingSpaceName = $_POST['advertising-space-name'] ?? '';
    $unit = $_POST['unit'] ?? '';
    $number = $_POST['number'] ?? 0; // Assuming number is an integer
    $pricePerUnit = $_POST['price-per-unit'] ?? '';
    $inventoryValue = $_POST['inventory-value'] ?? '';
    $sold = $_POST['is-sold'] ?? '';
    $workload = $_POST['workload'] ?? '';
    $valueSold = $_POST['value-sold'] ?? '';
    $proceeds = $_POST['proceeds'] ?? '';
    $club_id = $_SESSION['id'] ?? '';
    $partner_id = 0;

    // Check if the form data is not empty using a switch and add an error message to $errors array
    switch (true) {
        case empty($advertisingSpaceName):
          $_SESSION['error'] = $lang['Advertising Space Name cannot be empty'];
            break;
        case empty($unit):
          $_SESSION['error'] = $lang['Unit cannot be empty'];
            break;
        case empty($number):
          $_SESSION['error'] = $lang['Number cannot be empty'];
            break;
        case empty($pricePerUnit):
          $_SESSION['error'] = $lang['Price per unit cannot be empty'];
            break;
        case empty($inventoryValue):
          $_SESSION['error'] = $lang['Inventory value cannot be empty'];
            break;
        case empty($workload):
          $_SESSION['error'] = $lang['Workload cannot be empty'];
            break;
        case empty($valueSold):
          $_SESSION['error'] = $lang['Value sold cannot be empty'];
            break;
        case empty($proceeds):
          $_SESSION['error'] = $lang['Proceeds cannot be empty'];
            break;
        default:
            break;
    }

    // if no errors proceed
    if (!isset($_SESSION['error'])) {
          // Prepare an INSERT statement
    $sql = "INSERT INTO advertising_spaces (advertising_space_name, unit, number, price_unit, inventory_value, sold, workload, value_sold, proceeds, club_id, partner_id) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // Execute the statement with form data
    $stmt->execute([$advertisingSpaceName, $unit, (int)$number, $pricePerUnit, $inventoryValue, $sold, $workload, $valueSold, $proceeds, $club_id, $partner_id]);

    $_SESSION['success'] = $lang['Advertising Space added successfully!'];

    // Redirect or perform other actions after successful insertion
    header("Location: ./advertising-spaces.php");
    exit;
    }
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
    <h6><?php echo $lang['Logged in as:']; ?> <?php echo $_SESSION['email']; ?></h6>
    <hr>
        <nav class="nav flex-column">
            <a class="nav-link" href="./index.php"><?php echo $lang['Dashboard']; ?></a>
            <a class="nav-link active" href="./advertising-spaces.php"><?php echo $lang['Advertising Spaces']; ?></a>
            <a class="nav-link" href="./partners.php"><?php echo $lang['Partners']; ?></a>
            <a class="nav-link" href="./contracts.php"><?php echo $lang['Contracts']; ?></a>
            <a class="nav-link" href="./open-contacts.php"><?php echo $lang['Open Contacts']; ?></a>
            <a href="../logout.php" class="btn btn-danger"><?php echo $lang['Sign Out']; ?></a>
        </nav>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
    <style>
    i {
        color: white;
    }
</style>
<div class="container-fluid">
    <h2><?php echo $lang['Advertising Space']; ?></h2>
    <div class="card">
        <div class="card-header">
            <!-- Modal Trigger Button -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAdModal">
                <i class="fas fa-plus fa-2x"></i>
            </button>
            <!--  -->
            <?php echo $lang['Add Advertising Spaces']; ?>
            <!--  -->
        </div>
        <div class="card-body">
            <table class="table table-striped mt-5">
            <thead>
                <tr>
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
                    <th>#</th>
                    <th><?php echo $lang['Advertising Space Name']; ?></th>
                    <th><?php echo $lang['Unit']; ?></th>
                    <th><?php echo $lang['Number']; ?></th>
                    <th><?php echo $lang['Price/unit']; ?></th>
                    <th><?php echo $lang['Inventory-Value']; ?></th>
                    <th><?php echo $lang['Sold']; ?></th>
                    <th><?php echo $lang['Workload']; ?></th>
                    <th><?php echo $lang['Value sold']; ?></th>
                    <th><?php echo $lang['Proceeds']; ?></th>
                    <th><?php echo $lang['Edit']; ?></th>
                    <th><?php echo $lang['Delete']; ?></th>
                </tr>
            </thead>
            <tbody>
                <!--  -->
                <?php 
                    $counter = 1; // initialize the counter
                    foreach ($advertising_spaces as $advertising_space) {
                        // $advertising_space['first_name']
                        echo "<tr>";
                        echo "<td>" . $counter . "</td>"; // Displaying the counter
                        echo "<td>".$advertising_space['advertising_space_name']."</td>";
                        echo "<td>€/m".$advertising_space['unit']."</td>";
                        echo "<td>".strval($advertising_space['number'])."</td>";
                        echo "<td>€".strval($advertising_space['price_unit'])."</td>";
                        echo "<td>€".strval($advertising_space['inventory_value'])."</td>";
                        echo "<td>".strval($advertising_space['sold'])."</td>";
                        echo "<td>".strval($advertising_space['workload'])."</td>";
                        echo "<td>".strval($advertising_space['value_sold'])."%</td>";
                        echo "<td>€".strval($advertising_space['proceeds'])."</td>";
                        // 
                        echo '<td>
                                <button class="btn btn-success btn-sm">';
                        echo "<a class='dashboard-link' href='update-advertising.php?id=" . $advertising_space['id'] . "' class='btn btn-success btn-sm'>
                                    <i class='fas fa-edit fa-1x'></i>
                                </a>
                                </button>
                            </td>";
                        // 
                        echo '<td>
                                <button class="btn btn-danger btn-sm">';
                        echo "<a class='dashboard-link' href='delete-advertising-space.php?id=" . $advertising_space['id'] . "' class='btn btn-success btn-sm'>
                                    <i class='fas fa-trash fa-1x'></i>
                                </a>
                                </button>
                            </td>";
                        // 
                        echo "</tr>";
                        $counter++; // Increment the counter
                    } 
                ?>
                <!-- -->
            </tbody>
        </table>
        </div>
    </div>
    <!--  -->
    <div class="row mt-5">
        <!--  -->
        <div class="div col-md-3">
            <div class="card">
                <div class="card-header">
                <?php echo $lang['Advertising spaces - volume']; ?>
                </div>
                <div class="card-body">
                  <?php
                    // calculate the total number of advertising spaces
                    $stmt6 = $pdo->prepare('SELECT COUNT(*) AS total_count FROM advertising_spaces WHERE club_id = ?');
                    $stmt6->execute([$_SESSION['id']]);
                    $result = $stmt6->fetch(PDO::FETCH_ASSOC);
                    $count = $result['total_count'];

                    $AdvertisingSpaceVolume = $count * $advertising_space['price_unit'];
                  ?>
                    <h4><b><?php echo $AdvertisingSpaceVolume; ?></b></h4>
                </div>
            </div>
        </div>
        <!--  -->
        <div class="div col-md-3">
            <div class="card">
                <div class="card-header">
                <?php echo $lang['Workload']; ?>
                </div>
                <div class="card-body">
                    <h4><b><?php echo $advertising_space['Workload']; ?></b></h4>
                </div>
            </div>
        </div>
        <!--  -->
        <div class="div col-md-3">
            <div class="card">
                <div class="card-header">
                <?php echo $lang['Value sold']; ?>
                </div>
                <div class="card-body">
                    <h4><b><?php echo $advertising_space['Value sold']; ?></b></h4>
                </div>
            </div>
        </div>
        <!--  -->
        <div class="div col-md-3">
            <div class="card">
                <div class="card-header">
                <?php echo $lang['Proceeds']; ?>
                </div>
                <div class="card-body">
                    <h4><b>€7,100.00</b></h4>
                </div>
            </div>
        </div>
        <!--  -->
    </div>
    <!--  -->
</div>
<!-- Modal to Add new Advertising Spaces -->
<!-- Modal -->
<div class="modal fade" id="addAdModal" tabindex="-1" role="dialog" aria-labelledby="addAdModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document"> <!-- Increased modal width -->
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="addAdModalLabel"><?php echo $lang['Add Advertising Space']; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
          <div class="row">
            <!-- Row 1 -->
            <div class="col-md-6 form-group">
              <label for="advertisingSpaceName"><?php echo $lang['Advertising Space Name']; ?></label>
              <input type="text" class="form-control" id="advertisingSpaceName" placeholder="<?php echo $lang['Enter name']; ?>" name="advertising-space-name">
            </div>
            <div class="col-md-6 form-group">
              <label for="unit"><?php echo $lang['Unit']; ?></label>
              <input type="text" class="form-control" id="unit" placeholder="<?php echo $lang['Enter unit']; ?>" name="unit">
            </div>
          </div>

          <div class="row">
            <!-- Row 2 -->
            <div class="col-md-6 form-group">
              <label for="number"><?php echo $lang['Number']; ?></label>
              <input type="number" class="form-control" id="number" placeholder="<?php echo $lang['Enter number']; ?>" name="number">
            </div>
            <div class="col-md-6 form-group">
              <label for="pricePerUnit"><?php echo $lang['Price/unit']; ?></label>
              <input type="text" class="form-control" id="pricePerUnit" placeholder="<?php echo $lang['Enter price per unit']; ?>" name="price-per-unit">
            </div>
          </div>

          <div class="row">
            <!-- Row 3 -->
            <div class="col-md-4 form-group">
              <label for="inventoryValue"><?php echo $lang['Inventory-Value']; ?></label>
              <input type="text" class="form-control" id="inventoryValue" placeholder="<?php echo $lang['Enter inventory value']; ?>" name="inventory-value">
            </div>

            <!-- Sold or Not -->
            <input type="text" class="form-control" id="sold" placeholder="Enter sold amount" name="is-sold" value="0" hidden>

            <div class="col-md-4 form-group">
              <label for="workload"><?php echo $lang['Workload']; ?></label>
              <input type="text" class="form-control" id="workload" placeholder="<?php echo $lang['Enter workload']; ?>" name="workload">
            </div>
          </div>

          <div class="row">
            <!-- Row 4 -->
            <div class="col-md-6 form-group">
              <label for="valueSold"><?php echo $lang['Value sold']; ?></label>
              <input type="text" class="form-control" id="valueSold" placeholder="<?php echo $lang['Enter value sold']; ?>" name="value-sold">
            </div>
            <div class="col-md-6 form-group">
              <label for="proceeds"><?php echo $lang['Proceeds']; ?></label>
              <input type="text" class="form-control" id="proceeds" placeholder= "<?php echo $lang['Enter proceeds']; ?>" name="proceeds">
            </div>
          </div>
          <!--  -->
          <div class="row">
            <!-- -->
            <div class="col-md-6 form-group">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $lang['Close']; ?></button>
              <button type="submit" name="add-advertising-space" class="btn btn-primary"><?php echo $lang['Create New Advertising Space']; ?></button>
            </div>
          </div>
          <!--  -->
        </form>
      </div>

      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="add-advertising-space" class="btn btn-primary">Create New Advertising Space</button>
      </div> -->

    </div>
  </div>
</div>
    </div>
</div>

<!-- include dash_footer -->
<?php include '../inc/dash_footer.php'; ?>