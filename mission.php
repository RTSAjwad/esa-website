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
    <title>Add Mission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <!-- HTML FORM FOR ADDING MISSION -->
                <form method="post">
                    <h1>Add Mission</h1>
                    <label class="form-label" for="name">Enter mission name: </label>
                    <input class="form-control" name="name" type="text">
                    <label class="form-label" for="name">Enter type: </label>
                    <input class="form-control" name="type" type="text">
                    <label class="form-label" for="target">Select target: </label>
                    <select class="form-select" name="target" id="target">
                        <?php
                        //Allows the user to select which target they want to link to the mission
                        //by creating dropdown menu options from target table query
                        $target_dropdown_data_query = esa_query($connection, "SELECT target_id, target_name FROM target");
                        while ($row = mysqli_fetch_assoc($target_dropdown_data_query)) {
                            echo "<option value='{$row['target_id']}'>{$row['target_name']}</option>";
                        }
                        ?>
                    </select>
                    <label class="form-label" for="launch_date">Enter launch date: </label>
                    <input class="form-control" name="launch_date" type="date">
                    <input class="btn btn-primary" type="submit">
                </form>
            </div>
            <div class="col">
                <?php
                //Output the target table
                esa_output_mission_table($connection);
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

</body>

</html>
<?php

//We need to add validation to make sure we need to add atleast 2 astronauts to Astronauts_Missions

//If values have been set in input fields and are not empty
if (!empty($_POST['name']) && !empty($_POST['type']) && !empty($_POST['target']) && !empty($_POST['launch_date'])) {

    //Capture user input and store into variables
    $name = $_POST["name"];
    $type = $_POST["type"];
    $target = $_POST["target"];
    $launch_date = $_POST["launch_date"];

    //Insert new row to mission table in database containing captured user input.
    esa_query($connection, "INSERT INTO mission (mission_name, mission_type, target, launch_date) VALUES ('$name', '$type', '$target', '$launch_date')");

    //Increment the number of missions for the missions target.
    esa_query($connection, "UPDATE target SET no_missions = no_missions + 1 WHERE target_id = {$target}");

    //Select the first_mission from the missions target and store it as a variable
    $first_mission_id = mysqli_fetch_array(esa_query($connection, "SELECT first_mission FROM target WHERE target_id = {$target}"))['first_mission'];

    //Select the mission_id for the newly made mission and store it as a variable
    $new_mission_id = mysqli_fetch_array(esa_query($connection, "SELECT mission_id FROM mission WHERE mission_name = '{$name}'"))['mission_id'];

    //If it does have a first_mission already set (not NULL) then both missions launch_date must be compared to set the earlier one as first_mission.
    if ($first_mission_id == NULL) {
        //Set the new mission to its targets first mission if it doesn't already have a first mission
        esa_query($connection, "UPDATE target SET first_mission = {$new_mission_id} WHERE target_id = {$target}");
    } else {
        //Set the first_mission to the mission with the earliest launch date
        $first_mission_launch_date = mysqli_fetch_array(esa_query($connection, "SELECT launch_date FROM mission WHERE mission_id = {$first_mission_id}"))['launch_date'];

        if ($first_mission_launch_date > $launch_date) {
            //Set the first_mission to the mission with the earliest launch date
            esa_query($connection, "UPDATE target SET first_mission = {$new_mission_id} WHERE target_id = {$target}");
        }
    }
    //Close the database connection
    mysqli_close($connection);

    //Redirect to the current page to reset and stop excecuting php
    header("Location: dashboard.php");

    //Stop executing the script
    exit();
}

//Make sure we redirect if the request method for the page is POST and input wasn't accepted 
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Redirect back to the table view
    header("Location: mission.php");

    //Stop executing the script
    exit();
}
?>