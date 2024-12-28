@extends('layouts.superAdmin')

@section('pageName', 'Prisoner Crimes List')

@section('content')
@if ($viewing ?? false)
    @livewire('read-prisoner-crime-list', ['prisonerID' => $prisoner->id])
@elseif($adding ?? false)
    @livewire('prisoner-attach-crime', ['prisonerID' => $prisoner->id])
@elseif($editting ?? false)
    @livewire('prisoner-update-crime', [$prisonerCrimeId])
@else
    @livewire('read-prisoner-crimes')
@endif
@endsection