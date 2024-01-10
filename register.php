<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Car Parking Management System</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script src="scripts.js" defer></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    </head>
    <body>
        <h2 class="text-center">JOB'S PARKING MANAGEMENT SYSTEM</h2>
        <div class="container-form">
            <form id="carForm" action="submit_form.php" method="post">
                <div class="col1">
                    <label for="plateNumber"><b>Plate #</b></label>
                    <input type="text" placeholder="Enter plate number" id="plateNumber" name="plateNumber" required>
                </div>

                <div class="col2">
                    <label for="vehicleType"><b>Vehicle Type</b></label>
                    <select id="vehicleType" name="vehicleType" required>
                        <option value="" disabled selected>Select vehicle type</option>
                        <option value="sedan">Sedan</option>
                        <option value="suv">SUV</option>
                        <option value="truck">Truck</option>
                        <option value="motorcycle">Motorcycle</option>
                        <option value="van">Van</option>
                    </select>
                </div>

                <div class="col1">
                    <label for="brand"><b>Brand</b></label>
                    <input type="text" placeholder="Enter car brand" id="brand" name="brand" required>
                </div>

                <div class="col2">
                    <label for="model"><b>Model</b></label>
                    <input type="text" placeholder="Enter car brand" id="model" name="model" required>
                </div>
                
                <div class="col1">
                    <button type="submit">Submit</button>  
                </div>

                <div class="col2">
                    <button type="reset">Reset</button>  
                </div>                   
            </form>
        </div>

        <?php 
            include 'submit_form.php'; 
            $conn = connectToDatabase();
        ?>

        <div class="container-scroll">
            <table id="floor1" class="active" border="1">
                <thead>
                    <th>ID</th>
                    <th>Plate Number</th>
                    <th>Vehicle Type</th>
                    <th>Brand</th>
                    <th>Model</th> 
                    <th>Action</th>
                </thead>
                <tbody>
                    <!-- Car Details goes here -->
                    <?php fetchData("1", $conn)?>
                </tbody>
            </table>

            <table id="floor2" border="1">
                <thead>
                    <th>ID</th>
                    <th>Plate Number</th>
                    <th>Vehicle Type</th>
                    <th>Brand</th>
                    <th>Model</th> 
                    <th>Action</th>
                </thead>
                <tbody>
                    <!-- Car Details goes here -->
                    <?php fetchData("2", $conn)?>
                </tbody>
            </table>

            <table id="floor3" border="1">
                <thead>
                    <th>ID</th>
                    <th>Plate Number</th>
                    <th>Vehicle Type</th>
                    <th>Brand</th>
                    <th>Model</th> 
                    <th>Action</th>
                </thead>
                <tbody>
                    <!-- Car Details goes here -->
                    <?php fetchData("3", $conn)?>
                </tbody>
            </table>

            <table id="floor4" border="1">
                <thead>
                    <th>ID</th>
                    <th>Plate Number</th>
                    <th>Vehicle Type</th>
                    <th>Brand</th>
                    <th>Model</th> 
                    <th>Action</th>
                </thead>
                <tbody>
                    <!-- Car Details goes here -->
                    <?php fetchData("4", $conn)?>
                </tbody>
            </table>
        </div>

        <?php $conn->close() ?>

        <div class="container-floor">
            <nav id="floorMenu">
                <div class="nav-button" onclick="showFloor(1)">
                    Floor 1
                </div>
                <div class="nav-button" onclick="showFloor(2)">
                    Floor 2
                </div>
                <div class="nav-button" onclick="showFloor(3)">
                    Floor 3
                </div>
                <div class="nav-button" onclick="showFloor(4)">
                    Floor 4
                </div>
            </nav>
        </div>
        
        <div id=deleteContainer class="container-delete">
            <form id="deleteCarForm" action="delete_form.php" method="post">
                <div class="col1">
                    <label for="delID"><b>ID</b></label>
                    <input type="text" placeholder="Enter ID" id="delID" name="delID" required>
                </div>

                <div class="col2">
                    <label for="delPlateNumber"><b>Plate #</b></label>
                    <input type="text" placeholder="Enter plate number" id="delPlateNumber" name="delPlateNumber" required>
                </div>

                <div class="col1">
                    <button type="submit">Delete</button>  
                </div>

                <div class="col2">
                    <button type="reset">Reset</button>  
                </div> 
            </form>
        </div>


        <div class="modal" id="editModal">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <div class="modal-content">
              <!-- Modal content -->
              <!-- Your form goes here -->
              <div class="col1">
                <label for="plateNumber"><b>Plate #</b></label>
                <input type="text" placeholder="Enter plate number" id="editPlateNumber" name="editPlateNumber" required>
              </div>
          
              <div class="col2">
                <label for="vehicleType"><b>Vehicle Type</b></label>
                <select id="editVehicleType" name="editVehicleType" required>
                  <option value="" disabled selected>Select vehicle type</option>
                  <option value="sedan">Sedan</option>
                  <option value="suv">SUV</option>
                  <option value="truck">Truck</option>
                  <option value="motorcycle">Motorcycle</option>
                  <option value="van">Van</option>
                </select>
              </div>
          
              <div class="col1">
                <label for="brand"><b>Brand</b></label>
                <input type="text" placeholder="Enter car brand" id="editBrand" name="editBrand" required>
              </div>
          
              <div class="col2">
                <label for="model"><b>Model</b></label>
                <input type="text" placeholder="Enter car brand" id="editModel" name="editModel" required>
              </div>
          
              <button onclick="saveChanges()">Save Changes</button>
            </div>
        </div>


        <!-- Modal HTML -->
        <div id="messageModal" class="modal">
            <div class="modal-content">
                <p id="modalMessage"></p>
                <button class="close" onclick="closeModal()">Ok</span>
            </div>
        </div>

        <input type="hidden" id="recordStatus" name="recordStatus" value="">
        <input type="hidden" id="deleteStatus" name="deleteStatus" value="">
    </body>
</html>