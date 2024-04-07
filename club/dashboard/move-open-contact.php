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
    'success' => 'Open Contact was Moved to Partner successfully.',
    'success' => 'Partner added successfully.',
  
    //
  ];
  
  $german = [
    'password_error'=> 'Bitte geben Sie Ihr Passwort ein',
    'email_error' => 'Bitte geben Sie Ihre E-Mail-Adresse ein',
    'success' => 'Der offene Kontakt wurde erfolgreich zum Partner verschoben.',
    'success' => 'Partner erfolgreich hinzugefügt.'
];

// check session for selected langu and decide on the array to use
$lang = $_SESSION['lang'] == 'en' ? $english : $german;



// Include config file
require_once '../../common/inc/database.php';

$host = DB_SERVER;
$dbname = DB_NAME;
$user = DB_USERNAME;
$pass = DB_PASSWORD;

$pdo = null;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetching data from 'open_contacts' table
    $stmt = $pdo->query('SELECT * FROM open_contacts');
    $openContacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
//
function addOpenContactToPartners($pdo, $company_name, $contact_person, $address, $telephone, $email, $club_id)
{   
     // Prepare an INSERT statement
     $sql = "INSERT INTO partners (company_name, contact_person, address, telephone, email, club_id) VALUES (?, ?, ?, ?, ?, ?)";
     $stmt = $pdo->prepare($sql);
 
     // Execute the statement with form data
     $stmt->execute([$company_name, $contact_person, $address, $telephone, $email, $club_id]);
 
     $_SESSION['success'] = $lang['Partner added successfully.'];
}

function deleteThisOpenContact ($pdo, $id)
{
    // Prepare a delete statement
    $stmt = $pdo->prepare("DELETE FROM open_contacts WHERE id = ?");
    $stmt->execute([$id]);
    // Redirect after deletion
    header("Location: ./open-contacts.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetching data from 'open_contacts' table for this id
    $stmt = $pdo->prepare('SELECT * FROM open_contacts WHERE id = ?');
    $stmt->execute([$id]);
    $openContact = $stmt->fetch(PDO::FETCH_ASSOC);

    $company_name = $openContact['company_name'];
    $contact_person = $openContact['contact_person'];
    $address = $openContact['address'];
    $telephone = $openContact['telephone'];
    $email = $openContact['email'];

    $club_id = $_SESSION['id'];

    // Add open contact to partners
    addOpenContactToPartners($pdo, $company_name, $contact_person, $address, $telephone, $email, $club_id);

    // Delete this open contact
    deleteThisOpenContact($pdo, $id);

    $_SESSION['success'] = $lang['Open Contact was Moved to Partner successfully.'];
}