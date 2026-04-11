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
                <table id="tbl_auditTrail" class="table is-striped" style="width:100%; text-align: left;">
                    <thead>
                        <tr>
                            <th style="width: 10%">Date</th>
                            <th style="width: 20%">Actions</th>
                            <th style="width: 60%">Details</th>
                            <th style="width: 10%">User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->created_at }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->details }}</td>
                            <td>{{ $log->username }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

    </section>
</main>