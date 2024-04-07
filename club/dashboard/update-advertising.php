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
    'Price per Unit' => 'Price per Unit', 
    'Advertising Space not found.' => 'Advertising Space not found.',
    'Update the Advertising Space' => 'Update the Advertising Space',
    'Update Advertising Space' => 'Update Advertising Space',
    'success' => 'Advertising Space updated successfully!',
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
    'Price per Unit' => 'Preis pro Einheit'
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
    'Advertising Space not found.' => 'Werbefläche nicht gefunden.',
    'Update the Advertising Space' => 'Aktualisieren Sie die Werbefläche', 
    'Update Advertising Space' => 'Werbefläche aktualisieren',
    'success' => 'Werbefläche erfolgreich aktualisiert!', 
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

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetching data from 'partners' table
    $stmt = $pdo->query('SELECT * FROM advertising_spaces');
    $advertising_spaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
//
// Update data on database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $advertising_space_name = $_POST['advertising_space_name'];
    $unit = $_POST['unit'];
    $number = $_POST['number'];
    $price_per_unit = $_POST['price_per_unit'];
    $inventory_value = $_POST['inventory_value'];
    $workload = $_POST['workload'];
    $value_sold = $_POST['value_sold'];
    $proceeds = $_POST['proceeds'];

    // Prepare the SQL statement
    $stmt = $pdo->prepare("UPDATE advertising_spaces SET 
        advertising_space_name = ?, 
        unit = ?, 
        number = ?, 
        price_unit = ?,
        inventory_value = ?, 
        workload = ?, 
        value_sold = ?, 
        proceeds = ?
        WHERE id = ?"
    );

    // Execute the statement with the collected data
    $stmt->execute([
        $advertising_space_name, 
        $unit, 
        $number, 
        $price_per_unit, 
        $inventory_value, 
        $workload, 
        $value_sold, 
        $proceeds, 
        $id
    ]);

    $_SESSION['success'] = $lang['Advertising Space updated successfully!'];

    // Redirect back to the partners list or display a success message
    header("Location: ./advertising-spaces.php");
    exit;
}
//
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS CDN (you can download and host it locally if needed) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: #f4f7f6;
            margin-top: 20px;
        }
        .dashboard-wrap {
            display: flex;
            /* width: 100%; */
        }
        .side-panel {
            min-width: 250px;
            /* min-width: 15%; */
            height: 100vh;
            background-color: #e3f2fd; /* Light blue background */
            padding: 20px;
        }
        .side-panel .nav-link {
            color: #23527c;
            margin-bottom: 10px;
        }
        .side-panel .nav-link:hover {
            color: #1b6d85;
            background-color: #d4e6f1;
            border-radius: 4px;
        }
        .dashboard-content {
            flex-grow: 1;
            padding: 20px;
            /* min-width: 85%; */
        }
        /* ... [existing styles] ... */

    .side-panel .nav-link.active {
        background-color: #007bff; /* Bootstrap primary color */
        color: white;
        border-radius: 4px;
    }
    /*  */
    </style>
</head>
<body>

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
            <a class="nav-link active" href="./advertising-spaces.php"><?php echo $lang['Advertising Spaces']; ?></a>
            <a class="nav-link" href="./partners.php"><?php echo $lang['Partner']; ?></a>
            <a class="nav-link" href="./contracts.php"><?php echo $lang['Contracts']; ?></a>
            <a class="nav-link" href="./open-contacts.php"><?php echo $lang['Open Contacts']; ?></a>
            <a href="./logout.php" class="btn btn-danger"><?php echo $lang['Sign Out']; ?></a>
        </nav>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <!--  -->
        <div class="container-fluid mt-4">
        <h2><?php echo $lang['Update Advertising Space']; ?></h2>
                <!--  -->
                <?php
                    // Assuming you have a PDO connection $pdo
                    $AdvertisingSpaceId = $_GET['id']; // Get the partner ID from URL
                    $stmt = $pdo->prepare("SELECT * FROM advertising_spaces WHERE id = ?");
                    $stmt->execute([$AdvertisingSpaceId]);
                    $advertising_space = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($advertising_space) {
                    // Display the form with partner's data
                ?>
                <!--  -->
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($advertising_space['id']); ?>"> <!-- Replace ID_VALUE with actual ID -->
                   <div class="row">
                        <div class="col-md-6">
                          <div class="card">
                            <div class="card-body">
                            <div class="form-group">
                                <label for="advertisingSpaceName"><?php echo $lang['Advertising Space Name']; ?></label>
                                <input type="text" value="<?php echo htmlspecialchars($advertising_space['advertising_space_name']); ?>" class="form-control" id="advertisingSpaceName" name="advertising_space_name" required>
                            </div>

                            <div class="form-group">
                                <label for="unit"><?php echo $lang['Unit']; ?></label>
                                <input type="text" value="<?php echo htmlspecialchars($advertising_space['unit']); ?>" class="form-control" id="unit" name="unit" required>
                            </div>

                            <div class="form-group">
                                <label for="number"><?php echo $lang['Number']; ?></label>
                                <input type="number" value="<?php echo htmlspecialchars($advertising_space['number']); ?>" class="form-control" id="number" name="number" required>
                            </div>

                            <div class="form-group">
                                <label for="pricePerUnit"><?php echo $lang['Price per Unit']; ?></label>
                                <input type="text" value="<?php echo htmlspecialchars($advertising_space['price_unit']); ?>" class="form-control" id="pricePerUnit" name="price_per_unit" required>
                            </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                           <div class="card">
                            <div class="card-body">
                            <div class="form-group">
                                <label for="inventoryValue"><?php echo $lang['Inventory-Value']; ?></label>
                                <input type="text" value="<?php echo htmlspecialchars($advertising_space['inventory_value']); ?>" class="form-control" id="inventoryValue" name="inventory_value" required>
                            </div>
                                <div class="form-group">
                                    <label for="workload"><?php echo $lang['Workload']; ?></label>
                                    <input type="text" value="<?php echo htmlspecialchars($advertising_space['workload']); ?>" class="form-control" id="workload" name="workload" required>
                                </div>

                                <div class="form-group">
                                    <label for="valueSold"><?php echo $lang['Value sold']; ?></label>
                                    <input type="text" value="<?php echo htmlspecialchars($advertising_space['value_sold']); ?>" class="form-control" id="valueSold" name="value_sold" required>
                                </div>

                                <div class="form-group">
                                    <label for="proceeds"><?php echo $lang['Proceeds']; ?></label>
                                    <input type="text" value="<?php echo htmlspecialchars($advertising_space['proceeds']); ?>" class="form-control" id="proceeds" name="proceeds" required>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <!-- end or row -->
                    <div class="container-fluid mt-4">
                        <button type="submit" class="btn btn-warning btn-lg btn-block"><?php echo $lang['Update the Advertising Space']; ?></button>
                    </div>
                    <!--  -->
                </form>
                </div>
                <?php
                    } else {
                        echo "<p> <?php echo $lang['Advertising Space not found.']; ?> </p>";
                        // more error handling
                    }
                ?>
    </div>
    <!--  -->
    </div>
</div>

<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap Bundle with Popper -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>