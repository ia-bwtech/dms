<?php

namespace App\Http\Controllers\Admin;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Models\Bet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
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
        //     // if (auth()->user()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $users = User::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                // dd($request->all());
                $users = $users->where('users.is_handicapper', $request->is_handicapper);
            }
            if ($request->date_start != null && $request->date_end != null) {
                $users->whereBetween('created_at', [$request->date_start, $request->date_end]);
            }
            $users = $users->paginate(25);
        } else {

            $users = User::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $users->appends(array(
                'keyword' => $request->keyword
            ));

            if ($request->date_start != null && $request->date_end != null) {
                $users = User::where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->keyword . '%')
                        ->orWhere('email', 'like', '%' . $request->keyword . '%')
                        ->orWhere('id', 'like', '%' . $request->keyword . '%')
                        ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                        ->paginate(25)->setPath('');
                })
                    ->whereBetween('created_at', [$request->date_start, $request->date_end])
                    ->paginate(25)->setPath('');
            }
        }


        $data = view('admin.user.usertable', compact('users'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $users->total(),
            'pagination' => (string) $users->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = User::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {


        if (!$request->keyword) {
            $users = User::orderBy('created_at', 'desc')->paginate(25);
        } else {
            $users = User::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $users->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.user.index', compact(['users', 'roles']));
    }

    public function customers(Request $request)
    {
        if (!$request->keyword) {
            $users = User::orderBy('created_at', 'desc')->where('role_id', 2)->paginate(25);
        } else {
            $users = User::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%');

            $users = $users->where('role_id', 2)->paginate(25)->setPath('');

            $pagination = $users->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.customer.index', compact(['users', 'roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }

    public function profile()
    {
        return view('admin.user.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        User::create($request->except('password') + ['password' => Hash::make($request->password)]);
        return redirect()->route('admins.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if ($request->ajax()) {
            if ($request->keyword == null || $request->keyword == ' ') {
                $bets = Bet::where('user_id', $id)->orderBy('created_at', 'desc');
                if ($request->date_start != null && $request->date_end != null) {
                    $bets->whereBetween('created_at', [$request->date_start, $request->date_end]);
                }
                $bets = $bets->paginate(25);
            } else {

                $bets = Bet::where(function ($query) use ($request) {
                    $query->where('sport', 'like', '%' . $request->keyword . '%')
                        ->orWhere('league', 'like', '%' . $request->keyword . '%')
                        ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                        ->orWhere('game_id', 'like', '%' . $request->keyword . '%');
                })
                    ->where('user_id', $id)
                    ->paginate(25)->setPath('');
                if ($request->date_start != null && $request->date_end != null) {
                    $bets = Bet::where(function ($query) use ($request) {
                        $query->where('sport', 'like', '%' . $request->keyword . '%')
                            ->orWhere('league', 'like', '%' . $request->keyword . '%')
                            ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                            ->orWhere('game_id', 'like', '%' . $request->keyword . '%');
                    })
                        ->where('user_id', 68)
                        ->whereBetween('created_at', [$request->date_start, $request->date_end])
                        ->paginate(25)->setPath('');
                }
                $pagination = $bets->appends(array(
                    'keyword' => $request->keyword
                ));
            }
            $data = view('admin.bet.bettable', compact('bets'))->render();

            return response()->json([
                'data' => $data,
                'total' => (string) $bets->total(),
                'pagination' => (string) $bets->links()
            ]);
        }
        $user = User::find($id);
        return view('admin.user.show', compact('user'));
    }

    public function betfilter($request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        $roles = Role::all();
        return view("admin.user.edit", compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
        if ($request->password != '' && $request->password != null) {
            $user->update($request->except('password') + ['password' => Hash::make($request->password)]);
        } else {
            $user->update($request->except('password'));
        }
        return redirect()->route('admins.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        $user->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->userid;
        $user = User::find(auth()->user()->id);
        if ($request->hasFile('dp')) {
            if (auth()->user()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/userdp/'.auth()->user()->dp;
                $image_path = public_path('images/userdp/') . auth()->user()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/userdp');
            $image->move($destinationPath, $name);
            $user->dp = $name;
            $user->save();
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
        $filename = public_path("images/userdp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/userdp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/userdp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $users = User::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $users = $users->where('users.role_id', $request->role_id);
        }
        $users = $users->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $users->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.user.index', compact(['users', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $user = User::find($id);
        if (Hash::check($request->old_password, $user->password)) {

            $user->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.user.changepassword');
    }
}
