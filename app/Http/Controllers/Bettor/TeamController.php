<?php

namespace App\Http\Controllers\Bettor;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class TeamController extends Controller
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
        //     // if (auth()->team()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $teams = Team::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                // dd($request->all());
                $teams = $teams->where('teams.is_handicapper', $request->is_handicapper);
            }
            $teams = $teams->paginate(25);
        } else {

            $teams = Team::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $teams->appends(array(
                'keyword' => $request->keyword
            ));
        }


        $data = view('admin.team.teamtable', compact('teams'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $teams->total(),
            'pagination' => (string) $teams->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = Team::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {


            if (!$request->keyword) {
                $teams = Team::orderBy('created_at', 'desc')->paginate(25);
            } else {
                $teams = Team::where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('id', 'like', '%' . $request->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                    ->paginate(25)->setPath('');
                $pagination = $teams->appends(array(
                    'keyword' => $request->keyword
                ));
            }

        $roles = Role::all();

        return view('admin.team.index', compact(['teams', 'roles']));
    }

    public function customers(Request $request)
    {
            if (!$request->keyword) {
                $teams = Team::orderBy('created_at', 'desc')->where('role_id',2)->paginate(25);
            } else {
                $teams = Team::where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('id', 'like', '%' . $request->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $request->keyword . '%');

                    $teams=$teams->where('role_id',2)->paginate(25)->setPath('');

                    $pagination = $teams->appends(array(
                        'keyword' => $request->keyword
                    ));
            }

        $roles = Role::all();

        return view('admin.customer.index', compact(['teams', 'roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.team.create', compact('roles'));
    }

    public function profile()
    {
        return view('admin.team.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Team::create($request->except('password') + ['password' => Hash::make($request->password)]);
        return redirect()->route('bettorscrm.teams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(team $team)
    {
        return view('admin.team.show',compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(team $team)
    {
        $roles = Role::all();
        return view("admin.team.edit", compact('team', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, team $team)
    {
        if($request->password!='' && $request->password!=null){
            $team->update($request->except('password')+['password'=>Hash::make($request->password)]);

        }
        else{
            $team->update($request->except('password'));
        }
        return redirect()->route('bettorscrm.teams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(team $team)
    {
        $team->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->teamid;
        $team = Team::find(auth()->team()->id);
        if ($request->hasFile('dp')) {
            if (auth()->team()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/teamdp/'.auth()->team()->dp;
                $image_path = public_path('images/teamdp/') . auth()->team()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/teamdp');
            $image->move($destinationPath, $name);
            $team->dp = $name;
            $team->save();
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
        $filename = public_path("images/teamdp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/teamdp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/teamdp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $teams = Team::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $teams = $teams->where('teams.role_id', $request->role_id);
        }
        $teams = $teams->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $teams->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.team.index', compact(['teams', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $team = Team::find($id);
        if (Hash::check($request->old_password, $team->password)) {

            $team->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.team.changepassword');
    }
}
