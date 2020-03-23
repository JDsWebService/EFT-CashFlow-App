<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- Header --}}
    @include('partials.global._head')

    <style type="text/css">
        @yield('stylesheets')
    </style>
</head>
<body>
    <div id="app">
        @include('partials.global._navbar')

        {{-- Authentication Debug Component --}}
        {{-- @component('components.debug.auth')
        @endcomponent --}}

        <main class="py-4">
            
            <div class="container">
                {{-- Flash Messages --}}
                @include('partials.global._messages')
                
                @yield('content')
            </div>
            
            {{-- Footer --}}
            @include('partials.global._footer')
        </main>
    </div>

    <!-- Scripts -->
    @include('partials.global._scripts')
    <script type="text/javascript">
        @yield('scripts')
    </script>
</body>
</html>
