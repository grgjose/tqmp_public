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
        <div class=" mt-4">
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
                <li class="nav-item ms-auto">
                    <button class="btn btn-primary btn-sm">Mark all as read</button>
                </li>
            </ul>
            <div class="tab-content fade-in-up" id="categoriesTab">
                <div class="tab-pane fade-in-up show active" id="all">

                </div>
                <div class="tab-pane fade-in-up" id="new">

                </div>
                <div class="tab-pane fade-in-up" id="read">

                </div>
            </div>
        </div>
    </section>
</main>