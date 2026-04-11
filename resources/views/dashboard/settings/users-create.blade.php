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
    <form action="/users-store" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <p style="color: red;">Note: Random Password will be sent to the Email of the User</p>
            <div class="row mb-3">
                <div class="form-group col-2">
                    <label for="userpic">Profile Picture</label>
                    <input type="file" class="form-control" id="userpic" name="upload_file" accept="image/png, image/jpeg">
                </div>
                <div class="form-group col-3">
                    <label for="fname">First Name</label>
                    <input type="text" class="form-control" id="fname" name="fname" required>
                </div>
                <div class="form-group col-3">
                    <label for="mname">Middle Name</label>
                    <input type="text" class="form-control" id="mname" name="mname">
                </div>
                <div class="form-group col-3">
                    <label for="lname">Last Name</label>
                    <input type="text" class="form-control" id="lname" name="lname" required>
                </div>
                <div class="form-group col-1">
                    <label for="ext">Ext</label>
                    <input type="text" class="form-control" id="ext" name="ext">
                </div>
            </div> 
            <div class="row mb-3">
                <div class="form-group col-3">
                    <label for="usertype">Usertype</label>
                    <select class="form-control" name="usertype">
                        @foreach($usertypes as $usertype)
                            <option value="{{ $usertype->id }}">{{ $usertype->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-3">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group col-3">
                    <label for="contact_num">Contact Number</label>
                    <input type="text" class="form-control" id="contact_num" name="contact_num" required>
                </div>
                <div class="form-group col-3">
                    <label for="birthdate">Birth Date</label>
                    <input type="date" class="form-control" id="date" name="birthdate">
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-group col-12">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
            </div> 
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