<main class="app-main px-4">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">

        <section class="app-content">
            <div class="mt-4">

                <ul class="nav nav-tabs border-0 mb-3" id="adminTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active text-muted" id="tab-0" href="#home" data-bs-toggle="tab" role="tab">Home</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="tab-1" href="#bullet" data-bs-toggle="tab" role="tab">Bullet Proofing</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="tab-2" href="#glass_mfg" data-bs-toggle="tab" role="tab">Glass MFG</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="tab-3" href="#aluminum_mfg" data-bs-toggle="tab" role="tab">Aluminum MFG</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="tab-4" href="#glass_pro" data-bs-toggle="tab" role="tab">Glass Processing</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="tab-5" href="#about" data-bs-toggle="tab" role="tab">About</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="tab-6" href="#contact" data-bs-toggle="tab" role="tab">Contact</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="tab-7" href="#navbar" data-bs-toggle="tab" role="tab">Navbar</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="tab-8" href="#welcome" data-bs-toggle="tab" role="tab">Welcome</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-muted" id="tab-9" href="#all" data-bs-toggle="tab" role="tab">All</a>
                    </li>
                </ul>

                <div class="tab-content" id="adminTabContent">
                    <div class="tab-pane show active" id="home" role="tabpanel" aria-labelledby="tab-0" data-url="{{ route('admin-controller.loadTab', 'home') }}"></div>
                    <div class="tab-pane" id="bullet" role="tabpanel" aria-labelledby="tab-1" data-url="{{ route('admin-controller.loadTab', 'bullet') }}"></div>
                    <div class="tab-pane" id="glass_mfg" role="tabpanel" aria-labelledby="tab-2" data-url="{{ route('admin-controller.loadTab', 'glass_mfg') }}"></div>
                    <div class="tab-pane" id="aluminum_mfg" role="tabpanel" aria-labelledby="tab-3" data-url="{{ route('admin-controller.loadTab', 'aluminum_mfg') }}"></div>
                    <div class="tab-pane" id="glass_pro" role="tabpanel" aria-labelledby="tab-4" data-url="{{ route('admin-controller.loadTab', 'glass_pro') }}"></div>
                    <div class="tab-pane" id="about" role="tabpanel" aria-labelledby="tab-5" data-url="{{ route('admin-controller.loadTab', 'about') }}"></div>
                    <div class="tab-pane" id="contact" role="tabpanel" aria-labelledby="tab-6" data-url="{{ route('admin-controller.loadTab', 'contact') }}"></div>
                    <div class="tab-pane" id="navbar" role="tabpanel" aria-labelledby="tab-7" data-url="{{ route('admin-controller.loadTab', 'navbar') }}"></div>
                    <div class="tab-pane" id="welcome" role="tabpanel" aria-labelledby="tab-8" data-url="{{ route('admin-controller.loadTab', 'welcome') }}"></div>
                    <div class="tab-pane" id="all" role="tabpanel" aria-labelledby="tab-9" data-url="{{ route('admin-controller.loadTab', 'all') }}"></div>
                </div>
            </div>
        </section>

        {{-- <script>
            $(function() {
                $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                    const targetPaneId = $(e.target).attr('href'); // e.g. "#home"
                    const $pane = $(targetPaneId);
                    const url = $pane.data('url');

                    if (url && !$pane.data('loaded')) {
                        $pane.html('<div class="text-center p-5 text-muted">Loading...</div>');
                        $.get(url, function(data) {
                            $pane.html(data);
                            $pane.data('loaded', true); // mark as loaded
                        });
                    }
                });

                // 🔥 Auto-trigger the active tab on initial load
                const $activeTab = $('#adminTab a.nav-link.active');
                if ($activeTab.length) {
                    $activeTab.trigger('shown.bs.tab');
                }
            });

        @if(session()->has('active_tab'))
            $(document).ready(function () {
                $({{ session('active_tab') }}).tab('show'); // replace with your desired tab ID
            });
        @endif
        </script> --}}

    </div>
</main>