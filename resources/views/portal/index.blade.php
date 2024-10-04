@extends('layout.app');
@section('content')
    @extends('partials.app')

    @section('main')
    <div class="container mx-auto">
        <div class="section">
            <div class="col-span-6">
                @livewire('api-key', ['user' => Session::get('user')])
            </div>
        </div>

        <div class="section">
            <h2 class="text-3xl">Your Templates</h2>
            <div class="divider"></div>
            <div class="flex flex-col">

            </div>
        </div>
       <div class="section">
            <h2 class="text-1xl">Upload Template</h2>
            <div class="divider"></div>
            <div class="flex flex-col">
                @livewire('upload-template', ['user' => Session::get('user')])
            </div>
        </div>
    </div>
    @endsection
@endsection