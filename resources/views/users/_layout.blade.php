@extends('layouts.app')

@push('css')

@endpush

@section('content')
    <div class="email-app mb-4">
        <nav>
            <a class="btn btn-success btn-block" href="/member/create">New Member</a>
            <ul class="nav">
                @foreach($departments as $key => $department)
                    <li class="nav-item">
                        <a class="nav-link" href="/member/department/{{ $key }}"><i class="fa fa-inbox"></i> {{ $department }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
        <main class="inbox">
            @yield('user_content')
        </main>
    </div>
@endsection
