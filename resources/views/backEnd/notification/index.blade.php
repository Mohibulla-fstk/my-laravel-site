@extends('backEnd.layouts.master')
@section('title','All Notifications')

@section('css')
<link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container-fluid">
  
    <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">All Notifications</h4>
            </div>
        </div>

    <div class="card-s">
        <div class="" id="all-notifications">
            <p class="text-muted">Loading...</p>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
function iconByType(type){
    switch(type){
        case 'order': return `<span class="avatar-sm bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fe-shopping-cart"></i>
                              </span>`;
        case 'user': return `<span class="avatar-sm bg-soft-info text-info rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fe-user"></i>
                              </span>`;
        case 'collection': return `<span class="avatar-sm bg-soft-success text-success rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fe-layers"></i>
                              </span>`;
        case 'product': return `<span class="avatar-sm bg-soft-purple text-purple rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fe-box"></i>
                              </span>`;
        case 'coupon': return `<span class="avatar-sm bg-soft-danger text-danger rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fe-tag"></i>
                              </span>`;
        case 'activity': return `<span class="avatar-sm bg-soft-warning text-warning rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fe-activity"></i>
                              </span>`;
        case 'announcement': return `<span class="avatar-sm bg-soft-orange text-orange rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fa-light fa-bullhorn"></i>
                              </span>`;
        case 'setting': return `<span class="avatar-sm bg-soft-dark text-dark rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fe-settings"></i>
                              </span>`;
        case 'banner': return `<span class="avatar-sm bg-soft-pink text-pink rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fe-image"></i>
                              </span>`;
        case 'category':return `<span class="avatar-sm bg-soft-green text-green rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fe-grid"></i>
                                </span>`;
        case 'review':return `<span class="avatar-sm bg-soft-warning text-warning rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fe-star"></i>
                                </span>`;

        default: return `<span class="avatar-sm bg-soft-secondary text-secondary rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fe-bell"></i>
                         </span>`;
    }
}

function loadAllNotifications(page = 1){
    fetch(`{{ route('notifications.all.fetch') }}?page=${page}`)
        .then(res => res.json())
        .then(res => {

            let html = '';

            if(!res.data || res.data.length === 0){
                html = '<p class="text-muted mb-0">No notifications found</p>';
            } else {
                res.data.forEach(n => {
                html += `
                <a href="${n.url ?? '#'}" 
                class="d-flex justify-content-between align-items-start border-bottom py-2 notification-item ${n.is_read ? 'read' : ''}" 
                data-id="${n.id}" style="margin-top:5px;border:1px solid #e2e2e2; border-radius:5px; text-decoration:none">
                    <div class="d-flex gap-3" style="padding:0px 20px">
                        ${iconByType(n.type)}
                        <div>
                            <strong class="text-dark">${n.title}</strong>
                            <p class="mb-1 text-gray-500">${n.message}</p>
                          <small class="text-gray-500">${new Date(n.created_at).toLocaleString('en-GB',{day:'2-digit',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit',second:'2-digit',hour12:true}).replace(/(\d{2}\s\w{3}),/, '$1')}</small>

                        </div>
                    </div>
                 <!--<button class="btn btn-sm btn-outline-danger delete-notify">
                        <i class="fe-trash"></i>
                    </button> -->
                </a>`;
            });

            }

            document.getElementById('all-notifications').innerHTML = html;
        })
        .catch(() => {
            document.getElementById('all-notifications').innerHTML =
                '<p class="text-danger">Failed to load notifications</p>';
        });
}

/* ===== Click read / delete ===== */
document.addEventListener('click', function(e){
    let item = e.target.closest('.notification-item');
    if(!item) return;

    let id = item.dataset.id;

    // delete button
    if(e.target.closest('.delete-notify')){
        fetch(`/notifications/delete/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }).then(() => {
            // remove from DOM
            item.remove();

            // update badge
            let badge = document.getElementById('notify-count');
            let count = parseInt(badge.innerText) || 0;
            if(count > 0) badge.innerText = count - 1;
        });
        return; // stop further execution
    }

    // mark as read
    fetch('{{ url("/notifications/read") }}/' + id, { 
        method: 'POST', 
        headers: { 
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        } 
    })
    .then(res => res.json())
    .then(d => {
        if(d.success){
            item.classList.add('read', 'opacity-75');

            // badge decrease
            let badge = document.getElementById('notify-count');
            let count = parseInt(badge.innerText) || 0;
            if(count > 0){
                badge.innerText = count - 1;
            }
        }
    });
});
document.querySelectorAll('.delete-notify').forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault();
        let id = this.dataset.id; // assuming button has data-id
        fetch(`/notifications/delete/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }).then(res => res.json())
          .then(data => {
              if(data.success){
                  // remove notification from DOM
                  this.closest('.notification-item').remove();
                  // update badge count if needed
              }
          });
    });
});

setInterval(loadAllNotifications, 2000);
// initial load
loadAllNotifications();
</script>

@endsection
