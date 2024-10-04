@extends('layout.app')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center mt-4">
        <div class="col-md-6" style="position: relative">
                <!-- Profile -->
                @if(!empty($data))
                <div class="flex items-center gap-x-3">
                    <div class="shrink-0">
                        <img class="shrink-0 size-16 rounded-full" src="/storage/{{$data->profilePicture}}" alt="{{ ucwords($data->name) }}">
                    </div>
                
                    <div class="grow">
                        <h1 class="text-lg font-medium text-gray-800 dark:text-neutral-200">
                            {{ ucwords($data->name) }}
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                            {{ ucwords($data->title) }}
                        </p>
                        @if($data->company)
                            <p class="text-md  text-gray-600 dark:text-neutral-400">
                                <strong>{{ucwords($data->company)}}</strong>
                            </p>
                        @endif
                    </div>
                </div>
                <!-- End Profile -->
                
                <!-- Contact Information -->
                <div class="mt-5">
                    <ul class="flex flex-col gap-y-3">
                        <li class="flex items-center gap-x-2.5">
                           <i class="fa fa-envelope"></i>
                            <a class="text-[13px] text-gray-500 underline hover:text-gray-800 hover:decoration-2 focus:outline-none focus:decoration-2 dark:text-neutral-500 dark:hover:text-neutral-400" href="mailto:{{ $data->email }}">
                                {{ $data->email }}
                            </a> 
                            
                        </li>

                        <li class="flex items-center gap-x-2.5">
                            <i class="fa fa-phone"></i>
                            <a class="text-[13px] text-gray-500 hover:text-gray-800 hover:decoration-1 focus:outline-none focus:decoration-1" href="tel:{{$data->phone}}">{{$data->phone}}</a>
                        </li>
                
                        <li class="flex items-center gap-x-2.5">
                            <i class="fa fa-map-marker"></i>
                            <span class="text-[13px] text-gray-500 dark:text-neutral-500">
                                {{ ucwords($data->country) }} |  {{ ucwords($data->state) }}, {{ucwords($data->city)}}
                            </span>
                        </li>
                        @if($data->website)
                        <li class="flex items-center gap-x-2.5">
                            <i class="fa fa-globe"></i>
                            <a class="text-[13px] hover:text-gray-800 underline hover:decoration-2 text-gray-500 dark:text-neutral-500" href="{{$data->website}}" target="_blank">
                                {{ $data->website }}
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
                <!-- End Contact Information -->
                
                <!-- About -->
                <div class="mt-8">
                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                        {{$data->bio}}
                    </p>
                
                </div>
                
                <div class="qr-container">
                    {!! QrCode::size(100)->generate(env('APP_URL').'/'.$username) !!}
                </div>

                <div class="mt-5 flex flex-col gap-y-3">
                    @if($data->facebook)
                    <li class="flex items-center gap-x-2.5">
                        <i class="fab fa-facebook"></i>
                        <a class="text-[13px] text-gray-500 underline hover:text-gray-800 hover:decoration-2 focus:outline-none focus:decoration-2 dark:text-neutral-500 dark:hover:text-neutral-400" href="{{$data->facebook}}" target="_blank">
                           {{$data->facebook}}
                        </a>
                    </li>
                    @endif
                    @if($data->instagram)
                    <li class="flex items-center gap-x-2.5">
                        <i class="fab fa-instagram"></i>
                        <a class="text-[13px] text-gray-500 underline hover:text-gray-800 hover:decoration-2 focus:outline-none focus:decoration-2 dark:text-neutral-500 dark:hover:text-neutral-400" href="{{$data->instagram}}" target="_blank">
                           {{$data->instagram}}
                        </a>
                    </li>
                    @endif
                    @if($data->linkedin)
                    <li class="flex items-center gap-x-2.5">
                        <i class="fab fa-linkedin"></i>
                        <a class="text-[13px] text-gray-500 underline hover:text-gray-800 hover:decoration-2 focus:outline-none focus:decoration-2 dark:text-neutral-500 dark:hover:text-neutral-400" href="{{$data->linkedin}}" target="_blank">
                           {{$data->linkedin}}
                        </a>
                    </li>
                    @endif
                    @if($data->twitter)
                    <li class="flex items-center gap-x-2.5">
                        <i class="fab fa-twitter"></i>
                        <a class="text-[13px] text-gray-500 underline hover:text-gray-800 hover:decoration-2 focus:outline-none focus:decoration-2 dark:text-neutral-500 dark:hover:text-neutral-400" href="{{$data->twitter}}" target="_blank">
                           {{$data->twitter}}
                        </a>
                    </li>
                    @endif
                    
                    @if($data->github)
                    <li class="flex items-center gap-x-2.5">
                        <i class="fab fa-github"></i>
                        <a class="text-[13px] text-gray-500 underline hover:text-gray-800 hover:decoration-2 focus:outline-none focus:decoration-2 dark:text-neutral-500 dark:hover:text-neutral-400" href="{{$data->github}}" target="_blank">
                           {{$data->github}}
                        </a>
                    </li>
                    @endif
                    
                
                </div>
                <!-- End Social Media -->
                @else
                <div>Nothing to show</div>
                @endif
                
    </div>
</div>
@endsection