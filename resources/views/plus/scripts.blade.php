    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.5/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.5/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('js/chatbot.js') }}"></script>
    <script src="https://unpkg.com/@panzoom/panzoom@4.6.0/dist/panzoom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

    <!-- General Scripts -->
    @if(session()->has('error_msg'))
    <script>
        toastr.options.preventDuplicates = true;
        toastr.error("{{ session('error_msg') }}");
    </script>
    @endif
    @error('code')
    <script>
        toastr.options.preventDuplicates = true;
        toastr.error('Code already exists');
    </script>
    @enderror
    @if(session()->has('success_msg'))
    <script>
        toastr.options.preventDuplicates = true;
        toastr.success("{{ session('success_msg') }}");
    </script>
    @endif
    @if(session()->has('download_file'))
    <script>
        $("#download_filename").val("{{ session('download_file') }}");
        $("#downloadForm").submit();
    </script>
    @endif
    <script>
        function fetchNotifications() {
            $('#notifications').load('/notifications');
        }

        fetchNotifications();

        setInterval(fetchNotifications, 10000);
    </script>


    @if(isset($my_user))
        <script>
            $(document).ready(function() {
                $('#saveProfileForm').on('submit', function(e) {
                    let errors = [];
                    let oldPassword = $('#old_password').val();
                    let newPassword = $('#new_password').val();
                    let confirmPassword = $('#confirm_password').val();
                    let birthdate = $('#birthdate').val();
                    let contactNumber = $('#contact_number').val();
                    let username = $('#username').val();

                    

                    if (oldPassword || newPassword || confirmPassword) {
                        if (oldPassword === newPassword) {
                            errors.push("New password must be different from old password.");
                        }
                        if (newPassword.length < 8) {
                            errors.push("New password must be at least 8 characters.");
                        }
                        if (newPassword !== confirmPassword) {
                            errors.push("Confirm password must match new password.");
                        }
                    }

                    if (birthdate) {
                        let today = new Date();
                        let enteredDate = new Date(birthdate);
                        let age = today.getFullYear() - enteredDate.getFullYear();
                        let m = today.getMonth() - enteredDate.getMonth();
                        if (m < 0 || (m === 0 && today.getDate() < enteredDate.getDate())) {
                            age--;
                        }
                        if (enteredDate >= today) {
                            errors.push("Birthdate must be in the past.");
                        } else if (age < 18) {
                            errors.push("User must be at least 18 years old.");
                        }
                    } else {
                        errors.push("Birthdate is required.");
                    }

                    if (contactNumber != "") {
                        const phRegex = /^(09\d{9}|\+639\d{9})$/;
                        if (!phRegex.test(contactNumber)) {
                            errors.push("Contact number must be in PH format (09XXXXXXXXX or +639XXXXXXXXX).");
                        }
                    } else {
                        errors.push("Contact number is required.");
                    }

                    if (oldPassword && newPassword) {
                        $.ajax({
                            url: "{{ route('confirm.password') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                password: oldPassword
                            },
                            async: false,
                            error: function(xhr) {
                                errors.push("Old password is incorrect.");
                            }
                        });
                    }

                    if (username && username != "{{ $my_user->username }}") {
                        $.ajax({
                            url: "{{ route('confirm.username') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                username: username
                            },
                            async: false,
                            error: function(xhr) {
                                errors.push("Username already exists.");
                            }
                        });
                    }

                    if (errors.length > 0) {
                        $('#errorMessages').html(errors.join('\n'));
                        $('#errorMessages').removeClass('d-none');
                        e.preventDefault();
                    } else {
                        this.submit();
                        $('#errorMessages').html('');
                        $('#errorMessages').addClass('d-none');
                    }
                });
            });
        </script>
    @endif
    @if(isset($hostname))
        <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_api_key') }}&libraries=places&callback=initMap">
        </script>
        <script>
            function sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }

            function initMap() {
                const defaultLocation = { lat: 14.5995, lng: 120.9842 };

                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 12,
                    center: defaultLocation,
                });

                const geocoder = new google.maps.Geocoder();
                let marker = null;

                /** ==============================
                 *  ADDRESS AUTOCOMPLETE
                 *  ============================== */
                const input = document.getElementById("addressInput");
                const autocomplete = new google.maps.places.Autocomplete(input, {
                    fields: ["formatted_address", "geometry"],
                    componentRestrictions: { country: "ph" }
                });

                autocomplete.addListener("place_changed", async () => {
                    const place = autocomplete.getPlace();
                    if (!place.geometry) return;

                    const lat = place.geometry.location.lat();
                    const lng = place.geometry.location.lng();
                    const address = place.formatted_address;

                    updateMarker(lat, lng, address);
                    await requestLalamoveQuote(lat, lng, address);
                });

                /** ==============================
                 *  MAP CLICK HANDLER
                 *  ============================== */
                map.addListener("click", async (e) => {
                    const lat = e.latLng.lat();
                    const lng = e.latLng.lng();

                    geocoder.geocode({ location: { lat, lng } }, async (results, status) => {
                        if (status === "OK" && results[0]) {
                            const address = results[0].formatted_address;
                            updateMarker(lat, lng, address);
                            await requestLalamoveQuote(lat, lng, address);
                        }
                    });
                });

                /** ==============================
                 *  HELPER FUNCTIONS
                 *  ============================== */
                function updateMarker(lat, lng, address) {
                    if (marker) marker.setMap(null);

                    marker = new google.maps.Marker({
                        position: { lat, lng },
                        map: map,
                    });

                    map.panTo({ lat, lng });

                    $("#lat").text(`Lat: ${lat}`);
                    $("#lng").text(`Lng: ${lng}`);
                    $("#address").text(address);

                    $("#hidden_lat").val(lat);
                    $("#hidden_lng").val(lng);
                    $("#hidden_address").val(address);
                }

                async function requestLalamoveQuote(lat, lng, address) {
                    await sleep(1200);

                    try {
                        const response = await fetch("{{ route('lalamove.getQuotation') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                            },
                            body: JSON.stringify({
                                serviceType: "LD_10WHEEL_TRUCK",
                                specialRequests: ["HELPER_2"],
                                latitude: lat,
                                longitude: lng,
                                address: address,
                                quantity: 1,
                                weight: "MORE_THAN_10KG"
                            })
                        });

                        const data = await response.json();

                        $("#quote").text(data.data.priceBreakdown.total);
                        $("#hidden_delivery_fee").val(data.data.priceBreakdown.total);
                        //$("#deliveryFeeContainer").show();

                    } catch (err) {
                        console.error("Lalamove error:", err);
                    }
                }
            }
        </script>
        <script>
            $(document).ready(function() {
                $('#shippingForm').on('submit', function(e) {
                    const errors = [];
                    let lat = $('#hidden_lat').val();
                    let lng = $('#hidden_lng').val();
                    let address = $('#hidden_address').val();
                    let deliveryFee = $('#hidden_delivery_fee').val();
                    let contactNumber = $('#contact_number').val();

                    if (contactNumber) {
                        const phRegex = /^(09\d{9}|\+639\d{9})$/;
                        if (!phRegex.test(contactNumber)) {
                            errors.push("Contact number must be in PH format (09XXXXXXXXX or +639XXXXXXXXX).");
                        }
                    }
                    if (!lat || !lng || !address || !deliveryFee) {
                        errors.push("Please select a valid location on the map.");
                    }

                    if (errors.length > 0) {
                        e.preventDefault();
                        $('#errorMessages').html(errors.join('\n'));
                    } else {
                        this.submit();
                        $('#errorMessages').html('');
                    }
                });
            });
        </script>
    @endif
    <script>
        let currentImageIndex = 0;
        let allImages = [];

        document.addEventListener('DOMContentLoaded', function() {

            const imageElements = document.querySelectorAll('#imagesGallery .overflow-hidden img');
            allImages = Array.from(imageElements).map(img => ({
                src: img.src,
                alt: img.alt
            }));

            const thumbnails = document.querySelectorAll('#imagesGallery .overflow-hidden');
            thumbnails.forEach(thumb => {
                thumb.addEventListener('mouseenter', function() {
                    this.querySelector('img').style.transform = 'scale(1.05)';
                });
                thumb.addEventListener('mouseleave', function() {
                    this.querySelector('img').style.transform = 'scale(1)';
                });
            });
        });

        function openImageModal(src, alt) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            const modalLabel = document.getElementById('imageModalLabel');

            currentImageIndex = allImages.findIndex(img => img.src === src);

            modalImage.src = src;
            modalImage.style.transform = 'scale(1)';
            modalImage.style.cursor = 'zoom-in';
            modalLabel.textContent = alt || 'Image View';
            updateImageCounter();


        }

        function toggleZoom(img) {
            if (img.style.transform === 'scale(2)') {
                img.style.transform = 'scale(1)';
                img.style.cursor = 'zoom-in';
            } else {
                img.style.transform = 'scale(2)';
                img.style.cursor = 'zoom-out';
            }
        }

        function navigateImage(direction) {
            currentImageIndex += direction;

            if (currentImageIndex < 0) {
                currentImageIndex = allImages.length - 1;
            } else if (currentImageIndex >= allImages.length) {
                currentImageIndex = 0;
            }

            const modalImage = document.getElementById('modalImage');
            modalImage.src = allImages[currentImageIndex].src;
            modalImage.style.transform = 'scale(1)';
            modalImage.style.cursor = 'zoom-in';
            document.getElementById('imageModalLabel').textContent = allImages[currentImageIndex].alt || 'Image View';
            updateImageCounter();
        }

        function updateImageCounter() {
            document.getElementById('imageCounter').textContent =
                `${currentImageIndex + 1} of ${allImages.length}`;
        }

        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('imageModal');
            if (modal.classList.contains('show')) {
                if (e.key === 'ArrowLeft') {
                    navigateImage(-1);
                } else if (e.key === 'ArrowRight') {
                    navigateImage(1);
                } else if (e.key === 'Escape') {

                    document.getElementById('modalImage').style.transform = 'scale(1)';
                }
            }
        });
    </script>
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#quotationScrollspy'
        });
    </script>
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.querySelector('.card-body'), {
            target: '#notes-nav'
        });

        document.querySelectorAll('#notes-nav .nav-link').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('imageModal');
            let panzoomInstance = null;
            modal.addEventListener('shown.bs.modal', function() {
                const zoomContainer = document.getElementById('zoomContainer');
                if (panzoomInstance) {
                    panzoomInstance.destroy();
                }
                panzoomInstance = Panzoom(zoomContainer, {
                    maxScale: 5,
                    contain: 'outside',
                });
                zoomContainer.parentElement.addEventListener('wheel', panzoomInstance.zoomWithWheel);
            });
            modal.addEventListener('hidden.bs.modal', function() {
                if (panzoomInstance) {
                    panzoomInstance.destroy();
                    panzoomInstance = null;
                }
            });
        });
    </script>

    <script>
        function downloadConforme(id, from){
            if(from == null || from == undefined){
                window.location.href = '/download-conforme-user/' + id;    
            } else {
                window.location.href = '/download-conforme-user/' + id + '/' + from;    
            }
        }

        function downloadAr(id, from) {
            if(from == null || from == undefined){
                window.location.href = '/download-ar-user/' + id;    
            } else {
                window.location.href = '/download-ar-user/' + id + '/' + from;    
            }
        }

        function uploadConforme(id){
            $('#uploadConformeForm').attr('action', '/upload-conforme-user/' + id);
        }

        function uploadProof(id){
            $('#uploadProofForm').attr('action', '/upload-proof-of-payment/' + id);
        }

        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Add a message...',
                tabsize: 2,
                height: 100,
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
                        const switchHtml = ` `;
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
                                editor.next('.note-editor').css('border-left', '4px solid #0d6efd');
                            }
                        }
                    }
                }
            });
        });
    </script>
    @if(isset($quotation))
    <script>
        $(document).ready(function() {
            let reference = "{{ $quotation->reference }}";

            function fetchMessages() {
                $('#messages').load(`/show-quotation-messages/${reference}`);
            }

            setInterval(fetchMessages, 3000);

            fetchMessages();
        });
    </script>
    @endif
    <script>
        $(document).ready(function() {
            const checkboxes = $('input[name="checkboxes[]"]');
            const paymentMethods = $('input[name="paymentMethod"]:not(:disabled)');
            const deliveryMethods = $('input[name="delivery"]:not(:disabled)');
            const checkoutButton = $('#checkoutButton');
            const deliveryFeePrice = $('#deliveryFeePrice');

            checkoutButton.prop('disabled', true);

            function parsePesoAmount(text) {

                const amount = parseFloat(text.replace(/[₱,]/g, ''));
                return isNaN(amount) ? 0 : amount;
            }

            function validateForm() {
                const atLeastOneChecked = checkboxes.is(':checked');
                const paymentSelected = paymentMethods.is(':checked');
                const deliverySelected = deliveryMethods.is(':checked');
                const deliveryFee = parsePesoAmount(deliveryFeePrice.text().trim());
                const selectedDelivery = $('input[name="delivery"]:checked').val();
                const isPickup = selectedDelivery === 'pickup';

                const deliveryFeeValid = isPickup || deliveryFee > 0;

                const isValid = atLeastOneChecked && paymentSelected && deliverySelected && deliveryFeeValid;
                checkoutButton.prop('disabled', !isValid);
            }
            checkboxes.on('change', validateForm);
            paymentMethods.on('change', validateForm);
            deliveryMethods.on('change', validateForm);
            deliveryFeePrice.on('DOMSubtreeModified', validateForm);
        });
        // $(document).ready(function() {

        //     $('input[name="paymentMethod"]').on('change', function() {
        //         if ($('#uploadPayment').is(':checked')) {
        //             $('#paymentAttachment').attr('required', true);
        //             $('.attachmentRelated').prop('disabled', false).show();
        //         } else {
        //             $('#paymentAttachment').removeAttr('required');
        //             $('.attachmentRelated').prop('disabled', true).val('').hide();
        //         }
        //     });

        //     $('.attachmentRelated').hide();
        // });
        $(document).ready(function() {
            function computeTotal() {
                let subtotal = 0;
                let discount = 0;
                let checkedItems = 0;

                // Default shipping cost = 0
                let shippingCost = 0;

                // Check selected delivery method
                let selectedDelivery = $('input[name="delivery"]:checked').val();

                // Only apply shipping cost if delivery is chosen
                if (selectedDelivery === "delivery") {
                    let deliveryFeeText = $("#deliveryFeePrice").text().replace(/[₱,]/g, '').trim();
                    shippingCost = parseFloat(deliveryFeeText) || 0;
                }

                $("tbody tr").each(function() {
                    let isChecked = $(this).find("input[type='checkbox']").prop("checked");
                    if (isChecked) {
                        let priceText = $(this).find(".item_prices").text().replace(/[₱,]/g, '').trim();
                        let discountedPriceText = $(this).find(".item_discounted_prices").text().replace(/[₱,]/g, '').trim();
                        let quantity = $(this).find("input[type='number']").val();
                        if (priceText && quantity && discountedPriceText) {
                            let price = parseFloat(priceText) || 0;
                            let discountedprice = parseFloat(discountedPriceText) || 0;
                            let qty = parseInt(quantity, 10) || 1;
                            let itemTotal = price * qty;
                            let itemDiscountedTotal = discountedprice * qty;
                            subtotal += itemTotal;
                            discount += (itemTotal - itemDiscountedTotal);
                            $(this).find(".hiddenPrice").val(itemTotal);
                            $(this).find(".prices").text("₱" + itemTotal.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                            $(this).find(".discounted_prices").text("₱" + itemDiscountedTotal.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                            checkedItems++;
                        } else if(priceText && quantity) {
                            let price = parseFloat(priceText) || 0;
                            let qty = parseInt(quantity, 10) || 1;
                            let itemTotal = price * qty;
                            subtotal += itemTotal;
                            $(this).find(".hiddenPrice").val(itemTotal);
                            $(this).find(".prices").text("₱" + itemTotal.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                            checkedItems++;
                        }
                    }
                });

                if (checkedItems === 0) {
                    subtotal = 0;
                    shippingCost = 0;
                    discount = 0;
                }

                let total = subtotal + shippingCost - discount;

                $(".subtotal").text("₱" + subtotal.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $(".shipping-cost").text("₱" + shippingCost.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $(".discount").text("₱" + discount.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $(".total-payable2").text("₱" + total.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            }

            computeTotal();

            $(document).on("change", "input[type='number']", function() {
                computeTotal();
            });
            $(document).on("change", "input[type='checkbox']", function() {
                computeTotal();
            });
            $(document).on("change", "input[name='delivery']", function() {
                computeTotal();
            });
        });

        function removeItem(element, id) {

            const row = element.closest('tr');
            if (row) {
                row.remove();
            }
            if (!id) {
                console.error('No ID provided');
                return;
            }
            $.ajax({
                url: `/remove-cart-item/${id}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('Success:', response);
                    $(element).closest('tr').remove();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('Failed to remove item from cart.');
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('productSearch1');

            searchInput.addEventListener('keyup', function () {
                const query = this.value.toLowerCase().trim();

                // Loop through all tab panes
                document.querySelectorAll('.tab-pane').forEach(tabPane => {
                    let hasVisibleProduct = false;

                    // Loop through products inside this tab
                    tabPane.querySelectorAll('.product-item').forEach(product => {
                        const name = product.dataset.name?.toLowerCase() || '';

                        if (query === '' || name.includes(query)) {
                            product.style.display = '';
                            hasVisibleProduct = true;
                        } else {
                            product.style.display = 'none';
                        }
                    });

                    // Hide tab pane if no products match
                    tabPane.style.display = hasVisibleProduct ? '' : 'none';
                });

                // Handle tab buttons visibility
                document.querySelectorAll('#subcategory3-tabs .nav-link').forEach(tabBtn => {
                    const targetId = tabBtn.getAttribute('data-bs-target');
                    const targetPane = document.querySelector(targetId);

                    tabBtn.style.display =
                        targetPane && targetPane.style.display === 'none'
                            ? 'none'
                            : '';
                });

                // Activate first visible tab automatically
                const firstVisibleTab = document.querySelector(
                    '#subcategory3-tabs .nav-link:not([style*="display: none"])'
                );

                if (firstVisibleTab && !firstVisibleTab.classList.contains('active')) {
                    new bootstrap.Tab(firstVisibleTab).show();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {

            let otpVerified = false;
            // If URL is not /cart, skip OTP flow and allow normal checkout process
            if (window.location.href === "/cart")  return;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Step 1: Click Checkout → Call OTP_Get + show modal
            $('#checkoutButton').on('click', function (e) {
                e.preventDefault();

                $.ajax({
                    url: '/checkout_otp_get', // your OTP_Get API
                    method: 'POST',
                    success: function (res) {
                        if(res.success == true){
                            $('#otpModal').modal('show');
                        } else {
                            alert('Failed to generate OTP 2');
                        }
                    },
                    error: function (xhr) {
                        let message = 'Something went wrong';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        alert(message);
                    }
                });
            });

            // Step 2: Verify OTP
            $('#verify-btn').on('click', function () {

                let otp1 = $('#otp_digit1').val();
                let otp2 = $('#otp_digit2').val();
                let otp3 = $('#otp_digit3').val();
                let otp4 = $('#otp_digit4').val();
                let otp5 = $('#otp_digit5').val();
                let otp6 = $('#otp_digit6').val();

                $.ajax({
                    url: '/checkout_otp_post', // your OTP_Put API
                    method: 'POST',
                    data: {
                        otp: otp1 + otp2 + otp3 + otp4 + otp5 + otp6
                    },
                    success: function (res) {

                        if (res.success == true) {
                            otpVerified = true;
                            $('#otpModal').modal('hide');

                            // Step 3: Submit form AFTER success
                            $('#checkoutForm').submit();
                        } else {
                            //alert('Invalid OTP');
                        }
                    },
                    error: function (xhr) {
                        let message = 'Something went wrong';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        $('#otp-error').text(message).show();
                    }
                });
            });

        });
    </script>
    <script>
        $(document).ready(function () {

            let otpVerified = false;
            // If URL is not /home, skip OTP flow and allow normal checkout process
            if (window.location.href === "/home")  return;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Step 1: Click Checkout → Call OTP_Get + show modal
            $('#loginSubmitBtn').on('click', function (e) {
                e.preventDefault();

                $.ajax({
                    url: '/login_otp_get', // your OTP_Get API
                    method: 'POST',
                    data: {
                        email: $('#loginEmail').val(),
                        password: $('#loginPassword').val()
                    },
                    success: function (res) {
                        if(res.success == true){
                            $('#loginModalBody').addClass('d-none');
                            $('#otpModal').removeClass('d-none').modal('show');
                        } else {
                            $('#loginModalBody').removeClass('d-none').modal('show');
                            $('#otpModal').addClass('d-none');
                            alert('Failed to generate OTP 2');
                        }
                    },
                    error: function (xhr) {
                        let message = 'Something went wrong';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        alert(message);
                    }
                });
            });

            // Step 2: Verify OTP
            $('#verify-btn').on('click', function () {

                let otp1 = $('#otp_digit1').val();
                let otp2 = $('#otp_digit2').val();
                let otp3 = $('#otp_digit3').val();
                let otp4 = $('#otp_digit4').val();
                let otp5 = $('#otp_digit5').val();
                let otp6 = $('#otp_digit6').val();

                $.ajax({
                    url: '/login_otp_post', // your OTP_Put API
                    method: 'POST',
                    data: {
                        email: $('#loginEmail').val(),
                        password: $('#loginPassword').val(),
                        otp: otp1 + otp2 + otp3 + otp4 + otp5 + otp6
                    },
                    success: function (res) {

                        if (res.success == true) {
                            otpVerified = true;
                            $('#otpModal').modal('hide');
                            $('#otpModal').addClass('d-none');

                            // Step 3: Submit form AFTER success
                            $('#loginForm').submit();
                        } else {
                            $('#otp-error').text("Invalid OTP").show();
                        }
                    },
                    error: function (xhr) {
                        let message = 'Something went wrong';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        $('#otp-error').text(message).show();
                    }
                });
            });

        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            fetch('/user-counts')
                .then(response => response.json())
                .then(data => {

                    updateBadge('.cart-count', data.cart);
                    updateBadge('.order-count', data.orders);
                    updateBadge('.quotation-count', data.quotations);

                })
                .catch(err => console.error('Count fetch failed:', err));
        });

        function updateBadge(selector, count) {

            const badges = document.querySelectorAll(selector);

            badges.forEach(badge => {
                if (count > 0) {
                    badge.innerText = count;
                    badge.style.display = "inline-block"; // SHOW BADGE
                } else {
                    badge.innerText = ''; 
                    badge.style.display = "none"; // HIDE IF ZERO
                }

            });
        }
    </script>
