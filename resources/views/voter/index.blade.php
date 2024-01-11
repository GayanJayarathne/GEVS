@section('title')
    Voter
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/Leads.css') }}">
    <style>

    </style>
@endsection

@extends('voter.layout.master')

@section('container')
    <div id="app"></div>
@endsection

@section('scripts')
    <script>
        var authUser = @json(Auth::user());
    </script>
    <script src="{{ asset('js/views/Voter.js') }}"></script>
@endsection
