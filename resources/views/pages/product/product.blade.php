@extends('layouts.main')

@section('main')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid py-4">

    <div class="row">
        <div class="row">
            <div class="col-lg-6">
                <div class="position-relative">
                    @if (session('success'))
                        <script>
                           const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            iconColor: 'white',
                            customClass: {
                                popup: 'colored-toast',
                            },
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true
                           })
                           Toast.fire({
                            icon: 'success',
                            title: "{{ session('success') }}"
                           })
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-lg-6" >
                    <h5>Products</h5>
                </div>
                <div class="text-end col-lg-3">
                    <a type="button" href="{{ route('prodcreate') }}" class="btn btn-success">
                        <i class="fa fa-solid fa-plus"></i>
                        Add Product</a>
                </div>
                <div class="text-end col-lg-3">
                    <div class="input-group">
                        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" placeholder="Type here..." id="searchInput">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">
                                ID</th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                Image</th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                Product Name</th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                Product Category</th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                Size and Price</th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                Status</th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center mt-3 position-relative">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center pagination-sm" id="paginationContainer"></ul>
            </nav>
            <div id="entriesInfo" class="position-absolute end-0 text-sm me-3"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function(){

        //Inventory Table
        const tableBody = document.getElementById('tableBody');
        const paginationContainer = document.getElementById('paginationContainer');
        const searchInput = document.getElementById('searchInput');
        const entriesInfo = document.getElementById('entriesInfo');
        const addIngredientsForm = document.getElementById('AddIngredientsForm');

        if(tableBody && paginationContainer && entriesInfo){
            let debounceTimer;
            let totalEntries = 0;
            const entriesPerPage = 10;

            const debounce = (func, delay) => {
                return (...args) => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        func.apply(this, args);
                    }, delay);
                };
            };

            const fetchData = (page = 1, search = '') => {
                const spinnerRow = document.createElement('tr');
                spinnerRow.id = 'spinnerRow';
                spinnerRow.innerHTML = `
                    <td colspan="5" class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </td>
                `;

                tableBody.innerHTML = ''; // Clear previous data
                tableBody.appendChild(spinnerRow);

                axios.get(`{{ route('prodData') }}?page=${page}&search=${search}`)
                .then(function(response){
                    const productData = response.data.data;
                    totalEntries = response.data.total;

                    if(Array.isArray(productData)){
                        tableBody.innerHTML = '';

                        productData.forEach(product => {

                            const categoryMap = {
                                1: 'special drinks',
                                2: 'milktea',
                                3: 'praf',
                                4: 'coffee',
                                5: 'fruit tea',
                                6: 'brosty'
                            };

                            const category = categoryMap[product.product_category] || 'Unknown';

                            const statusMap = {
                                0: 'In Active',
                                1: 'Active',
                            };

                            const status = statusMap[product.product_status] || 'Unknown';

                            // Prepare the sizes and prices for display
                            let sizesHtml = '';
                            product.sizes.forEach(size => {
                                sizesHtml += `
                                    <p class="text-xs font-weight-bold mb-0">
                                        ${size.size} - $${size.price}
                                    </p>
                                `;
                            });

                            const row = `
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <h6 class="mb-0 text-sm">
                                                ${product.id}
                                            </h6>
                                        </div>
                                    </td>

                                    <td>
                                        <img src="{{ asset('uploads/${product.image_name}') }}" alt="${product.product_name}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                    </td>

                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">${product.product_name}</p>
                                    </td>

                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">${category}</p>
                                    </td>

                                    <td class="text-xs">
                                        ${sizesHtml}
                                    </td>

                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">${status}</p>
                                    </td>

                                    <td class="align-middle text-start text-xs">
                                        <a type="button" href="/product/${product.id}/edit" class="btn btn-xs bg-gradient-dark edit-btn">
                                            <i class="fa fa-solid fa-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-xs bg-gradient-dark delete-btn" data-bs-toggle="modal" data-bs-target="#ModalDelete" data-id="${product.id}" data-product-name="${product.product_name}">
                                            <i class="fa fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                    @include('pages.product.delete')
                                </tr>

                            `;
                            tableBody.innerHTML += row;
                        });

                        const paginationLinks = response.data.last_page;
                        updatePaginationLinks(paginationLinks, page, search);

                        document.querySelectorAll('.delete-btn').forEach(btn => {
                            btn.addEventListener('click', function() {
                                const prod_id = this.getAttribute("data-id");
                                const product_name = this.getAttribute("data-product-name");

                                console.log("product_name", product_name);


                                document.getElementById('modalProductName').innerText = product_name;

                                document.getElementById('modalDeleteProd').addEventListener('click', function(event){
                                    event.preventDefault();

                                    $('#ModalDelete').modal('hide');

                                    axios.post('{{ route('proddelete') }}', {
                                        _method: 'DELETE',
                                        prod_id: prod_id

                                    })
                                    .then(response => {

                                        if(response.status === 200){
                                            Swal.fire({
                                                icon: response.data.icon,
                                                title: response.data.title,
                                                text: response.data.message,
                                                showConfirmButton: false,
                                                timer: 3000
                                            }).then(() =>{
                                                location.reload();
                                            });
                                        }else{
                                            Swal.fire({
                                                icon: 'danger',
                                                title: 'Not Successful',
                                                showConfirmButton: false,
                                                timer: 3000
                                            }).then(() => {
                                                location.reload();
                                            })
                                        }
                                    })
                                    .catch(error => {
                                        console.error(error);
                                    })
                                })
                            })
                        });

                        updateEntriesInfo(page, productData.length, totalEntries);

                    } else {
                        console.error('Data received is not an array: ', productData);
                    }

                })
                .catch(function(error){
                    console.error('Error fetching data:', error);
                })
                .finally(() => {
                    // Hide spinner
                    tableBody.removeChild(spinnerRow);
                });

            }
            const debouncedFetchData = debounce(fetchData, 300);

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.trim();
                debouncedFetchData(1, searchTerm);
            });

            const updatePaginationLinks = (paginationLinks, page, search) => {
                paginationContainer.innerHTML = '';
                // Add Previous button
                const prevLi = document.createElement('li');
                prevLi.classList.add('page-item');
                const prevLink = document.createElement('a');
                prevLink.classList.add('page-link');
                prevLink.href = 'javascript:;';
                prevLink.innerHTML = '<i class="fas fa-chevron-left"></i>';
                prevLink.addEventListener('click', () => {
                    if (page > 1) {
                        fetchData(page - 1, search);
                    }
                });
                prevLi.appendChild(prevLink);
                paginationContainer.appendChild(prevLi);
                // Display pages
                for (let i = Math.max(1, page - 2); i <= Math.min(paginationLinks, page + 2); i++) {
                    const li = document.createElement('li');
                    li.classList.add('page-item', 'page-number');
                    const link = document.createElement('a');
                    link.classList.add('page-link');
                    link.href = 'javascript:;';
                    link.textContent = i;
                    if (i === page) {
                        li.classList.add('active');
                    }
                    link.addEventListener('click', () => {
                        fetchData(i, search);
                    });
                    li.appendChild(link);
                    paginationContainer.appendChild(li);
                }
                // Add Next button
                const nextLi = document.createElement('li');
                nextLi.classList.add('page-item');
                const nextLink = document.createElement('a');
                nextLink.classList.add('page-link');
                nextLink.href = 'javascript:;';
                nextLink.innerHTML = '<i class="fas fa-chevron-right"></i>'
                nextLink.addEventListener('click', () => {
                    if (page < paginationLinks) {
                        fetchData(page + 1, search);
                    }
                });
                nextLi.appendChild(nextLink);
                paginationContainer.appendChild(nextLi);
            }

            const updateEntriesInfo = (page, entriesShown, totalEntries) => {
                const startEntry = (page - 1) * entriesPerPage + 1;
                const endEntry = startEntry + entriesShown - 1;
                entriesInfo.textContent = `Showing ${startEntry} to ${endEntry} of ${totalEntries} entries`;
            }

            fetchData();
        } else {
            console.error('Required elements not found in the DOM.');
        }

    })

</script>


@endsection
