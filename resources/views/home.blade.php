@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('upload')
        </div>

        <div class="row">
            @include('myfiles')
        </div>
    </div>

@endsection
