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
                
                {!! Form::open(['url' => 'uploads', 'files' => true]) !!}

                     <div class="form-group">
                        {!! Form::label('image', 'Image:') !!}    
                        {!! Form::file('image', ['class' => 'form-control']) !!}     
                    </div>

                    <div class="form-group">
                        <h4 class="text-center">OR</h4>
                    </div>

                    <div class="form-group">
                        {!! Form::label('raw_image_url', 'Image URL:') !!}    
                        {!! Form::text('raw_image_url', null, ['class' => 'form-control', 'placeholder' => 'eg: http://www.example.com/your_image.png']) !!}    
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('units', 'Unit of measurement:') !!}
                        {!! Form::select('units', ['cm' => 'centimeters', 'in' => 'inches'], 'cm', ['class' => 'form-control', 'required' => 'required']) !!}    
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('product_height_cm', 'Product Height:') !!}
                        {!! Form::text('product_height_cm', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'eg: 21.93']) !!}    
                    </div>

                    <div class="form-group">
                        {!! Form::label('product_width_cm', 'Product Width:') !!}
                        {!! Form::text('product_width_cm', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'eg: 10.20']) !!}    
                    </div>
                    
                        {!! Form::hidden('ip', $_SERVER['REMOTE_ADDR'], ['class' => 'form-control', 'required' => 'required']) !!}    
                    
                    <div class="form-group">
                        {!! Form::submit('Upload', ['class' => 'btn btn-primary form-control']) !!}    
                    </div>
                    

                {!! Form::close() !!}

            </div> <!-- /.col-lg-12 -->

             <div class="col-lg-12">
            
                @if($errors->any())

                    @foreach($errors->all() as $error)

                        <p class="alert alert-danger text-center"> {{ $error }} </p>

                    @endforeach

                @endif

            </div>

        </div> <!-- /.row -->
    

@stop

@section('footer')

<script type="text/javascript">
    
    (function() {



    })();
</script>

@stop