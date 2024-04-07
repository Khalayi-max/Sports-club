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
    'admin_title' => 'Create New Club',
    'dashboard_l' => 'Dashboard',
    'clubs_l' => 'Clubs',
    'addclubs_l' => 'Add New Clubs',
    'view_club' => 'View Club Overview',
    'logout' => 'Sign Out',
    'email' => 'Email Address',
    'password' => 'Password',
    'enter_email' => 'Enter Club\'s Email',
    'enter_password' => 'Enter Club\'s Password',
    'create_btn' => 'Create Club',
    'choose_club_image' => 'Choose Club Image',
    'ClubImage' => 'Club Image',
    'clubName' => 'Club Name',
    'enter_club_name' => 'Enter Club Name',
    //
];

$german = [
    'title' => 'Admin Dashboard',
    'admin_title' => 'Neuen Club erstellen',
    'dashboard_l' => 'Dashboard',
    'clubs_l' => 'Clubs',
    'addclubs_l' => 'Neue Clubs hinzufügen',
    'view_club' => 'Club Übersicht anzeigen',
    'logout' => 'Abmelden',
    'email' => 'E-Mail-Addresse',
    'password' => 'Passwort',
    'enter_email' => 'Geben Sie die E-Mail-Adresse des Clubs ein',
    'enter_password' => 'Geben Sie das Passwort des Clubs ein',
    'create_btn' => 'Club erstellen',
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
require_once '../../common/inc/database.php'; // Adjust the path as needed

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $email = $_POST['email'] ?? '';
//     $password = $_POST['password'] ?? '';

//     // Uploading the Image
//     $target_dir = "../../club/club_images/";
//     $imageFileName = basename($_FILES["clubImage"]["name"]);
//     // $imageFileName = basename($_FILES[$tclubImage]["name"]);
//     // $target_file = $target_dir . $imageFileName;
//     $uniqueId = uniqid(); // Generates a unique ID
//     $target_file = $target_dir . $uniqueId . '_' . $imageFileName;
//     //
//     $uploadOk = 1;

//     // Check if image file is an actual image or fake image
//     if(isset($_POST["submit"])) {
//         $check = getimagesize($_FILES["clubImage"]["tmp_name"]);
//         if($check !== false) {
//             $uploadOk = 1;
//         } else {
//             $_SESSION['error'] = "File is not an image.";
//             $uploadOk = 0;
//             header('Location: ./add-club.php');
//             exit;
//         }
//     }

//     // Check file size - 3MB maximum
//     if ($_FILES["clubImage"]["size"] > 3000000) { // 5000000 for 5Mbs
//         $_SESSION['error'] = "Sorry, your file is too large. Upload images less than 3MB.";
//         $uploadOk = 0;
//         header('Location: ./add-club.php');
//         exit;
//     }

//     // Allow certain file formats
//     // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//     // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
//     // && $imageFileType != "gif" ) {
//     //     $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//     //     $uploadOk = 0;
//     //     header('Location: ./add-club.php');
//     //     exit;
//     // }

//     // Check if $uploadOk is set to 0 by an error
//     if ($uploadOk == 0) {
//         $_SESSION['error'] = "Sorry, your file was not uploaded.";
//         header('Location: ./add-club.php');
//         exit;
//     // if everything is ok, try to upload file
//     } else {
//         if (move_uploaded_file($_FILES["clubImage"]["tmp_name"], $target_file)) {

//             // Set the club image path
//             $tclubImagePath = $target_file;

//             // Process the data to database
//             addclub($email, $password, $tclubImagePath);
           
//         } else {
//             $_SESSION['error'] = "Sorry, there was an error uploading your file.";
//             header('Location: ./add-club.php');
//             exit;
//         }
//     }
//     //
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $clubName = $_POST['clubName'] ?? '';

    // Initialize upload flag
    $uploadOk = 1;

    // Check if a file is uploaded and get the file name
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
            // Set the club image path
            $tclubImagePath = $target_file;

            // Process the data to database
            addclub($email, $password, $clubName, $tclubImagePath);
        } else {
            $_SESSION['error'] = $_SESSION['error'] ?? "Sorry, there was an error uploading your file.";
            header('Location: ./add-club.php');
            exit;
        }
    } else {
        // Handle no file uploaded
        $_SESSION['error'] = "No file uploaded.";
        header('Location: ./add-club.php');
        exit;
    }
}


function addclub($temail, $tpassword, $club_name, $tclubImagePath)
{
    // Create a connection to the database
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Check if club already exists
    $checkSql = "SELECT id FROM clubs WHERE email = ?";
    if ($checkStmt = $conn->prepare($checkSql)) {
        $checkStmt->bind_param("s", $temail);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        if ($result->num_rows > 0) {
            //echo "Club with this email already exists.";
            $_SESSION['error'] = "Club with this email already exists.";
            $checkStmt->close();
            return;
        }
        $checkStmt->close();
    } else {
        //echo "Error preparing statement: " . $conn->error;
        $_SESSION['error'] = "Error preparing statement: " . $conn->error;
        return;
    }

    // Hash the password
    $passwordHash = password_hash($tpassword, PASSWORD_DEFAULT);

     // Prepare an insert statement
     $sql = "INSERT INTO clubs (email, password, clubName, clubImagePath) VALUES (?, ?, ?, ?)";

     if ($stmt = $conn->prepare($sql)) {
         $stmt->bind_param("ssss", $temail, $passwordHash, $club_name, $tclubImagePath);

         if ($stmt->execute()) {
             $_SESSION['success'] = "The Club was registered successfully.";
             header('Location: ./clubs.php');
             exit;
         } else {
             $_SESSION['error'] = "Error: " . $stmt->error;
             header('Location: ./add-club.php');
             exit;
         }

         $stmt->close();
     } else {
         $_SESSION['error'] = "Error preparing statement: " . $conn->error;
         header('Location: ./add-club.php');
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
            <a class="nav-link active" href="./add-club.php"><?php echo $lang["addclubs_l"]; ?></a>
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
                        <label for="clubName"><?php echo $lang["clubName"]; ?>:</label>
                        <input type="text" class="form-control" id="clubName" name="clubName" placeholder="<?php echo $lang["enter_club_name"]; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email"><?php echo $lang["email"]; ?>:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="<?php echo $lang["enter_email"]; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="pwd"><?php echo $lang["password"]; ?>:</label>
                        <input type="text" class="form-control" id="pwd" name="password" placeholder="<?php echo $lang["enter_password"]; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="clubImage"><?php echo $lang["ClubImage"]; ?>:</label>
                        <input type="file" class="form-control" id="clubImage" name="clubImage" placeholder="<?php echo $lang["choose_club_image"]; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo $lang["create_btn"]; ?></button>
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