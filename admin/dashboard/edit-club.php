<?php
// Start a new session
session_start();

// Check if the user is not logged in, then redirect to the login page.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../index.php'); // Redirect to the login page.
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
    'title' => 'Admin Dashboard',
    'admin_title' => 'Edit This Club',
    'dashboard_l' => 'Dashboard',
    'clubs_l' => 'Clubs',
    'addclubs_l' => 'Add New Clubs',
    'editclubs_l' => 'Edit Club',
    'view_club' => 'View Club Overview',
    'logout' => 'Sign Out',
    'email' => 'Email Address',
    'password' => 'Password',
    'enter_email' => 'Enter Club\'s Email',
    'enter_password' => 'Enter Club\'s Password',
    'update_btn' => 'Update Club',
    'choose_club_image' => 'Choose Club Image',
    'ClubImage' => 'Club Image',
    'clubName' => 'Club Name',
    'enter_club_name' => 'Enter Club Name',
    //
];

$german = [
    'title' => 'Admin Dashboard',
    'admin_title' => 'Diesen Club bearbeiten',
    'dashboard_l' => 'Dashboard',
    'clubs_l' => 'Clubs',
    'addclubs_l' => 'Neue Clubs hinzufügen',
    'editclubs_l' => 'Club bearbeiten',
    'view_club' => 'Club Übersicht anzeigen',
    'logout' => 'Abmelden',
    'email' => 'E-Mail-Addresse',
    'password' => 'Passwort',
    'enter_email' => 'Geben Sie die E-Mail-Adresse des Clubs ein',
    'enter_password' => 'Geben Sie das Passwort des Clubs ein',
    'update_btn' => 'Club aktualisieren',
    'choose_club_image' => 'Wählen Sie das Club-Bild',
    'ClubImage' => 'Club-Bild',
    'clubName' => 'Club-Name',
    'enter_club_name' => 'Geben Sie den Club-Namen ein',
    //
];
//
// check session for selected langu and decide on the array to use
$lang = $_SESSION['lang'] == 'en' ? $english : $german;
//$lang["view_club"]
//

// Include database configuration
require_once '../../common/inc/database.php';

$host = DB_SERVER;
$dbname = DB_NAME;
$user = DB_USERNAME;
$pass = DB_PASSWORD;

$club_id = 0; // initialize the contact ID
$this_club = []; // initialize the current club

// GET request to get the contact ID
if (isset($_GET['id'])) {
    $club_id = $_GET['id'];
} else {
    $_SESSION['error'] = 'The Club ID not found.';
    header('Location: ./clubs.php');
    exit;
}

// Getting the current club
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // fetch this club info
    $stmt = $pdo->prepare('SELECT * FROM clubs WHERE id = :tid');
    $stmt->execute(['tid' => $club_id]);
    $this_club = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // $this_club = $this_club[0];

} catch (PDOException $e) {
    //echo 'Connection failed: ' . $e->getMessage();
    $_SESSION['error'] = 'Connection failed: ' . $e->getMessage();
}
// End of getting the current club

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $email = $_POST['email'] ?? '';
//     $password = $_POST['password'] ?? '';
//     $clubName = $_POST['clubName'] ?? '';

//     // Initialize upload flag
//     $uploadOk = 1;

//     // Check if a file is uploaded and get the file name
//     if (isset($_FILES['clubImage']) && $_FILES['clubImage']['error'] == 0) {
//         $imageFileName = basename($_FILES["clubImage"]["name"]);
//         $uniqueId = uniqid(); // Generates a unique ID
//         $target_file = "../../club/club_images/" . $uniqueId . '_' . $imageFileName;

//         // Check file size - 2MB maximum
//         if ($_FILES["clubImage"]["size"] > 2000000) {
//             $_SESSION['error'] = "Sorry, your image file is too large. Upload images less than 2MB.";
//             $uploadOk = 0;
//         }

//         // Allow certain file formats
//         $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
//         if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
//             $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//             $uploadOk = 0;
//         }

//         // Check if image file is an actual image or fake image
//         $check = getimagesize($_FILES["clubImage"]["tmp_name"]);
//         if ($check === false) {
//             $_SESSION['error'] = "File is not an image.";
//             $uploadOk = 0;
//         }

//         // delete the old image from the uploads folder
//         unlink($this_club[0]['clubImagePath']);

//         // Attempt to upload file if checks passed
//         if ($uploadOk == 1 && move_uploaded_file($_FILES["clubImage"]["tmp_name"], $target_file)) {
            
//             // Set the club image path
//             $tclubImagePath = $target_file;

