<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MediaRaw;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(request()->ajax()){

            DB::enableQueryLog();

            $status = true;

            $images = MediaRaw::where(['model_type' => User::class, 'model_id' => auth()->user()->id])->orderBy('id','desc')->get();

            return compact(['status','images']);
        }
        
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

        $user = User::where(['id' => auth()->user()->id])->first();

        try {
            if($request->hasFile('files') && $request->file('files')->isValid()){
                $user->addMediaFromRequest('files')->toMediaCollection('images/'.$user->id);
            }
            return ['status' => true];
        }catch(\Exception $e){
            return ['status' => false, 'error' => $e->getMessage()];
        }
  
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
