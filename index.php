<?php
// start session
session_start();

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
    'welcome' => 'Welcome',
    'title' => 'Sports Management System',
    'select_portal' => 'Select your portal to login.',
    'admin_portal' => 'Admin Portal',
    'club_portal' => 'Club Portal',
    'admin_text' => 'For administrators to manage the system.',
    'club_text' => 'For clubs to access their information.',
    'admin_login_btn' => 'Admin Login',
    'club_login_btn' => 'Club Login',
    //
];

$german = [
    'welcome' => 'Willkommen',
    'title' => 'Sportverwaltungssystem',
    'select_portal' => 'Wählen Sie Ihr Portal aus, um sich anzumelden.',
    'admin_portal' => 'Admin-Portal',
    'club_portal' => 'Club-Portal',
    'admin_text' => 'Für Administratoren, um das System zu verwalten.',
    'club_text' => 'Für Vereine, um auf ihre Informationen zuzugreifen.',
    'admin_login_btn' => 'Admin Login',
    'club_login_btn' => 'Club Login',
    //
];
//
// check session for selected langu and decide on the array to use
$lang = $_SESSION['lang'] == 'en' ? $english : $german;

// use the $lang array to translate the page
// echo $lang['welcome'];
?>
<!--  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang['title']; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Custom styles -->
    <style>
        html, body {
            height: 98%;
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 0;
            padding-bottom: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 700px;
        }
        .card {
            margin-bottom: 20px;
        }
        /*  */
        #logo{
            width: 100%;
            max-width: 300px;
            margin: -70px auto;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header text-center">
        <!--  -->
        <div>
            <!-- Language selection buttons -->
            <a href="?lang=en"><img style="margin: 10px;" width="40" src="./common/images/us.webp" alt="English"></a>
            <a href="?lang=de"><img style="margin: 10px;" width="40" src="./common/images/de.webp" alt="German"></a>
        </div>
        <!--  -->
        <h1><?php echo $lang['title']; ?></h1>
        <div class="row">
            <img id="logo" src="./common/images/logo.png" alt="Hey Sponsor Logo">
        </div>
        <p class="lead"><?php echo $lang['select_portal']; ?></p>
    </div>
    
    <div class="row mt-5">
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header"><?php echo $lang['admin_portal']; ?></div>
                <div class="card-body text-center d-flex flex-column">
                    <p class="card-text flex-fill"><?php echo $lang['admin_text']; ?></p>
                    <a href="admin/index.php" class="btn btn-primary btn-custom mt-auto"><?php echo $lang['admin_login_btn']; ?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header"><?php echo $lang['club_portal']; ?></div>
                <div class="card-body text-center d-flex flex-column">
                    <p class="card-text flex-fill"><?php echo $lang['club_text']; ?></p>
                    <a href="club/index.php" class="btn btn-success btn-custom mt-auto"><?php echo $lang['club_login_btn']; ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>