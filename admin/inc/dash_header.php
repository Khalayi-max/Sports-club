<?php
//session_start(); // Start the session.



// 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php //echo $lang['title']; ?>
        Admin panel
    </title>
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
        .active{
            background-color: #007bff;
            color: white;
            border-radius: 4px;
        }
        /* ... [existing styles] ... */
        /* Mobile Responsive */
        @media (max-width: 768px) {
        .dashboard-wrap {
            flex-direction: column;
        }
        .side-panel {
            width: 100%;
            min-width: auto;
            height: auto;
            padding: 10px;
        }
        .dashboard-content {
            width: 100%;
            min-width: auto;
            padding: 10px;
        }
    }
    /* End of Mobile Responsive */

    .side-panel .nav-link.active {
        background-color: #007bff; /* Bootstrap primary color */
        color: white;
        border-radius: 4px;
    }
    /*  */
    </style>
</head>
<body>