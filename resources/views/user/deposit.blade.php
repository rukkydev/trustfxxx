@extends('layouts.dash')

@section('content')

@php
    $headerType = 'back';
    $pageTitle = 'Deposit Funds';
@endphp

<livewire:user.deposit />

@endsection
