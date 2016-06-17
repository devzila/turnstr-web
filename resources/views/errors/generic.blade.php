@extends('layouts.app')
@section('content')

        <div class="container">
            <div class="content">
                <div class="title"><h3>{{ $msg }}</h3>
				</div>
				@if($previousUrl)
					Go back to <a href="{{$previousUrl}}">Turnstr</a>.
				@endif
            </div>
        </div>
		
@endsection 
