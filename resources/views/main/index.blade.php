@extends('app')

@section('content')

        <div class="row">
            <div class="col-lg-12">

                <div class="jumbotron">
                    
                    <h1> Welcome To Sizer </h1>

                    <p>Upload your products and get a human size reference</p>                
                    
                </div>
            </div> <!-- .col-lg-12 -->
            
            <div class="col-lg-12">
                
                {!! Form::open(['url' => 'uploads']) !!}

                    <div class="form-group">
                        {!! Form::label('raw_image_url', 'Image URL:') !!}    

                        {!! Form::text('raw_image_url', null, ['class' => 'form-control']) !!}    
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('product_width_cm', 'Product Width:') !!}
                        {!! Form::text('product_width_cm', null, ['class' => 'form-control']) !!}    
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('product_height_cm', 'Product Height:') !!}
                        {!! Form::text('product_height_cm', null, ['class' => 'form-control']) !!}    
                    </div>
                    
                        {!! Form::hidden('ip', $_SERVER['REMOTE_ADDR'], ['class' => 'form-control']) !!}    
                    
                    <div class="form-group">
                        {!! Form::submit('Upload', ['class' => 'btn btn-primary form-control']) !!}    
                    </div>
                    

                {!! Form::close() !!}

            </div>

        </div> <!-- /.row -->
    

@stop

@section('footer')

<script type="text/javascript">
    
    (function() {



    })();
</script>

@stop