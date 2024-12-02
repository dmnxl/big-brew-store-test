@extends('layouts.main')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Product</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Edit Products</li>
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
            height: 39px; /* Match input field height */
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
                <form action="{{ route('produpdate', ['id' => $findProduct]) }}" method="POST" enctype="multipart/form-data" id="addTicketForm">
                    @csrf

                    <div class="row p-5">
                        <div class="col-lg-6">
                            <label class="form-control-label" for="basic-url">Product Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="product-name" class="form-control" placeholder="Enter a Products Name" id="basic-url" aria-describedby="basic-addon3" value="{{$findProduct->product_name}}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="exampleFormControlSelect1">Product Category <span class="text-danger">*</span></label>
                            <select class="form-control" name="product-cat" id="choices-button" placeholder="Select a Product Category" required>
                                <option value="">Select Option</option>
                                <option value="1" {{ $findProduct->product_category == 1 ? 'selected' : '' }}>Special Drinks</option>
                                <option value="2" {{ $findProduct->product_category == 2 ? 'selected' : '' }}>Milktea</option>
                                <option value="3" {{ $findProduct->product_category == 3 ? 'selected' : '' }}>Praf</option>
                                <option value="4" {{ $findProduct->product_category == 4 ? 'selected' : '' }}>Coffee</option>
                                <option value="5" {{ $findProduct->product_category == 5 ? 'selected' : '' }}>Fruit Tea</option>
                                <option value="6" {{ $findProduct->product_category == 6 ? 'selected' : '' }}>Brosty</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="exampleFormControlSelect1">Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" id="statusDropdown" placeholder="Select a Status" required>
                                <option value="">Select Option</option>
                                <option value="0" {{ $findProduct->product_status == 0 ? 'selected' : '' }}>in Active</option>
                                <option value="1" {{ $findProduct->product_status == 1 ? 'selected' : '' }}>Active</option>
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <label for="exampleFormControlSelect1">Image</label>

                            <input type="file" class="form-control" name="Attachment" id="fileUpload" aria-describedby="basic-addon3">
                            <div id="fileError" class="text-danger mt-2"></div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <label for="exampleFormControlSelect1">Image uploaded</label>
                            @if(!empty($findProduct->image_name))
                                <div class="mb-3">
                                    <img src="{{ asset('uploads/' . $findProduct->image_name) }}" alt="Product Image" style="max-width: 150px; max-height: 150px;">
                                </div>
                            @endif
                        </div>

                        <div class="col-lg-12" id="sizes">
                            <label for="sizes">Add Sizes</label>
                            <div id="sizeInputsContainer">
                                @foreach($findProductSize as $size)
                                <div class="size-section">
                                    <div class="row">
                                        <!-- Size and Price Input -->

                                        <div class="col-lg-12">
                                            <div class="input-group size-row">
                                                <input type="text" name="sizes[]" class="form-control col-lg-4" style="max-width: 200px;" placeholder="Size (e.g., Medio)" value="{{ $size->size }}">
                                                <input type="number" step="0.01" name="prices[]" class="form-control" style="max-width: 200px;" placeholder="Price" value="{{ $size->price }}">
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
                                                            <input type="checkbox" class="form-check-input inventory-checkbox-material" name="inventory_material_items[]" value="{{ $inventory->id }}" @if($findProductInventoryMaterial->contains('inventory_id', $inventory->id)) checked @endif>
                                                            <label class="form-check-label">{{ $inventory->ingredients_name }}</label>
                                                        </div>
                                                    </div>
                                                    @endforeach
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
                                                                    <input type="checkbox" class="form-check-input inventory-checkbox" name="inventory_items[]" value="{{ $inventory->id }}">
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

                                            <div id="sizeInputsContainer"></div>
                                        </div>


                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" id="addSizeButton" class="btn btn-secondary mt-2">Add Size</button>
                        </div>

                        <div class="col-lg-12 text-end mt-3">
                            <button id="addTicket" type="button" class="btn btn-success">Save</button>
                            <a type="button" href="{{ route('product') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

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
        let sizeIndex = 0;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the checkbox listeners
            document.querySelectorAll('.size-section').forEach(section => {
                updateCheckboxListeners(section);
            });

            // Event delegation for remove buttons
            document.getElementById('sizeInputsContainer').addEventListener('click', function(event) {
                if (event.target && event.target.classList.contains('remove-btn')) {
                    removeSizeSection(event.target);
                }
            });

            // Add event listener for the add size button
            document.getElementById('addSizeButton').addEventListener('click', function() {
                addNewSizeSection();
            });
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

            // Append the cloned section to the sizeInputsContainer
            document.getElementById('sizeInputsContainer').appendChild(sizeSection);

            // Update the event listeners for the new checkboxes
            updateCheckboxListeners(sizeSection);
        }

        function updateCheckboxListeners(section) {
            // Only update checkboxes within the new section
            section.querySelectorAll('.inventory-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const container = section.querySelector('.inventoryInputsContainer');
                    const inventoryId = this.value;
                    const inventoryName = this.nextElementSibling.innerText;

                    if (this.checked) {
                        let inputDiv = container.querySelector(`.inventory-input[data-inventory-id="${inventoryId}"]`);

                        if (!inputDiv) {
                            inputDiv = document.createElement('div');
                            inputDiv.classList.add('input-group', 'mb-3', 'inventory-input');
                            inputDiv.setAttribute('data-inventory-id', inventoryId);

                            const inputPrepend = document.createElement('div');
                            inputPrepend.classList.add('input-group-prepend');
                            inputPrepend.innerHTML = `<span class="input-group-text">${inventoryName}</span>`;

                            const inputQuantity = document.createElement('input');
                            inputQuantity.type = 'number';
                            inputQuantity.classList.add('form-control');
                            inputQuantity.name = `inventory_${inventoryId}_quantity`;
                            inputQuantity.placeholder = 'Enter quantity';
                            inputQuantity.required = true;
                            inputQuantity.min = 1;

                            const unitSelect = document.createElement('select');
                            unitSelect.classList.add('form-control');
                            unitSelect.name = `inventory_${inventoryId}_unit`;
                            const units = ['grams', 'milliliters', 'pieces'];
                            units.forEach(unit => {
                                const option = document.createElement('option');
                                option.value = unit;
                                option.text = unit.charAt(0).toUpperCase() + unit.slice(1);
                                unitSelect.appendChild(option);
                            });

                            inputDiv.appendChild(inputPrepend);
                            inputDiv.appendChild(inputQuantity);
                            inputDiv.appendChild(unitSelect);
                            container.appendChild(inputDiv);
                        }
                    } else {
                        const inputDiv = container.querySelector(`.inventory-input[data-inventory-id="${inventoryId}"]`);
                        if (inputDiv) {
                            container.removeChild(inputDiv);
                        }
                    }
                });

                // Trigger change event if checkbox is pre-checked
                if (checkbox.checked) {
                    const event = new Event('change');
                    checkbox.dispatchEvent(event);
                }
            });
        }

        function removeSizeSection(button) {
            // Only allow removal if there is more than one size section
            if (document.querySelectorAll('.size-section').length > 1) {
                button.closest('.size-section').remove();
            } else {
                alert("You must have at least one size section.");
            }
        }

        // Add the initial remove event listener for the existing remove button
        // document.querySelector('.remove-btn').addEventListener('click', function() {
        //     console.log("Hello world!");

        //     removeSizeSection(this);
        // });

        function showPopup() {
            const form = document.getElementById('addTicketForm');
            const isValid = validateForm(form);

            if (isValid) {
                // Example condition: You can add any custom condition here
                // For example, check if a specific field has a certain value
                const someCondition = true; // Replace this with your actual condition

                if (someCondition) {
                    Swal.fire({
                        title: '&#x231B; <br> Adding Product...',
                        text: 'Please wait while process the product.',
                        showConfirmButton: false,
                        showCancelButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                            form.submit();  // Submit the form only if the condition is met
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
                    // Condition not met, do not proceed with form submission
                    Swal.fire({
                        icon: 'error',
                        title: 'Condition Not Met',
                        text: 'You cannot proceed because the condition is not met.',
                    });
                }
            } else {
                // Validation failed
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fill in all the required fields.',
                });
            }
        }

        // Attach the click event listener to the button
        document.getElementById('addTicket').addEventListener('click', showPopup);


        document.getElementById('addTicket').addEventListener('click', showPopup);

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
