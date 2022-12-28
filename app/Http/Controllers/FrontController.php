<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function packages(Request $request)
    {
        $users = User::has('packages', '>', 0)->with('packages')->orderBy('verified_win_loss_percentage', 'desc')->paginate(5);

        if (isset($request->sortBy)) {
            $users = User::has('packages', '>', 0)->with('packages')->orderBy($request->orderBy, $request->sortBy)->paginate(5);
        }
        if (isset($request->search)) {
            $users = User::has('packages', '>', 0)->with('packages')->where('name', 'like', '%' . $request->search . '%')->paginate(5);
        }
        if ($request->ajax()) {
            return view('handicapper-packages-ajax', compact('users'));
        }
        return view('handicapper-packages');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
