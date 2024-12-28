@extends('layouts.superAdmin')

@section('pageName', 'Prisoner Management')

@section('content')
@livewire('update-prisoner', ['prisonerId' => $prisoner->id])
@endsection