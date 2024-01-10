// Global variables
var row;

function showFloor(floorNumber) {
    // Hide all tables
    var tables = document.querySelectorAll('.container-scroll table');
    tables.forEach(function(table) {
        table.classList.remove('active');
    });

    // Show the selected table
    var selectedTable = document.getElementById('floor' + floorNumber);
    if (selectedTable) {
        selectedTable.classList.add('active');
    }

    // Reset the styling of buttons 
    var buttons = document.querySelectorAll('.nav-button');
    buttons.forEach(function (button) {
        button.classList.remove('clicked');
    });

    //Apply styling to the clicked floor button
    var clickedButton = document.querySelector('.nav-button:nth-child(' + floorNumber + ')');
    clickedButton.classList.add('clicked');
}


function editTableRow(button) {
    // Get the row that contains the button
    row = button.parentNode.parentNode;

    // Populate modal with current row details
    document.getElementById('editPlateNumber').value = row.cells[1].innerText;

    var vehicleTypeValue = row.cells[2].textContent.trim();
    var editVehicleTypeSelect = document.getElementById('editVehicleType');
    editVehicleTypeSelect.value = vehicleTypeValue;

    document.getElementById('editBrand').value = row.cells[3].innerText;
    document.getElementById('editModel').value = row.cells[4].innerText;

    // Display the modal
    document.getElementById('editModal').style.display = 'block';
}


function saveChanges() {
    // Retrieve values from the edit modal
    var plateNumber = document.getElementById('editPlateNumber').value.toUpperCase();
    var vehicleType = document.getElementById('editVehicleType').value.toUpperCase();
    var brand = document.getElementById('editBrand').value.toUpperCase();
    var model = document.getElementById('editModel').value.toUpperCase();

    // Apply changes to the selected row
    row.cells[1].innerHTML = plateNumber;
    row.cells[2].innerHTML = vehicleType;
    row.cells[3].innerHTML = brand;
    row.cells[4].innerHTML = model;

    closeEditModal();
}


function closeEditModal() {
    // Close the modal
    document.getElementById('editModal').style.display = 'none';
}

document.getElementById('deleteCarForm').addEventListener('submit', function(e) {

})

// document.getElementById('deleteCarForm').addEventListener('submit', function(e) {
//     var delID = document.getElementById('delID').value;
//     var delPlateNumber = document.getElementById('delPlateNumber').value;

//     // Get the table reference
//     var tableID = ['floor1', 'floor2', 'floor3', 'floor4'];
//     // indication that the details exist in the table
//     var entryFound = false;

//     // loop through each table
//     for (var i=0; i < tableID.length; i++) {
//         var currentTable = document.getElementById(tableID[i]);
//         // loop through each row
//         for (var j=1; j < currentTable.rows.length; j++) {          // not start at 0 because of the header
//             var row = currentTable.rows[j];
//             var rowID = row.cells[0].innerText;
//             var rowPlateNumber = row.cells[1].innerText;

//             if (delID === rowID && delPlateNumber === rowPlateNumber) {
//                 currentTable.deleteRow(j);
//                 // Clear input fields
//                 document.getElementById('delID').value = "";
//                 document.getElementById('delPlateNumber').value = "";
//                 entryFound = true;

//                 break
//             }
//         }

//         if (entryFound) {
//             openAlertModal("SUCCESSFULLY", "Car details deleted successfully");
//             break; // Exit outer loop if entry is found
//         }
//     }
//     if (!entryFound) {
//         openAlertModal("UNSUCCESSFULLY", "Entry does not exist in any floor");
//     }
// })


document.getElementById("carForm").addEventListener("submit", function (event) {
    event.preventDefault();

    // Use Fetch API or AJAX to submit the form data to the PHP script
    fetch(this.action, {
        method: this.method,
        body: new FormData(this),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Show success modal
            document.getElementById("modalMessage").innerText = data.message;
            document.getElementById("messageModal").style.display = "block";
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });

    // For demonstration purposes, set a dummy status (replace this with actual AJAX call)
    var dummyStatus = 'success';

    // Update the hidden input field with the dummy status
    document.getElementById('recordStatus').value = dummyStatus;

    // Show the modal based on the status
    showResultModal();
});


document.getElementById("deleteCarForm").addEventListener("submit", function (event) {
    event.preventDefault();

    // Use Fetch API or AJAX to submit the form data to the PHP script
    fetch(this.action, {
        method: this.method,
        body: new FormData(this),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Show success modal
            document.getElementById("modalMessage").innerText = data.message;
            document.getElementById("messageModal").style.display = "block";
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });

    // For demonstration purposes, set a dummy status (replace this with actual AJAX call)
    var dummyStatus = 'success';

    // Update the hidden input field with the dummy status
    document.getElementById('deleteStatus').value = dummyStatus;

    // Show the modal based on the status
    showResultModal();
});


function showResultModal() {
    var status = document.getElementById('deleteStatus').value;
    var modalMessage = document.getElementById('modalMessage');

    if (status === 'success') {
        modalMessage.innerHTML = 'Record deleted successfully';
    } else {
        modalMessage.innerHTML = 'Error deleting record';
    }

    // Show the modal
    document.getElementById('messageModal').style.display = 'block';
}


function closeModal() {
    // Close the modal
    document.getElementById('messageModal').style.display = 'none';
    location.reload();
}


// Function to generate a random 6-digit ID
function generateRandomId() {
    var min = 100000;
    var max = 999999;
    return Math.floor(Math.random() * (max-min+1) + min);
}


