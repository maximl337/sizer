@extends('app')

@section('content')

        <div class="row">
            <div class="col-lg-12">

                <div class="jumbotron">
                    
                    <h1> Welcome To Sizer </h1>

                    <p>Upload your products and get a human size reference</p>                
                    
                </div>
            </div> <!-- .col-lg-12 -->
            <div class="col-lg-12 well">
                <p class="alert alert-succes">Here is a gift for installing imgur api successfully</p>
                <div class="text-center">
                    
                    <img src="{{ $image->getLink() }}" alt="" class="img img-round">
                </div>
            </div>
            
        </div>
    

@stop

@section('footer')

<script type="text/javascript">
    
    (function() {



    })();
</script>

@stop