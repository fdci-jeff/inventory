<!-- Dropezone CSS -->
<link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
<!-- CoreUI CSS -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}" crossorigin="anonymous">
<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

@yield('css')

@livewireStyles

@stack('page_css')

<style>
    div.dataTables_wrapper div.dataTables_length select {
        width: 65px;
        display: inline-block;
    }
</style>