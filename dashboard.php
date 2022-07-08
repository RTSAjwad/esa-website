<?php
//Start buffering the output
ob_start();

//Including functions.php allows for handy functions to prevent code duplication
include("functions.php");

//connect to database
$connection = esa_connect();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <?php
                //Output the mission table
                esa_output_mission_table($connection);
                ?>
            </div>
            <div class="col-6">
                <?php
                //Output the target table
                esa_output_target_table($connection);
                ?>
            </div>
            <div class="col-6">
                <?php
                //Output the target table
                esa_output_astronaut_table($connection);
                ?>
            </div>
            <div class="col-6">
                <?php
                //Output the target table
                esa_output_astronaut_mission_table($connection);
                ?>
            </div>
        </div>
    </div>

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
</body>

</html>