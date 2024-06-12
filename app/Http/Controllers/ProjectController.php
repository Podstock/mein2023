<?php

namespace App\Http\Controllers;

use App\Http\Resources\Project as ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::where(['user_id' => auth()->user()->id])->get();

        return ProjectResource::collection(
            $projects
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $p = new Project;
        $p->user_id = auth()->user()->id;
        $p->save();
    }

    public function store_logo(Project $project)
    {
        request()->validate([
            'file' => ['required', 'image'],
        ]);

        $path = request()->file('file')->store('logos', 'public');

        Storage::disk('public')->copy($path, 'small/'.$path);
        $img = Image::make(storage_path('app/public/small/'.$path));
        $img->resize(256, 256);
        $img->save();

        Storage::disk('public')->copy($path, 'tiny/'.$path);
        $img = Image::make(storage_path('app/public/tiny/'.$path));
        $img->resize(64, 64);
        $img->save();

        $project->logo = $path;
        $project->save();

        /* Cache::forget('users_list'); */
        /* Cache::forget('users_list_new'); */

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        request()->validate([
            'name' => 'required',
            'url' => ['required', 'url'],
            'logo' => ['nullable', 'image'],
        ]);

        $this->authorize('update', $project);

        if (request()->hasFile('logo')) {
            $path = request()->file('logo')->store('logos', 'public');

            Storage::disk('public')->copy($path, 'small/'.$path);
            $img = Image::make(storage_path('app/public/small/'.$path));
            $img->resize(256, 256);
            $img->save();

            Storage::disk('public')->copy($path, 'tiny/'.$path);
            $img = Image::make(storage_path('app/public/tiny/'.$path));
            $img->resize(64, 64);
            $img->save();

            $project->logo = $path;
        }

        $project->name = request()->name;
        $project->url = request()->url;
        $project->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
    }
}
