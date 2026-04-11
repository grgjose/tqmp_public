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
        border-style: 1px solid black;
    }
</style>
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Catalogue Details</h3>
    </div>
    <form action="/catalogue-store" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row mb-3">
                <div class="form-group col-12">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-group col-12">
                    <label for="userpic">Catalogue Photo</label>
                    <input type="file" class="form-control" id="upload_file" name="upload_file" accept="image/png, image/jpeg" required>
                </div>
            </div> 
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Save</button>
            <button class="btn btn-secondary" onclick="hideDetails();">Close</button>
        </div>
    </form>
</div>