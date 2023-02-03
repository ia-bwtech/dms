<?php

namespace App\Http\Controllers\Handicapper;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class LeagueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware(function (Request $request, $next) {
        //     // if (auth()->league()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $leagues = League::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                // dd($request->all());
                $leagues = $leagues->where('leagues.is_handicapper', $request->is_handicapper);
            }
            $leagues = $leagues->paginate(25);
        } else {

            $leagues = League::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $leagues->appends(array(
                'keyword' => $request->keyword
            ));
        }


        $data = view('admin.league.ajaxtable', compact('leagues'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $leagues->total(),
            'pagination' => (string) $leagues->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = League::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {


            if (!$request->keyword) {
                $leagues = League::orderBy('created_at', 'desc')->paginate(25);
            } else {
                $leagues = League::where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('id', 'like', '%' . $request->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                    ->paginate(25)->setPath('');
                $pagination = $leagues->appends(array(
                    'keyword' => $request->keyword
                ));
            }

        $roles = Role::all();

        return view('admin.league.index', compact(['leagues', 'roles']));
    }

    public function customers(Request $request)
    {
            if (!$request->keyword) {
                $leagues = League::orderBy('created_at', 'desc')->where('role_id',2)->paginate(25);
            } else {
                $leagues = League::where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('id', 'like', '%' . $request->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $request->keyword . '%');

                    $leagues=$leagues->where('role_id',2)->paginate(25)->setPath('');

                    $pagination = $leagues->appends(array(
                        'keyword' => $request->keyword
                    ));
            }

        $roles = Role::all();

        return view('admin.customer.index', compact(['leagues', 'roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.league.create', compact('roles'));
    }

    public function profile()
    {
        return view('admin.league.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        League::create($request->except('password') + ['password' => Hash::make($request->password)]);
        return redirect()->route('handicapperscrm.leagues.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\league  $league
     * @return \Illuminate\Http\Response
     */
    public function show(league $league)
    {
        return view('admin.league.show',compact('league'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\league  $league
     * @return \Illuminate\Http\Response
     */
    public function edit(league $league)
    {
        $roles = Role::all();
        return view("admin.league.edit", compact('league', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\league  $league
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, league $league)
    {
        if($request->password!='' && $request->password!=null){
            $league->update($request->except('password')+['password'=>Hash::make($request->password)]);

        }
        else{
            $league->update($request->except('password'));
        }
        return redirect()->route('handicapperscrm.leagues.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\league  $league
     * @return \Illuminate\Http\Response
     */
    public function destroy(league $league)
    {
        $league->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->leagueid;
        $league = League::find(auth()->league()->id);
        if ($request->hasFile('dp')) {
            if (auth()->league()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/leaguedp/'.auth()->league()->dp;
                $image_path = public_path('images/leaguedp/') . auth()->league()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/leaguedp');
            $image->move($destinationPath, $name);
            $league->dp = $name;
            $league->save();
            return 1;
        }
    }


    public function rotate_image(Request $request)
    {
        // $data = $request->all();
        // dd($data);
        $filename = $request->image;
        $arrayimage = explode('/', $filename);
        $imagename = $arrayimage[sizeof($arrayimage) - 1];
        $filename = public_path("images/leaguedp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/leaguedp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/leaguedp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $leagues = League::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $leagues = $leagues->where('leagues.role_id', $request->role_id);
        }
        $leagues = $leagues->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $leagues->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.league.index', compact(['leagues', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $league = League::find($id);
        if (Hash::check($request->old_password, $league->password)) {

            $league->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.league.changepassword');
    }
}
