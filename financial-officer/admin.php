<?php

session_start();
if(!isset($_SESSION['username']))
{
  echo "
  <script>
  window.location.href='../index.php';
  </script>
  ";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Div Display with Persistence</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery (required for Bootstrap JS) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .navbar-nav {
margin-left:1050px !important;

        }
        .btn{
            color:white !important;
        }
        .navbar{
            background:#375E97 !important;
        }
        .form-label{
            margin-bottom:20px !important;
        }
    </style>

    <!-- Data table -->
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.6/datatables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script> 

    <style>

.dt-paging .dt-paging-button
  {
     display: none !important;
     background:none !important
 }
 </style> 
   </style>
    

</head>
<body>

<!-- Navigation Menu -->
<nav class="navbar navbar-expand-lg navbar-dark ">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">CRPIMS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#"><?php echo $_SESSION['username']?></a>
                    </li>
                    <li class="nav-item">
                    <a class="btn  d-flex" href="../index.php" >Logout</a>
                    </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
    <h1>Karibu!!</h1>
    <div class="mb-5">
        <label for="exampleSelect" class="form-label">What are your looking for? | Unatafuta nini tukusaidie?</label>
        <select class="form-select" id="exampleSelect" aria-label="Default select example">
        <option selected disabled>---Select---</option>
            <option value="1">Weather Information | Taarifa za hali ya hewa</option>
            <option value="2">Agricultural Officers | Maafisa Kilimo</option>
         
        </select>
    </div>
    
    <!-- Content Display Area -->
    <div id="contentDisplay" class="mt-3">
        <div id="option1" class="content-div" style="display: none;">
        <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
                  <div class="card" style="height:700px !important">
                    <div class="row  g-0">
                      <div class="col-md-12">
                        
                        
                       
                     <div  class="nav-tabs" style="margin-left:5px;margin-bottom:55px;">

<!-- WEATHER BLOCK -->
<style>
        .map-container {
            margin-top: 20px;
            width: 100%;
            height: 400px;
        }
        .weather-icon {
            width: 100px;
            height: 100px;
        }
    </style>
 <?php include "weatherScripts.php";?>
                   

<form method="POST" style="margin-top:20px !important">
    <label for="region">Region:</label>
    <select id="region" name="region">
        <option value="" disabled selected>Select a region</option>
        <?php foreach ($regions as $region): ?>
            <option value="<?= htmlspecialchars($region) ?>" <?= ($selectedRegion === $region) ? 'selected' : '' ?>>
                <?= htmlspecialchars($region) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Request</button>
</form>

<?php if ($selectedRegion && $weather && !$errorMessage): ?>
    <h4 style="text-align:center;margin-top:30px">Weather in <?= htmlspecialchars($selectedRegion) ?>:</h4>

    <!-- Display weather icon -->
     <div style="margin-left:400px !important">
    <img class="weather-icon" src="http://openweathermap.org/img/wn/<?= $weather['weather'][0]['icon'] ?>@2x.png" alt="Weather Icon">
    
    <p>Temperature: <?= $weather['main']['temp'] ?>°C</p>
    <p>Weather: <?= $weather['weather'][0]['description'] ?></p>
    <p>Humidity: <?= $weather['main']['humidity'] ?>%</p>
    <p>Wind Speed: <?= $weather['wind']['speed'] ?> m/s</p>
    <p>Cloudiness: <?= $weather['clouds']['all'] ?>%</p>


    <!-- Display precipitation if available -->
    <?php if (isset($weather['rain']['1h'])): ?>
        <p>Rain (Last Hour): <?= $weather['rain']['1h'] ?> mm</p>
    <?php elseif (isset($weather['rain']['3h'])): ?>
        <p>Rain (Last 3 Hours): <?= $weather['rain']['3h'] ?> mm</p>
    <?php elseif (isset($weather['snow']['1h'])): ?>
        <p>Snow (Last Hour): <?= $weather['snow']['1h'] ?> mm</p>
    <?php elseif (isset($weather['snow']['3h'])): ?>
        <p>Snow (Last 3 Hours): <?= $weather['snow']['3h'] ?> mm</p>
    <?php else: ?>
        <p>No precipitation data available.</p>
    <?php endif; ?>
    </div>

    <!-- Embed Google Map -->
    <div class="map-container">
        <iframe 
            width="100%" 
            height="400" 
            frameborder="0" 
            style="border:0"
            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBznmosJbZDx0SRuYZcQPVq7rJRrjLy8UU&q=<?= urlencode($selectedRegion) ?>" 
            allowfullscreen>
        </iframe>
    </div>

