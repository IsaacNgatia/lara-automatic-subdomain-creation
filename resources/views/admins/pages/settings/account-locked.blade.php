@extends('components.layouts.auth')

@section('styles')
    <link rel="stylesheet" href="{{ asset('build/assets/libs/glightbox/css/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/libs/gridjs/theme/mermaid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/libs/apexcharts/apexcharts.css') }}">
@endsection

@section('content')
    <livewire:admins.settings.account.account-locked />
@endsection

@section('scripts')
    <script src="{{ asset('build/assets/libs/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('build/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('build/assets/apexcharts-stock-prices.js') }}"></script>

    <script src="{{ asset('build/assets/libs/gridjs/gridjs.umd.js') }}"></script>
    <script src="{{ asset('build/assets/libs/chart.js/chart.min.js') }}"></script>

    <script src="{{ asset('assets/js/grid.js') }}"></script>
    <script src="{{ asset('assets/js/custom/user-profile/transactions-chart.js') }}"></script>
    <script src="{{ asset('assets/js/profile.js') }}"></script>
    <script src="{{ asset('assets/js/apexcharts-area.js') }}"></script>
    <script src="{{ asset('build/assets/chat.js') }}"></script>
@endsection
