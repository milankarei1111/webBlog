@extends('adminlte.master')

@section('breadcrumb')
  <section class="content-header">
    <h1>主控台<small>後台網站管理主控台</small></h1>
    {{ Breadcrumbs::render('home') }}
  </section>
@endsection
@section('content')
    <p>{{ __('Logged in') }}</p>
@endsection
