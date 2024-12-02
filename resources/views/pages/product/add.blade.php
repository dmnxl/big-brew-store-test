@extends('layouts.main')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Product</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Add New Products</li>
        </ol>
    </nav>
@endsection

@section('main')
    <style>
        /* Set a consistent width for the input fields */
        .size-row input[type="text"],
        .size-row input[type="number"] {
            width: 100px; /* Adjust width as needed */
        }

        /* Make the size row a flex container */
        .size-row {
            display: flex;
            align-items: center; /* Vertically centers items in the row */
            margin-bottom: auto; /* Optional: adds space between rows */
        }

        /* Style the Remove button to align with input fields */
        .size-row .remove-btn {
            margin-top: 15px;
            height: 42px; /* Match input field height */
            padding: 5px 10px;
        }

        /* Style for the Add Size button */
        #addSizeButton {
            padding: 8px 16px;
            font-size: 14px;
        }

    </style>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body px-0 pt-0 pb-2">
                <form action="{{ route('prodstore') }}" method="POST" enctype="multipart/form-data" id="addTicketForm">
                    @csrf
                    <input type="hidden" id="sizesDataInput" name="sizes">

                    <div class="row p-5">
                        <div class="col-lg-6">
                            <label class="form-control-label" for="basic-url">Product Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="product-name" class="form-control" placeholder="Enter a Products Name" id="basic-url" aria-describedby="basic-addon3" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="exampleFormControlSelect1">Product Category <span class="text-danger">*</span></label>
                            <select class="form-control" name="product-cat" id="choices-button" placeholder="Select a Product Category" required>
                                <option value="">Select Option</option>
                                <option value="1">Special Drinks</option>
                                <option value="2">Milktea</option>
                                <option value="3">Praf</option>
                                <option value="4">Coffee</option>
                                <option value="5">Fruit Tea</option>
                                <option value="6">Brosty</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="exampleFormControlSelect1">Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" id="statusDropdown" placeholder="Select a Status" required>
                                <option value="">Select Option</option>
                                <option value="0">in Active</option>
                                <option value="1">Active</option>
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <label for="exampleFormControlSelect1">Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="Attachment" id="fileUpload" aria-describedby="basic-addon3" required>
                            <div id="fileError" class="text-danger mt-2"></div>
                        </div>

                        <div class="col-lg-12" id="sizes">
                            <label for="sizes">Add Sizes</label>
                            <div id="sizeInputsContainer">
                                <div class="size-section" data-index="0">
                                    <div class="row">
                                        <!-- Size and Price Input -->
                                        <div class="col-lg-12">
                                            <div class="input-group size-row">
                                                <input type="text" name="sizes[0][name]" class="form-control col-lg-4" style="max-width: 200px;" placeholder="Size (e.g., Medio)">
                                            <input type="number" step="0.01" name="sizes[0][price]" class="form-control" style="max-width: 200px;" placeholder="Price">
                                            <button type="button" class="btn btn-danger remove-btn">Remove</button>
                                            </div>
                                        </div>

                                        <!-- Materials Selection -->
                                        <div class="col-lg-6">
                                            <label for="inventoryMaterialSearch">Select Materials Items:</label>
                                            <input type="text" class="form-control mb-3" id="inventoryMaterialSearch" placeholder="Search Materials items">
                                            <div class="inventoryCheckboxListMaterial" style="max-height: 200px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                                                <div class="row">
                                                    @foreach($inventoryItemsMaterials as $inventory)
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input inventory-checkbox-material" name="inventory_material_items[]" value="{{ $inventory->id }}"
                                                                    data-name="{{ $inventory->ingredients_name }}"
                                                                    data-units="{{ json_encode($inventory->available_units) }}">
                                                            <label class="form-check-label">{{ $inventory->ingredients_name }}</label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>

                                                <div class="col-lg-12 mt-3 inventoryInputsContainerMaterial">
                                                </div>
                                            </div>


                                        </div>

                                        <!-- Ingredients Selection -->
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label for="inventorySearch">Select Ingredients Items:</label>
                                                    <input type="text" class="form-control mb-3" id="inventorySearch" placeholder="Search Ingredients items">
                                                    <div class="inventoryCheckboxList" style="max-height: 200px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                                                        <div class="row">
                                                            @foreach($inventoryItems as $inventory)
                                                            <div class="col-md-6">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input inventory-checkbox" name="inventory_items[]" value="{{ $inventory->id }}"
                                                                        data-name="{{ $inventory->ingredients_name }}"
                                                                        data-units="{{ json_encode($inventory->available_units) }}">
                                                                    <label class="form-check-label">{{ $inventory->ingredients_name }}</label>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="col-lg-12 mt-3 inventoryInputsContainer">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="addSizeButton" class="btn btn-secondary mt-2">Add Size</button>
                        </div>

                        <div class="col-lg-12 text-end mt-3">
                            <button id="addTicket" type="button" class="btn btn-success">Add</button>
                            <a type="button" href="{{ route('product') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let sizeIndex = 1;

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('addTicketForm');

            form.addEventListener('submit', function (event) {
                // Prevent the default form submission
                event.preventDefault();

                // Call your preparation logic here
                prepareFormSubmission();

                // Submit the form after processing
                form.submit();
            });
        });

        function prepareFormSubmission() {
            const sizeSections = document.querySelectorAll('.size-section');
            let sizesData = {};

            sizeSections.forEach((section, index) => {
                // Initialize size data
                let sizeData = {};
                sizeData['name'] = section.querySelector('input[name*="sizeName"]').value;
                sizeData['price'] = section.querySelector('input[name*="sizePrice"]').value;

                // Collect ingredients for this size
                let inventoryItems = section.querySelectorAll('.inventoryInputsContainer input[type="checkbox"]:checked');
                inventoryItems.forEach(item => {
                    const inventoryId = item.value; // Assuming the value of checkbox is inventory ID
                    const quantity = item.closest('.inventory-item').querySelector('.quantity').value;
                    const unit = item.closest('.inventory-item').querySelector('.unit').value;

                    sizeData[`inventory_${inventoryId}_quantity`] = quantity;
                    sizeData[`inventory_${inventoryId}_unit`] = unit;
                });

                // Collect inventory materials for this size
                let inventoryMaterials = section.querySelectorAll('.inventoryInputsContainerMaterial input[type="checkbox"]:checked');
                inventoryMaterials.forEach(material => {

                    const materialId = material.value; // Assuming the value of checkbox is inventory ID
                    const quantity = material.closest('.inventory-item').querySelector('.quantity').value;
                    const unit = material.closest('.inventory-item').querySelector('.unit').value;

                    sizeData[`material_${materialId}_quantity`] = quantity;
                    sizeData[`material_${materialId}_unit`] = unit;
                });

                // Add to sizesData with a numeric index
                sizesData[index] = sizeData;
            });

            // Update the hidden input field or pass this object for AJAX submission
            document.getElementById('sizesDataInput').value = JSON.stringify(sizesData);
        }

        $(document).ready(function () {

            $("#inventorySearch").on("keyup", function () {
                const searchValue = $(this).val().toLowerCase();
                $(".inventoryCheckboxList .form-check").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
                });
            });

            $("#inventoryMaterialSearch").on("keyup", function () {
                const searchValue = $(this).val().toLowerCase();
                $(".inventoryCheckboxListMaterial .form-check").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
                });
            });
        });

        document.getElementById('fileUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const maxSizeMB = 25;
            const maxSizeBytes = maxSizeMB * 1024 * 1024;
            const errorDiv = document.getElementById('fileError');
            errorDiv.textContent = '';

            if (file) {
                if (file.size > maxSizeBytes) {
                    errorDiv.textContent = 'File size exceeds 25MB.';
                    event.target.value = '';
                } else if (file.name.endsWith('.exe')) {
                    errorDiv.textContent = 'Executable files are not allowed.';
                    event.target.value = '';
                }
            }
        });

        const sizeInputsContainer = document.getElementById('sizeInputsContainer');


        document.getElementById('addSizeButton').addEventListener('click', function() {
            addNewSizeSection();
        });

        function addNewSizeSection() {
            // Clone the initial size section
            let sizeSection = document.querySelector('.size-section').cloneNode(true);

            // Reset input fields within the cloned section
            sizeSection.querySelectorAll('input[type="text"], input[type="number"]').forEach(input => {
                input.value = '';
            });

            // Uncheck any selected checkboxes in materials and ingredients
            sizeSection.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false;
            });

            let newInventoryInputsContainer = sizeSection.querySelector('.inventoryInputsContainer');
            newInventoryInputsContainer.innerHTML = '';

            let newInventoryInputsContainerMaterials = sizeSection.querySelector('.inventoryInputsContainerMaterial');
            newInventoryInputsContainerMaterials.innerHTML = '';

            // Update the data-index to the new sizeIndex
            sizeSection.dataset.index = sizeIndex;
            sizeSection.querySelectorAll('input, select').forEach(input => {
                input.name = input.name.replace(/\[\d+\]/, `[${sizeIndex}]`);
            });

            sizeIndex++; // Increment sizeIndex for the next section

            // Add event listener to remove button in the cloned section
            sizeSection.querySelector('.remove-btn').addEventListener('click', function() {
                removeSizeSection(this);
            });

            // Append the cloned section to the sizeInputsContainer
            document.getElementById('sizeInputsContainer').appendChild(sizeSection);

            // Update the event listeners for the new checkboxes
            updateCheckboxListeners(sizeSection);
        }

        function updateCheckboxListeners(section) {
            // Handler for 'inventory-checkbox'
            section.querySelectorAll('.inventory-checkbox').forEach((checkbox) => {
                checkbox.addEventListener('change', function () {
                    const container = section.querySelector('.inventoryInputsContainer'); // Correct container
                    const inventoryId = this.value;
                    const inventoryName = this.nextElementSibling.innerText;
                    const sectionIndex = section.getAttribute('data-index'); // Unique index for this size section

                    if (this.checked) {
                        const inputDiv = document.createElement('div');
                        inputDiv.classList.add('input-group', 'mb-3', 'inventory-input');
                        inputDiv.setAttribute('data-inventory-id', inventoryId);

                        const inputPrepend = document.createElement('div');
                        inputPrepend.classList.add('input-group-prepend');
                        inputPrepend.innerHTML = `<span class="input-group-text">${inventoryName}</span>`;

                        const inputQuantity = document.createElement('input');
                        inputQuantity.type = 'number';
                        inputQuantity.classList.add('form-control');
                        inputQuantity.name = `sizes[${sectionIndex}][inventory_${inventoryId}_quantity]`;
                        inputQuantity.placeholder = 'Enter quantity';
                        inputQuantity.required = true;
                        inputQuantity.min = 1;

                        const unitSelect = document.createElement('select');
                        unitSelect.classList.add('form-control');
                        unitSelect.name = `sizes[${sectionIndex}][inventory_${inventoryId}_unit]`;
                        const units = ['grams', 'milliliters', 'pieces'];
                        units.forEach((unit) => {
                            const option = document.createElement('option');
                            option.value = unit;
                            option.text = unit.charAt(0).toUpperCase() + unit.slice(1);
                            unitSelect.appendChild(option);
                        });

                        inputDiv.appendChild(inputPrepend);
                        inputDiv.appendChild(inputQuantity);
                        inputDiv.appendChild(unitSelect);
                        container.appendChild(inputDiv);
                        console.log(container);

                    } else {
                        console.log(`Removing input fields for Inventory ID ${inventoryId} in section ${sectionIndex}`);
                        const inputDiv = container.querySelector(
                            `.inventory-input[data-inventory-id="${inventoryId}"]`
                        );
                        if (inputDiv) {
                            container.removeChild(inputDiv);
                        }
                    }
                });
            });

            // Handler for 'inventory-checkbox-material'
            section.querySelectorAll('.inventory-checkbox-material').forEach((checkbox) => {
                checkbox.addEventListener('change', function () {
                    const materialContainer = section.querySelector('.inventoryInputsContainerMaterial'); // Correct container
                    const inventoryId = this.value;
                    const inventoryName = this.nextElementSibling.innerText;
                    const sectionIndex = section.getAttribute('data-index'); // Unique index for this size section

                    if (this.checked) {
                        const inputDiv = document.createElement('div');
                        inputDiv.classList.add('input-group', 'mb-3', 'inventory-input-material');
                        inputDiv.setAttribute('data-inventory-id', inventoryId);
                        inputDiv.style.display = 'none'; // Hide this input

                        const inputPrepend = document.createElement('div');
                        inputPrepend.classList.add('input-group-prepend');
                        inputPrepend.innerHTML = `<span class="input-group-text">${inventoryName}</span>`;

                        const inputQuantity = document.createElement('input');
                        inputQuantity.type = 'hidden';
                        inputQuantity.classList.add('form-control');
                        inputQuantity.name = `sizes[${sectionIndex}][inventory_${inventoryId}_quantity]`;
                        inputQuantity.value = 1;

                        const unitInput = document.createElement('input');
                        unitInput.type = 'hidden';
                        unitInput.classList.add('form-control');
                        unitInput.name = `sizes[${sectionIndex}][inventory_${inventoryId}_unit]`;
                        unitInput.value = 'piece';

                        inputDiv.appendChild(inputPrepend);
                        inputDiv.appendChild(inputQuantity);
                        inputDiv.appendChild(unitInput);
                        materialContainer.appendChild(inputDiv);

                    } else {
                        const inputDiv = materialContainer.querySelector(
                            `.inventory-input-material[data-inventory-id="${inventoryId}"]`
                        );
                        if (inputDiv) {
                            materialContainer.removeChild(inputDiv);
                        }
                    }
                });
            });
        }

        updateCheckboxListeners(document.querySelector('.size-section'));

        // Function to handle removing a size section
        function removeSizeSection(button) {
            const sizeSection = button.closest('.size-section');
            sizeSection.remove();

            // Reindex all remaining size sections
            reindexSizeSections();
        }

        function reindexSizeSections() {
            const sizeSections = document.querySelectorAll('.size-section');
            sizeIndex = 0; // Reset the sizeIndex

            sizeSections.forEach((section) => {
                section.dataset.index = sizeIndex;
                section.querySelectorAll('input, select').forEach(input => {
                    input.name = input.name.replace(/\[\d+\]/, `[${sizeIndex}]`);
                });
                sizeIndex++; // Increment for the next section
            });
        }


        // Add the initial remove event listener for the existing remove button
        document.querySelector('.remove-btn').addEventListener('click', function() {
            removeSizeSection(this);
        });



        function showPopup() {
            const form = document.getElementById('addTicketForm');
            const isValid = validateForm(form);

            if (isValid) {
                const someCondition = true;

                if (someCondition) {
                    Swal.fire({
                        title: '&#x231B; <br> Adding Product...',
                        text: 'Please wait while process the product.',
                        showConfirmButton: false,
                        showCancelButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                            form.submit();
                        }
                    }).catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Adding Product',
                            text: 'An error occurred while processing the product. Please try again.',
                            showConfirmButton: true
                        });
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Condition Not Met',
                        text: 'You cannot proceed because the condition is not met.',
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fill in all the required fields.',
                });
            }
        }

        document.getElementById('addTicket').addEventListener('click', showPopup);


        // document.getElementById('addTicket').addEventListener('click', showPopup);

        function validateForm(form) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');

            requiredFields.forEach(field => {
                if (field.value.trim() === '') {
                    isValid = false;
                }
            });

            return isValid;
        }

    </script>
@endsection
