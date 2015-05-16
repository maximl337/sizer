@extends('app')

@section('content')

    <div class="row">
        
        <div class="col-lg-12">
            
            <ul>
                
            </ul>

            <h1>Final Image</h1>

            <img src="{{ $output->image_url }}">

        </div>
    </div>

@stop