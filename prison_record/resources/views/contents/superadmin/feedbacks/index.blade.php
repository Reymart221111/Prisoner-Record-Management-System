@extends('layouts.superAdmin')

@section('pageName', 'Feedback Details')

@section('content')
@if ($viewing ?? false)
@livewire('view-feed-back-details', ['feedback' => $feedback])
@else
{{-- Display the feedback submission list --}}
@livewire('view-feedback-submission')
@endif
@endsection