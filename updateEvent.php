<?php
// JOIN session
// session_start();

// ALLOW access by making sure validUser session variable isset 
// and validUser session variable is valid
// if(isset($_SESSION['validUser']) && $_SESSION['validUser']){
    
// }else{
    // Deny access if false and redirect to the login form page
//     header("Location: login.php");
// }
$updateId = $_GET['eventId'];

$dateUpdated = currentDateSQLFormat();


function currentDateSqlFormat()
{
    $date = date_default_timezone_set("America/Chicago");   // sets the date to central US time since server is in EU
    $date = date("Y-m-d");                                  // assign formatted date in $date variable   
    return $date;                                           // return the sql formatted date
}// end currentDateSqlFormat()

if(isset($_POST['submit'])){

    // honeypot validation
    $host = $_POST['events_host'];
    if(!empty($host)){
        header("refresh:0");    // refreshes page if text field is not empty
    }else{
  
        
        $eventName = $_POST['events_name'];
        $eventDescription = $_POST['events_description'];
        $eventPresenter = $_POST['events_presenter'];
        $eventDate = $_POST['events_date'];
        $eventTime = $_POST['events_time'];
        $eventDateInserted = $_POST['events_date_inserted'];
        $eventDateUpdated = $dateUpdated;
        
        try {       
            require 'dbConnect.php';	//CONNECT to the database
            //$sql = "SELECT * from wdv341_events";
            //Create the SQL command string
            $sql = "UPDATE wdv341_events SET ";   // db table columns
            $sql .= "events_name =:eventName, ";
            $sql .= "events_description =:eventDescription, ";
            $sql .= "events_presenter =:eventPresenter, ";
            $sql .= "events_date =:eventPresenter, ";
            $sql .= "events_time =:eventTime, ";
            $sql .= "events_date_inserted =:eventDateInserted, ";
            $sql .= "events_updated_date =:eventDateUpdated ";
            $sql .= "WHERE events_id =:eventId";
            
            //PREPARE the SQL statement
            $stmt = $conn->prepare($sql);
            
            //BIND the values to the input parameters of the prepared statement
            $stmt->bindParam(':eventId', $updateId);
            $stmt->bindParam(':eventName', $eventName);
            $stmt->bindParam(':eventDescription', $eventDescription);		
            $stmt->bindParam(':eventPresenter', $eventPresenter);		
            $stmt->bindParam(':eventPresenter', $eventDate);		
            $stmt->bindParam(':eventTime', $eventTime);
            $stmt->bindParam(':eventDateInserted', $eventDateInserted);
            $stmt->bindParam(':eventDateUpdated', $eventDateUpdated);		
            
            //EXECUTE the prepared statement
            $stmt->execute();
            
            //$newEventId =  $conn->lastInsertId();   // grabs last event id
            
            //send user to "a response page" to display to the customer that everything worked
            header('Location: selectEvents.php?eventId=' . $updateId . '&eventName=' . $eventName);     
        }
        
        catch(PDOException $e)
        {
            $message = "There has been a problem. The system administrator has been contacted. Please try again later.";
            error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
        }
    }
}else{
  try{
      include "dbConnect.php";
      
      $sql = "SELECT * FROM wdv341_events WHERE events_id =:eventId";   //sql command as a string variable formats time and date in sql
      $stmt = $conn->prepare($sql);           // prepare the statement
      $stmt->bindParam(':eventId', $updateId);
      $stmt->execute();                       // the result object is still in database format not directly readable
  
      $result = $stmt->fetch(PDO::FETCH_ASSOC);


  }
  catch(PDOException $e){
    $message = "There has been a problem. The system administrator has been contacted. Please try again later.";
    error_log($e->getMessage());	
  }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatable" content="IE=edge">
        <meta name="viewport" content="width=device-width, intial-scale=1.0">
        <title>Create a form page for the events</title>
        <!--Jeremy Brannen
            WDV341 Create a form page for the events-->

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
            a:hover{
                color: purple;
                text-decoration: none;
            }
            div:nth-child(4){
                display: none;
            }
            
        </style>
    </head>

    <body>
        <h1 class="text-center">Update Event</h1>
        <h2 class="text-center">WDV341 Intro PHP</h2>
        
        <div class= "jumbotron col-md-4 mx-auto border border-dark rounded-lg m-4 p-4" style="background-color:lightgray">
            
            <form name="eventsForm" id="eventsForm" method="post" action="updateEvent.php?eventId=<?php echo $updateId; ?>">

                <div class="form-group">
                    <label for="events_name">Event Name: </label>
                    <input type="text" class="form-control form-control-sm" name="events_name" id="events_name" value="<?php echo $result['events_name']; ?> ">
                </div>

                <div class="form-group">
                    <label for="events_description">Event Description: </label>
                    <input type="text" class="form-control form-control-sm" name="events_description" id="events_description" value="<?php echo $result['events_description']; ?> ">
                </div>
                    
                <div class="form-group">
                    <label for="events_presenter">Event Presenter: </label>
                    <input type="text" class="form-control form-control-sm" name="events_presenter" id="events_presenter" value="<?php echo $result['events_presenter']; ?> "> 
                </div>

                <div class="form-group">
                    <label for="events_host">Event Host: </label>
                    <input type="text" class="form-control form-control-sm" name="events_host" id="events_host" value="">
                </div>
                    
                <div class="form-group">
                    <label for="events_date">Event Date: </label>
                    <input type="date" class="form-control form-control-sm" name="events_date" id="events_date" value="<?php echo $result['events_date']; ?> "> 
                </div>
                    
                <div class="form-group">
                    <label for="events_time">Event Time: </label>
                    <input type="time" class="form-control form-control-sm" name="events_time" id="events_time" value="<?php echo $result['events_time']; ?> "> 
                </div>
                    
                <div class="form-group">
                    <label for="events_date_inserted">Event Date Inserted: </label>
                    <input type="text" class="form-control form-control-sm" name="events_date_inserted" id="events_date_inserted" value="<?php echo $result['events_date_inserted']; ?> " readonly> 
                </div>

                <div class="form-group">
                    <label for="events_updated_date">Event Date Updated: </label>
                    <input type="text" class="form-control form-control-sm" name="events_updated_date" id="events_updated_date" value="<?php echo $result['events_updated_date']; ?> " readonly> 
                </div>
                    
                <div class="text-center">
                    <input type="submit" class="bg-primary text-light rounded-sm" name="submit" id="submit" value="Save">
                    <input type="reset" name="Reset" id="button" value="Reset Form">
                </div>
            </form>
        </div>
        <footer>

            <p class="text-center">
                <a target="_blank"href="https://github.com/jrbrannen/Create-Delete-Functionality-PHP.git">GitHub Repo Link</a>    <!--  GitHub Repo Link -->
            </p>

            <p class="text-center">
                <a href="../wdv341.php">PHP Homework Page</a>    <!-- Homework page link -->
            </p>

        </footer>

    </body>

</html>
<?php
    }
?>