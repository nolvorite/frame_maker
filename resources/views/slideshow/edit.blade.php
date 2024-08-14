@extends('layouts.frame')
@section('title')
@if($type === 'clip_template')
(Edit) {{ $clipTemplate->frame_name }}
@else
(Edit) {{ $clip->clip_name }}
@endif
@endsection
@section('content')
<div id="editor_page_app_wrap">
	<div id="editor_page_wrap_inner">
		<editor-panel></editor-panel>
		<preview-iframe></preview-iframe>
	</div>
</div>
@endsection
@section('javascripts')

@php

	$clipTemplate = !isset($clipTemplate) ? $clip->template : $clipTemplate;

@endphp

<script type='text/javascript' defer>
	const siteData = {id: {{ intval($id) }}, clipTemplate: {!! json_encode($clipTemplate) !!}, type: "{{ $type }}" @if($type === 'clip'), clip: {!! json_encode($clip) !!} @endif , csrf: '{{ csrf_token() }}'}
</script>
@endsection