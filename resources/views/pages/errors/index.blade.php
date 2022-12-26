@extends('layouts.parent')

@section('error', 'Error')
@section('error-nav', 'active')

@section('main-content')

<h3>{{ $error }}</h3>
@endsection
