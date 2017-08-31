@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="text-align: center">
            <h1 style="padding-top: 50px;">Wellcome to poll app</h1>  

            <br><br>

            <a href="{{ route('polls') }}" class="btn btn-primary">Checkout existing polls</a>
            
            
            <a href="{{ route('dashboard') }}" class="btn btn-success">Create new poll</a>
            

        </div>
    </div>
</div>
@endsection
