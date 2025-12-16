@extends('admin.template')
@section('main')
    <div class="container-fluid">
        <div class="row">
            <!-- Category Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/category/list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Category</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $category }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-primary-light rounded-circle p-3">
                                <i class="mdi mdi-folder-outline text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sub Category Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/subcategory/list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Sub Category</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $subcategory }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-success-light rounded-circle p-3">
                                <i class="mdi mdi-folder-multiple-outline text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/product/list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Products</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $product }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-info-light rounded-circle p-3">
                                <i class="mdi mdi-package-variant text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customers Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/custumer/list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Customers</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $users }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-warning-light rounded-circle p-3">
                                <i class="mdi mdi-account-group text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Customers Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/custumer/new-list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">New Customers</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $new_users }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-primary-light rounded-circle p-3">
                                <i class="mdi mdi-account-plus text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estimate Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/order/list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Estimate</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $orders }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-success-light rounded-circle p-3">
                                <i class="mdi mdi-clipboard-check text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Custom Estimate Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/custum/list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Custom Estimate</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $custom }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-info-light rounded-circle p-3">
                                <i class="mdi mdi-clipboard-edit text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Users Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/user/list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Admin Users</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $admin }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-warning-light rounded-circle p-3">
                                <i class="mdi mdi-account-cog text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/notificaiton/list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Notifications</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $notis }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-primary-light rounded-circle p-3">
                                <i class="mdi mdi-bell-outline text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Offers Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/offer/list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Offers</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $offer }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-success-light rounded-circle p-3">
                                <i class="mdi mdi-tag-outline text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Custom Notification Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/custom/notificaion') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Custom Notification</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $tasks }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-info-light rounded-circle p-3">
                                <i class="mdi mdi-bell-ring text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/media/list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Media</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $media }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-warning-light rounded-circle p-3">
                                <i class="mdi mdi-image-multiple text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Essentials Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/essential/list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Essentials</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $essential }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-primary-light rounded-circle p-3">
                                <i class="mdi mdi-cube-outline text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Collection Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/collection/list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Collection</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $collection }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-success-light rounded-circle p-3">
                                <i class="mdi mdi-folder-multiple text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/store/list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Store</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $store }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-info-light rounded-circle p-3">
                                <i class="mdi mdi-store text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Headings Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/heading/list') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">Headings</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $headings }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-warning-light rounded-circle p-3">
                                <i class="mdi mdi-format-header-1 text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- App Layouts Card -->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card border-0 shadow-sm h-100 dashboard-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <a href="{{ url('admin/layouts') }}" class="text-decoration-none">
                                    <p class="text-muted text-uppercase fw-semibold small mb-1">App Layouts</p>
                                    <h3 class="mb-0 fw-bold text-dark">{{ $layouts }}</h3>
                                </a>
                            </div>
                            <div class="icon-wrapper bg-primary-light rounded-circle p-3">
                                <i class="mdi mdi-cellphone-text text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Graphs Section -->
    <div class="row mt-4">


        <!-- Order Status Distribution -->
        <div class="col-xl-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-2">
                    <h6 class="card-title mb-0 text-dark fw-semibold">
                        <i class="mdi mdi-chart-pie me-2 text-success"></i>
                        Order Status
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <div class="chart-container" style="position: relative; height: 220px;">
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Trend -->
        <div class="col-xl-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-2">
                    <h6 class="card-title mb-0 text-dark fw-semibold">
                        <i class="mdi mdi-currency-usd me-2 text-warning"></i>
                        Revenue Trend
                    </h6>
                    <p class="text-muted small mb-0">Last 4 Weeks</p>
                </div>
                <div class="card-body pt-0">
                    <div class="chart-container" style="position: relative; height: 220px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Orders Chart -->
        <div class="col-xl-12 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 pb-2">
                    <h6 class="card-title mb-0 text-dark fw-semibold">
                        <i class="mdi mdi-chart-line me-2 text-primary"></i>
                        Monthly Orders Trend
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <div class="chart-container" style="position: relative; height: 250px;">
                        <canvas id="monthlyOrdersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>



    <style>
        :root {
            --primary-color: #143632;
            --primary-light: rgba(20, 54, 50, 0.1);
            --success-color: #10b981;
            --info-color: #3b82f6;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --gold-color: #d4af37;
        }

        .dashboard-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            border: 1px solid #f0f0f0;
            background: white;
            position: relative;
            overflow: hidden;
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-color));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(20, 54, 50, 0.15) !important;
            border-color: var(--primary-color);
        }

        .dashboard-card:hover::before {
            opacity: 1;
        }

        .card {
            border-radius: 12px;
            border: 1px solid rgba(20, 54, 50, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 5px 15px rgba(20, 54, 50, 0.1);
        }

        .card-title {
            font-weight: 600;
            color: var(--primary-color);
        }

        .chart-container {
            min-height: 200px;
        }

        /* Responsive chart adjustments */
        @media (max-width: 768px) {
            .chart-container {
                height: 200px !important;
            }
        }

        @media (max-width: 576px) {
            .chart-container {
                height: 180px !important;
            }
        }
    </style>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Orders Line Chart - Compact
            const monthlyOrdersCtx = document.getElementById('monthlyOrdersChart').getContext('2d');
            new Chart(monthlyOrdersCtx, {
                type: 'line',
                data: {
                    labels: @json($monthly_orders['labels']),
                    datasets: [{
                        label: 'Orders',
                        data: @json($monthly_orders['data']),
                        borderColor: '#143632',
                        backgroundColor: 'rgba(20, 54, 50, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#143632',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 1,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(20, 54, 50, 0.9)',
                            titleFont: {
                                size: 12
                            },
                            bodyFont: {
                                size: 11
                            },
                            padding: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.03)'
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 10
                                },
                                padding: 5
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 10
                                },
                                padding: 5
                            }
                        }
                    },
                    layout: {
                        padding: {
                            left: 5,
                            right: 5,
                            top: 5,
                            bottom: 5
                        }
                    }
                }
            });

            // Order Status Doughnut Chart - Compact
            const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
            new Chart(orderStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($order_status_data['labels']),
                    datasets: [{
                        data: @json($order_status_data['data']),
                        backgroundColor: @json($order_status_data['colors']),
                        borderWidth: 1,
                        borderColor: '#fff',
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: {
                                    size: 10
                                },
                                boxWidth: 8
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(20, 54, 50, 0.9)',
                            bodyFont: {
                                size: 11
                            },
                            padding: 6
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    }
                }
            });

            // Revenue Bar Chart - Compact
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: @json($revenue_trend['labels']),
                    datasets: [{
                        label: 'Revenue ($)',
                        data: @json($revenue_trend['data']),
                        backgroundColor: [
                            'rgba(212, 175, 55, 0.8)',
                            'rgba(20, 54, 50, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(59, 130, 246, 0.8)'
                        ],
                        borderColor: [
                            '#d4af37',
                            '#143632',
                            '#10b981',
                            '#3b82f6'
                        ],
                        borderWidth: 1,
                        borderRadius: 4,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `$${context.parsed.y.toLocaleString()}`;
                                }
                            },
                            bodyFont: {
                                size: 11
                            },
                            padding: 6
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.03)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '₹' + value.toLocaleString();
                                },
                                color: '#6b7280',
                                font: {
                                    size: 9
                                },
                                padding: 3,
                                maxTicksLimit: 6
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 10
                                },
                                padding: 3
                            }
                        }
                    },
                    layout: {
                        padding: {
                            left: 5,
                            right: 5,
                            top: 5,
                            bottom: 5
                        }
                    }
                }
            });

            // Make charts responsive on window resize
            window.addEventListener('resize', function() {
                // Charts will automatically resize due to maintainAspectRatio: false
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.select2').select2({
                closeOnSelect: false,
            });

            // Add click animation to cards
            $('.dashboard-card').on('click', function() {
                $(this).addClass('active');
                setTimeout(() => {
                    $(this).removeClass('active');
                }, 300);
            });
        });
    </script>
@stop
