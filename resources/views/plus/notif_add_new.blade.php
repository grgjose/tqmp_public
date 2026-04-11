 @foreach($notifications_new as $notif)
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
@endforeach
@if(count($notifications_new) == 0)
 <div class="d-flex align-items-center justify-content-between p-3 mb-2 rounded border border-info-subtle">
     <div class="d-flex align-items-center">
         <div class="me-3">
         </div>
         <div>
             <div class="fw-semibold">Empty New Notifications</div>
         </div>
     </div>
 </div>
 @endif