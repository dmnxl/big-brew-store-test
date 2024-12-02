@extends('layouts.main')

@section('main')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-fluid py-4">
    <div class="row">
        <!-- Existing cards for Today -->
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 pt-3">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total No. of Orders Today</p>
                                <h5 class="font-weight-bolder">{{ $totalOrdersToday }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-primary text-center rounded-circle">
                                <i class="fa fa-mug-saucer text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 pt-3">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total No. of Sales Today</p>
                                <h5 class="font-weight-bolder">{{ $totalSalesToday }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="fa fa-chart-line text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 pt-3">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total No. of Customers Today</p>
                                <h5 class="font-weight-bolder">{{ $ordersCountToday }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-primary text-center rounded-circle">
                                <i class="fa fa-user text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Graph -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="font-weight-bold">Daily Sales & Orders Overview</h5>
                    <canvas id="dailyChart" height="100"></canvas> <!-- Daily Chart Canvas -->
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Graph -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="font-weight-bold">Monthly Sales & Orders Overview</h5>
                    <canvas id="monthlyChart" height="100"></canvas> <!-- Specify height here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Yearly Graph -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="font-weight-bold">Yearly Sales & Orders Overview</h5>
                    <canvas id="yearlyChart" height="100"></canvas> <!-- Yearly Chart Canvas -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     // Daily Chart
     var dailyCtx = document.getElementById('dailyChart').getContext('2d');
    var dailyChart = new Chart(dailyCtx, {
        type: 'line', // Line chart for daily data
        data: {
            labels: @json(range(1, 31)), // Days of the current month (1 to 31)
            datasets: [
                {
                    label: 'Total Orders',
                    data: @json($dailyOrders), // Daily order data
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true
                },
                {
                    label: 'Total Sales',
                    data: @json($dailySales), // Daily sales data
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    fill: true
                },
                {
                    label: 'Total Customers',
                    data: @json($dailyCustomers), // Daily customer data
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderWidth: 2,
                    fill: true
                }
            ]
        },
        options:{
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        }
    });

    var ctx = document.getElementById('monthlyChart').getContext('2d');
    var monthlyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], // Months of the year
            datasets: [
                {
                    label: 'Total Orders',
                    data: @json($monthlyOrders), // Monthly order data
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true
                },
                {
                    label: 'Total Sales',
                    data: @json($monthlySales), // Monthly sales data
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    fill: true
                },
                {
                    label: 'Total Customers',
                    data: @json($monthlyCustomers), // Monthly customer data
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderWidth: 2,
                    fill: true
                }
            ]
        },
        options:{
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
            },
        }
    });

     // Yearly Chart
     var yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
    var yearlyChart = new Chart(yearlyCtx, {
        type: 'bar',  // Bar chart for yearly data
        data: {
            labels: @json($yearlyOrders).map(item => item.year), // Years
            datasets: [
                {
                    label: 'Total Orders',
                    data: @json($yearlyOrders).map(item => item.total), // Yearly order data
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                },
                {
                    label: 'Total Sales',
                    data: @json($yearlySales).map(item => item.total), // Yearly sales data
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                },
                {
                    label: 'Total Customers',
                    data: @json($yearlyCustomers).map(item => item.total), // Yearly customer data
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
