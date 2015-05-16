@extends('app')

@section('content')

    <div class="row">
        <div class="col-lg-6">
            <h1>View Silhouettes here</h1>        
        </div>
        <div class="col-lg-6">
            
            <a href="/admin/silhouettes/create" class="btn btn-success">Add Silhouette</a>
        </div>

        
    </div> <!-- /.row -->
<hr />
    <div class="row">
        <div class="col-lg-12">
            
            @foreach($silhouettes as $silhouette)
            
                <div class="row">
                    <div class="col-md-3">
                        <img style="max-width: 100px; height: auto;" src="{{ $silhouette->image_url }}">
                    </div>
                    <div class="col-md-3">
                        <p><strong>Height CM:</strong> {{ $silhouette->max_height_cm }}</p>
                        <p><strong>Width CM:</strong> {{ $silhouette->max_width_cm }}</p>
                        <p><strong>Offset PX:</strong> {{ $silhouette->offset_height_px }}</p>
                    </div>
                    <div class="col-md-3">

                        <p><a href="#" class="btn btn-primary btn-mini">Edit</a></p>
                        <p>
                            {!! Form::open(['action' => ['SilhouetteController@destroy', $silhouette->id], 'method' => 'delete']) !!}
                              {!! Form::submit('Delete', ['class'=>'btn btn-danger btn-mini']) !!}
                            {!! Form::close() !!}
                        </p>
                    </div>
                    <div class="col-md-3">
                        
                    </div>


                </div> <!-- /.row -->
        
                <hr />
            @endforeach

        </div>
    </div>
    
    {!! $silhouettes->render() !!}
    
@stop