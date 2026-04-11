<div class="card card-danger">
    <div class="card-header">
        <h3 class="card-title">User Details</h3>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="form-group col-3">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" id="fname" value="{{ $user->fname }}" readonly>
            </div>
            <div class="form-group col-3">
                <label for="mname">Middle Name</label>
                <input type="text" class="form-control" id="mname" value="{{ $user->mname }}" readonly>
            </div>
            <div class="form-group col-3">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname" value="{{ $user->lname }}" readonly>
            </div>
            <div class="form-group col-3">
                <label for="ext">Ext</label>
                <input type="text" class="form-control" id="ext" value="{{ $user->ext }}" readonly>
            </div>
        </div> 
        <div class="row mb-3">
            <div class="form-group col-4">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
            </div>
            <div class="form-group col-4">
                <label for="contact_num">Contact Number</label>
                <input type="text" class="form-control" id="contact_num" value="{{ $user->contact_num }}" readonly>
            </div>
            <div class="form-group col-4">
                <label for="birthdate">Birth Date</label>
                <input type="date" class="form-control" id="date" value="{{ $user->birthdate }}" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <div class="form-group col-12">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" value="{{ $user->address }}" readonly>
            </div>
        </div> 
        <div class="row">
            <div class="form-group col-12">
                <label for="upload_file">Submitted File Preview</label>
                <iframe src="{{ asset('storage/uploads/'.$user->upload_file) }}" style="width: 100%; height: 500px;">
                </iframe>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" onclick="hideDetails();">Close</button>
    </div>
</div>
