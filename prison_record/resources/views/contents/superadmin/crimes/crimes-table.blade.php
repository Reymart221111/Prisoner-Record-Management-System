@extends('layouts.superAdmin')

@section('pageName', 'Crime Lists Management')

@section('content')
@if ($adding ?? false)
    @livewire('store-crime')
@elseif($editing ?? false)
    @livewire('update-crime', [$crime->id])
@else
    @include('components.superadmin.crimes-list')
@endif

@endsection

