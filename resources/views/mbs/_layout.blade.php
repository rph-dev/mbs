@extends('layouts.app')

@push('css')
    <style>
        ul.scroll {
            height: 1100px;
            width: auto;
            overflow: auto;
        }
        ul.message-scroll {
            height: 650px;
            width: auto;
            overflow: auto;
        }
        #app-message {
            font-size: medium;
        }
        .list-group-item {
            padding: 6px;
        }
    </style>
@endpush

@section('content')
    <div id="app-message" class="message-app mb-4">
        <nav>
            @if(request()->is('mbs'))
                @include('mbs._menu')
            @else
                @include('mbs._menu_custom_page')
            @endif
        </nav>
        <main class="inbox">
            @yield('mbs_filter')

            <div class="row">
                <div class="col-md-12">
                    @yield('mbs_content')
                </div>
            </div>
        </main>
    </div>
@endsection

