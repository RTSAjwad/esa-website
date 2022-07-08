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
    <title>Add Astronaut To Mission</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <!-- HTML FORM FOR ASSIGNING ASTRONAUT -->
                <form method="post">
                    <h1>Add Astronaut to Mission</h1>
                    <label class="form-label" for="astronaut_id">Select Astronaut: </label>
                    <select class="form-select" name="astronaut_id">
                        <?php
                        //Allows the user to select which astronaut they want to assign
                        //by creating dropdown menu options from astronaut table query
                        $target_dropdown_data_query = esa_query($connection, "SELECT astronaut_id, astronaut_name FROM astronaut");
                        while ($row = mysqli_fetch_assoc($target_dropdown_data_query)) {
                            echo "<option value='{$row['astronaut_id']}'>{$row['astronaut_id']}: {$row['astronaut_name']}</option>";
                        }
                        ?>
                    </select>
                    <label class="form-label" for="astronaut_id">Select Mission: </label>
                    <select class="form-select" name="mission_id">
                        <?php
                        //Allows the user to select which mission they want to assign
                        //by creating dropdown menu options from mission table query
                        $target_dropdown_data_query = esa_query($connection, "SELECT mission_id, mission_name FROM mission");
                        while ($row = mysqli_fetch_assoc($target_dropdown_data_query)) {
                            echo "<option value='{$row['mission_id']}'>{$row['mission_id']}: {$row['mission_name']}</option>";
                        }
                        ?>
                    </select>
                    <input class="btn btn-primary" type="submit">
                </form>
            </div>
            <div class="col">
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
<?php

//Check if the post user input has been recieved
if (isset($_POST['astronaut_id']) && isset($_POST['mission_id'])) {

    //Store the user input in variables
    $astronaut_id = $_POST["astronaut_id"];
    $mission_id = $_POST["mission_id"];

    //Insert the astronaut and mission ids into a new row.
    esa_query($connection, "INSERT INTO astronaut_mission (astronaut_id, mission_id) VALUES ('{$astronaut_id}', '{$mission_id}')");

    //Increment the number of missions for the astronaut that has just been assigned a mission
    esa_query($connection, "UPDATE astronaut SET no_missions = no_missions + 1 WHERE astronaut_id = {$astronaut_id}");

    //Increment the crew_size for the mission that has just been assigned an astronaut
    esa_query($connection, "UPDATE mission SET crew_size = crew_size + 1 WHERE mission_id = {$mission_id}");

    //close the connection to the database
    mysqli_close($connection);

    //Redirect back to the table view
    header("Location: dashboard.php");

    //stop executing script
    exit();
}

//Make sure we redirect if the request method for the page is POST and input wasn't accepted 
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Redirect back to the table view
    header("Location: astronaut.php");

    //Stop executing the script
    exit();
}
?>

</html>