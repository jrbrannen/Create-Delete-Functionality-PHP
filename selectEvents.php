<?php

    include "dbConnect.php";

    try{
        $sql = "SELECT * FROM wdv341_events";   //sql command as a string variable formats time and date in sql
        $stmt = $conn->prepare($sql);           // prepare the statement
        $stmt->execute();                       // the result Object is still in database format not directly readable
    }
    catch(PDOException $e){
        echo "Errors: " . $e->getMessage();
    }
   
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatable" content="IE=edge">
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <title>Select Events</title>

        <!--Jeremy Brannen
            WDV341 7-1 Select Events-->

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

        <style>
                
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');
            body{
                font-family: 'Open Sans', sans-serif;
            }

            h1, h2{
            color: purple;
            }

            a:hover{
                color: purple;
                text-decoration: none;
            }
            
        </style>

    </head>

    <body class="col-10 mx-auto">

        <h1 class="text-center"> WDV341 Intro PHP </h1>
        <h2 class="text-center"> Select Events-PHP </h2>

        <?php
            if(!empty($_GET['eventId'])){
              $id = $_GET['eventId'];
              $name = $_GET['eventName'];
        ?>
            <h2 class="text-primary text-center">Event Named <?php echo $name ?> Is Updated</h2>
        <?php 
            }
        ?>
        <table class="table"> <!-- Displays a table to the browser with headers-->
            <thead>
                <tr>
                    <th scope="col">Event Id</th>
                    <th scope="col">Event</th>
                    <th scope="col">Time</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>

            <?php
                foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $result) {     // php is coded so that no data or html will show if database is empty
            ?>      
                <tbody>
                    <tr>
                        <th scope="row"><?php echo $result['events_id']; ?></th>
                        <td><?php echo $result['events_name']; ?></td>
                        <td><?php echo $result['events_time']; ?></td>
                        <td><?php echo $result['events_date']; ?></td>
                         <!-- pass the selected event id as a get parameter on the url -->
                        <td><?php echo "<a href=updateEvent.php?eventId=" . $result['events_id'] . ">Update Link</a>" ?></td>
                        <td><?php echo "<a href=deleteEvent.php?eventId=" . $result['events_id'] . ">Delete Link</a>" ?></td>

                        <?php 
                            


                        ?>
                    </tr>
                </tbody>
            
            <?php
                } // end of foreach()        
            ?>
        </table>  
        
        <footer>

            <p class="text-center">
                <a target="_blank"href="https://github.com/jrbrannen/Create-Delete-Functionality-PHP.git">GitHub Repo Link</a>
            </p>
            
            <p class="text-center">
                <a href="../../wdv341.php">PHP Homework Page</a>    <!-- Homework page link -->
            </p>
        </footer>

    </body>

</html>