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

document.addEventListener('DOMContentLoaded', function() {
    const modalImage = document.getElementById('modalPreviewImage');
    const zoomInBtn = document.querySelector('.zoom-in-btn');
    const zoomOutBtn = document.querySelector('.zoom-out-btn');
    const zoomResetBtn = document.querySelector('.zoom-reset-btn');

    let currentScale = 1;
    const zoomLevels = [1, 1.5, 2, 2.5, 3];
    let currentZoomIndex = 0;

    // Set initial transform origin
    modalImage.style.transformOrigin = 'center center';

    // Click to cycle through zoom levels
    modalImage.addEventListener('click', function(e) {
        // Calculate click position relative to image
        const rect = this.getBoundingClientRect();
        const x = (e.clientX - rect.left) / rect.width;
        const y = (e.clientY - rect.top) / rect.height;

        // Set transform origin to click position
        this.style.transformOrigin = `${x * 100}% ${y * 100}%`;

        // Cycle to next zoom level
        currentZoomIndex = (currentZoomIndex + 1) % zoomLevels.length;
        currentScale = zoomLevels[currentZoomIndex];
        applyZoom();
    });

    // Zoom in button
    zoomInBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (currentZoomIndex < zoomLevels.length - 1) {
            currentZoomIndex++;
            currentScale = zoomLevels[currentZoomIndex];
            applyZoom();
        }
    });

    // Zoom out button
    zoomOutBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (currentZoomIndex > 0) {
            currentZoomIndex--;
            currentScale = zoomLevels[currentZoomIndex];
            applyZoom();
        }
    });

    // Reset zoom
    zoomResetBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        currentZoomIndex = 0;
        currentScale = 1;
        modalImage.style.transformOrigin = 'center center';
        applyZoom();
    });

    // Apply the current zoom
    function applyZoom() {
        modalImage.style.transform = `scale(${currentScale})`;
        modalImage.style.cursor = currentScale > 1 ? 'zoom-out' : 'zoom-in';
    }

    // Panning functionality when zoomed
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

    // Reset on modal close
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