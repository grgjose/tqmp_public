<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>TQMP | Notification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Total Quality Management Products Philippines" />
    <meta name="author" content="TQMP" />
    <meta name="description" content="Your Partner in Progress: The Marketing Arm of Philippines Glass and Aluminum Conglomerate" />
    <meta name="keywords" content="TQMP, Total Quality Management Products Philippines, aluminum, aluminum manufacturing, bullet proofing, architectural hardware, glass, glass manufacturing, glass processing, TQMP Services" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('storage/dist/css/adminlte.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
</head>

<div class="app-wrapper">
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block"><a href="/dashboard" class="nav-link">Home</a></li>
                <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <div class="d-flex align-items-center gap-2 position-relative">
                    <div class="dropdown me-2">
                        <a href="#" class="d-flex align-items-center text-decoration-none position-relative" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-bell fs-5 text-dark"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.50rem;">
                                3
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-4 p-3 mt-2" aria-labelledby="notificationDropdown" style="min-width: 260px;">
                            <li class="fw-bold mb-2 text-danger mt-2">Notifications</li>
                            <li class="dropdown-item py-2">
                                <div>
                                    <a class="fw-medium text-dark text-decoration-none" href="">Your order is "Ready to Deliver"</a><br>
                                    <a class="text-muted small text-decoration-none" href="#">10 minutes ago</a>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="dropdown-item py-2">
                                <div>
                                    <a class="fw-medium text-dark text-decoration-none" href="">Your order is "For Cutting".</a><br>
                                    <a class="text-muted small text-decoration-none" href="#">Today 7:12 am</a>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="dropdown-item py-2">
                                <div>
                                    <a class="fw-medium text-dark text-decoration-none" href="">Your order is "For Laminating".</a><br>
                                    <a class="text-muted small text-decoration-none" href="#">Thursday 2:20 pm</a>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="d-block text-center dropdown-item py-2 text-danger text-decoration-none" href="#">View All Notifications</a>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-circle-user fs-5 me-2 text-dark"></i>
                            <div class="d-none d-md-block" style="line-height:1.1;">
                                <div class="fw-semibold text-danger" style="font-size:0.95rem;">{{ $my_user->fname }} {{ $my_user->lname }}</div>
                                @if($my_user->usertype == 1)
                                <small class="text-muted" style="font-size:0.80rem;">Administrator</small>
                                @endif
                                @if($my_user->usertype == 2)
                                <small class="text-muted" style="font-size:0.80rem;">Sales Representative</small>
                                @endif
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-4 p-3 mt-2" aria-labelledby="profileDropdown" style="min-width: 260px;">
                            <li><a class="dropdown-item py-2" href="/home"><i class="fa-solid fa-house me-2"></i>Home Page</a></li>
                            <li><a class="dropdown-item py-2" href="/profile"><i class="fa-solid fa-user me-2"></i> Account</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </ul>
        </div>
    </nav>
    <aside class="app-sidebar bg-dark shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
            <a href="/dashboard" class="brand-link">
                <img src="{{ asset('storage/logos/TQMPLogo.png') }}" alt="TQMP Logo" width="60" class="brand-image opacity-75 shadow">
                <span class="brand-text fw-light">TQMPAdmin</span>
            </a>
        </div>
        <div class="sidebar-wrapper">
            <nav class="mt-2 d-flex flex-column justify-content-between" style="height: 100%;">
                <ul class="nav sidebar-menu nav-sidebar flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                    <li class="nav-sidebar menu-open">
                        <ul class="nav nav-treeview">
                            <li class="nav-header">Menu</li>
                            <li class="nav-item">
                                <a href="/dashboard" class="nav-link">
                                    <p><i class="fa-solid fa-chart-line me-2"></i>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/notification_admin" class="nav-link">
                                    <p><i class="fa-solid fa-flag me-2"></i>Notifications</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/inventory" class="nav-link">
                                    <p><i class="fa-solid fa-warehouse me-2"></i>Inventory</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/order" class="nav-link">
                                    <p><i class="fa-solid fa-store me-2"></i>Orders</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/quotations" class="nav-link">
                                    <p><i class="fa-solid fa-pen-ruler me-2"></i>Quotations</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/consumers" class="nav-link">
                                    <p><i class="fa-solid fa-users me-2"></i>Consumers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/approvals" class="nav-link">
                                    <p><i class="fa-solid fa-user-check me-2"></i>Approvals</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/inquiries" class="nav-link">
                                    <p><i class="fa-solid fa-circle-question me-2"></i>Inquiries</p>
                                </a>
                            </li>

                            @if($my_user->usertype == 1)
                            <li class="nav-header">Settings</li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon bi bi-speedometer"></i>
                                    <p>
                                        Settings
                                        <i class="nav-arrow bi bi-chevron-right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/users" class="nav-link">
                                            <p><i class="fa-solid fa-users me-2"></i>Active Users</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/products" class="nav-link">
                                            <p><i class="fa-solid fa-tags me-2"></i>Products</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/product-categories" class="nav-link">
                                            <p><i class="fa-solid fa-icons me-2"></i>Product Categories</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/catalogue" class="nav-link">
                                            <p><i class="fa-solid fa-book-open me-2"></i>Catalogue</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif

                            <li class="nav-item">
                                <a href="/#" onclick="document.getElementById('logoutForm').submit(); return false;" class="nav-link">
                                    <p><i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Logout</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- User Panel fixed at bottom -->
                <div class="user-panel mt-3 pb-3 d-flex align-items-center border-top pt-3">
                    <div class="image">
                        <a href="#">
                            <img src="{{ asset('storage/user-pics/'.$my_user->user_pic) }}"
                                class="img-circle elevation-2"
                                alt="User Image"
                                style="width: 40px; height: 40px; border-radius: 50%; margin-left: 10px;">
                        </a>
                    </div>
                    <div class="info ms-3">
                        <a href="#" class="d-block text-decoration-none">{{ $my_user->fname.' '.$my_user->lname }}</a>
                    </div>
                </div>
            </nav>
        </div>
    </aside>
    <form style="display:none;" id="logoutForm" action="/logout" method="POST">@csrf</form>
    <main class="app-main px-4">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="app-content">
            <div class="card tbl">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Audit Trail</h4>
                </div>
                <div class="card-body">
                    <table id="" class="table is-striped" style="width:100%; text-align: left;">
                        <thead>
                            <tr>
                                <th style="width: 20%">Date</th>
                                <th style="width: 40%">Description</th>
                                <th style="width: 15%">Actions</th>
                                <th style="width: 10%">User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2024-06-01 10:15:30</td>
                                <td>Updated product stock for "Aluminum Sheet A123"</td>
                                <td>Update Stock</td>
                                <td>John Doe</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

        </section>
    </main>
</div>

</html>