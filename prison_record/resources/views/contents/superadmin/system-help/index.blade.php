@extends('layouts.superAdmin')

@section('pageName', 'System Help')
    
@section('content')
@if ($adding ?? false)
   @livewire('store-system-help')
@elseif($viewing ?? false)
   @livewire('show-system-help', ['helpId' => $help->id])
@elseif($editing ?? false)
   @livewire('update-system-help', ['helpId' => $help->id])
@else
   @livewire('read-system-help')
@endif
@endsection