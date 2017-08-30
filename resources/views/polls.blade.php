@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">All polls</div>

                <div class="panel-body">                                          
                    @forelse($polls as $poll)

                        <div class='container'>
                            <h4>
                                <a href="{{ url('polls/'.$poll->id) }}">
                                    {{ $poll->title }}
                                </a>
                            </h4>
                        </div>
                    
                    @empty
                        <h3 style="text-align: center;">No polls atm :(</h3>                    
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
