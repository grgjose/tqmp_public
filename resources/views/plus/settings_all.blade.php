<div class="row g-4 mt-3">

    @foreach($settings as $setting)

            @php
                // Determine the storage path based on the setting key
                if(str_starts_with($setting->key, 'HOME_')){ $storagePath = 'home'; } 
                if(str_starts_with($setting->key, 'BULLET_')){ $storagePath = 'bulletproofing'; } 
                if(str_starts_with($setting->key, 'GLASS_MFG_')){ $storagePath = 'glass-mfg'; } 
                if(str_starts_with($setting->key, 'ALUMINUM_MFG_')){ $storagePath = 'aluminum'; } 
                if(str_starts_with($setting->key, 'GLASS_PRO_')){ $storagePath = 'glass-processing'; } 
                if(str_starts_with($setting->key, 'ABOUT_US_')){ $storagePath = 'about-us'; }
                if(str_starts_with($setting->key, 'NAVBAR_')){ $storagePath = 'logos'; } 
                if(str_starts_with($setting->key, 'WELCOME_')){ $storagePath = 'logos'; } 
            @endphp

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
                                    style="height: 120px; background: url('storage/{{ $storagePath }}/{{ $setting->value }}') no-repeat center center; background-size: contain;">
                                    
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

            @elseif($setting->type == 'Video')

           <!-- For Videos -->
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
                                    style="height: 120px; background: no-repeat center center; background-size: contain;">
                                    <video width="100%" height="100%" controls>
                                        <source src="storage/{{ $storagePath }}/{{ $setting->value }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                </div>
                                {{-- //accepts videos only --}}
                                <input type="file" name="file" class="form-control" id="bannerVideo" accept="video/*" />
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

    @endforeach

    <script>
        document.getElementById('bannerVideo').addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.size > 15 * 1024 * 1024) { // 20 MB limit
                alert('File is too large! Please upload a video smaller than 20 MB.');
                this.value = ''; // clear the file input
            }
        });
    </script>
</div>