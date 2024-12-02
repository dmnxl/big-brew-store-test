@extends('layouts.main')

@section('main')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid py-4">

    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-lg-6" >
                    <h5>Add Ons</h5>
                </div>
                <div class="text-end col-lg-3">
                    <button href="#" class="btn btn-md bg-gradient-success" data-bs-toggle="modal" data-bs-target="#ModalInventory"><i class="fa fa-solid fa-plus"></i> Add add-ons</button>
                    @include('pages.inventory.addAddOns')
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
                                Inventory Name</th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                Stocks</th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-2">
                                Unit</th>
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

                axios.get(`{{ route('invDataAddOns') }}?page=${page}&search=${search}`)
                .then(function(response){
                    const inventoryData = response.data.data;
                    totalEntries = response.data.total;

                    if(Array.isArray(inventoryData)){
                        tableBody.innerHTML = '';

                        inventoryData.forEach(inventory => {
                            const row = `
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <h6 class="mb-0 text-sm">
                                                ${inventory.id}
                                            </h6>
                                        </div>
                                    </td>

                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">${inventory.ingredients_name}</p>
                                    </td>

                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">${inventory.stocks}</p>
                                    </td>

                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">${inventory.unit ? inventory.unit : 'No unit available'}</p>
                                    </td>


                                    <td class="align-middle text-start text-xs">
                                        <button type="button" class="btn btn-xs bg-gradient-dark edit-btn" data-bs-toggle="modal" data-bs-target="#ModalEdit" data-id="${inventory.id}" data-ingredients-name="${inventory.ingredients_name}" data-stock="${inventory.stocks}">
                                            <i class="fa fa-solid fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-xs bg-gradient-dark delete-btn" data-bs-toggle="modal" data-bs-target="#ModalDelete" data-id="${inventory.id}" data-ingredients-name="${inventory.ingredients_name}">
                                            <i class="fa fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                    @include('pages.inventory.edit')
                                    @include('pages.inventory.delete')
                                </tr>

                            `;
                            tableBody.innerHTML += row;
                        });

                        const paginationLinks = response.data.last_page;
                        updatePaginationLinks(paginationLinks, page, search);

                        document.querySelectorAll('.delete-btn').forEach(btn => {
                            btn.addEventListener('click', function() {
                                const inv_id = this.getAttribute("data-id");
                                const ingredients_name = this.getAttribute("data-ingredients-name");

                                document.getElementById('modalGrpName').innerText = ingredients_name;

                                document.getElementById('modalDeleteGrp').addEventListener('click', function(event){
                                    event.preventDefault();

                                    $('#ModalDelete').modal('hide');

                                    axios.post('{{ route('invendelete') }}', {
                                        _method: 'DELETE',
                                        inv_id: inv_id

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

                        document.querySelectorAll('.edit-btn').forEach(btn => {
                            btn.addEventListener('click', function() {
                                const inv_id = this.getAttribute("data-id");
                                const ingredients_name = this.getAttribute("data-ingredients-name");
                                const stock = this.getAttribute("data-stock");

                                document.getElementById('modalIngredientsNames').innerText = ingredients_name;
                                document.getElementById('inv_id').value = inv_id;
                                document.getElementById('ingredientsName').value = ingredients_name;
                                document.getElementById('stock').value = stock;

                                document.getElementById('ModalEditGrp').addEventListener('click', function(event){
                                    event.preventDefault();

                                    const ingredientsName = document.getElementById('ingredientsName').value;
                                    const stock = document.getElementById('stock').value;
                                    const inv_id = document.getElementById('inv_id').value;

                                    axios.post('{{ route('checkInventory') }}', {ingredientsName: ingredientsName, stock: stock, id: inv_id})
                                    .then(function(response){
                                        if (response.data.exists) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Ingredients already exists',
                                                text: 'Please choose a different Ingredients name.',
                                                showConfirmButton: false,
                                                timer: 3000
                                            });
                                        }else{
                                            $('#ModalEdit').modal('hide');

                                            axios.post('{{ route('invenedit') }}', {
                                                inv_id: inv_id,
                                                ingredientsName: ingredientsName,
                                                stock: stock
                                            })
                                            .then(response => {

                                                if(response.status === 200){
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Success',
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
                                        }

                                    })
                                    .catch(function(error) {
                                        console.error('Error checking group:', error);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Failed to check group. Please try again later.',
                                            showConfirmButton: false,
                                            timer: 3000
                                        });
                                    });


                                })
                            })
                        });

                        updateEntriesInfo(page, inventoryData.length, totalEntries);
                    } else {
                        console.error('Data received is not an array:', accountData);
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

            addIngredientsForm.addEventListener('submit', async function(event) {
                event.preventDefault();
                var submitButton = this.querySelector('button[type="submit"]');
                submitButton.disabled = true;

                var formData = new FormData(this);

                var ingredientsName = formData.get('ingredients-name');

                try{
                    var checkResponse = await axios.post('{{ route('checkInventory') }}', {
                        ingredientsName: ingredientsName,
                    });

                    if (checkResponse.data.exists) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ingredients already exists',
                            text: 'Please choose a different ingredients name.',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }else{
                        $('#ModalInventory').modal('hide');

                        try {
                            var storeResponse = await axios.post('{{ route('invenstoreAddOns') }}', formData);

                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: storeResponse.data.message,
                                showConfirmButton: false,
                                timer: 3000
                            }).then(() => {
                                location.reload();
                            });
                        } catch (error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Not Successful',
                                text: 'Adding failed, please try again later.',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(() => {
                                location.reload();
                            });
                        }
                    }



                }catch (error) {
                    console.error('Error checking inventory:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to check inventory. Please try again later.',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } finally {
                    submitButton.disabled = false;
                }
            });


            fetchData();
        } else {
            console.error('Required elements not found in the DOM.');
        }

    })

</script>


@endsection
