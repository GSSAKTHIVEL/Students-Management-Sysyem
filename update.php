<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$Register_Number = $First_Name = $Last_Name =  $Mobile_Number = $Gender = $Email_Id = $University_Name = $District = $Year = $Semester = $Date_of_Birth = $Address = "";

 $Register_Number_err = $First_Name_err = $Last_Name_err =  $Mobile_Number_err = $Gender_err = $Email_Id_err = $University_Name_err = $District_err = $Year_err = $Semester_err = $Date_of_Birth_err = $Address_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate Register_Number
    $input_Register_Number = trim($_POST["Register_Number"]);
    if(empty($input_Register_Number)){
        $Register_Number_err = "Please enter an Register_Number.";     
    } else{
        $Register_Number = $input_Register_Number;
    }


    // Validate First_Name
    $input_First_Name = trim($_POST["First_Name"]);
    if(empty($input_First_Name)){
        $First_Name_err = "Please enter a First_Name.";
    } elseif(!filter_var($input_First_Name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $First_Name_err = "Please enter a valid First_Name.";
    } else{
        $First_Name = $input_First_Name;
    }

     // Validate Last_Name
    $input_Last_Name = trim($_POST["Last_Name"]);
    if(empty($input_Last_Name)){
        $Last_Name_err = "Please enter a Last_Name.";
    } elseif(!filter_var($input_Last_Name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Last_Name_err = "Please enter a valid Last_Name.";
    } else{
        $Last_Name = $input_Last_Name;
    }

    // Validate Mobile_Number
    $input_Mobile_Number = trim($_POST["Mobile_Number"]);
    if(empty($input_Mobile_Number)){
        $Mobile_Number_err = "Please enter the Mobile_Number.";     
    }  else{
        $Mobile_Number = $input_Mobile_Number;
    }

     // Validate Gender
    $input_Gender = trim($_POST["Gender"]);
    if(empty($input_Gender)){
        $Gender_err = "Please enter the Gender.";     
    }  else{
        $Gender = $input_Gender;
    }

    // Validate Email_Id
    $input_Email_Id = trim($_POST["Email_Id"]);
    if(empty($input_Email_Id)){
        $Email_Id_err = "Please enter the Email_Id.";     
    }
    else{
        $Email_Id = $input_Email_Id;
    }
    
    // Validate University_Name
    $input_University_Name = trim($_POST["University_Name"]);
    if(empty($input_University_Name)){
        $University_Name_err = "Please select an University_Name.";     
    } else{
        $University_Name = $input_University_Name;
    }

     // Validate District
    $input_District = trim($_POST["District"]);
    if(empty($input_District)){
        $District_err = "Please select an District.";     
    } else{
        $District = $input_District;
    }

    // Validate Year
    $input_Year = trim($_POST["Year"]);
    if(empty($input_Year)){
        $Year_err = "Please select an Year.";     
    } else{
        $Year = $input_Year;
    }
      // Validate Semester
    $input_Semester = trim($_POST["Semester"]);
    if(empty($input_Semester)){
        $Semester_err = "Please enter an Semester.";     
    } else{
        $Semester = $input_Semester;
    }

      // Validate Date_of_Birth
    $input_Date_of_Birth = trim($_POST["Date_of_Birth"]);
    if(empty($input_Date_of_Birth)){
        $Date_of_Birth_err = "Please enter an Date_of_Birth.";     
    } else{
        $Date_of_Birth = $input_Date_of_Birth;
    }

     // Validate Address
    $input_Address = trim($_POST["Address"]);
    if(empty($input_Address)){
        $Address_err = "Please enter an Address.";     
    } else{
        $Address = $input_Address;
    }
    
    
    // Check input errors before inserting in database
        if(empty($Register_Number_err) && empty($First_Name_err) && empty($Last_Name_err) && empty($Mobile_Number_err) && empty($Gender_err) && empty($Email_Id_err) && empty($University_Name_err) && empty($District_err) && empty($Year_err) && empty($Semester_err) && empty($Date_of_Birth_err) && empty($Address_err)){
        // Prepare an update statement
        $sql = "UPDATE Students_Details SET Register_Number=?, First_Name=?, Last_Name=?, Mobile_Number=?, Gender=?, Email_Id=?, University_Name=?, District=?, Year=?, Semester=?, Date_of_Birth=?, Address=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssssssi", $param_Register_Number, $param_First_Name, $param_Last_Name, $param_Mobile_Number, $param_Gender, $param_Email_Id, $param_University_Name, $param_District, $param_Year, $param_Semester, $param_Date_of_Birth, $param_Address, $param_id);
            
            // Set parameters
            $param_Register_Number = $Register_Number;
            $param_First_Name = $First_Name;
            $param_Last_Name = $Last_Name;
            $param_Mobile_Number = $Mobile_Number;
            $param_Gender = $Gender;
            $param_Email_Id = $Email_Id;
            $param_University_Name = $University_Name;
            $param_District = $District;
            $param_Year = $Year;
            $param_Semester = $Semester;
            $param_Date_of_Birth = $Date_of_Birth;
            $param_Address = $Address;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM Students_Details WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $Register_Number = $row["Register_Number"];
                    $First_Name = $row["First_Name"];
                    $Last_Name = $row["Last_Name"];
                    $Mobile_Number = $row["Mobile_Number"];
                    $Gender = $row["Gender"];
                    $Email_Id = $row["Email_Id"];
                    $University_Name = $row["University_Name"];
                    $District = $row["District"];
                    $Year = $row["Year"];
                    $Semester = $row["Semester"];
                    $Date_of_Birth = $row["Date_of_Birth"];
                    $Address = $row["Address"];
                
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body
        {
            background: linear-gradient(lightgray,skyblue);
        }
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
         label
         {
            color: white;
            font-weight: bold;
            font-size: 22px;
         }
         .form-group input
         {
            font-weight: bold;
          background: lightgray;
         }
         .form-group select
         {
            font-weight: bold;
            background: lightgray;
         }
         .form-group textarea
         {
            font-weight: bold;
            background: lightgray;
         }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid bg-info">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 text-white">Update Record</h2>
                    <p style="font-size: 18px;">Please edit the input values and submit to update the Students Details record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Register Number</label>
                            <input type="number" name="Register_Number"  class="form-control <?php echo (!empty($Register_Number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Register_Number; ?>">
                            <span class="invalid-feedback"><?php echo $Register_Number_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="First_Name" class="form-control <?php echo (!empty($First_Name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $First_Name; ?>">
                            <span class="invalid-feedback"><?php echo $First_Name_err;?></span>
                        </div>
                       

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="Last_Name" class="form-control <?php echo (!empty($Last_Name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Last_Name; ?>">
                            <span class="invalid-feedback"><?php echo $Last_Name_err;?></span>
                        </div>
                    

                         <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="number" name="Mobile_Number" maxlength="10" class="form-control <?php echo (!empty($Mobile_Number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Mobile_Number; ?>">
                            <span class="invalid-feedback"><?php echo $Mobile_Number_err;?></span>
                        </div>

                        <div class="form-group"> 
                           <div class="radio">
                            <label>Gender</label>
                            <label style="margin-left:20px;"><input type="radio" name="Gender" value="Male" <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?> value="<?php echo $gender; ?>"> Male</label>

                            <label style="margin-left: 30px;"><input type="radio" name="Gender" value="Female" <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?> value="<?php echo $gender; ?>"> Female</label>

                             </div>  
                           </div>

                          <div class="form-group">
                            <label>Email Id</label>
                            <input type="text" name="Email_Id" class="form-control <?php echo (!empty($Email_Id_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Email_Id; ?>">
                            <span class="invalid-feedback"><?php echo $Email_Id_err;?></span>
                        </div>
                    

                         <div class="form-group">
                            <label>University Name</label>
                            <select name="University_Name" class="form-control <?php echo (!empty($University_Name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $University_Name; ?>">
                               <option value="Periyar University">Periyar University</option>
                               <option value="Tamil Nadu Agricultural University">Tamil Nadu Agricultural University</option>
                               <option value="Tamil Nadu Dr. Ambedkar Law University">Tamil Nadu Dr. Ambedkar Law University</option>
                               <option value="Tamil Nadu Dr. M.G.R. Medical University">Tamil Nadu Dr. M.G.R. Medical University</option>
                               <option value="Mother Teresa Women's University">Mother Teresa Women's University</option>
                               <option value="Manonmaniam Sundaranar University">Manonmaniam Sundaranar University</option>
                               <option value="Madurai Kamaraj University">Madurai Kamaraj University</option>
                               <option value="Bharathidasan University">Bharathidasan University</option>
                               <option value="Bharathiar University">Bharathiar University</option>
                               <option value="Annamalai University">Annamalai University</option>
                               <option value="Anna University">Anna University</option>
                               <option value="Alagappa University">Alagappa University</option>
                               <option value="Tamil Nadu Veterinary and Animal Sciences University">Tamil Nadu Veterinary and Animal Sciences University</option>
                               <option value="Tamil University">Tamil University</option>
                               <option value="Thiruvalluvar University">Thiruvalluvar University</option>
                               <option value="University of Madras">University of Madras</option>
                               <option value="Tamil Nadu Dr. J. Jayalalithaa Music and Fine Arts University">Tamil Nadu Dr. J. Jayalalithaa Music and Fine Arts University</option>
                               <option value="Tamil Nadu Teachers Education University">Tamil Nadu Teachers Education University</option>
                               <span class="invalid-feedback"><?php echo $University_Name_err;?></span>
                           </select>
                        </div>
                    

                        <div class="form-group">
                            <label>District</label>
                            <select name="District" class="form-control <?php echo (!empty($District_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $District; ?>">
                            <option value="Chennai">Chennai</option>
                            <option value="Nagapattinam">Nagapattinam</option>
                            <option value="Thanjavur">Thanjavur</option>
                            <option value="Vellore">Vellore</option>
                            <option value="Salem">Salem</option>
                            <option value="Coimbatore">Coimbatore</option>
                            <option value="Tirunelveli">Tirunelveli</option>
                            <option value="Dindigul">Dindigul</option>
                            <option value="Madurai">Madurai</option>
                            <option value="Trichy">Trichy</option>
                            <option value="Coimbatore">Coimbatore</option>
                            <option value="Karaikudi">Karaikudi</option>
                            <option value="Sivagangai">Sivagangai</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $District_err;?></span>
                        </div>
                       
                        <div class="form-group">
                            <label>Year</label>
                            <select name="Year" class="form-control <?php echo (!empty($Year_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Year; ?>">
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $Year_err;?></span>
                        </div>
                  
                        <div class="form-group">
                            <label>Semester</label>
                            <select name="Semester" class="form-control <?php echo (!empty($Semester_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Semester; ?>">
                            <option value="1-Semester">1-Semester</option>
                            <option value="2-Semester">2-Semester</option>
                            <option value="3-Semester">3-Semester</option>
                            <option value="4-Semester">4-Semester</option>
                            <option value="5-Semester">5-Semester</option>
                            <option value="6-Semester">6-Semester</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $Semester_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="date" name="Date_of_Birth" class="form-control <?php echo (!empty($Date_of_Birth_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Date_of_Birth; ?>">
                            <span class="invalid-feedback"><?php echo $Date_of_Birth_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="Address" class="form-control <?php echo (!empty($Address_err)) ? 'is-invalid' : ''; ?>"><?php echo $Address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $Address_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
