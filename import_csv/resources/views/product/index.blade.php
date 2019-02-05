@extends('layouts.base')

@section('styles')
    <link href="{{ asset('/css/product/index.css') }}" rel="stylesheet">
@endsection

@section('content')
    <products-list></products-list>
@endsection

@section('scripts')
    <script src="{{ asset('/js/product/index.js') }}"></script>
@endsection