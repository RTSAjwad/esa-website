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
    <title>Add Astronaut</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <!-- HTML FORM FOR ADDING ASTRONAUT -->
                <form method="post">
                    <h1>Add Astronaut</h1>
                    <label class="form-label" for="name">Enter astronaut name: </label>
                    <input class="form-control" name="name" type="text">
                    <input class="btn btn-primary" type="submit">
                </form>
            </div>
            <div class="col">
                <?php
                //Output the target table
                esa_output_astronaut_table($connection);
                ?>
            </div>
        </div>
    </div>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
</body>
<?php

//Makes sure code only excecutes when name is submitted and not empty
if (!empty($_POST['name'])) {

    echo $_SERVER['REQUEST_METHOD'];
    //Capture the name input and store it in a variable
    $name = $_POST["name"];

    //Perform an sql query to insert the new astronaut
    esa_query($connection, "INSERT INTO astronaut (astronaut_name) VALUES ('$name')");

    //Close connection to the database.
    mysqli_close($connection);

    //Redirect back to the table view
    header("Location: dashboard.php");

    //Stop executing the script
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