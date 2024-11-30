function filterTableData(tableId, inputValue) {
    // Convert the input value to lowercase for a case-insensitive search
    var value = inputValue.toLowerCase();

    console.log(inputValue);
    
    // Select the table body rows within the specified table ID
    $('#' + tableId + ' tbody tr').each(function() {
        // Get the text of the current row and convert it to lowercase
        var text = $(this).text().toLowerCase();
        
        // Toggle the visibility of the row based on whether it contains the input value
        $(this).toggle(text.indexOf(value) > -1);
    });
}
document.addEventListener('DOMContentLoaded', function () {
    // Get all dropdown buttons
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');

    dropdownBtns.forEach(dropdownBtn => {
        const selectItems = dropdownBtn.nextElementSibling;
        const selectAllCheckbox = selectItems.querySelector('.select-all');
        const optionCheckboxes = selectItems.querySelectorAll('.option-checkbox');

        // Toggle dropdown visibility
        dropdownBtn.addEventListener('click', function () {
            selectItems.style.display = selectItems.style.display === 'block' ? 'none' : 'block';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            if (!dropdownBtn.contains(event.target) && !selectItems.contains(event.target)) {
                selectItems.style.display = 'none';
            }
        });

        // Handle "Select All" functionality
        selectAllCheckbox.addEventListener('change', function () {
            optionCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Update "Select All" checkbox based on individual selections
        optionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const allChecked = Array.from(optionCheckboxes).every(checkbox => checkbox.checked);
                selectAllCheckbox.checked = allChecked;
            });
        });
    });
});// Export to Excel functionality
document.getElementById('exportButton').addEventListener('click', function() {
    exportTableToExcel('dataTable'); // Pass the table ID to the function
});

function exportTableToExcel(tableId) {
    var table = document.getElementById(tableId); // Get table element
    var tbody = table.getElementsByTagName('tbody')[0]; // Get the tbody element

    // Check if tbody has any tr (rows) with data
    if (tbody && tbody.getElementsByTagName('tr').length > 0) {
        var worksheet = XLSX.utils.table_to_sheet(table); // Convert table to worksheet
        var workbook = XLSX.utils.book_new(); // Create new workbook
        XLSX.utils.book_append_sheet(workbook, worksheet, "Data"); // Append sheet to workbook
        XLSX.writeFile(workbook, 'data.xlsx'); // Export the workbook
    } else {
        swal.fire({
            icon: 'warning', // Set the icon to 'warning'
            title: 'Warning', // Change the title to 'Warning'
            text: 'No data available to export' // Warning message text
        });
    }
}

// js for edit status



// function for submit form data using ajax
function submitForm(formId, route) {
    $(formId).on('submit', function(e) {
        e.preventDefault();
        alert("Hello");
    });
}



// function for the get option for the clieant search
function searchClent(route, inputText, csrf) {
    let data = { inputText: inputText }; 
    console.log(data);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': csrf 
        },
        url: route,
        type: "POST", 
        data: data,
        success: function(response) {
            console.log(response); 
        },
        error: function(xhr, status, error) {
            console.error('Error:', error); 
        }
    });
}


// Function to handle the AJAX request
function searchClent(route, inputText, csrf) {
    $.ajax({
        url: route,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrf
        },
        data: { inputText: inputText },
        success: function(response) {
            console.log(response);
            populateDatalist(response);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

// Function to populate the datalist dynamically
function populateDatalist(data) {
    let datalist = $('#dynamicList');
    datalist.empty();
    if (data.length > 0) {
        data.forEach(function(item) {
            let option = $('<option></option>')
                .val(item.application_no)
                .text(item.file_name) 
                .attr('data-id', item.id); 
            datalist.append(option);
        });
    } else {
        datalist.append('<option>No results found</option>');
    }
}

// sub status
function populateSubstatus(route, substatusId = null) {
    $.ajax({
        url: route,
        type: 'GET',
        success: function (response) {
            let select = $('#sub-status');
            select.empty(); 
            select.append(`<option value="">**Please Select Sub Status..</option>`);
            response.forEach(substatus => {
                // Check if this substatus should be selected
                let isSelected = substatusId && substatus.id == substatusId ? 'selected' : '';
                let option = `
                    <option value="${substatus.id}" data-slug="${substatus.slug}" ${isSelected}>
                        ${substatus.substatus_name}
                    </option>
                `;
                select.append(option);
            });

            // Trigger any additional logic if needed
            if (selectedSlug) {
                select.trigger('change'); // Trigger change event if a selection was made
            }
        },
        error: function () {
            console.error('Failed to fetch substatus');
        }
    });
}


// function for the registration form select box validation
function validateSelectBoxes(selectBoxIds) {
    let isValid = true;
    for (let id of selectBoxIds) {
        const selectBox = document.getElementById(id);

        if (selectBox && !selectBox.value) {
            isValid = false;
            selectBox.focus();
            alert(`Please select an option for ${id}`);
            break;
        }
    }

    return isValid;
}






