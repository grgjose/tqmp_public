<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>TQMP | Messages</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Total Quality Management Products Philippines" />
    <meta name="author" content="TQMP" />
    <meta name="description" content="Your Partner in Progress: The Marketing Arm of Philippines Glass and Aluminum Conglomerate" />
    <meta name="keywords" content="TQMP, Total Quality Management Products Philippines, aluminum, aluminum manufacturing, bullet proofing, architectural hardware, glass, glass manufacturing, glass processing, TQMP Services" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('storage/dist/css/adminlte.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <main class="app-main px-4">
            <div class="app-content-header">
                <div class="container-fluid py-4 bg-white">
                    <div class="row">
                        <div class="mx-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0">Messages</h3>
                                <div>
                                    <button class="btn btn-sm btn-primary" onclick="saveInput()">Save</button>
                                </div>
                            </div>
                            <div class="row mt-3 mb-4">
                                <div class="col-md-4">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-9" data-bs-spy="scroll" data-bs-target="#quotationScrollspy" data-bs-offset="100" style="height: 500px; width:auto; overflow-y: auto;">
                                        <form action="/create-quotation" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div id="glassDetails" class="mb-5">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Service Type</label>
                                                    <input name="glasstype[]" class="form-control" type="text" placeholder="Glass Processing" >
                                                    <input type="hidden" name="quotation_type" value="glass">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Glass Type</label>
                                                    <input name="glasstype[]" class="form-control" type="text" placeholder="Enter glass type" >
                                                </div>
                                                <div class="row g-3 mb-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">Thickness</label>
                                                        <input name="thickness[]" class="form-control" type="text" placeholder="Enter thickness" >
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">Color</label>
                                                        <input name="width1[]" class="form-control" type="text" placeholder="Enter color" >
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">Quantity</label>
                                                        <input name="quantity[]" class="form-control" type="number" min="1" value="1" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="dimensions" class="mb-5">
                                                <div class="row g-3 mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Height (mm)</label>
                                                        <div class="row g-2">
                                                            <div class="col">
                                                                <input name="height1[]" class="form-control" type="number" placeholder="H1" >
                                                            </div>
                                                            <div class="col">
                                                                <input name="height2[]" class="form-control" type="number" placeholder="H2" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Width (mm)</label>
                                                        <div class="row g-2">
                                                            <div class="col">
                                                                <input name="width1[]" class="form-control" type="number" placeholder="W1" >
                                                            </div>
                                                            <div class="col">
                                                                <input name="width2[]" class="form-control" type="number" placeholder="W2" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="cuttingDetails" class="mb-5">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Cutting Details</label>
                                                    <textarea name="cutting_details" rows="2" class="form-control" ></textarea>
                                                </div>
                                            </div>
                                            <div id="imagesGallery" class="mb-5">
                                                <h6 class="mb-4 border-bottom pb-2">Images Gallery</h6>
                                                <div class="border rounded p-2">
                                                    @if(isset($images) && count($images) > 0)
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach($images as $image)
                                                        <div class="border rounded overflow-hidden" style="width: 80px; height: 80px;"
                                                            data-bs-toggle="modal" data-bs-target="#imageModal"
                                                            onclick="document.getElementById('modalImage').src=''">
                                                            <img src="" alt="Quotation Image"
                                                                class="w-100 h-100 object-fit-cover">
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @else
                                                    <div class="text-center py-2 text-muted">
                                                        No images available
                                                        <div class="d-flex flex-row gap-2 mt-3">
                                                            <div class="border rounded overflow-hidden" style="width: 80px; height: 80px;"
                                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                                onclick="document.getElementById('modalImage').src=' '">
                                                                <img src=" " alt="Quotation Image"
                                                                    class="w-100 h-100 object-fit-cover">
                                                            </div>
                                                            <div class="border rounded overflow-hidden" style="width: 80px; height: 80px;"
                                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                                onclick="document.getElementById('modalImage').src=' '">
                                                                <img src=" " alt="Quotation Image"
                                                                    class="w-100 h-100 object-fit-cover">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div id="vehicleDetails">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Service Type</label>
                                                    <input name="glasstype[]" class="form-control" type="text" placeholder="Bullet Proofing Manufacturing" >
                                                    <input type="hidden" name="quotation_type" value="glass">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="plateNumber" class="form-label fw-bold">Plate Number <span class="text-danger">*</span></label>
                                                    <input id="plateNumber" name="plateNumber" class="form-control" type="text" placeholder="Enter Plate Number" >
                                                </div>
                                                <div class="mb-3">
                                                    <label for="model" class="form-label fw-bold">Model <span class="text-danger">*</span></label>
                                                    <input id="model" name="model" class="form-control" type="text" placeholder="Enter Vehicle Model" >
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Color</label>
                                                    <input id="color" name="color" class="form-control" type="text" placeholder="Enter Vehicle Color" >
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Services</label>
                                                    <input id="services" name="services" class="form-control" type="text" placeholder="Enter Services" >
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Remarks</label>
                                                    <input id="remarks" name="remarks" class="form-control" type="text" placeholder="Enter Remarks" >
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                                <div class="border col-md-8">
                                    <div class="card-body p-0" style="position: relative; height: 500px; overflow-y: auto;" data-bs-spy="scroll" data-bs-target="#scrollspy-nav" data-bs-offset="20">
                                        <div id="note-0" class="border-end border-secondary border-4 mb-3 bg-white p-3">
                                            <div class="d-flex justify-content-between align-items-center bg-light p-2 mb-2 border-bottom">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">TQ</div>
                                                    <div class="ms-2">
                                                        <strong>Default</strong>
                                                        <div class="text-muted small"></div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="badge bg-secondary me-1">Default Message</span>
                                                    <span><i class="fas fa-ellipsis-v"></i></span>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="mb-0">[Internal Note] Please wait for the Sales Representative's Verification. The Representative will message here in a bit. It is possible that the Representative will call you on your designated number for clarification.</p>
                                            </div>
                                        </div>
                                        <div id="note-1" class="border-start border-primary border-4 mb-3 bg-white p-3">
                                            <div class="d-flex justify-content-between align-items-center bg-primary bg-opacity-10 p-2 mb-2 border-bottom">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">JD</div>
                                                    <div class="ms-2">
                                                        <strong>John Doe</strong>
                                                        <div class="text-muted small">Today, 10:30 AM</div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="badge bg-primary me-1">Customer</span>
                                                    <span><i class="fas fa-ellipsis-v"></i></span>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="mb-0">Contacted the user and walked them through the password reset process. User confirmed they can now log in successfully.</p>
                                            </div>
                                        </div>
                                        <div id="note-2" class="border-end border-danger border-4 mb-3 bg-white p-3">
                                            <div class="d-flex justify-content-between align-items-center bg-light p-2 mb-2 border-bottom">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">SR</div>
                                                    <div class="ms-2">
                                                        <strong>Sales Representative</strong>
                                                        <div class="text-muted small">Yesterday, 3:45 PM</div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="badge bg-danger me-1">Representative</span>
                                                    <span><i class="fas fa-ellipsis-v"></i></span>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="mb-0">[Internal Note] This appears to be related to the ongoing authentication system issues. Escalating to L2 support.</p>
                                            </div>
                                        </div>
                                        <div id="note-3" class="border-start border-primary border-4 mb-3 bg-white p-3">
                                            <div class="d-flex justify-content-between align-items-center bg-primary bg-opacity-10 p-2 mb-2 border-bottom">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">JD</div>
                                                    <div class="ms-2">
                                                        <strong>John Doe</strong>
                                                        <div class="text-muted small">Yesterday, 11:15 AM</div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="badge bg-primary me-1">Public</span>
                                                    <span><i class="fas fa-ellipsis-v"></i></span>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="mb-0">User reported being unable to reset password. Verified account status is active. Reset link was sent but user reports not receiving it.</p>
                                                <p class="mt-2 mb-0"><strong>Next Steps:</strong> Check email logs for the reset request.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer p-0">
                                <div id="summernote"></div>
                                <div class="p-3 bg-light d-flex justify-content-between">
                                    <div>
                                                                            </div>
                                    <div>
                                        <button class="btn btn-sm btn-primary">Send Message</button>
                                    </div>
                                </div>
                            </div>
                        </div>
        </main>
    </div>
    <script>
        function showInputBox(action) {
            const inputBoxContainer = document.getElementById('inputBoxContainer');
            const inputBoxLabel = document.getElementById('inputBoxLabel');
            inputBoxContainer.style.display = 'block';
            if (action === 'approve') {
                inputBoxLabel.innerHTML = 'Reason for Approval: <span style="color: red;">*</span>';
            } else if (action === 'reject') {
                inputBoxLabel.innerHTML = 'Reason for Rejection: <span style="color: red;">*</span>';
            }
            document.getElementById('actions').scrollIntoView({
                behavior: 'smooth'
            });
        }
        function saveInput() {
            const inputBox = document.getElementById('inputBox');
            const inputValue = inputBox.value.trim();
            if (inputValue) {
                alert('Input saved: ' + inputValue);
                inputBox.value = '';
                document.getElementById('inputBoxContainer').style.display = 'none';
            } else {
                alert('Please provide a reason before saving.');
            }
        }
    </script>
    <script>
        document.getElementById('imageInput')?.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.getElementById('previewImage');
                    const modalPreviewImage = document.getElementById('modalPreviewImage');
                    previewImage.src = e.target.result;
                    modalPreviewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalImage = document.getElementById('modalPreviewImage');
            const zoomInBtn = document.querySelector('.zoom-in-btn');
            const zoomOutBtn = document.querySelector('.zoom-out-btn');
            const zoomResetBtn = document.querySelector('.zoom-reset-btn');
            let currentScale = 1;
            const zoomLevels = [1, 1.5, 2, 2.5, 3];
            let currentZoomIndex = 0;
            modalImage.style.transformOrigin = 'center center';
            modalImage.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width;
                const y = (e.clientY - rect.top) / rect.height;
                this.style.transformOrigin = `${x * 100}% ${y * 100}%`;
                currentZoomIndex = (currentZoomIndex + 1) % zoomLevels.length;
                currentScale = zoomLevels[currentZoomIndex];
                applyZoom();
            });
            zoomInBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (currentZoomIndex < zoomLevels.length - 1) {
                    currentZoomIndex++;
                    currentScale = zoomLevels[currentZoomIndex];
                    applyZoom();
                }
            });
            zoomOutBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (currentZoomIndex > 0) {
                    currentZoomIndex--;
                    currentScale = zoomLevels[currentZoomIndex];
                    applyZoom();
                }
            });
            zoomResetBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                currentZoomIndex = 0;
                currentScale = 1;
                modalImage.style.transformOrigin = 'center center';
                applyZoom();
            });
            function applyZoom() {
                modalImage.style.transform = `scale(${currentScale})`;
                modalImage.style.cursor = currentScale > 1 ? 'zoom-out' : 'zoom-in';
            }
            let isDragging = false;
            let startX, startY, translateX = 0,
                translateY = 0;
            modalImage.addEventListener('mousedown', function(e) {
                if (currentScale > 1) {
                    isDragging = true;
                    startX = e.clientX - translateX;
                    startY = e.clientY - translateY;
                    this.style.cursor = 'grabbing';
                    e.preventDefault();
                }
            });
            document.addEventListener('mousemove', function(e) {
                if (!isDragging) return;
                translateX = e.clientX - startX;
                translateY = e.clientY - startY;
                modalImage.style.transform = `scale(${currentScale}) translate(${translateX}px, ${translateY}px)`;
            });
            document.addEventListener('mouseup', function() {
                isDragging = false;
                if (currentScale > 1) {
                    modalImage.style.cursor = 'zoom-out';
                }
            });
            $('#imageModal').on('hidden.bs.modal', function() {
                currentZoomIndex = 0;
                currentScale = 1;
                translateX = 0;
                translateY = 0;
                modalImage.style.transform = 'scale(1)';
                modalImage.style.transformOrigin = 'center center';
                modalImage.style.cursor = 'zoom-in';
            });
        });
    </script>
    <script>
        function uploadAndPreviewImage(file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#summernote').summernote('insertImage', e.target.result, file.name);
            };
            reader.readAsDataURL(file);
        }
    </script>
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.querySelector('.card-body'), {
            target: '#scrollspy-nav'
        });
        document.querySelectorAll('#notes-admin .nav-link').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#scrollspy'
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="{{ asset('storage/dist/js/adminlte.js') }}"></script>
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Add a message...',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview', 'help']]
                ],
                callbacks: {
                    onInit: function() {
                        const toolbar = $('.note-toolbar');
                        const switchHtml = `
                        <div class="private-note-switch d-flex align-items-center me-2 mt-2 mb-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="privateNote">
                                <label class="form-check-label ms-2" for="privateNote">Private Note</label>
                            </div>
                        </div>
                    `;
                        toolbar.append(switchHtml);
                        updateNoteBorder();
                        $('#privateNote').change(function() {
                            updateNoteBorder();
                        });
                        function updateNoteBorder() {
                            const editor = $('#summernote');
                            if ($('#privateNote').is(':checked')) {
                                editor.next('.note-editor').css('border-left', '4px solid #dc3545');
                            } else {
                                editor.next('.note-editor').css('border-right', '4px solid #0d6efd');
                            }
                        }
                    }
                }
            });
        });
    </script>
    <script>
        new DataTable('#example');
    </script>
</body>
</html>