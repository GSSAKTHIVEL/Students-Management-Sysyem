<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .wrapper{
            width: 510px;
            position: absolute;
            
        }
        table tr td:last-child{
            width: 100px;

        }
       
         .navbar
        {
            margin-left: -12px;
            width: 100%;
            position: fixed;
            z-index: 1;
            padding: 1px;
            

        }
        .rounded-circle
        {
            width: 50px;
        }
        .sms
        {
            font-size: 22px;

        }
        .nav-item a
        {
            font-size: 20px;
            margin-left: 20px;
        }
         .clearfix
         {
            position: fixed;
            background:lightblue;
            width: 100%;
            height: 50px;
            margin-left: -12px;
         }
      
     
       .nav-link
       {
        font-size: 18px;
       }
       .nav-link:hover
       {
         text-decoration: underline;
         text-decoration-color: white;

       }
       /*Export data*/
       .text-end
       {
         background:white;
         height: 50px;
         margin-top: -4px;
       }
       .dnd
       {
        color:green;
       }
      
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
     <div class="container-fluid">
    <nav class="navbar navbar-expand-sm bg-info navbar-dark">
       <div class="container-fluid">
         <a class="navbar-brand" href="#"><img src="image/logo.jpg" class="rounded-circle">
            <span class="sms">SMS</span></a>
            <a href="logout.php" class="btn btn-danger mr-1 fs-5">Log out</a>
        </div>
      </nav>
     </div>  
<br>
    <div class="wrapper">
    
        <div class="container-fluid">
                
            <div class="row">
                <div class="col-md-12" style="margin-top: -15px;">
                    <div class="mt-5 clearfix">
                        <div class="row">
                            <div class="col">
                        <h2 class="pull-left ml-2 p-1"> Students Details</h2>
                    </div>
                    <div class="col">
                        <a href="create.php" class="btn btn-success mt-1" style="margin-left: -22px;"><i class="fa fa-plus"></i> Add New Students Details</a>
                    </div>
                </div>
                 <div class="text-end">

                        <a href="export.php" class="btn btn-warning mr-5 mt-1 text-success fw-bold" target="_blank"><i class="fa fa-download dnd"></i> Data Export</a>
                    </div>
                    </div><br><br><br><br><br><br>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM Students_Details";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                           
                            echo '<table class="table table-bordered table-striped mt-1">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Id</th>";
                                        echo "<th>Register_Number</th>";
                                        echo "<th>First_Name</th>";
                                        echo "<th>Last_Name</th>";
                                        echo "<th>Mobile_Number</th>";
                                        echo "<th>Gender</th>";
                                        echo "<th>Email_Id</th>";
                                        echo "<th>University_Name</th>";
                                        echo "<th>District</th>";
                                        echo "<th>Year</th>";
                                        echo "<th>Semester</th>";
                                        echo "<th>Date_of_Birth</th>";
                                        echo "<th>Address</th>";
                                        echo "<th>Actions</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                 echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['Id'] . "</td>";
                                        echo "<td>" . $row['Register_Number'] . "</td>";
                                        echo "<td>" . $row['First_Name'] . "</td>";
                                        echo "<td>" . $row['Last_Name'] . "</td>";
                                        echo "<td>" . $row['Mobile_Number'] . "</td>";
                                        echo "<td>" . $row['Gender'] . "</td>";
                                        echo "<td>" . $row['Email_Id'] . "</td>";
                                        echo "<td>" . $row['University_Name'] . "</td>";
                                        echo "<td>" . $row['District'] . "</td>";
                                        echo "<td>" . $row['Year'] . "</td>";
                                        echo "<td>" . $row['Semester'] . "</td>";
                                        echo "<td>" . $row['Date_of_Birth'] . "</td>";
                                        echo "<td>" . $row['Address'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $row['Id'] .'" class="mr-1" data-bs-toggle="modal" data-bs-target="#myModall" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $row['Id'] .'"class="mr-1" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $row['Id'] .'" class="mr-1"title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                   


                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>

                </div>
            </div>        
        </div>
             
    </div>

    
</body>
</html>