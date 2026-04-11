<!DOCTYPE html>
<html lang="en">
<head>
    @include ('plus.head')
</head>
<body>
    @include('plus.navbar')
    <section id="title">
        <div class="container text-center py-5 fade-in-up">
            <span class="badge text-white mb-2" style="background-color: #950101; font-size:large;">Shop</span>
            <h2 class="fw-bold">Welcome! Come shop with us!</h2>
            <p class="mt-3">
                Explore our wide range of quality products and find what you need to enhance your experience with us.
            </p>
        </div>
    </section>
    <section class="container text-center fade-in-up">
        <ul class="nav nav-underline justify-content-center flex-nowrap overflow-x-auto pb-2" id="servicesNav">
            <li class="nav-item flex-shrink-0">
                <a class="nav-link active" aria-current="page" href="#bullet-proofing" data-bs-toggle="tab">
                    <i class="fas fa-shield-alt me-1 me-md-2"></i>
                    <span class="d-none d-md-inline">Bullet</span> Proofing
                </a>
            </li>
            <li class="nav-item flex-shrink-0">
                <a class="nav-link" href="#glass-manufacturing" data-bs-toggle="tab">
                    <i class="fas fa-industry me-1 me-md-2"></i>
                    <span class="d-none d-md-inline">Glass</span> Manufacturing
                </a>
            </li>
            <li class="nav-item flex-shrink-0">
                <a class="nav-link" href="#glass-processing" data-bs-toggle="tab">
                    <i class="fas fa-cut me-1 me-md-2"></i>
                    <span class="d-none d-md-inline">Glass</span> Processing
                </a>
            </li>
            <li class="nav-item flex-shrink-0">
                <a class="nav-link" href="#aluminum-manufacturing" data-bs-toggle="tab">
                    <i class="fas fa-cogs me-1 me-md-2"></i>
                    <span class="d-none d-md-inline">Aluminum</span> Manufacturing
                </a>
            </li>
            <li class="nav-item flex-shrink-0">
                <a class="nav-link" href="#other-products" data-bs-toggle="tab">
                    <i class="fa-solid fa-box-open me-1 me-md-2"></i>
                    Other Products
                </a>
            </li>
        </ul>
        <div class="tab-content" id="servicesTabContent">
            <div class="tab-pane fade show active" id="bullet-proofing">
                @include('plus.add_bulletproof')
            </div>
            <div class="tab-pane fade" id="glass-manufacturing">
                @include('plus.add_glassmfg')
            </div>
            <div class="tab-pane fade" id="glass-processing">
                @include('plus.add_glasspro')
            </div>
            <div class="tab-pane fade" id="aluminum-manufacturing">
                @include('plus.add_alummfg')
            </div>
            <div class="tab-pane fade" id="other-products">
                @include('plus.add_otherprod')
            </div>
        </div>
    </section>
    <style>
        .nav-underline .nav-link {
            font-weight: 500;
            color: #495057;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border-bottom: 2px solid #dee2e6;
        }
        .nav-underline .nav-link:hover,
        .nav-underline .nav-link:focus {
            color: #920B12;
            transform: translateY(-2px);
        }
        .nav-underline .nav-link.active {
            color: #841617;
            border-bottom: 3px solid #841617;
        }
        .fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .tab-content>.tab-pane {
            transition: opacity 0.3s ease;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabElms = document.querySelectorAll('#servicesNav a[data-bs-toggle="tab"]');
            tabElms.forEach(tabEl => {
                tabEl.addEventListener('shown.bs.tab', function(event) {
                    history.pushState(null, null, event.target.getAttribute('href'));
                });
            });
            if (window.location.hash) {
                const activeTab = document.querySelector(`#servicesNav a[href="${window.location.hash}"]`);
                if (activeTab) {
                    const tab = new bootstrap.Tab(activeTab);
                    tab.show();
                }
            }
            window.addEventListener('popstate', function() {
                const hash = window.location.hash;
                if (hash) {
                    const correspondingTab = document.querySelector(`#servicesNav a[href="${hash}"]`);
                    if (correspondingTab) {
                        const tab = new bootstrap.Tab(correspondingTab);
                        tab.show();
                    }
                }
            });
        });
    </script>
    @include('plus.chatbot')
    @include ('plus.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>