<?php elseif ($errorMessage): ?>
    <p><?= htmlspecialchars($errorMessage) ?></p>
<?php endif; ?>

                  
           

                    
                    
                    

 
                      </div>
  
        
                    </div>
                  </div>
                </div>

          </div>
        </div>
        <div id="option2" class="content-div" style="display: none;">
        <div class="container">
            <table id="farmersTable" class="table  table-striped table-bordered" style="width:1000px !importnant">
            <thead>
                <tr>
                    <th>Mobile number</th>
                    <th>Occupation</th>
                    <th>First name</th>
                    <th>Middle name</th>
                    <th>Last name</th>
                
                    <th>Birth day</th>
                    <th>Birth month</th>
                    <th>Birth year</th>
                    <th>Gender</th>
                    <th>Physical address</th>

                </tr>
            </thead>
            <tbody>
            <?php
            require 'connection.php';
$selectOfficers="select * from agroofficers";
$runSelectstmt=mysqli_query($conn,$selectOfficers);
foreach($runSelectstmt as $officers)
{

               
              echo "<tr class='dataRow' data-phone='" . $officers['mobileNumber']."'data-occupation='" . $officers['occupation'].
              "' data-fname='" . $officers['fname'] . "' data-mname='" . $officers['mname'] . "' data-lname='" . $officers['lname'] 
               . "' data-gender='" . $officers['gender'] . "' data-day='" . $officers['birthDay'] . "'. data-month='" . $officers['birthMonth'] . "'
               data-year='" . $officers['birthYear'] . "'data-address='" . $officers['address'] . "'>";
               ?>
                    <td class="tableData"><?php  echo $officers['mobileNumber']?></td>
                    <td class="tableData"><?php  echo $officers['occupation']?></td>
                    <td class="tableData"><?php echo $officers['fname']?></td>
                    <td class="tableData"><?php echo $officers['mname']?></td>
                    <td class="tableData"><?php echo $officers['lname']?></td>
                    <td class="tableData"><?php echo $officers['gender']?></td>
                    <td class="tableData"><?php echo $officers['birthDay']?></td>
                    <td class="tableData"><?php echo $officers['birthMonth']?></td>
                    <td class="tableData"><?php echo $officers['birthYear']?></td>
                    <td class="tableData"><?php echo $officers['address']?></td>
                   
                </tr>
                <?php
}
?>


</form>
            </tbody>
        </table>
        <script>


$('#farmersTable').dataTable( {
  info:false,
  // paging:false,
  pagingType:"simple",
  "language": {
    "decimal":        "",
    "emptyTable":     "No data available in table",
    "info":" ",
    // "infoEmpty":      "Showing 0 to 0 of 0 entries",
    "infoFiltered":   "",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "Show _MENU_ entries",
    // "loadingRecords": "Loading...",
    "ordering":"",
    "processing":     "",
    "search":         "Search:",
    "zeroRecords":    "No matching records found",

    //    "bProcessing": true,
    // "sAutoWidth": false,
    // "bDestroy":true,
    // "sPaginationType": "bootstrap", // full_numbers
    // "iDisplayStart ": 10,
    // "iDisplayLength": 10,
    // "bPaginate": false, //hide pagination
    // "bFilter": false, //hide Search bar
    // "bInfo": false, // hide showing entries
    "paginate": {
        // "first":      "First",
        // "last":       "Last",
        "next":       "<button  class='paging-button' style='border:1px solid grey !important;color:grey;margin:0'>Next</button>",
        "previous":   "<button class='paging-button' style='border:1px solid grey !important;color:grey'>Previous</button>",
        
    }
  }
  

  
} );

</script>
        
        </div>
        
    </div>
</div>

<!-- Bootstrap JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Check if there is a stored selection and set the dropdown and content accordingly
    const storedValue = localStorage.getItem('selectedOption');
    if (storedValue) {
        $('#exampleSelect').val(storedValue);
        $('.content-div').hide();
        $('#option' + storedValue).show();
    }

    $('#exampleSelect').change(function() {
        // Hide all content divs
        $('.content-div').hide();

        // Get the selected value
        var selectedValue = $(this).val();

        // Show the corresponding content div based on the selected value
        if (selectedValue) {
            $('#option' + selectedValue).show();
            // Store the selected value in local storage
            localStorage.setItem('selectedOption', selectedValue);
        }
    });
});
</script>
</body>
</html>
