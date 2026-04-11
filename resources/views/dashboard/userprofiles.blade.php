<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Total Quality Management Products Philippines">
    <meta name="author" content="TQMP">
    <title>Catalogue | Total Quality Management Products Philippines</title>
    <link rel="icon" href="{{ asset('storage/logos/TQMPLogo.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">
    <script src="{{ asset('js/chatbot.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>
    @include('plus.navbar')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold">User Profile</h5>
            <button class="card-button btn btn-primary">Save Changes</button>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="text-center">
                    <img src="https://th.bing.com/th/id/OIP.MAGyL3kQm3GYlLroszc3sgHaEK?rs=1&pid=ImgDetMain" alt="Profile" class="img-fluid rounded mb-2" style="height: 225px; width: 100%;">
                </div>
                <div class="mt-3">
                    <label for="password" class="form-label">Update Profile Picture</label>
                    <input type="file" class="form-control mb-2" accept="image/*">
                    <label for="password" class="form-label">Old Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control mb-2" placeholder="Old Password">
                    <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control mb-4" placeholder="New Password">
                    <button class="card-button btn btn-primary w-100">Change Password</button>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" value="john.doe">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" value="John">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nickname</label>
                        <input type="text" class="form-control" value="Johnny">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" value="Doe">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Display Name Publicly as</label>
                        <input type="text" class="form-control" value="John Doe">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email (required)</label>
                        <input type="email" class="form-control" value="john.doe@example.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">WhatsApp</label>
                        <input type="text" class="form-control" value="@john-doe">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Website</label>
                        <input type="text" class="form-control" value="john-doe.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telegram</label>
                        <input type="text" class="form-control" value="@john-doe">
                    </div>
                </div>
                <div class="mt-3">
                    <label class="form-label">Biographical Info</label>
                    <textarea class="form-control" rows="5">John Doe is a software engineer with over 10 years of experience...</textarea>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        Default Shipping Address
                    </div>
                    <div class="card-body">
                        <p>Default Shipping Address: blah blah</p>
                        <hr>
                        <p>Billing Address: blah blah</p>
                        <hr>
                        <p>Email Address: blahblah@practice.com</p>
                        <hr>
                        <button class="card-button btn btn-primary">Edit Address</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        Bank Details
                    </div>
                    <div class="card-body">
                        <p>Bank: ABC Bank</p>
                        <hr>
                        <p>Account Number: 123456789</p>
                        <hr>
                        <p>IFSC Code: ABCD0123456</p>
                        <hr>
                        <button class="card-button btn btn-primary">Edit Bank Details</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                Order History
                </div>
                <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>12345</td>
                        <td>2023-01-01</td>
                        <td><span class="text-success">Completed</span></td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>12346</td>
                        <td>2023-02-01</td>
                        <td><span class="text-success">Pending</span></td>
                        <td>$150.00</td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                Current Orders
                </div>
                <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>12347</td>
                        <td>2023-03-01</td>
                        <td><span class="text-success">Processing</span></td>
                        <td>$200.00</td>
                    </tr>
                    <tr>
                        <td>12348</td>
                        <td>2023-04-01</td>
                        <td><span class="text-success">Shipped</span></td>
                        <td>$250.00</td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
            </div>
        </div>
    </div>
    @include ('plus.chatbot')
    @include ('plus.footer')
    <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>
</body>
</html>