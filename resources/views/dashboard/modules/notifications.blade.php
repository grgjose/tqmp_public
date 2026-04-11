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
                    @foreach($notifications as $notif)
                        @if($notif->isRead == false)
                        <div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded bg-success-subtle border border-success-subtle">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fa-solid fa-flag fa-xl text-success"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $notif->message }}</div>
                                    <a href="{{ $notif->link }}" class="text-muted">Please check your status here</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success mb-1 ">New</span>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded border border-success-subtle">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fa-solid fa-flag fa-xl text-success"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $notif->message }}</div>
                                    <a href="{{ $notif->link }}" class="text-muted">Please check your status here</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <small class="text-muted">{{ $notif->created_at }}</small><br>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    @if(count($notifications) == 0)
                    <div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded border border-info-subtle">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                            </div>
                            <div>
                                <div class="fw-semibold">Empty Notifications</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="tab-pane fade-in-up" id="new">
                    @foreach($notifications as $notif)
                        @if($notif->isRead == false)
                        <div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded bg-success-subtle border border-success-subtle">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fa-solid fa-flag fa-xl text-success"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $notif->message }}</div>
                                    <a href="{{ $notif->link }}" class="text-muted">Please check your status here</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success mb-1 ">New</span>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded border border-success-subtle">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fa-solid fa-flag fa-xl text-success"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $notif->message }}</div>
                                    <a href="{{ $notif->link }}" class="text-muted">Please check your status here</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <small class="text-muted">{{ $notif->created_at }}</small><br>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    @if(count($notifications) == 0)
                    <div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded border border-info-subtle">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                            </div>
                            <div>
                                <div class="fw-semibold">Empty Notifications</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="tab-pane fade-in-up" id="read">
                    @foreach($notifications as $notif)
                        @if($notif->isRead == false)
                        <div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded bg-success-subtle border border-success-subtle">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fa-solid fa-flag fa-xl text-success"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $notif->message }}</div>
                                    <a href="{{ $notif->link }}" class="text-muted">Please check your status here</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success mb-1 ">New</span>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </div>
                        </div>
                        @else
                        <div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded border border-success-subtle">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fa-solid fa-flag fa-xl text-success"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $notif->message }}</div>
                                    <a href="{{ $notif->link }}" class="text-muted">Please check your status here</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <small class="text-muted">{{ $notif->created_at }}</small><br>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    @if(count($notifications) == 0)
                    <div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded border border-info-subtle">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                            </div>
                            <div>
                                <div class="fw-semibold">Empty Notifications</div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>