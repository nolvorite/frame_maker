<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clip;
use App\Models\ClipTemplate;
use Illuminate\Support\Facades\DB;

class ClipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = (object) $request->all();

        switch($request->get('type')){
            case "clip":
                $newClip = Clip::create([
                    'clip_name' => $data->clip_name,
                    'custom_json_data' => json_decode($data->data),
                    'template_id' => $data->clip_template_id,
                    'created_by' => auth()->user()->id,
                    'width' => $data->width === null ? env('DEFAULT_WIDTH') : $data->width.'',
                    'height' => $data->height === null ? env('DEFAULT_HEIGHT') : $data->height.''
                ]);
                return redirect('user/clips/'. $newClip->id .'/edit?type=clip');
            break;
            default:
            case "clip_template":
                $newClipTemplate = ClipTemplate::create([
                    'frame_name' => $data->frame_name,
                    'frame_description' => $data->frame_description,
                    'json_data' => $data->json_data,
                    'created_by' => auth()->user()->id,
                    'width' => $data->width,
                    'height' => $data->height
                ]);
                return redirect('user/clips/'. $newClipTemplate->id .'/edit?type=clip_template');
            break;
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {

        $type = $request->get('type') === null ? 'clip' : $request->get('type');

        switch($type){
            case "clip_template":

                $clipTemplate = ClipTemplate::where(['id' => $id])->first();
                return view('slideshow.show', compact(['id','clipTemplate','type']));

            break;
            case "clip":
            default:

                $clip = Clip::where(['id' => $id])->first();

                return view('slideshow.show', compact(['id','clip','type']));

            break;
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {

        $type = $request->get('type');



        switch($type){
            case "clip_template":

                $clipTemplate = ClipTemplate::where(['id' => $id])->first();
                return view('slideshow.edit', compact(['id','clipTemplate','type']));

            break;
            case "clip":

                $clip = Clip::with('template')->where(['id' => $id])->first();

                return view('slideshow.edit', compact(['id','clip','type']));

            break;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = (object) $request->all();

        switch($request->get('type')){
            case "clip":

                switch(request()->get('action')){
                    case "edit_css":
                        $newClip = Clip::where(['id' => $id])->update([
                            'css' => $data->css,
                        ]);
                    break;
                    default:
                        $newClip = Clip::where(['id' => $id])->update([
                            'clip_name' => $data->clip_name,
                            'custom_json_data' => $data->data,
                            'created_by' => auth()->user()->id,
                            'width' => $data->width === null ? env('DEFAULT_WIDTH') : $data->width.'',
                            'height' => $data->height === null ? env('DEFAULT_HEIGHT') : $data->height.''
                        ]);
                    break;
                }

                
            
            break;
            default:
            case "clip_template":
                $newClipTemplate = ClipTemplate::where(['id' => $id])->update([
                    'frame_name' => $data->frame_name,
                    'frame_description' => $data->frame_description,
                    'json_data' => $data->json_data,
                    'created_by' => auth()->user()->id,
                    'width' => $data->width,
                    'height' => $data->height
                ]);
                
            break;
        }

        return ['status' => true];

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
