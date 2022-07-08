<?php

//Connect to the database
//Throw error and stop executing on failure.
function esa_connect()
{
    //Connect to the sql database. Throw error and stop executing on failure.
    $connection = mysqli_connect('localhost', 'root', '', 'esa_database');
    if (mysqli_connect_errno()) {
        exit("Failed to connect: " + mysqli_connect_error());
    }
    return $connection;
}


//Perform SQL query
//Return result
//Throw error and stop executing on failure.
function esa_query($connection, $query)
{
    $query = mysqli_query(
        $connection,
        $query
    );
    if (!$query) {
        exit("Failed: " + mysqli_error($connection));
    }
    return $query;
}

function esa_output_mission_table($connection)
{
    echo "
    <table class='table table-striped table-hover table-bordered caption-top'>
    <caption>Missions <a href='mission.php'><i class='bi bi-plus-lg'></i></a></caption>
    <thead>
        <tr class='table-primary'>
            <th scope='col'>ID</th>
            <th scope='col'>Name</th>
            <th scope='col'>Type</th>
            <th scope='col'>Target</th>
            <th scope='col'>Launch Date</th>
            <th scope='col'>Crew Size</th>
        </tr>
    </thead>
    ";

    $query = esa_query($connection, "SELECT * FROM mission");
    while ($row = mysqli_fetch_assoc($query)) {
        echo
        "<tr>
        <td>{$row['mission_id']}</td>
        <td>{$row['mission_name']}</td>
        <td>{$row['mission_type']}</td>
        <td>{$row['target']}</td>
        <td>{$row['launch_date']}</td>
        <td>{$row['crew_size']}</td>
        </tr>";
    }

    echo "</table>";
}

function esa_output_target_table($connection)
{
    echo "
    <table class='table table-striped table-hover table-bordered caption-top'>
    <caption>Targets <a href='target.php'><i class='bi bi-plus-lg'></i></a></caption>
    <thead>
        <tr class='table-primary'>
            <th scope='col'>ID</th>
            <th scope='col'>Name</th>
            <th scope='col'>Type</th>
            <th scope='col'>First Mission</th>
            <th scope='col'>No Missions</th>
        </tr>
    </thead>
    ";

    $query = esa_query($connection, "SELECT * FROM target");
    while ($row = mysqli_fetch_assoc($query)) {
        echo
        "<tr>
        <td>{$row['target_id']}</td>
        <td>{$row['target_name']}</td>
        <td>{$row['target_type']}</td>
        <td>{$row['first_mission']}</td>
        <td>{$row['no_missions']}</td>
        </tr>";
    }

    echo "</table>";
}

function esa_output_astronaut_table($connection)
{
    echo "
    <table class='table table-striped table-hover table-bordered caption-top'>
    <caption>Astronauts <a href='astronaut.php'><i class='bi bi-plus-lg'></i></a></caption>
    <thead>
        <tr class='table-primary'>
            <th scope='col'>ID</th>
            <th scope='col'>Name</th>
            <th scope='col'>No Missions</th>
        </tr>
    </thead>
    ";

    $query = esa_query($connection, "SELECT * FROM astronaut");
    while ($row = mysqli_fetch_assoc($query)) {
        echo
        "<tr>
        <td>{$row['astronaut_id']}</td>
        <td>{$row['astronaut_name']}</td>
        <td>{$row['no_missions']}</td>
        </tr>";
    }

    echo "</table>";
}

function esa_output_astronaut_mission_table($connection)
{
    echo "
    <table class='table table-striped table-hover table-bordered caption-top'>
    <caption>Assign astronauts to missions <a href='assign_astronaut.php'><i class='bi bi-plus-lg'></i></a></caption>
    <thead>
        <tr class='table-primary'>
            <th scope='col'>Astronaut ID</th>
            <th scope='col'>Mission ID</th>
        </tr>
    </thead>
    ";

    $query = esa_query($connection, "SELECT * FROM astronaut_mission");
    while ($row = mysqli_fetch_assoc($query)) {
        echo
        "<tr>
        <td>{$row['astronaut_id']}</td>
        <td>{$row['mission_id']}</td>
        </tr>";
    }

    echo "</table>";
}
