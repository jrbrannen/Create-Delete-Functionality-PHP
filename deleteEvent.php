<?php
    
    // get the selected event id as a get parameter on the url
    // echo $_GET['eventId'];
    $deleteId = $_GET['eventId'];
    $deleteName =$_GET['eventName'];
    // -connect to the db
    // -write the sql
    // -prepare the stmt
    // -bind param (if any)
    // -execute the stmt
    // -confirm/error check

    try{
        require 'dbConnect.php';

        $sql = "DELETE FROM wdv341_events WHERE events_id=:eventId"; 
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':eventId', $deleteId);
        $stmt->execute();

        // how many rows were affected by the previous SQL execute
        // echo "<h1>Number of rows deleted:" .$stmt->rowCount() . "<h1>"; 
        $numDeleted = $stmt->rowCount();    // flag
        // if row count > 0 assume sucessful delete of record
        // display confirmation page
      
    }
    catch(PDOException $e){
        $message = "There has been a problem. The system administrator has been contacted. Please try again later.";
        error_log($e->getMessage());			//Delivers a developer defined error message 
        
        $numDeleted = -1; // flag tells that deleted didn't work
    }
    


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatable" content="IE=edge">
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <title>Delete Event</title>
        <!--Jeremy Brannen
            Create Delete Funcionality-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script>

        </script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');
            body{
                font-family: 'Open Sans', sans-serif;
            }
            h1, h2{
            color: purple;
            }
            a:hover{
                text-decoration: none;
            }
        </style>
    </head>

    <body>
    <?php
        if($numDeleted > 0){
          // if good delete comfirmation and provide link back to login
    ?>      
            <h1 class='text-danger text-center'>Your Event " <?php $deleteName ?>  " Was Successfully Deleted!</h1>
            <h2 class='text-center'>You will be redirected momentarily.<br>  
                If you are not redircted please click the link below.
            </h2>
            <div class='d-flex justify-content-center'>
              <button class='btn btn-outline-primary text-center'><a href='selectEvents.php'>Redirect</a></button>
            </div>
    <?php 
            header('refresh:7; url=//localhost/wdv341/unit 15 SQL Delete/Examples/selectEvents.php');
        }else{
        // else display error msg, provide link back to selectEvents to try again
    ?>   
            <h1 class='text-danger text-center'>Delete Unsuccessful!  Please Try Again.</h1>
            <h2 class='text-center'>You will be redirected momentarily.<br>  
                If you are not redircted please click the link below.
            </h2>
            <div class='d-flex justify-content-center'>
              <button class='btn btn-outline-primary text-center'><a href='selectEvents.php'>Redirect</a></button>
            </div>
    <?php
            header('refresh:7; url=//localhost/wdv341/unit 15 SQL Delete/Examples/selectEvents.php');
        }
    ?>
    </body>

</html>