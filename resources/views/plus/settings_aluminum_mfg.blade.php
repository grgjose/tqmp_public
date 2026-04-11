<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0"></h4>

    <button class="btn btn-danger" id="add-aluminum-btn" data-bs-toggle="modal" data-bs-target="#addAluminumModal">
        <i class="fas fa-plus"></i> Add New Profile
    </button>
</div>  

<div class="row g-4 mt-3">

    @foreach($settings as $setting)

        @if(str_starts_with($setting->key, 'ALUMINUM_MFG_'))

            @if($setting->type == 'Text')

            <!-- For Texts -->
            <div class="col-md-4">
                <div class="card card-danger card-outline mb-4">
                    <div class="card-header">
                        <div class="card-title fw-bold">Replace {{ $setting->description }}</div>
                    </div>

                    <form method="POST" action="/admin-control/update/{{ $setting->id }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="setting_textarea" class="form-label">Text: </label>
                                <textarea class="form-control" name="value" id="setting_textarea" style="resize: none;" rows="6">{{ $setting->value }}</textarea>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            @elseif($setting->type == 'Image')

            <!-- For Images -->
            <div class="col-md-4">
                <div class="card card-danger card-outline mb-4">
                    <div class="card-header">
                        <div class="card-title fw-bold">Replace {{ $setting->description }}</div>
                    </div>

                    <form method="POST" action="/admin-control/update/{{ $setting->id }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="bg-light rounded w-100 mb-3 d-flex align-items-center justify-content-center"
                                    style="height: 120px; background: url('storage/aluminum/{{ $setting->value }}') no-repeat center center; background-size: contain;">
                                    
                                </div>
                                <input type="file" name="file" class="form-control" id="bannerImage" accept="image/*" />
                            </div>
                            <div class="form-text text-muted">
                                Ideal for promotional or landing page banners.
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            @endif

        @endif

    @endforeach

</div>

<!-- Add New Aluminum Profile Modal -->
<div class="modal fade" id="addAluminumModal" tabindex="-1" aria-labelledby="addAluminumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">                
                <h5 class="modal-title" id="addAluminumModalLabel">Add New Aluminum Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="/admin-control/store" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="profile_title" class="form-label">Profile Title</label>
                        <input type="text" class="form-control" id="profile_title" name="profile_title" required>
                    </div>
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>