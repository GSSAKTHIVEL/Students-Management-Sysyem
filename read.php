<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM Students_Details WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_Id);
        
        // Set parameters
        $param_Id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Retrieve individual field value
                $Register_Number = $row["Register_Number"];
                $First_Name = $row["First_Name"];
                $Last_Name = $row["Last_Name"];
                $Mobile_Number = $row["Mobile_Number"];
                $Email_Id = $row["Email_Id"];
                $University_Name = $row["University_Name"];
                $District = $row["District"];
                $Year = $row["Year"];
                $Semester = $row["Semester"];
                $Date_of_Birth = $row["Date_of_Birth"];
                $Address = $row["Address"];

            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body
        {
            background: linear-gradient(lightgray,whitesmoke,white);
            margin-top: -60px;
        }
        .wrapper{
            width: 600px;
            margin: 20px auto;
            background: linear-gradient(lightgray,whitesmoke,lightgray);
        }
        label
         {
            color: darkgray;
            font-weight: bold;
            font-size: 22px;
         }
         p
         {
            font-size: 20px;
         }
         h1
         {
            text-decoration: underline;
         }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Register Number</label>
                        <p><b><?php echo $row["Register_Number"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <p><b><?php echo $row["First_Name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <p><b><?php echo $row["Last_Name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <p><b><?php echo $row["Mobile_Number"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <p><b><?php echo $row["Gender"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Email Id</label>
                        <p><b><?php echo $row["Email_Id"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>University Name</label>
                        <p><b><?php echo $row["University_Name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>District</label>
                        <p><b><?php echo $row["District"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Year</label>
                        <p><b><?php echo $row["Year"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <p><b><?php echo $row["Semester"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <p><b><?php echo $row["Date_of_Birth"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <p><b><?php echo $row["Address"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
