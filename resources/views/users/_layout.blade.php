@extends('layouts.app')

@push('css')

@endpush

@section('content')
    <div class="message-app mb-4">
        <nav>
            <a class="btn btn-success btn-block" href="/company/member/create">New Member</a>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="/company/member"><i class="fa fa-inbox"></i> ทั้งหมด</a>
                </li>
                @foreach($departments as $key => $department)
                    <li class="nav-item">
                        <a class="nav-link" href="/company/department/{{ $key }}"><i class="fa fa-inbox"></i> {{ $department }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
        <main class="inbox">
            @yield('user_content')
        </main>
    </div>
@endsection
