@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ URL::to('/') }}/css/dashboard.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">                    
                    <nav class='dashboard-nav'>                        
                        <a href="#" class='active'>New poll</a>                        
                        <a href="#">My polls</a>                        
                    </nav>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    
                    <div class="row new-poll">                    
                        <div class="col-md-8 col-md-offset-2">
                            <h3 style="margin-bottom: 20px;cursor: pointer;user-select:none;">Add new poll</h3>
                            <form>
                                <div class="form-group">                            
                                    <input placeholder="Poll title" name='title' type="text" class="form-control" id="poll-title">
                                    <hr>                                                        
                                </div>
                                <div class="form-group">
                                    <h4>Choices</h4>
                                </div>

                                <div class="choices">
                                    <div class="form-group">                            
                                        <input placeholder="Enter choice" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input placeholder="Enter choice" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input placeholder="Enter choice" type="text" class="form-control">
                                    </div>
                                </div>
                                
                                <div style="display: none;" class="form-group">
                                    <button class="btn btn-primary new-choice">Add new choice field</button>
                                </div>

                                <div class="form-group">                                                                    
                                    <button type="submit" class="btn btn-success">Add new poll</button>
                                </div>                                                                                       
                            </form>
                        </div>
                    </div>                    
                    


                    <div class="my-polls row" style="display: none;">
                        <div class="col-md-8 col-md-offset-2">
                            <h3>My polls</h3>                            
                            <hr>
                            <ul class="poll-list list-group">
                                @foreach($mypolls as $poll)
                                    <li class='list-group-item'>
                                        <h4>
                                            <a href="{{ url('polls/'.$poll->id) }}">
                                                {{ $poll->title }}
                                            </a>
                                            <a  data-id="{{ $poll->id }}" 
                                                href="#" 
                                                class="btn btn-danger btn-xs delete-poll"
                                            >
                                                X
                                            </a>
                                        </h4>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script type='text/javascript' src="{{ URL::to('/') }}/js/dashboard.js"></script>
@endsection