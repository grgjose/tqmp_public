<style>
    .img-circle{
        border-radius: 50%;
    }
    .profile-user-img{
        border: 3px solid #adb5bd;
        margin: 0 auto;
        padding: 3px;
        width: 100px;
    }
    .img-fluid{
        max-width: 100%;
        height: auto;
    }
    img{
        vertical-align: middle;
        border-style: none;
    }
</style>
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">User Details</h3>
    </div>
    <div class="card-body">
        <div class="form-group col-2">
            <label for="user_pic">Profile Picture</label>
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/user-pics/'.$user->user_pic) }}" alt="User profile picture">
                <br> <a href="#" onclick="clickInputFile()">[Change Profile Picture]</a>
                <form id="uploadForm" action="/users-changepic/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input id="userChangeProfilePic" name="upload_file" type="file" class="form-control" style="display: none;" accept="image/png, image/jpeg">
                </form>
            </div>
        </div>
        <form action="/users-update/{{ $user->id }}" method="POST">
            @csrf
            @method('PUT')
        <div class="row mb-3">
            <div class="form-group col-3">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" value="{{ $user->fname }}" required>
            </div>
            <div class="form-group col-3">
                <label for="mname">Middle Name</label>
                <input type="text" class="form-control" id="mname" name="mname" value="{{ $user->mname }}" >
            </div>
            <div class="form-group col-3">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" value="{{ $user->lname }}" required>
            </div>
            <div class="form-group col-1">
                <label for="ext">Ext</label>
                <input type="text" class="form-control" id="ext" name="ext" value="{{ $user->ext }}" >
            </div>
        </div> 
        <div class="row mb-3">
            <div class="form-group col-4">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group col-4">
                <label for="contact_num">Contact Number</label>
                <input type="text" class="form-control" id="contact_num" name="contact_num" value="{{ $user->contact_num }}" required>
            </div>
            <div class="form-group col-4">
                <label for="birthdate">Birth Date</label>
                <input type="date" class="form-control" id="date" name="birthdate" value="{{ $user->birthdate }}" >
            </div>
        </div>
        <div class="row mb-3">
            <div class="form-group col-12">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" required>
            </div>
        </div> 
        @if($user->usertype == 3)
        <div class="row">
            <div class="form-group col-12">
                <label for="upload_file">Submitted File Preview</label>
                <iframe src="{{ asset('storage/uploads/'.$user->upload_file) }}" style="width: 100%; height: 500px;">
                </iframe>
            </div>
        </div>
        @endif
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" type="submit">Save</button>
        <button class="btn btn-secondary" onclick="hideDetails();">Close</button>
    </div>
    </form>
</div>
<script>
    function clickInputFile(){
        $('#userChangeProfilePic').click();
    }
    $(document).ready(function() {
        $('#userChangeProfilePic').on('change', function() {
            if (this.files.length > 0) {
                $('#uploadForm').submit();
            }
        });
    });
</script>