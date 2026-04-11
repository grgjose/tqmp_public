<div class="row g-4 mt-3">

    @foreach($settings as $setting)

        @if(str_starts_with($setting->key, 'GLASS_MFG_'))

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
                                    style="height: 120px; background: url('storage/glass-mfg/{{ $setting->value }}') no-repeat center center; background-size: contain;">
                                    
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