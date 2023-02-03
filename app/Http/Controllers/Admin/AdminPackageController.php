<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminPackage;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $package=AdminPackage::find(1);
        return view('admin.adminpackage.edit',compact('package'));
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
        $adminpackage=AdminPackage::find(1);
        $adminpackage->update($request->all());
        $handicappers=User::where('is_handicapper',1)->where('stripe_connected',0)->get();
        foreach($handicappers as $item){
            $package=Package::where('user_id',$item->id)->where('is_admin',1)->first();
            if(empty($package)){
                Package::create($request->all()+['is_admin'=>1,'user_id'=>$item->id]);
            }
            else{
                $package1=Package::where('user_id',$item->id)->where('is_admin',1)->first();
                $package1->update($request->all()+['is_admin'=>1,'user_id'=>$item->id]);
            }
        }
        return redirect()->back();
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