//             // Process the data to database
//             editclub($email, $password, $clubName, $tclubImagePath);
//         } else {
//             $_SESSION['error'] = $_SESSION['error'] ?? "Sorry, there was an error uploading your file.";
//             header('Location: ./add-club.php');
//             exit;
//         }
//     } else {
//         // Handle no file uploaded
//         $_SESSION['error'] = "No file uploaded.";
//         header('Location: ./add-club.php');
//         exit;
//     }
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $clubName = $_POST['clubName'] ?? '';

    $tclubImagePath = $this_club[0]['clubImagePath']; // Default to existing image path

    // Initialize upload flag
    $uploadOk = 1;

    // Check if a file is uploaded
    if (isset($_FILES['clubImage']) && $_FILES['clubImage']['error'] == 0) {
        $imageFileName = basename($_FILES["clubImage"]["name"]);
        $uniqueId = uniqid(); // Generates a unique ID
        $target_file = "../../club/club_images/" . $uniqueId . '_' . $imageFileName;

        // Check file size - 2MB maximum
        if ($_FILES["clubImage"]["size"] > 2000000) {
            $_SESSION['error'] = "Sorry, your image file is too large. Upload images less than 2MB.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["clubImage"]["tmp_name"]);
        if ($check === false) {
            $_SESSION['error'] = "File is not an image.";
            $uploadOk = 0;
        }

        // Attempt to upload file if checks passed
        if ($uploadOk == 1 && move_uploaded_file($_FILES["clubImage"]["tmp_name"], $target_file)) {
            // Delete the old image if a new one is successfully uploaded
            if (file_exists($this_club[0]['clubImagePath'])) {
                unlink($this_club[0]['clubImagePath']);
            }

            $tclubImagePath = $target_file; // Update to new image path
        } else {
            $_SESSION['error'] = $_SESSION['error'] ?? "Sorry, there was an error uploading your file.";
            header('Location: ./edit-club.php?id=' . urlencode($clubId));
            exit;
        }
    }

    // Process the data to database
    if ($uploadOk == 1) {
        editclub($email, $password, $clubName, $tclubImagePath, $club_id);
    } else {
        $_SESSION['error'] = $_SESSION['error'] ?? "Error occurred in updating club.";
        header('Location: ./edit-club.php?id=' . urlencode($clubId));
        exit;
    }
}


function editclub($temail, $tpassword, $club_name, $tclubImagePath, $tclub_id)
{
    // Create a connection to the database
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash the password
    $passwordHash = password_hash($tpassword, PASSWORD_DEFAULT);

    // Prepare an update statement
    $sql = "UPDATE clubs SET email = ?, password = ?, clubName = ?, clubImagePath = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Assuming $club_id is the ID of the club you want to update
        $stmt->bind_param("ssssi", $temail, $passwordHash, $club_name, $tclubImagePath, $tclub_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "The Club was updated successfully.";
            header('Location: ./clubs.php');
            exit;
        } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
            //header('Location: ./edit-club.php'); // Redirect to the edit page instead
            header('Location: ./edit-club.php?id=' . urlencode($tclub_id));
            exit;
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Error preparing statement: " . $conn->error;
        header('Location: ./edit-club.php'); // Redirect to the edit page instead
        exit;
    }

    // Close connection
    $conn->close();
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
        <nav class="nav flex-column">
            <a class="nav-link" href="./index.php"><?php echo $lang["dashboard_l"]; ?></a>
            <a class="nav-link" href="./clubs.php"><?php echo $lang["clubs_l"]; ?></a>
            <a class="nav-link" href="./add-club.php"><?php echo $lang["addclubs_l"]; ?></a>
            <a class="nav-link active" href="./edit-club.php"><?php echo $lang["editclubs_l"]; ?></a>
            <a href="../logout.php" class="btn btn-danger"><?php echo $lang["logout"]; ?></a>
        </nav>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <!--  -->
        <div class="container mt-5">
            <h2><?php echo $lang["admin_title"]; ?></h2>
            <div class="card">
                <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                        <label for="clubName"><?php echo $lang['clubName']; ?>:</label>
                        <input value="<?php echo $this_club[0]['clubName'] ?>" type="text" class="form-control" id="clubName" name="clubName" placeholder="<?php echo $lang["enter_club_name"]; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email"><?php echo $lang["email"]; ?>:</label>
                        <input value="<?php echo $this_club[0]['email'] ?>" type="email" class="form-control" id="email" name="email" placeholder="<?php echo $lang["enter_email"]; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd"><?php echo $lang["password"]; ?>:</label>
                        <input type="text" class="form-control" id="pwd" name="password" placeholder="<?php echo $lang["enter_password"]; ?>" required>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Current Club Image</label>
                                <img style="margin-left: 20px;" width="100px" src="<?php echo $this_club[0]['clubImagePath'] ?>" alt="The club image">
                            </div>

                            <div class="col-md-6">
                                <label for="clubImage"><?php echo $lang["ClubImage"]; ?>:</label>
                                <input type="file" class="form-control" id="clubImage" name="clubImage" placeholder="<?php echo $lang["choose_club_image"]; ?>" required>
                            </div>

                        </div>
                    </div>
                    <!--  -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary form-control"><?php echo $lang["update_btn"]; ?></button>
                            </div>

                            <div class="col-md-6">
                                <a href="./delete-club.php?id=<?php echo$club_id; ?>" class="btn btn-danger btn-block">Delete</a>
                            </div>

                        </div>
                    </div>
                    <!--  -->
                </form>
                </div>
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
            </div>
        </div>
        <!--  -->
    </div>
</div>

<!-- include dash_footer -->
<?php include '../inc/dash_footer.php'; ?>