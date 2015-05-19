@extends('app')

@section('content')

    <div class="row">
        
        <div class="col-lg-12">
            
        
            @if(count($output))

                <h1>Final Image</h1>

                <img src="{{ $output->image_url }}">

            @endif
        </div>

        <div class="col-lg-12">
            
            @if($errors->any())

                @foreach($errors->all() as $error)

                    <p class="alert alert-danger text-center"> {{ $error }} </p>

                @endforeach

            @endif
        </div>
    </div>

@stop