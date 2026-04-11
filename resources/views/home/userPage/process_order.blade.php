<!DOCTYPE html>
<html lang="en">
<head>
    @include ('plus.head')
</head>
<body>
    @include('plus.navbar')
    <section id="form" class="fade-in-up container py-5">
        <div class="col-md-12" style="border: 1px solid #ccc; padding: 20px; border-radius: 3px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold">Cart Quotation > Process Order</h5>
            </div>
            <form class="py-3">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="fullName" class="form-label fw-bold">Size <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="size" placeholder="Add preferred size">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-bold">Color <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="color" placeholder="Add preferred color">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label fw-bold">Add Details <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="details" rows="5" placeholder="Add your description here"></textarea>
                </div>
                <div class="mb-3">
                    <label for="formFileSm" class="form-label fw-bold">Add Image Attachment <span class="text-danger">*</span></label>
                    <input class="form-control form-control-sm" id="formFileSm" type="file">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary w-100">Get Quotation</button>
                </div>
            </form>
        </div>
    </section>
    @include ('plus.footer')
</body>
</html>