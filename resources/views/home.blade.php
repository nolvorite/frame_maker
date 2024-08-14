@extends('layouts.app')

@section('content')
<div class="container-fluid" id="dashboard">
    <div class="row justify-content-center mb-5">
        
        <div class='col-lg-12' id="clips">

            <div class='row'>
            
                @foreach($clips as $clip)
                <div class=' col-lg-3 col-md-4'>
                    <div class='card'>
                        <div class='card-body'>
                            <h5 class="card-title">{{ $clip->clip_name }}</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary"><b>Template:</b> {{ $clip->template->frame_name }}</h6>

                            <div class='text-end'><a target='_blank' href='/user/clips/{{ $clip->id }}/edit?type=clip' class='btn btn-sm btn-primary'>Edit Clip</a></div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>

    </div>
    <div class="row justify-content-center">
        
        <div class='col-lg-4' id="frame_templates_list">
            
            <form id='new_frame_template_form' method="POST" action="/user/clips" class="card mb-3">
                {{ csrf_field() }}
                <div class="card-header">{{ __("Create New Clip Template") }}</div>
                <div class="card-body">
                
                    <div class="form-group mb-3">
                        <label for="frame_name_input">Template Name</label>

                        <input 
                        id="frame_name_input" 
                        name="frame_name"

                        required
                        type="text" 
                        class="form-control" 
                        aria-describedby="frame_name_input" 
                        placeholder="Frame Name">

                    </div>

                    <div class="form-group mb-3">
                        <label for="frame_description_input">Template Description</label>

                        <textarea 
                        id="frame_description_input" 
                        name="frame_description"

                        class="form-control" 
                        aria-describedby="frame_description_input" 
                        placeholder="Frame Description"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="json_data_input">JSON Data</label>

                        <textarea 
                        id="json_data_input" 
                        name="json_data"
                        
                        class="form-control" 
                        aria-describedby="json_data_input" 
                        placeholder="JSON Data">{}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="json_data_input">Dimensions</label>

                        <div class="row">
                            <div class="col-lg-5">
                                <input 
                                id="width_input" 
                                name="width"
                                value="{{ env('DEFAULT_WIDTH') }}"
                                required
                                type="text" 
                                class="form-control col-lg-4" 
                                aria-describedby="width_input" 
                                placeholder="Width">
                            </div>
                            <div class="col-lg-5 offset-lg-1">
                                <input 
                                id="height_input" 
                                name="height"
                                value="{{ env('DEFAULT_HEIGHT') }}"
                                required
                                type="text" 
                                class="form-control col-lg-4" 
                                aria-describedby="height_input" 
                                placeholder="Height">
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 text-end">
                        <button type='submit' class='btn btn-block btn-primary'>Add New Clip Template</button>
                    </div>

                </div>
            </form>

            <div class="card mb-4">
                <div class="card-header">
                    Clip Templates
                </div>   
                <div class="card-body">
                    <div class="list-group">
                    @foreach($clipTemplates as $clipTemplate)
                    <a href="/user/clip/{{$clipTemplate->id}}/edit?type=clip_template" class="list-group-item list-group-item-action" target="_new">
                        {{ $clipTemplate->frame_name }} <span class="badge text-bg-primary">{{ $clipTemplate->width }} - {{ $clipTemplate->height }}</span>
                    </a>
                    @endforeach
                    </div>
                </div>   
            </div>
        </div>

        <div class='col-lg-4' id="clips_images_list">
            <images-list />        
        </div>

        <div class='col-lg-4' id='new_clip_section'>
            <new-clip />
        </div>


    </div>
</div>
@endsection
@section('javascripts')
<script type='text/javascript' defer>
    const siteData = {clipTemplates: {!! json_encode($clipTemplates) !!}, appUrl: '{{ env("APP_URL") }}/', csrf: '{{ csrf_token() }}'};
</script>
@endsection