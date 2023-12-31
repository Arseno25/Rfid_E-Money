<!DOCTYPE html>
{{-- <html lang="{{ $page->language ?? 'en' }}"> --}}

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="referrer" content="always">
    {{-- <link rel="canonical" href="{{ $page->getUrl() }}"> --}}

    {{-- <meta name="description" content="{{ $paage->description }}"> --}}

    <link rel="stylesheet" href="{{ asset('build/assets/app-ee148ebf.css') }}">

    <script type="module" src="{{ asset('build/assets/app-154cb3de.js') }}"></script>

    <title>{{config()->get('app.name')}}</title>

    @vite('resources/css/app.css')
    @vite('resources/css/app.js')
</head>

<body>
    <div x-data="{ cartOpen: false, isOpen: false }">
        @include('_layouts._navbar')

        @include('_layouts._cart')

        <main class="my-8">
            @yield('body')
        </main>

        @include('_layouts._footer')
    </div>
</body>

<script>
    import Alpine from "alpinejs";

    window.Alpine = Alpine;

    Alpine.start();
</script>

</html>
