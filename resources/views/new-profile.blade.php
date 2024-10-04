@extends('layout.app');
@section('content')
    @extends('partials.app')

    @section('main')
      @livewire('profile-form', ['id' => Session::get('user')])
    @endsection
@endsection