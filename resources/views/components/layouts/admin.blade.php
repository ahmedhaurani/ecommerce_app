<!doctype html>
<html
class="light-style layout-navbar-fixed layout-menu-fixed"
defaultTheme="1"
data-theme="theme-default"
data-assets-path="../../assets/"
data-template="vertical-menu-template-no-customizer-starter">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?IBM+Plex+Sans+Arabic,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
    />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('style/assets/vendor/libs/quill/editor.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/vendor/libs/quill/katex.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/vendor/fonts/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/vendor/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/vendor/css/theme-semi-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="shortcut icon" href="{{ asset('style/images/favicon.png') }}" />

    <link rel="stylesheet" href="{{ asset('css/wysiwyg.css') }}">
    <link rel="stylesheet" href="{{ asset('css/highlight.min.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('style/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('style/assets/js/config.js') }}"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
            @livewireStyles()

            <style>
/* Tree structure */
.tree {
    position: relative;
    margin-left: 20px;
    padding: 0;
    list-style: none;
}

.tree-item {
    position: relative;
    margin-left: 20px;
    padding-left: 15px;
    border-left: 2px solid #ccc;
}

.tree-item:last-child {
    border-left: none;
}

.tree-item .category-info {
    position: relative;
}

.tree-item .category-info:before {
    content: '';
    position: absolute;
    top: 12px;
    left: -15px;
    width: 15px;
    height: 2px;
    background-color: #ccc;
}

.tree-item .tree-item {
    margin-left: 0;
    padding-left: 30px;
    border-left-color: #007bff;
}
                </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @livewire('partials.admin.sidebar')
            <div class="layout-page">
                @livewire('partials.admin.navbar')
                <div class="content-wrapper">
                    <main>
                        {{ $slot }}
                    </main>
                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-fluid d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                ©
                                <script>
                                    document.write(new Date().getFullYear());
                                </script><a href="https://pixinvent.com" target="_blank" class="footer-link fw-semibold">Jeeran</a>
                                , made with ❤️dd
                            </div>
                            <div></div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('style/vendors/base/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('style/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('style/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('style/js/off-canvas.js') }}"></script>
    <script src="{{ asset('style/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('style/js/template.js') }}"></script>
    <script src="{{ asset('style/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('style/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('style/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('style/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('style/assets/assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>

    <script src="{{ asset('style/js/main.js') }}"></script>
    <script src="{{asset('style/assets/vendor/libs/quill/katex.js')}}"></script>
    <script src="{{asset('style/assets/vendor/libs/quill/quill.js')}}"></script>

    @livewireStyles
    @livewireScripts

    <!-- Custom Scripts -->
    @stack('scripts')
</body>

</html>
