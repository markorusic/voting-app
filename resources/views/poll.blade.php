@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
	    <div class="col-md-8 col-md-offset-2">
	        <div class="panel panel-default">
	            <div class="panel-heading"> <h3> {{ $poll->title }} </h3> </div>
	            <div class="panel-body">  
	            	<h3> 
	            		@if($poll->voted)
	            			<span title="You voted from this ip adress">You voted on this poll</span>
	            		@endif
	            	</h3>

	            	@if($poll->voted)
						
						<div>
		            		<canvas id="chart-area"></canvas>
		            	</div>

		            @else
		            	<ul class="choices">
		            		@foreach($poll->choices as $choice)		            			
		            			<div class="radio">
								  <label><input type="radio" value="{{ $choice->id }}" name='choice'>
								  	{{ $choice->title }}
								  </label>
								</div>
		            		@endforeach
		            	</ul>
	            	@endif



					<br>			

					@if(!$poll->voted)		
	            		<button class="btn btn-success" id='vote' style="float: left;">Vote</button>	            	
	            	@endif
	            	<button class="btn btn-primary" id='share' 

						@if(!$poll->voted)
							style="float:right;"
						@endif

	            	>Copy link of this poll</button>
	        	</div>
	    	</div>
		</div>
	</div> 
</div>

@endsection

@section('scripts')
	
	@if($poll->voted)
		<script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js'></script>
		<script src="https://codepen.io/anon/pen/aWapBE.js"></script>

		<script type="text/javascript">
			const data = <?=$poll->choices?>;			

			window.chartColors = {
				red: 'rgb(255, 99, 132)',
				orange: 'rgb(255, 159, 64)',
				yellow: 'rgb(255, 205, 86)',
				green: 'rgb(75, 192, 192)',
				blue: 'rgb(54, 162, 235)',
				purple: 'rgb(153, 102, 255)',
				grey: 'rgb(201, 203, 207)'
			};

			const config = {
		        type: 'pie',
		        data: {
		            datasets: [{
		                data: data.map(e => e.votes),
		                backgroundColor: palette('tol', data.length).map(hex => '#' + hex),
		                label: 'Dataset 1'
		            }],
		            labels: data.map(e => e.title)
		        },
		        options: {
		            responsive: true,
		            maintainAspectRatio: false
		        }
		    };

		    $(function(){
		    	var ctx = document.getElementById("chart-area").getContext("2d");
	        	window.myPie = new Chart(ctx, config);
		    });

		</script>	
	@else
    	<script type='text/javascript' src="{{ URL::to('/') }}/js/poll.js"></script>
    @endif
@endsection