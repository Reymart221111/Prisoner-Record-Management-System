@extends('layouts.superAdmin')

@section('pageName', 'Prisoner Medical Record List')

@section('content')
@if ($viewingPrisonerRecord ?? false)
    @livewire('read-prisoner-medical-record-list', ['prisonerId' => $prisoner->id])
@elseif($adding ?? false)
    @livewire('store-medical-record', ['prisonerId' => $prisoner->id])
@elseif($viewing ?? false)
    @livewire('view-medical-record', ['prisonerMedicalRecordId' => $prisonerMedicalRecord->id])
@elseif($editing ?? false)
    @livewire('update-prisoner-medical-record', ['prisonerMedicalRecordId' => $prisonerMedicalRecord->id])
@else
    @livewire('read-prisoner-medical-records')
@endif
@endsection