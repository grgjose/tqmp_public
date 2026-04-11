<div class="dropdown" id="notifications">
    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle no-caret" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-regular fa-bell fs-4 text-dark"></i>
        @if($count_notifications > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.50rem;">
            {{ $count_notifications; }}
        </span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-4 p-3"
        aria-labelledby="notificationDropdown"
        style="min-width: 300px; max-width: 90vw;"
        id="notificationsList">
        <li class="fw-bold mb-2 text-danger mt-2">Notifications</li>
        @foreach($notifications as $notif)
        <li class="dropdown-item py-2">
            <a class="fw-medium text-dark wrap" style="width: 300px;" href="{{ $notif->link }}">
                {{ $notif->message }}
            </a>
            <small class="text-muted small ms-2">{{ $notif->created_at }}</small>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        @endforeach
        <li>
            <a class="d-block text-center dropdown-item py-2 text-danger" href="/notification_user">View All Notifications</a>
        </li>
    </ul>
</div>