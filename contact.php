<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: login.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                }
                 else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>SMS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
        body
        { 
            font: 14px sans-serif;
            overflow-x: hidden; 
            background: linear-gradient(80deg,lightgrey,gray,lightgrey,gray);
        }
  
        .reg
        {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
        .reg:hover
        {
            color: black;
        }
        
        .form-group label
        {
            font-size: 20px;
            margin-left: 5px;
            padding: 5px;
        }
    
     .navbar
        {
            margin-left: -12px;
            width: 100%;
            position: fixed;
            z-index: 1;
            

        }
        .rounded-circle
        {
            width: 50px;
        }
        .sms
        {
            font-size: 20px;

        }
        .navbar{
            padding: 1px;
            margin-top: -20px;
        }
        .nav-item a
        {
            font-size: 15px;
            margin-left: 15px;
        }
        #Signup
        {
            display: none;
        }
        
        @media screen and (max-width:575px)
        {
            #log
            {
                display: none;
            }
            #Signup
            {
                display: block;
            }
            .btn-warning
            {
                display: none;
            }
            

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
       .modal
       {
        margin-top: 100px;

       }
       .modal-body
       {
          background: lightsalmon;
        
       }
       .modal-content
       {
        background: lightsalmon;
       }
       iframe
       {
        margin-top: 10px;
        width: 100%;
        height: 500px;
       }
        .social-media
       {
        background: black;
       }
       .border
       {
        background: black;
        height: 50px;
        width: 150px;
        padding: 5px;
        font-size: 20px;
        text-decoration: none;
        color: whitesmoke;
        margin-left: 10px;
        border-radius: 20px;

       }
       .ws
       {
        color: green;
        font-size: 32px;
        font-weight: bold;
       }
       
       .in
       {
        color: lightpink;
        font-size: 32px;
        font-weight: bold;
       }
       .fb
       {
        color: blue;
        font-size: 32px;
        font-weight: bold;
       }
       .tw
       {
        color: lightblue;
        font-size: 32px;
        font-weight: bold;
       }
       .ph
       {
        color: blue;
        font-size: 32px;
        font-weight: bold;
       }
       .yp
       {
        color: red;
        font-size: 32px;
        font-weight: bold;
       }
       .border:hover
       {
        background: white;
       }
       .col-lg
       {
        color: white;
       }
       

       



    </style>
</head>
<body>
      <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
    <div class="container-fluid">
    <nav class="navbar navbar-expand-sm bg-info navbar-dark">
       <div class="container-fluid">

         <a class="navbar-brand" href="#"><img src="image/logo.jpg" class="rounded-circle">
            <span class="sms">SMS</span></a>
           
          <button type="button" style="margin-left:100px;height: 40px;" class="navbar-toggler bg-primary text-white"data-bs-toggle="modal" data-bs-target="#myModal" title="Login">Log In</button>
          <button type="button" class="btn btn-warning" id="Signup"><a href="register.php" class="reg" title="Signup">Sign Up</a></button>
         <button class="navbar-toggler mr-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
           
           <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">

           <ul class="navbar-nav">
             <li class="nav-item">
               <a class="nav-link text-white fs-5" href="login.php">Home</a>
             </li>
             <li class="nav-item">
               <a class="nav-link text-white fs-5" href="#">About</a>
             </li>
             <li class="nav-item">
               <a class="nav-link text-white fs-5" href="contact.php">Contact</a>
             </li>
             <span style="margin-left:20px;"></span>
              <button type="button" class="btn btn-primary" id="log" data-bs-toggle="modal" data-bs-target="#myModal" title="Login">Log In</button><span style="padding: 5px;"></span>
              <button type="button" class="btn btn-warning"><a href="register.php" class="reg" title="Signup">Sign Up</a></button>
           </ul>
         </div>

        </div>

      </nav>

     </div>  



<div class="container mt-3">
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Login here</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
       
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter The Username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                <br>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter The Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <br>
            <p>Don't have an account? <a href="register.php">Sign Up now</a>.</p>
        </form>
      </div>

    </div>
  </div>
  </div>
</div>
</div>

<br><br>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
       <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d19242.639795970077!2d78.14493483132607!3d9.925142578718967!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1678873943845!5m2!1sen!2sin" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
         </div>  
         </div>
         </div>
         
</div>
                    <center>
           <div class="social-media"> 
            <br>
           <div class="row" id="socmed">
            <div class="col-lg-2 p-2">
               <a href="#" type="button" class="border text-success"><i class="fa fa-whatsapp ws"></i> Whatsapp</a>
                
            </div>
            <div class="col-lg-2 p-2">
               <a href="#" type="button" class="border text-info"><i class="fa fa-phone ph"></i> Talk To Us</a>
                
            </div>
            <div class="col-lg-2 p-2">
               <a href="#" type="button" class="border text-danger"><i class="fa fa-instagram in"></i> Instagram</a>
                
            </div>
            <div class="col-lg-2 p-2">
               <a href="#" type="button" class="border text-info"><i class="fa fa-facebook fb"></i> facebook</a>
                
            </div>
            
            <div class="col-lg-2 p-2">
               <a href="#" type="button" class="border text-info"><i class="fa fa-twitter tw"></i> Twitter</a>
                
            </div>
            <div class="col-lg-2 p-2">
               <a href="#" type="button" class="border text-danger"><i class="fa fa-youtube-play yp"></i> Youtube</a>
                
            </div>
           </div>
           <br>
            <div class="row">
                   <div class="col-lg p-2">
                      <h3>Contact Information</h3>
                      <br>
                      <h4>SMS Head office</h4>
                      <h4>2/192, East marret street,</h4>
                      <h4>Madurai- 625 010.</h4>
                      <br>
                      <h4>+91 9236424631 <i class="fa fa-whatsapp ws"></i></h4>
                      <h4>+91 6391736622 <i class="fa fa-phone ph"></i></h4>
                   </div>
                   <div class="col-lg p-2">
                      <h3>Support</h3>
                      <br>
                      <h4>Contact Us</h4>
                      <h4>Site Maps</h4>
                      <h4>One Assist</h4>
                      <br>
                      <h4>Sms919@gmail.com <i class="fa fa-envelope-o text-info"></i></h4>
                      <h4>www.SMS.in <i class="fa fa-chrome text-danger"></i></h4>

                   </div>
                   <div class="col-lg p-2">
                      <h3>Policies</h3>
                      <br>
                      <h4>T & C</h4>
                      <h4>Privacy Police</h4>
                   </div>
                   <div class="col-lg p-2">
                      <h3>Know More</h3>
                      <br>
                      <h4>About Us</h4>
                      <h4>Our Store</h4>
                   </div>
               </div>
                <br><br>
                <div class="col-lg fs-5">
               <p>Copyright © 2020-<?php echo date("Y");?> SMS</p>
               </div>
           </div>
           </center>

        
</body>
</html>