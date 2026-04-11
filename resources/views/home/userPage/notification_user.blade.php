<!DOCTYPE html>
<html lang="en">
<head>
    @include ('plus.head')
</head>
<body>
    @include('plus.navbar')
    <section class="content">
        <div class="container mt-4 py-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="mb-1">Notifications</h5>
                    <small class="text-muted">You’ve 3 unread notifications</small>
                </div>
                <a class="text-danger">Mark all as read</a>
            </div>
            <ul class="nav nav-tabs border-0 mb-3" id="categoriesTab">
                <li class="nav-item">
                    <a class="nav-link active" href="#all" data-bs-toggle="tab">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" href="#new" data-bs-toggle="tab">New</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-muted" href="#read" data-bs-toggle="tab">Unread</a>
                </li>
            </ul>
            <div class="tab-content fade-in-up" id="categoriesTab">
                <div class="tab-pane fade-in-up show active" id="all">
                    @include('plus.notif_add_all')
                </div>
                <div class="tab-pane fade-in-up" id="new">
                    @include('plus.notif_add_new')
                </div>
                <div class="tab-pane fade-in-up" id="read">
                    @include('plus.notif_add_unread')
                </div>
            </div>
        </div>
    </section>
    @include ('plus.footer')
    @include ('plus.scripts')
</body>
</html>