<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    <!-- Metrics -->
    <div class="row">
        <!-- Today Orders -->
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-calendar-check"></i>
                            </span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $todayOrders }}</h4>
                    </div>
                    <p class="mb-1">Today Orders</p>
                </div>
            </div>
        </div>

        <!-- This Month Orders -->
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-success h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-calendar"></i>
                            </span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $thisMonthOrders }}</h4>
                    </div>
                    <p class="mb-1">This Month Orders</p>
                </div>
            </div>
        </div>

        <!-- Last Month Orders -->
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-warning h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="bx bx-calendar-minus"></i>
                            </span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $lastMonthOrders }}</h4>
                    </div>
                    <p class="mb-1">Last Month Orders</p>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-sm-6 col-lg-3 mb-4">
            <div class="card card-border-shadow-danger h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2 pb-1">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="bx bx-box"></i>
                            </span>
                        </div>
                        <h4 class="ms-1 mb-0">{{ $totalOrders }}</h4>
                    </div>
                    <p class="mb-1">Total Orders</p>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <!-- Total Products -->
        <div class="col-6 col-md-3 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            <i class="bx bx-box fs-4"></i> <!-- Icon for Products -->
                        </span>
                    </div>
                    <span class="d-block text-nowrap">Total Products</span>
                    <h2 class="mb-0">{{ $totalProducts }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Brands -->
        <div class="col-6 col-md-3 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-success">
                            <i class="bx bx-cube fs-4"></i> <!-- Icon for Brands -->
                        </span>
                    </div>
                    <span class="d-block text-nowrap">Total Brands</span>
                    <h2 class="mb-0">{{ $totalBrands }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Categories -->
        <div class="col-6 col-md-3 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-warning">
                            <i class="bx bx-category fs-4"></i> <!-- Icon for Categories -->
                        </span>
                    </div>
                    <span class="d-block text-nowrap">Total Categories</span>
                    <h2 class="mb-0">{{ $totalCategories }}</h2>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- Total Revenue -->


        <!-- Today's Revenue -->
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-container me-3">

                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bxs-party"></i>
                            </span>
                        </div>
                    </div>
                    <div>
                        <h6>Today's Revenue</h6>
                        <h3>{{ number_format($todayRevenue) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- This Month's Revenue -->
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-container me-3">
                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-bar-chart-alt"></i>
                            </span>
                        </div>

                    </div>
                    <div>
                        <h6>This Month's Revenue</h6>
                        <h3>{{ number_format($thisMonthRevenue) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- This Year's Revenue -->
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-container me-3">


                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="bx bx-money"></i>
                            </span>
                        </div>
                    </div>
                    <div>
                        <h6>This Year's Revenue</h6>
                        <h3>{{ number_format($thisYearRevenue) }}</h3>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body d-flex align-items-center">

                        <div class="avatar me-2">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="bx bxs-balloon"></i>
                            </span>
                        </div>

                    <div>
                        <h6>Total Revenue</h6>
                        <h3>{{ number_format($totalRevenue) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Orders Chart -->
    <div class="">
        <h2 class="text-lg font-semibold mb-4">Monthly Orders Overview</h2>
        <div class="bg-white rounded-lg shadow-md p-4">
            <canvas id="myChart" style="width:100%;max-height:500px;"></canvas>
        </div>
    </div>

</div>


@push('scripts')

<!-- Include Chart.js -->
<script>
    document.addEventListener('livewire:load', function () {
        // Initialize the Chart
        const ctx = document.getElementById('barChart').getContext('2d');

        const ordersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Monthly Orders',
                    data: @json($monthlyOrdersData), // Pass your Livewire data here
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Dropdown Handling for Chart Updates
        function updateChart(range) {
            let newData;

            // Simulate data for different ranges (replace with Livewire emit or API calls)
            switch (range) {
                case 'today':
                    newData = [2, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    break;
                case 'yesterday':
                    newData = [0, 1, 2, 3, 4, 0, 0, 0, 0, 0, 0, 0];
                    break;
                case 'last7':
                    newData = [1, 1, 1, 2, 2, 2, 3, 0, 0, 0, 0, 0];
                    break;
                case 'last30':
                    newData = [0, 1, 2, 3, 2, 1, 0, 1, 2, 3, 2, 1];
                    break;
                case 'currentMonth':
                    newData = [0, 0, 0, 0, 0, 0, 0, 0, 4, 0, 7, 0]; // Replace with dynamic data
                    break;
                case 'lastMonth':
                    newData = [0, 0, 0, 0, 0, 0, 0, 0, 3, 1, 4, 0]; // Replace with dynamic data
                    break;
                default:
                    newData = @json($monthlyOrdersData);
            }

            // Update chart data
            ordersChart.data.datasets[0].data = newData;
            ordersChart.update();
        }

        // Expose updateChart globally for dropdown actions
        window.updateChart = updateChart;
    });
</script>
<script>
    // Chart data
    const xValues = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const yValues = @json($monthlyOrdersData);

    // Chart configuration
    new Chart("myChart", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
                label: "Monthly Orders",
                data: yValues,
                fill: true, // Fill the area under the line
                backgroundColor: "rgba(75, 192, 192, 0.2)", // Light teal for fill
                borderColor: "rgba(75, 192, 192, 1)", // Teal for line
                borderWidth: 2, // Thicker line
                pointBackgroundColor: "rgba(75, 192, 192, 1)", // Points color
                pointBorderColor: "#fff", // Points border color
                pointHoverBackgroundColor: "#fff", // Points hover background
                pointHoverBorderColor: "rgba(75, 192, 192, 1)", // Points hover border
                tension: 0.3 // Smooth curve
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top', // Position of the legend
                    labels: {
                        color: '#4A4A4A', // Legend text color
                        font: {
                            size: 14 // Font size for legend
                        }
                    }
                },
                tooltip: {
                    enabled: true, // Show tooltips
                    backgroundColor: "rgba(0,0,0,0.8)", // Tooltip background color
                    titleFont: { size: 16, weight: 'bold' }, // Tooltip title font
                    bodyFont: { size: 14 }, // Tooltip body font
                    footerFont: { size: 12 }, // Tooltip footer font
                    padding: 10, // Tooltip padding
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#6B7280', // X-axis ticks color
                        font: {
                            size: 12 // Font size for X-axis
                        }
                    },
                    grid: {
                        display: false // Remove grid lines
                    }
                },
                y: {
                    ticks: {
                        color: '#6B7280', // Y-axis ticks color
                        font: {
                            size: 12 // Font size for Y-axis
                        },
                        callback: function(value) {
                            return value; // Format tick labels
                        }
                    },
                    grid: {
                        color: 'rgba(75, 192, 192, 0.1)', // Grid line color
                        borderDash: [5, 5] // Dashed grid lines
                    }
                }
            }
        }
    });
</script>
@endpush
