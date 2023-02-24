<?php

namespace App\Http\Controllers;

use App\Models\AcademicLevel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        //return all levels in the db
        $levels = AcademicLevel::all();
        return Inertia::render('Admin/AcademicLevels', [
            'levels'=>$levels
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // save levels
        AcademicLevel::create(
            $request->validate([
                'name' => 'required',
                'rate' => 'required'
            ])
        );
        return redirect()->route('admin.levels')->with("success", "Academic Level has been saved successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcademicLevel::$id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        // delete level
        $level = AcademicLevel::findOrFail($id);
        $level->delete();
        return redirect(route('admin.levels'))->with("message", "Level Deleted from database");
    }
}
