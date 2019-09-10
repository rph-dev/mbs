@extends('layouts.theme.elegant.layout')

@section('title', 'Division')

@section('page_name')
    Division
@endsection

@section('breadcrumb_top')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">company.</a></li>
        <li class="breadcrumb-item"><a href="{{ route('division.index') }}">Divisions</a></li>
        <li class="breadcrumb-item active">{{ $division->name }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="m-b-10">
                    <a href="{!! route('division.index') !!}" class="btn btn-success btn-rounded"><i class="ti-control-backward"></i> Back</a>
                </div>
                <hr>
                <h4 class="card-title">{{ $division->name }}</h4>
                @include('company.departments.table_data')
            </div>
        </div>
    </div>
</div>
@endsection