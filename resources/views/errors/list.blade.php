@if ($errors->any())
    <div class="alert alert-danger">
        <ol>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ol>
    </div>
@elseif (session()->get('success'))
    <div class="alert alert-success">{{ session()->get('success') }}</div>
@elseif (session()->get('error'))
    <div class="alert alert-danger">{{ session()->get('error') }}</div>
@endif
