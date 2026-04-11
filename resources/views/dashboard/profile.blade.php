<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>TQMP | Profile</title>
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

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
                    <li class="nav-item d-none d-md-block"><a href="/dashboard" class="nav-link">Home</a></li>
                    <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <div class="d-flex align-items-center gap-2 position-relative">
                        <div class="dropdown me-2"> <a href="#" class="d-flex align-items-center text-decoration-none position-relative" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false"> <i class="fa-regular fa-bell fs-5 text-dark"></i> <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.50rem;"> 3 </span> </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-4 p-3 mt-2" aria-labelledby="notificationDropdown" style="min-width: 260px;">
                                <li class="fw-bold mb-2 text-danger mt-2">Notifications</li>
                                <li class="dropdown-item py-2">
                                    <div> <a class="fw-medium text-dark text-decoration-none" href="">Your order is "Ready to Deliver"</a><br> <a class="text-muted small text-decoration-none" href="#">10 minutes ago</a> </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="dropdown-item py-2">
                                    <div> <a class="fw-medium text-dark text-decoration-none" href="">Your order is "For Cutting".</a><br> <a class="text-muted small text-decoration-none" href="#">Today 7:12 am</a> </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="dropdown-item py-2">
                                    <div> <a class="fw-medium text-dark text-decoration-none" href="">Your order is "For Laminating".</a><br> <a class="text-muted small text-decoration-none" href="#">Thursday 2:20 pm</a> </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li> <a class="d-block text-center dropdown-item py-2 text-danger text-decoration-none" href="#">View All Notifications</a> </li>
                            </ul>
                        </div>
                        <div class="dropdown"> <a href="#" class="d-flex align-items-center text-decoration-none" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false"> <i class="fa-solid fa-circle-user fs-5 me-2 text-dark"></i>
                                <div class="d-none d-md-block" style="line-height:1.1;">
                                    <div class="fw-semibold text-danger" style="font-size:0.95rem;">{{ $my_user->fname }} {{ $my_user->lname }}</div> @if($my_user->usertype == 1) <small class="text-muted" style="font-size:0.80rem;">Administrator</small> @endif @if($my_user->usertype == 2) <small class="text-muted" style="font-size:0.80rem;">Sales Representative</small> @endif
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-4 p-3 mt-2" aria-labelledby="profileDropdown" style="min-width: 260px;">
                                <li><a class="dropdown-item py-2" href="/home"><i class="fa-solid fa-house me-2"></i>Home Page</a></li>
                                <li><a class="dropdown-item py-2" href="/adminprofile"><i class="fa-solid fa-user me-2"></i> Account</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="/logout" method="POST"> @csrf <button type="submit" class="dropdown-item py-2 text-danger"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout</button> </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </ul>
            </div>
        </nav>
        <aside class="app-sidebar bg-dark shadow" data-bs-theme="dark">
            <div class="sidebar-brand"> <a href="/dashboard" class="brand-link"> <img src="{{ asset('storage/logos/TQMPLogo.png') }}" alt="TQMP Logo" width="60" class="brand-image opacity-75 shadow"> <span class="brand-text fw-light">TQMPAdmin</span> </a> </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <div class="user-panel mt-3 pb-3 d-flex align-items-center">
                        <div class="image"> <a href="#"><img src="{{ asset('storage/user-pics/'.$my_user->user_pic) }}" class="img-circle elevation-2" alt="User Image" style="width: 40px; height: 40px; border-radius: 50%; margin-left: 10px;"></a> </div>
                        <div class="info ms-3"> <a href="#" class="d-block" style="text-decoration: none;">{{ $my_user->fname.' '.$my_user->lname }}</a> </div>
                    </div>
                    <ul class="nav sidebar-menu nav-sidebar flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <li class="nav-sidebar menu-open">
                            <ul class="nav nav-treeview">
                                <li class="nav-header">Menu</li>
                                <li class="nav-item"> 
                                    <a href="/dashboard" class="nav-link">
                                        <p><i class="fa-solid fa-chart-line" style="margin-right: 10px;"></i>Dashboard</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="/notification" class="nav-link">
                                        <p><i class="fa-solid fa-flag" style="margin-right: 10px;"></i>Notifications</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="/inventory" class="nav-link">
                                        <p><i class="fa-solid fa-warehouse" style="margin-right: 10px;"></i>Inventory</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="/order" class="nav-link">
                                        <p><i class="fa-solid fa-store" style="margin-right: 10px;"></i>Orders</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="/quotations" class="nav-link">
                                        <p><i class="fa-solid fa-pen-ruler" style="margin-right: 10px;"></i>Quotations</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="/consumers" class="nav-link">
                                        <p><i class="fa-solid fa-users" style="margin-right: 10px;"></i>Consumers</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="/approvals" class="nav-link">
                                        <p><i class="fa-solid fa-user-check" style="margin-right: 10px;"></i>Approvals</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="/inquiries" class="nav-link">
                                        <p><i class="fa-solid fa-circle-question" style="margin-right: 10px;"></i>Inquiries</p>
                                    </a> </li> @if($my_user->usertype == 1) <li class="nav-header">Settings</li>
                                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-speedometer"></i>
                                    <p> Settings <i class="nav-arrow bi bi-chevron-right"></i> </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item"> <a href="/users" class="nav-link">
                                            <p><i class="fa-solid fa-users" style="margin-right: 10px;"></i>Active Users</p>
                                        </a> </li>
                                        <li class="nav-item"> <a href="/products" class="nav-link">
                                            <p><i class="fa-solid fa-tags" style="margin-right: 10px;"></i>Products</p>
                                        </a> </li>
                                        <li class="nav-item"> <a href="/product-categories" class="nav-link">
                                            <p><i class="fa-solid fa-icons" style="margin-right: 10px;"></i>Product Categories</p>
                                        </a> </li>
                                        <li class="nav-item"> <a href="/product-variants" class="nav-link">
                                            <p><i class="fa-solid fa-palette" style="margin-right: 10px;"></i>Product Variants</p>
                                        </a> </li>
                                        <li class="nav-item"> <a href="/catalogue" class="nav-link">
                                            <p><i class="fa-solid fa-book-open" style="margin-right: 10px;"></i>Catalogue</p>
                                        </a> </li>
                                    </ul>
                                        </li> @endif <li class="nav-item"> <a href="/#" onclick="document.getElementById('logoutForm').submit(); return false;" class="nav-link">
                                                <p><i class="fa-solid fa-arrow-right-from-bracket" style="margin-right: 10px;"></i>Logout</p>
                                    </a> 
                                </li>
                            </ul>
                        </li>
                    </ul>
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
                <section class="">
                    <div class="border-0 shadow-sm p-4">
                        <form id="saveProfileForm" action="/save-profile" method="POST" enctype="multipart/form-data"> @csrf <input type="hidden" name="user_id" value="{{ $my_user->id }}">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="fw-bold mb-0">User Profile</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-4 text-center d-flex flex-column align-items-center"> <img src="{{ asset('storage/user-pics/'.$my_user->user_pic) }}" alt="Profile Picture" class="img-fluid rounded-circle shadow-sm mb-3" style="height: 150px; width: 150px; object-fit: cover;">
                                    <div class="w-75 mt-auto"> <label class="form-label fw-bold">Update Profile Picture</label> <input type="file" name="profile_pic" class="form-control form-control-sm mb-2" accept="image/*"> </div> @if ($errors->any()) <div class="alert alert-danger text-start mt-3 w-75">
                                        <ul class="mb-0"> @foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach </ul>
                                    </div> @endif
                                </div>
                                <div class="col-md-8 d-flex flex-column justify-content-between">
                                    <div class="mb-3"> <label class="form-label fw-bold">Old Password</label> <input type="password" name="old_password" class="form-control form-control-sm mb-2" placeholder="Enter old password"> </div>
                                    <div class="mb-3"> <label class="form-label fw-bold">New Password</label> <input type="password" name="new_password" class="form-control form-control-sm mb-2" placeholder="Enter new password"> </div>
                                    <div class="mb-3 mt-auto"> <label class="form-label fw-bold">Confirm Password</label> <input type="password" name="confirm_password" class="form-control form-control-sm mb-2" placeholder="Confirm new password"> </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <h5 class="fw-bold mb-3">Personal Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6"> <label class="form-label fw-bold">Username</label> <input type="text" name="username" class="form-control form-control-sm mb-2" value="{{ $my_user->username }}"> </div>
                                <div class="col-md-6"> <label class="form-label fw-bold">First Name</label> <input type="text" name="fname" class="form-control form-control-sm mb-2" value="{{ $my_user->fname }}"> </div>
                                <div class="col-md-6"> <label class="form-label fw-bold">Middle Name</label> <input type="text" name="mname" class="form-control form-control-sm mb-2" value="{{ $my_user->mname }}"> </div>
                                <div class="col-md-6"> <label class="form-label fw-bold">Last Name</label> <input type="text" name="lname" class="form-control form-control-sm mb-2" value="{{ $my_user->lname }}"> </div>
                                <div class="col-md-6"> <label class="form-label fw-bold">Extension</label> <input type="text" name="ext" class="form-control form-control-sm mb-2" value="{{ $my_user->ext }}" placeholder="Jr., Sr., III."> </div>
                                <div class="col-md-6"> <label class="form-label fw-bold">Email <span class="text-danger">*</span></label> <input type="email" name="email" class="form-control form-control-sm mb-2" value="{{ $my_user->email }}"> </div>
                                <div class="col-md-6"> <label class="form-label fw-bold">Birthdate</label> <input type="date" name="birthdate" class="form-control form-control-sm mb-2" value="{{ \Carbon\Carbon::parse($my_user->birthdate)->format('Y-m-d') }}"> </div>
                                <div class="col-md-6"> <label class="form-label fw-bold">Contact Number</label> <input type="text" name="contact_number" class="form-control form-control-sm mb-2" value="{{ $my_user->contact_num }}"> </div>
                                <div class="col-md-12"> <label class="form-label fw-bold">Full Address</label> <textarea name="address" class="form-control form-control-sm mb-2" rows="2">{{ $my_user->address }}</textarea> </div>
                            </div> <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                        </form>
                    </div>
                </section>
            </section>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script>
        function showInputBox(action) {
            const inputBoxContainer = document.getElementById('inputBoxContainer');
            const inputBoxLabel = document.getElementById('inputBoxLabel');
            inputBoxContainer.style.display = 'block';
            if (action === 'approve') {
                inputBoxLabel.innerHTML = 'Reason for Approval: <span style="color: red;">*</span>';
            } else if (action === 'reject') {
                inputBoxLabel.innerHTML = 'Reason for Rejection: <span style="color: red;">*</span>';
            }
            document.getElementById('actions').scrollIntoView({
                behavior: 'smooth'
            });
        }

        function saveInput() {
            const inputBox = document.getElementById('inputBox');
            const inputValue = inputBox.value.trim();
            if (inputValue) {
                alert('Input saved: ' + inputValue);
                inputBox.value = '';
                document.getElementById('inputBoxContainer').style.display = 'none';
            } else {
                alert('Please provide a reason before saving.');
            }
        }
    </script>
    <script>
        document.getElementById('imageInput')?.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.getElementById('previewImage');
                    const modalPreviewImage = document.getElementById('modalPreviewImage');
                    previewImage.src = e.target.result;
                    modalPreviewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalImage = document.getElementById('modalPreviewImage');
            const zoomInBtn = document.querySelector('.zoom-in-btn');
            const zoomOutBtn = document.querySelector('.zoom-out-btn');
            const zoomResetBtn = document.querySelector('.zoom-reset-btn');
            let currentScale = 1;
            const zoomLevels = [1, 1.5, 2, 2.5, 3];
            let currentZoomIndex = 0;
            modalImage.style.transformOrigin = 'center center';
            modalImage.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width;
                const y = (e.clientY - rect.top) / rect.height;
                this.style.transformOrigin = `${x * 100}% ${y * 100}%`;
                currentZoomIndex = (currentZoomIndex + 1) % zoomLevels.length;
                currentScale = zoomLevels[currentZoomIndex];
                applyZoom();
            });
            zoomInBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (currentZoomIndex < zoomLevels.length - 1) {
                    currentZoomIndex++;
                    currentScale = zoomLevels[currentZoomIndex];
                    applyZoom();
                }
            });
            zoomOutBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (currentZoomIndex > 0) {
                    currentZoomIndex--;
                    currentScale = zoomLevels[currentZoomIndex];
                    applyZoom();
                }
            });
            zoomResetBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                currentZoomIndex = 0;
                currentScale = 1;
                modalImage.style.transformOrigin = 'center center';
                applyZoom();
            });

            function applyZoom() {
                modalImage.style.transform = `scale(${currentScale})`;
                modalImage.style.cursor = currentScale > 1 ? 'zoom-out' : 'zoom-in';
            }
            let isDragging = false;
            let startX, startY, translateX = 0,
                translateY = 0;
            modalImage.addEventListener('mousedown', function(e) {
                if (currentScale > 1) {
                    isDragging = true;
                    startX = e.clientX - translateX;
                    startY = e.clientY - translateY;
                    this.style.cursor = 'grabbing';
                    e.preventDefault();
                }
            });
            document.addEventListener('mousemove', function(e) {
                if (!isDragging) return;
                translateX = e.clientX - startX;
                translateY = e.clientY - startY;
                modalImage.style.transform = `scale(${currentScale}) translate(${translateX}px, ${translateY}px)`;
            });
            document.addEventListener('mouseup', function() {
                isDragging = false;
                if (currentScale > 1) {
                    modalImage.style.cursor = 'zoom-out';
                }
            });
            $('#imageModal').on('hidden.bs.modal', function() {
                currentZoomIndex = 0;
                currentScale = 1;
                translateX = 0;
                translateY = 0;
                modalImage.style.transform = 'scale(1)';
                modalImage.style.transformOrigin = 'center center';
                modalImage.style.cursor = 'zoom-in';
            });
        });
    </script>
    <script>
        function uploadAndPreviewImage(file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#summernote').summernote('insertImage', e.target.result, file.name);
            };
            reader.readAsDataURL(file);
        }
    </script>
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.querySelector('.card-body'), {
            target: '#scrollspy-nav'
        });
        document.querySelectorAll('#notes-admin .nav-link').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#scrollspy'
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ=" crossorigin="anonymous"></script>
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
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Add a message...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview', 'help']]
                ],
                callbacks: {
                    onInit: function() {
                        const toolbar = $('.note-toolbar');
                        const switchHtml = `                        <div class="private-note-switch d-flex align-items-center me-2 mt-2 mb-2">                            <div class="form-check form-switch">                                <input class="form-check-input" type="checkbox" id="privateNote">                                <label class="form-check-label ms-2" for="privateNote">Private Note</label>                            </div>                        </div>                    `;
                        toolbar.append(switchHtml);
                        updateNoteBorder();
                        $('#privateNote').change(function() {
                            updateNoteBorder();
                        });

                        function updateNoteBorder() {
                            const editor = $('#summernote');
                            if ($('#privateNote').is(':checked')) {
                                editor.next('.note-editor').css('border-left', '4px solid #dc3545');
                            } else {
                                editor.next('.note-editor').css('border-right', '4px solid #0d6efd');
                            }
                        }
                    }
                }
            });
        });
    </script>
    <script>
        new DataTable('#example');
        new DataTable('#tbl_approvals');
        new DataTable('#tbl_variants');
        new DataTable('#tbl_keys');
        new DataTable('#tbl_values');
        new DataTable('#tbl_mappings');
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script> @if(session()->has('quotation_id')) <script>
        quotationShow({
            {
                session('quotation_id')
            }
        });
    </script> @endif @if(session()->has('error_msg')) <script>
        toastr.options.preventDuplicates = true;
        toastr.error("{{ session('error_msg') }}");
    </script> @endif @if(session()->has('success_msg')) <script>
        toastr.options.preventDuplicates = true;
        toastr.success("{{ session('success_msg') }}");
    </script> @endif
</body>

</html>