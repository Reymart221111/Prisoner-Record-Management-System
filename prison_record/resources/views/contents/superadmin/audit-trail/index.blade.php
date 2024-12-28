@extends('layouts.superAdmin')

@section('pageName', 'Audit Logs')

@section('content')
@include('contents.superadmin.audit-trail.includes.audit-table')
@endsection

