<!DOCTYPE html>
<html lang="en">
<head>
    @include ('plus.head')
</head>
<body>
    @include('plus.navbar')
    <section class="container py-5">
        <div class="border-0 shadow-sm p-4">
            <form id="saveProfileForm" action="/save-profile" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $my_user->id }}">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">User Profile</h4>
                </div>
                <div class="row">
                    <div class="col-md-4 text-center mb-4">
                        <img src="{{ asset('storage/user-pics/'.$my_user->user_pic) }}"
                            alt="Profile Picture"
                            class="img-fluid rounded-circle shadow-sm mb-3"
                            style="max-height: 180px; width: 180px; object-fit: cover;">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Update Profile Picture</label>
                            <input type="file" name="profile_pic" class="form-control form-control-sm" accept="image/*">
                        </div>
                        @if ($errors->any())
                        <div class="alert alert-danger text-start">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Old Password</label>
                            <input type="password" id="old_password" name="old_password" class="form-control" placeholder="Enter old password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">New Password</label>
                            <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter new password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm new password">
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <h5 class="fw-bold mb-3">Personal Information</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" id="username" name="username" class="form-control" value="{{ $my_user->username }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">First Name</label>
                        <input type="text" id="fname" name="fname" class="form-control" value="{{ $my_user->fname }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Middle Name</label>
                        <input type="text" id="mname" name="mname" class="form-control" value="{{ $my_user->mname }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Last Name</label>
                        <input type="text" id="lname" name="lname" class="form-control" value="{{ $my_user->lname }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Extension</label>
                        <input type="text" id="ext" name="ext" class="form-control" value="{{ $my_user->ext }}" placeholder="Jr., Sr., III.">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ $my_user->email }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Birthdate</label>
                        <input type="date" id="birthdate" name="birthdate" class="form-control" value="{{ \Carbon\Carbon::parse($my_user->birthdate)->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Contact Number</label>
                        <input type="text" id="contact_number" name="contact_number" class="form-control" value="{{ $my_user->contact_num }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Full Address</label>
                        <textarea id="address" name="address" class="form-control" rows="2">{{ $my_user->address }}</textarea>
                    </div>
                </div>
                <hr class="my-4">
                <h5 class="fw-bold mb-3">Shipping Addresses</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Address</th>
                                <th>Default</th>
                                <th>Set as</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($shippings) == 0)
                            <tr>
                                <td colspan="3" class="text-center text-muted">No shipping addresses found.</td>
                            </tr>
                            @else
                            @foreach($shippings as $shipping)
                            <tr>
                                <td>{{ $shipping->address }}</td>
                                <td>
                                    <span class="badge {{ $shipping->isDefault ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $shipping->isDefault ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="address_type" id="addressHome{{ $shipping->id }}" value="home" {{ $shipping->isDefault ? 'checked' : '' }}>
                                        <label class="form-check-label" for="addressHome{{ $shipping->id }}">Home</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="address_type" id="addressWork{{ $shipping->id }}" value="work" {{ !$shipping->isDefault ? 'checked' : '' }}>
                                        <label class="form-check-label" for="addressWork{{ $shipping->id }}">Work</label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div id="errorMessages" class="alert alert-danger d-none">
                </div>
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="/profile-set-shipping" class="btn btn-danger">+ Add New Shipping Address</a>
                    <input type="submit" value="Save Changes" class="btn btn-danger px-4" />
                    {{-- <button type="submit" class="btn btn-danger px-4">Save Changes</button> --}}
                </div>

            </form>
        </div>
    </section>
    @include ('plus.chatbot')
    @include ('plus.footer')
    @include ('plus.scripts')
</body>
</html>