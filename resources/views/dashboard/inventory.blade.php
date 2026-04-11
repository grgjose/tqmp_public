<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>TQMP | Consumers</title>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Dashboard</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-chat-text"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img
                                            src="https://th.bing.com/th/id/OIP.aNuVPko-fipxD4-hwuKSTQHaHl?rs=1&pid=ImgDetMain"
                                            class="img-size-50 rounded-circle me-3" />
                                    </div>
                                    <div class="flex-grow-1">
                                        <h3 class="dropdown-item-title">
                                            Geneva Garcia
                                            <span class="float-end fs-7 text-danger"><i class="bi bi-star-fill"></i></span>
                                        </h3>
                                        <p class="fs-7">Call me whenever you can...</p>
                                        <p class="fs-7 text-secondary">
                                            <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-bell-fill"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="bi bi-envelope me-2"></i> 4 new messages
                                <span class="float-end text-secondary fs-7">3 mins</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="{{ asset('storage/user-pics/'.$my_user->user_pic) }}"
                                class="user-image rounded-circle shadow" />
                            <span class="d-none d-md-inline">{{ $my_user->fname.' '.$my_user->lname }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <li class="user-header text-bg-primary">
                                <img
                                    src="{{ asset('storage/user-pics/'.$my_user->user_pic) }}"
                                    class="rounded-circle shadow"
                                    alt="User Image" />
                                <p>
                                    {{ $my_user->fname.' '.$my_user->lname }} - Web Developer
                                    <small>Member since Nov. 2023</small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                <a href="/logout" class="btn btn-default btn-flat float-end">Sign out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <aside class="app-sidebar bg-dark shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="./index.html" class="brand-link">
                    <img src="{{ asset('storage/logos/TQMPLogo.png') }}" alt="TQMP Logo" width="60" class="brand-image opacity-75 shadow">
                    <span class="brand-text fw-light">TQMPAdmin</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <div class="user-panel mt-3 pb-3 d-flex align-items-center">
                        <div class="image">
                            <a href="#"><img src="{{ asset('storage/user-pics/'.$my_user->user_pic) }}" class="rounded-circle shadow" alt="User Image" /></a>
                        </div>
                        <div class="info ms-3">
                            <a href="#" class="d-block" style="text-decoration: none;">{{ $my_user->fname.' '.$my_user->lname }}</a>
                        </div>
                    </div>
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <li class="nav-item menu-open">
                            <ul class="nav nav-treeview">
                                <li class="nav-header">Menu</li>
                                <li class="nav-item">
                                    <a href="/dashboard" class="nav-link">
                                        <p><i class="fa-solid fa-chart-line" style="margin-right: 10px;"></i>Dashboard</p>
                                    </a>
                                </li>
                                <li class="nav-header">Information</li>
                                <li class="nav-item menu-open">
                                    <a href="#" class="nav-link active">
                                        <i class="nav-icon bi bi-speedometer"></i>
                                        <p>
                                            Tables
                                            <i class="nav-arrow bi bi-chevron-right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="/inventory" class="nav-link active">
                                                <p><i class="fa-solid fa-warehouse" style="margin-right: 10px;"></i>Inventory</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/order" class="nav-link">
                                                <p><i class="fa-solid fa-store" style="margin-right: 10px;"></i>Orders</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="/consumer" class="nav-link">
                                                <p><i class="fa-solid fa-users" style="margin-right: 10px;"></i>Consumers</p>
                                            </a>
                                        </li>
                                    </ul>
                                <li class="nav-header">Settings</li>
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <p><i class="fa-solid fa-user-tie" style="margin-right: 10px;"></i>Profile</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <p><i class="fa-solid fa-gear" style="margin-right: 10px;"></i>Settings</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <p><i class="fa-solid fa-arrow-right-from-bracket" style="margin-right: 10px;"></i>Logout</p>
                                    </a>
                                </li>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <main class="app-main px-4">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Inventory</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Inventory</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid" style="border: 1px solid #ddd; padding: 15px; border-radius: 5px; background-color: white;">
                    <div class="row">
                        <div class="col-6">
                        </div>
                        <div class="col-4">
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success" onclick="showForm()">
                                <span class="fas fa-plus"></span> Export CSV
                            </button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success" onclick="showForm()">
                                <span class="fas fa-plus"></span> Add Inventory
                            </button>
                        </div>
                        <table id="example" class="table is-striped" style="width:100%; text-align: left;">
                            <thead>
                                <tr>
                                    <th>Brand</th>
                                    <th>Product Name</th>
                                    <th>Model Number</th>
                                    <th>Details</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Thore</td>
                                    <td>Patch Fittings</td>
                                    <td>GSM-0039</td>
                                    <td>Transom / Top Corner Patch</td>
                                    <td># 60</td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Status
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Available</a></li>
                                                <li><a class="dropdown-item" href="#">Low Stock</a></li>
                                                <li><a class="dropdown-item" href="#">Out of Stock</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <button class="btn btn-success btn-sm">Add</button>
                                            <button class="btn btn-warning btn-sm">Edit</button>
                                            <button class="btn btn-primary btn-sm">Delete</button>
                                            <button class="btn btn-info btn-sm">View</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Thore</td>
                                    <td>Door Closers</td>
                                    <td>GSM-0060</td>
                                    <td>Floor Hinge</td>
                                    <td># 30</td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Status
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Available</a></li>
                                                <li><a class="dropdown-item" href="#">Low Stock</a></li>
                                                <li><a class="dropdown-item" href="#">Out of Stock</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <button class="btn btn-success btn-sm">Add</button>
                                            <button class="btn btn-warning btn-sm">Edit</button>
                                            <button class="btn btn-primary btn-sm">Delete</button>
                                            <button class="btn btn-info btn-sm">View</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Yale</td>
                                    <td>Floor Check</td>
                                    <td>YFS-8003</td>
                                    <td>Yale Floor Spring - Cast Iron Body</td>
                                    <td># 8</td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Status
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Available</a></li>
                                                <li><a class="dropdown-item" href="#">Low Stock</a></li>
                                                <li><a class="dropdown-item" href="#">Out of Stock</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <button class="btn btn-success btn-sm">Add</button>
                                            <button class="btn btn-warning btn-sm">Edit</button>
                                            <button class="btn btn-primary btn-sm">Delete</button>
                                            <button class="btn btn-info btn-sm">View</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Thore</td>
                                    <td>Sliding Door Hanger</td>
                                    <td>GSM-0103</td>
                                    <td>Sliding Door</td>
                                    <td># 10</td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Status
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Available</a></li>
                                                <li><a class="dropdown-item" href="#">Low Stock</a></li>
                                                <li><a class="dropdown-item" href="#">Out of Stock</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <button class="btn btn-success btn-sm">Add</button>
                                            <button class="btn btn-warning btn-sm">Edit</button>
                                            <button class="btn btn-primary btn-sm">Delete</button>
                                            <button class="btn btn-info btn-sm">View</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script
        src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
        integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="{{ asset('storage/dist/js/adminlte.js') }}"></script>
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script>
        new DataTable('#example');
    </script>
</body>
</html>