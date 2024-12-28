@extends('layouts.superAdmin')

@section('pageName')
@if (Auth::user()->role === 'superadmin')
Super Admin Dashboard
@elseif(Auth::user()->role === 'admin')
Admin Dashboard
@elseif(Auth::user()->role === 'employee')
Employee Dashboard
@endif

@endsection

@section('content')
<!-- Improved Stats Cards -->
@livewire('view-dashboard')

@endsection