@extends('layouts.frame')

@section('title')
@if($type === 'clip_template')
(Showing) {{ $clipTemplate->frame_name }}
@endif

@if($type === 'clip')	
@php

$clipTemplate = $clip->template;
@endphp
(Showing) {{ $clip->clip_name }}
@endif

@endsection


@section('content')
<!-- 
<div id='draw_board'>
	<draw-board></draw-board>
</div> -->
@include('slideshow.frames.'.$clipTemplate->id, compact('type'))

<style type='text/css' id='custom_clip_style'>
@if($type === 'clip')
	{!! $clip->css  !!}
@endif
@if($type === 'clip_template')
	{!! $clipTemplate->css  !!}
@endif
</style>

@endsection
@section('javascripts')

@endsection