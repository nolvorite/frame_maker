@php

	$imageUrl = request()->get('url') === null ? env('DEFAULT_IMG') : request()->get('url');
	$duration = request()->get('duration') === null ? 10000 : request()->get('duration');



	$startingWidth = request()->get('starting_width') === null ? '60%' : request()->get('starting_width').'%';
	$endingWidth = request()->get('ending_width') === null ? '90%' : request()->get('ending_width').'%';



	$startingHeight = request()->get('starting_height') === null ? '70%' : request()->get('starting_height').'%';
	$endingHeight = request()->get('ending_height') === null ? '100%' : request()->get('ending_height').'%';

	$pauseBeforeStarting = request()->get('pause_before_starting') === null ? '1000' : request()->get('pause_before_starting');



	$basis = request()->get('basis') !== null ? request()->get('basis') : 'height';

	switch($type){
		case "clip":

			if(@$clip->custom_json_data->imageUrl !== null){
				$imageUrl = @$clip->custom_json_data->imageUrl;
			}

			if(@$clip->custom_json_data->startingWidth !== null){
				$startingWidth = @$clip->custom_json_data->startingWidth;
			}

			if(@$clip->custom_json_data->endingWidth !== null){
				$endingWidth = @$clip->custom_json_data->endingWidth;
			}

			if(@$clip->custom_json_data->startingHeight !== null){
				$startingHeight = @$clip->custom_json_data->startingHeight;
			}

			if(@$clip->custom_json_data->endingHeight !== null){
				$endingHeight = @$clip->custom_json_data->endingHeight;
			}

			if(@$clip->custom_json_data->pauseBeforeStarting !== null){
				$endingHeight = @$clip->custom_json_data->pauseBeforeStarting;
			}

			if(@$clip->custom_json_data->duration !== null){
				$duration = @$clip->custom_json_data->duration;
			}

		break;
	}



@endphp

<div id='page_span'>
	
</div>
<div id='page_float'>
	<div class='img_box'>
		<img src='{{ $imageUrl }}' class='img-fluid' id='img_to_zoom' alt='Image To Show'>
	</div>
</div>
<style type='text/css'>
	#page_float{width:100%;height:100%;position:fixed;z-index:5; display: flex;    align-items: center;}
	#page_span{background:#000 url('{{ $imageUrl }}') no-repeat scroll center center;background-size: cover;height:100%;width:100%;position:absolute;opacity:.5; filter: blur(10px);z-index:0;   }
	.img_box{text-align:center;width:100%;

		@if($basis === 'height')

		height: {{ $startingHeight }};

		-webkit-transition: height {{ $duration / 1000 }}s ease-in-out;
	    -moz-transition: height {{ $duration / 1000 }}s ease-in-out;
	    -o-transition: height {{ $duration / 1000 }}s ease-in-out;
	    transition: height {{ $duration / 1000 }}s ease-in-out;

	    @endif

	}
	#img_to_zoom{



		border-radius:50px;

		@if($basis === 'width')

		{{ $basis }}:{{ $startingWidth  }};

		-webkit-transition: {{ $basis }} {{ $duration / 1000 }}s ease-in-out;
	    -moz-transition: {{ $basis }} {{ $duration / 1000 }}s ease-in-out;
	    -o-transition: {{ $basis }} {{ $duration / 1000 }}s ease-in-out;
	    transition: {{ $basis }} {{ $duration / 1000 }}s ease-in-out;

	    @endif

	    @if($basis === 'height')

	    height:100%;

	    @endif

	}

</style>
<script type='text/javascript' src='https://code.jquery.com/jquery-3.7.1.js'>
</script>
<script type='text/javascript'>

	$(document).ready(function(){

		setTimeout(() => {

			@if($basis === 'width')
			$("#img_to_zoom").css('width',"{{ $endingWidth }}");
			@endif
			@if($basis === 'height')
			$("#page_float .img_box").css('height',"{{ $endingHeight }}");
			@endif

		}, {{ $pauseBeforeStarting }});

	});

	// //animate
	// var duration = {{ $duration }};
	// var startingWidth = parseFloat('{{ $startingWidth }}');
	// var endingWidth = parseFloat('{{ $endingWidth }}');

	// var currentWidth = startingWidth;
	// var timeElapsed = 0;
	// var difference = endingWidth - startingWidth;

	// currentPad = 0;

	// setInterval(()=> {

	// 	if(timeElapsed < duration){

	// 		currentWidth = startingWidth + (difference * (timeElapsed / duration ) );

	// 		timeElapsed = (timeElapsed + 100);

	// 		console.log(currentWidth);

	// 		$("#img_to_zoom").css('width',currentWidth+'%');

	// 	}

	// },100);
</script>