<?php
// session
session_start();

// Check if the user is not logged in, then redirect to the login page.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../index.php'); // Redirect to the login page.
    exit; // Stop further execution of the script.
}
//
// Include config file
require_once '../../common/inc/database.php';

$host = DB_SERVER;
$dbname = DB_NAME;
$user = DB_USERNAME;
$pass = DB_PASSWORD;

$id = 0;
// $partners = [];
// When View Club is clicked
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // fetch club info with this id
    $stmt = $pdo->prepare('SELECT * FROM clubs WHERE id = ?');
    $stmt->execute([$id]);
    $club = $stmt->fetch(PDO::FETCH_ASSOC);

    // fetch all partners with this id
    $stmt = $pdo->prepare('SELECT * FROM partners WHERE club_id = ?');
    $stmt->execute([$id]);
    $partners = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // fetch all contracts with this id
    $stmt = $pdo->prepare('SELECT * FROM contracts WHERE club_id = ?');
    $stmt->execute([$id]);
    $contracts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // fetch all advertising spaces with this id
    $stmt = $pdo->prepare('SELECT * FROM advertising_spaces WHERE club_id = ?');
    $stmt->execute([$id]);
    $advertising_spaces = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
//
?>
<!-- include dash_header -->
<?php include '../inc/dash_header.php'; ?>
<style>
    i {
        color: white;
    }
</style>
<div class="dashboard-wrap">
    <!-- Side Panel -->
    <style>
        .side-panel nav a{
            border-bottom: 1px solid #ccc;
        }
    </style>
    <div class="side-panel">
        <nav class="nav flex-column">
            <a class="nav-link" href="./index.php">Dashboard</a>
            <a class="nav-link" href="./clubs.php">Clubs</a>
            <a class="nav-link active" href="./club-overview.php">Club Overview</a>
            <a class="nav-link" href="./add-club.php">Add New Clubs</a>
            <a href="../logout.php" class="btn btn-danger">Sign Out</a>
        </nav>
    </div>

    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <!--  -->
        <h2> Club Overview - <?php echo $club['email'] ?? "No Club Email Found!"; ?></h2>
        <!--  -->
        <hr>
        <div class="row">
            <!--  -->
            <div class="card mt-5">
        <div class="card-header">
            <!--  -->
            <!-- Trigger Button for Modal -->
            <!-- <button type="button" class="btn btn-secondary  mr-2" data-toggle="modal" data-target="#addPartnerModal">
                 <i class="fas fa-plus fa-2x"></i>
            </button> -->
            <!--  -->
            Partners
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Contact Person</th>
                        <th scope="col">Email</th>
                        <th scope="col">Address</th>
                        <th scope="col">Telephone</th>
                        <th scope="col">Contracts</th>
                        <th scope="col">Update</th>
                        <th scope="col">Delete</th>
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
                            echo "<a class='dashboard-link' href='./delete-partner.php?id=" . $partner['id'] . "' class='btn btn-success btn-sm'>
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
        </div>
        <hr>
        <div class="row">
            <!--  -->
            <div class="card">
                <div class="card-header">
                    <!-- Modal Trigger Button -->
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAdModal">
                        <i class="fas fa-plus fa-2x"></i>
                    </button> -->
                    <!--  -->
                    Add Advertising Spaces
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
                            <th>Advertising Space Name</th>
                            <th>Unit</th>
                            <th>Number</th>
                            <th>Price/unit</th>
                            <th>Inventory-Value</th>
                            <th>Sold</th>
                            <th>Workload</th>
                            <th>Value sold</th>
                            <th>Proceeds</th>
                            <th>Edit</th>
                            <th>Delete</th>
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
        </div>
        <hr>
        <hr>
        <div class="row mt-5">
        <!--  -->
        <div class="col-md-3 mb-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header">
                    All Contracts
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <!-- Modal Trigger Button -->
                    <button type="button" class="btn btn-secondary btn-lg" data-toggle="modal" disabled data-target="#addContractModal">
                    <i class="fas fa-file-contract fa-2x"></i>
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

<!-- include dash_footer -->
<?php include '../inc/dash_footer.php'; ?>