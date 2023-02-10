<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Http\Resources\SiteResource;
use Illuminate\Validation\Rule;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SiteResource::collection(Site::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:sites',
            'description' => 'required',
            'region' => 'required',
            'is_active' => Rule::in(['0', '1']),
        ]);

        $site = Site::create($validatedData);

        return new SiteResource($site);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site)
    {
        return new SiteResource($site);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|unique:sites,name,'.$site->id,
            'description' => 'sometimes',
            'region' => 'sometimes',
            'is_active' => Rule::in(['0', '1']),
        ]);

        $site->update($validatedData);

        return new SiteResource($site);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        $site->delete();

        return response()->json(null, 204);
    }
}
