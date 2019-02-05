@extends('layouts.base')

@section('styles')
    <link href="{{ asset('/css/file/statistics.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="file-statistics">
        <div class="container">
            <h2>Statystyki</h2>
            <br>
            @if ($file) 
                <p>Data ostatniego importu: {{ $file->created_at }}</p>
                <p>Ilości zaimportowanych rekordów: {{ $imported_records }}</p>
            @endif
        </div>
    </section>
@endsection