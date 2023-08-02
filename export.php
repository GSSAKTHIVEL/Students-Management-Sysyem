<?php
require_once "config.php";
header("content-type:application/vnd-ms-excel");
$filename="student_data.xls";
header("content-disposition:attachment;filename=\"$filename\"");
?>        
          
                    <?php   
                            echo '<table class="table table-bordered table-striped">';
                              $sql = "SELECT * FROM Students_Details";
                              if($result = mysqli_query($link, $sql)){
                                  if(mysqli_num_rows($result) > 0){
                           
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
                                       
                                    echo "</tr>";
                                   
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            
                        }
                    } 
                    ?>
