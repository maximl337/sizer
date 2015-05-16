@extends('app')

@section('content')

    <div class="row">

        <div class="col-lg-12">
            
            <h1>Add a Silhouette</h1>
            <hr />
        </div>
        
        <div class="col-lg-12">
            
          {!! Form::open(['action' => 'SilhouetteController@store', 'files' => true]) !!}

                    <div class="form-group">
                        {!! Form::label('image_url', 'Image:') !!}    
                        {!! Form::file('image_url', ['class' => 'form-control']) !!}    
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('max_height_cm', 'Max Height Product Allowed CM:') !!}
                        {!! Form::text('max_height_cm', null, ['class' => 'form-control']) !!}    
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('max_width_cm', 'Max Width Product Allowed CM:') !!}
                        {!! Form::text('max_width_cm', null, ['class' => 'form-control']) !!}    
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('offset_height_px', 'Offset Height In Pixels:') !!}
                        {!! Form::text('offset_height_px', null, ['class' => 'form-control']) !!}    
                    </div>    
                    
                     <div class="form-group">
                        {!! Form::label('one_cm_to_pixel_ratio', 'CM to Pixel ratio:') !!}
                        {!! Form::text('one_cm_to_pixel_ratio', null, ['class' => 'form-control']) !!}    
                    </div>    

                    
                    <div class="form-group">
                        {!! Form::submit('Upload', ['class' => 'btn btn-primary form-control']) !!}    
                    </div>
                    

                {!! Form::close() !!}



        </div> <!-- /.col-lg-12 -->

    </div><!-- /.row -->

@stop