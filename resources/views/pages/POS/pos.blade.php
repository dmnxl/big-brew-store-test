@extends('layouts.main')

@section('main')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid py-4">

        <div class="row">
            <div class="col-sm-12 col-md-9">
                <div class="row">
                    <h3>Categories</h3>

                    <div class="col-sm-12">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex overflow-scroll" style="min-width: 250px; height: 180px;">
                                        <div class="card me-1" style=" cursor: pointer; min-width: 150px; height:150px; background-color: #1C1C1C" id="category_products" data-category="all">
                                            <div class="card-body">
                                                <img src="{{ asset('img/all.png') }}" alt="Praf Image" class="img-fluid">
                                                <h5 class="card-title text-center text-white">All</h5>
                                            </div>
                                        </div>
                                        <div class="card me-1" style=" cursor: pointer; min-width: 150px; height:150px; background-color: #B46A1F" id="category_products" data-category="3">
                                            <div class="card-body">
                                                <img src="{{ asset('img/praf.png') }}" alt="Praf Image" class="img-fluid">
                                                <h5 class="card-title text-center text-white">Praf</h5>
                                            </div>
                                        </div>
                                        <div class="card me-1" style=" cursor: pointer; min-width: 150px; height:150px; background-color: #1C1C1C" id="category_products" data-category="2">
                                            <div class="card-body">
                                                <img src="{{ asset('img/milktea.png') }}" alt="Milktea Image"
                                                    class="img-fluid">
                                                <h5 class="card-title text-center text-white">Milktea</h5>
                                            </div>
                                        </div>
                                        <div class="card me-1" style=" cursor: pointer; min-width: 150px; height:150px; background-color: #B46A1F" id="category_products" data-category="4">
                                            <div class="card-body">
                                                <img src="{{ asset('img/coffee.png') }}" alt="Coffee Image"
                                                    class="img-fluid">
                                                <h5 class="card-title text-center text-white">Coffee</h5>
                                            </div>
                                        </div>
                                        <div class="card me-1" style=" cursor: pointer; min-width: 150px; height:150px; background-color: #1C1C1C" id="category_products" data-category="5">
                                            <div class="card-body">
                                                <img src="{{ asset('img/fruittea.png') }}" alt="Fruit Tea Image"
                                                    class="img-fluid">
                                                <h5 class="card-title text-center text-white">Fruit Tea</h5>
                                            </div>
                                        </div>
                                        <div class="card me-1" style=" cursor: pointer; min-width: 150px; height:150px; background-color: #B46A1F" id="category_products" data-category="6">
                                            <div class="card-body">
                                                <img src="{{ asset('img/brosty.png') }}" alt="brosty Image"
                                                    class="img-fluid"
                                                    style="margin-left: 15px; width: 75px; height: 75px;">
                                                <h5 class="card-title text-center text-white">Brosty</h5>
                                            </div>
                                        </div>
                                        <div class="card me-1" style=" cursor: pointer; min-width: 150px; height:150px; background-color: #1C1C1C" id="category_products" data-category="1">
                                            <div class="card-body">
                                                <img src="{{ asset('img/special.png') }}" alt="Special Image"
                                                    class="img-fluid">
                                                <h5 class="card-title text-center text-white">Special Drinks</h5>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div style="position: relative;">
                                    <!-- Spinner, centered within products-container -->
                                    <div id="loading-spinner" class="text-center" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 10;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>

                                    <!-- Product container -->
                                    <div class="row mt-4" id="products-container">
                                        @forelse($products as $product)
                                            <div class="col-md-3 mb-4">
                                                <div class="card product-card" style="height: 250px; cursor: pointer;"
                                                    data-product-id="{{ $product->id }}"
                                                    data-product-name="{{ $product->product_name }}"
                                                    data-product-image="{{ asset('uploads/' . $product->image_name) }}"
                                                    data-product-medio-price="{{ $product->medio }}"
                                                    data-product-grande-price="{{ $product->grande }}">
                                                    <img src="{{ asset('uploads/' . $product->image_name) }}"
                                                        alt="{{ $product->product_name }}" class="card-img-top"
                                                        style="width: 100%; height: 150px;">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-center" style="min-height: 50px;">{{ $product->product_name }}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <p class="text-center">No products available in this category.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Receipt section: visible only on desktop -->
            <div class="col-sm-12 col-md-4 d-none d-md-block"
                style="position: absolute; top: 1; right: 0; width: 28%; height: 100vh; background-color: #f8f9fa; border-left: 1px solid #ddd; overflow-y: auto;">
                <div class="card p-3" style="border-radius: 10px;">
                    <h3 class="text-center mb-4">Cart</h3>
                    <ul class="list-group mb-3" id="cart-items">
                        <!-- Cart items will be appended here dynamically -->
                    </ul>

                    <!-- Summary -->
                    <div class="d-flex justify-content-between mb-3">
                        <span><strong>Total</strong></span>
                        <span class="badge bg-success rounded-pill" id="cart-total">₱0.00</span>
                    </div>

                    <button class="btn btn-primary w-100" id="checkoutButton">Proceed to Checkout</button>
                </div>
            </div>

            <!-- Button to show receipt on mobile -->
            <button class="btn btn-primary d-md-none" data-bs-toggle="modal" data-bs-target="#receiptModal"
                style="position: fixed; bottom: 20px; right: 20px;">Show Receipt</button>
        </div>

    </div>

    <!-- Modal for Product Details -->
    @include('pages.POS.order')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productCards = document.querySelectorAll('.product-card');
            let cart = [];
            let cartTotal = 0;

            document.querySelectorAll('[id^="category_"]').forEach(card => {
                card.addEventListener('click', function() {
                    let category = this.getAttribute('data-category');
                    let productsContainer = document.getElementById('products-container');
                    let spinner = document.getElementById('loading-spinner');

                    // Show spinner and hide existing content
                    spinner.style.display = 'block';
                    productsContainer.style.opacity = '0.5';

                    axios.get('/filter-products', {
                        params: {
                            category: category
                        }
                    })
                    .then(function(response) {
                        let products = response.data.products;
                        productsContainer.innerHTML = ''; // Clear current products, but spinner stays

                        if (products.length > 0) {
                            products.forEach(product => {
                                productsContainer.innerHTML += `
                                    <div class="col-md-3 mb-4">
                                        <div class="card product-card" style="height: 250px; cursor: pointer;"
                                            data-product-id="${product.id}"
                                            data-product-name="${product.product_name}"
                                            data-product-image="/uploads/${product.image_name}"
                                            data-product-medio-price="${product.medio}"
                                            data-product-grande-price="${product.grande}">
                                            <img src="/uploads/${product.image_name}" alt="${product.product_name}" class="card-img-top" style="width: 100%; height: 150px;">
                                            <div class="card-body">
                                                <h5 class="card-title text-center" style="min-height: 50px;">${product.product_name}</h5>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            productsContainer.innerHTML = '<p class="text-center">No products available in this category.</p>';
                        }
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                    })
                    .finally(function() {
                        // Hide spinner and show content again after fetching is done
                        spinner.style.display = 'none';
                        productsContainer.style.opacity = '1';
                    });
                });
            });



            // Clear modal content before populating new data
            document.getElementById('products-container').addEventListener('click', function (event) {
                if (event.target.closest('.product-card')) {
                    const card = event.target.closest('.product-card');

                    const productId = card.getAttribute('data-product-id');
                    const productName = card.getAttribute('data-product-name');
                    const productImage = card.getAttribute('data-product-image');

                    // Clear old sizes and reset modal content
                    document.getElementById('productId').value = '';
                    document.getElementById('productName').textContent = '';
                    const sizesContainer = document.getElementById('sizes');
                    sizesContainer.innerHTML = ''; // Clear previous sizes

                    // Populate modal with current product details
                    document.getElementById('productId').value = productId;
                    document.getElementById('productName').textContent = productName;

                    // Fetch new sizes
                    fetch('/get-product-sizes', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ product_id: productId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.sizes && data.sizes.length > 0) {
                            data.sizes.forEach(size => {
                                const sizeElement = `
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="size" id="size${size.id}" value="${size.size}" data-price="${parseFloat(size.price).toFixed(2)}">
                                        <label class="form-check-label" for="size${size.id}">
                                            ${size.size} - ₱${parseFloat(size.price).toFixed(2)}
                                        </label>
                                    </div>`;
                                sizesContainer.insertAdjacentHTML('beforeend', sizeElement);
                            });
                        } else {
                            sizesContainer.innerHTML = '<p class="text-muted">No sizes available for this product.</p>';
                        }
                    })
                    .catch(error => console.error('Error fetching sizes:', error));

                    const modal = new bootstrap.Modal(document.getElementById('productModal'));
                    modal.show();
                }
            });


            // Add to cart
            document.getElementById('addToCartButton').addEventListener('click', function () {
                const productId = document.getElementById('productId').value;
                const productName = document.getElementById('productName').textContent;
                const quantity = document.querySelector('input[name="quantity_medio"]').value;
                const sizeElement = document.querySelector('input[name="size"]:checked');
                const sugarLevelElement = document.querySelector('input[name="sugarLevel"]:checked');
                const addOnElements = document.querySelectorAll('.inventory-checkbox:checked');

                console.log(sizeElement);


                // Validation
                let errorMessages = [];
                if (!productId) {
                    errorMessages.push("Product ID is missing.");
                }
                if (!productName) {
                    errorMessages.push("Product Name is missing.");
                }
                if (!quantity || parseInt(quantity) <= 0) {
                    errorMessages.push("Please enter a valid quantity.");
                }
                if (!sizeElement) {
                    errorMessages.push("Please select a size.");
                }
                if (!sugarLevelElement) {
                    errorMessages.push("Please select a sugar level.");
                }

                // Show errors if any and stop execution
                if (errorMessages.length > 0) {
                    alert(errorMessages.join('\n'));
                    return;
                }

                const size = sizeElement.value;
                const price = sizeElement.getAttribute('data-price');
                const sugarLevel = sugarLevelElement.value;
                const addOns = Array.from(addOnElements).map(item => ({
                    id: item.value,
                    name: item.parentElement.textContent.trim()
                }));
                const totalPrice = calculatePrice(parseFloat(price), parseInt(quantity), addOns.length);

                // Check if editing an item
                const editIndex = document.getElementById('productModal').dataset.editIndex;
                if (editIndex !== undefined) {
                    // Update existing item
                    cart[editIndex] = {
                        productId,
                        productName,
                        quantity,
                        size,
                        sugarLevel,
                        addOns,
                        totalPrice
                    };
                    delete document.getElementById('productModal').dataset.editIndex; // Clear edit index
                } else {
                    // Add new item
                    cart.push({
                        productId,
                        productName,
                        quantity,
                        size,
                        sugarLevel,
                        addOns,
                        totalPrice
                    });
                }

                updateCartDisplay();

                // Reset the form and uncheck all inputs
                document.getElementById('AddOrder').reset();
                document.querySelectorAll('input[type="radio"]').forEach(radio => (radio.checked = false));
                document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => (checkbox.checked = false));

                // Hide the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
                modal.hide();
            });



            // Function to calculate price based on size and quantity (implement actual logic)
            function calculatePrice(price, quantity, addOnCount) {
                const addOnPrice = 9;
                const totalAddOnPrice = addOnCount * addOnPrice;
                const totalPrice = (price + totalAddOnPrice) * quantity;
                return totalPrice;
            }

            function updateCartDisplay() {
                const cartItemsContainer = document.getElementById('cart-items');
                cartItemsContainer.innerHTML = ''; // Clear the current items

                cart.forEach((item, index) => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-start';

                    const addOnList = item.addOns.map(addOn => addOn.name).join(', ');

                    li.innerHTML = `
                        <div class="row">
                            <div class="col-md-12">
                                <a class="remove-item" data-index="${index}" style="margin-left: 10px; cursor:pointer; float:right;">&times;</a>
                                <a class="edit-item" data-index="${index}" style="margin-left: 10px; cursor:pointer; float:right;">&#9998</a>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="fw-bold">${item.productName}</div>
                                    </div>
                                    <div class="col-md-5">
                                        <span class="badge bg-success rounded-pill">₱${item.totalPrice.toFixed(2)}</span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">Quantity: ${item.quantity}</div>
                                            <div class="col-md-12">Size: ${item.size}</div>
                                            <div class="col-md-12">Sugar: ${item.sugarLevel}</div>
                                            <div class="col-md-12">Add-ons: ${addOnList}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    cartItemsContainer.appendChild(li);
                });

                // Update total price
                updateCartTotal();
            }

            // Remove item from cart
            document.getElementById('cart-items').addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-item')) {
                    const index = e.target.getAttribute('data-index');

                    // Show confirmation dialog using Swal
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you want to remove this item from the cart?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, remove it!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Remove item from cart array
                            cart.splice(index, 1);
                            updateCartDisplay(); // Re-render cart items
                            Swal.fire(
                                'Removed!',
                                'The item has been removed from your cart.',
                                'success'
                            );
                        }
                    });
                }
            });


            document.getElementById('cart-items').addEventListener('click', function (e) {
                if (e.target.classList.contains('edit-item')) {
                    const index = e.target.getAttribute('data-index');
                    const item = cart[index];

                    // Populate modal with the item’s current details
                    document.getElementById('productId').value = item.productId;
                    document.getElementById('productName').textContent = item.productName;
                    document.querySelector('input[name="quantity_medio"]').value = item.quantity;

                    // Set size radio button and sugar level based on current item details
                    document.querySelector(`input[name="size"][value="${item.size}"]`).checked = true;
                    document.querySelector(`input[name="sugarLevel"][value="${item.sugarLevel}"]`).checked = true;

                    // Set add-ons checkboxes based on current item details
                    document.querySelectorAll('.inventory-checkbox').forEach(checkbox => {
                        checkbox.checked = item.addOns.some(addOn => addOn.id === checkbox.value);
                    });

                    // Show the modal
                    const modal = new bootstrap.Modal(document.getElementById('productModal'));
                    modal.show();

                    // Save the index of the item being edited
                    document.getElementById('productModal').dataset.editIndex = index;
                }
            });



            function updateCartTotal() {
                cartTotal = cart.reduce((total, item) => total + item.totalPrice, 0);
                document.getElementById('cart-total').textContent = `₱${cartTotal.toFixed(2)}`;
            }

            document.getElementById('checkoutButton').addEventListener('click', function () {
                // Check if the cart is empty
                if (cart.length === 0) {
                    Swal.fire(
                        'Empty Cart',
                        'Your cart is empty. Please add items before proceeding.',
                        'warning'
                    );
                    return; // Stop the checkout process if the cart is empty
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to proceed with the checkout?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, proceed!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Prepare the cart data to send to the backend
                        axios.post('/checkout', { cart: cart })
                            .then(function(response) {
                                Swal.fire(
                                    'Success!',
                                    'Checkout successful!',
                                    'success'
                                );
                                console.log("Receipt logs", response.data);
                                // Open the receipt page in a new window
                                const orderId = response.data.orderId;
                                const receiptUrl = `/receipt/${orderId}`;
                                const receiptWindow = window.open(receiptUrl, '', 'width=600,height=400');
                                // Clear the cart
                                cart = [];
                                updateCartDisplay();
                            })
                            .catch(function(error) {
                                console.error('Error:', error);
                                Swal.fire(
                                    'Oops...',
                                    'An error occurred during checkout.',
                                    'error'
                                );
                            });
                    }
                });
            });

        });

    </script>
@endsection
