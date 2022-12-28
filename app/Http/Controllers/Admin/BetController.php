<?php

namespace App\Http\Controllers\Admin;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Models\Bet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class BetController extends Controller
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
        //     // if (auth()->bet()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $bets = Bet::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                // dd($request->all());
                $bets = $bets->where('bets.is_handicapper', $request->is_handicapper);
            }
            if ($request->date_start != null && $request->date_end != null) {
                $bets->whereBetween('created_at', [$request->date_start, $request->date_end]);
            }
            $bets = $bets->paginate(25);
        } else {

            $bets = Bet::where('sport', 'like', '%' . $request->keyword . '%')
                ->orWhere('league', 'like', '%' . $request->keyword . '%')
                ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                ->orWhere('game_id', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            if ($request->date_start != null && $request->date_end != null) {
                $bets=Bet::where(function($query) use ($request){
                    $query->where('sport', 'like', '%' . $request->keyword . '%')
                    ->orWhere('league', 'like', '%' . $request->keyword . '%')
                    ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('game_id', 'like', '%' . $request->keyword . '%');
                })
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

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = Bet::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {


        if (!$request->keyword) {
            $bets = Bet::orderBy('created_at', 'desc')->paginate(25);
        } else {
            $bets = Bet::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $bets->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.bet.index', compact(['bets', 'roles']));
    }

    public function customers(Request $request)
    {
        if (!$request->keyword) {
            $bets = Bet::orderBy('created_at', 'desc')->where('role_id', 2)->paginate(25);
        } else {
            $bets = Bet::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%');

            $bets = $bets->where('role_id', 2)->paginate(25)->setPath('');

            $pagination = $bets->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.customer.index', compact(['bets', 'roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.bet.create', compact('roles'));
    }

    public function profile()
    {
        return view('admin.bet.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Bet::create($request->except('password') + ['password' => Hash::make($request->password)]);
        return redirect()->route('admins.bets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\bet  $bet
     * @return \Illuminate\Http\Response
     */
    public function show(bet $bet)
    {
        return view('admin.bet.show', compact('bet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\bet  $bet
     * @return \Illuminate\Http\Response
     */
    public function edit(bet $bet)
    {
        $roles = Role::all();
        return view("admin.bet.edit", compact('bet', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\bet  $bet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, bet $bet)
    {
        if ($request->password != '' && $request->password != null) {
            $bet->update($request->except('password') + ['password' => Hash::make($request->password)]);
        } else {
            $bet->update($request->except('password'));
        }
        return redirect()->route('admins.bets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\bet  $bet
     * @return \Illuminate\Http\Response
     */
    public function destroy(bet $bet)
    {
        $bet->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->betid;
        $bet = Bet::find(auth()->bet()->id);
        if ($request->hasFile('dp')) {
            if (auth()->bet()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/betdp/'.auth()->bet()->dp;
                $image_path = public_path('images/betdp/') . auth()->bet()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/betdp');
            $image->move($destinationPath, $name);
            $bet->dp = $name;
            $bet->save();
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
        $filename = public_path("images/betdp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/betdp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/betdp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $bets = Bet::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $bets = $bets->where('bets.role_id', $request->role_id);
        }
        $bets = $bets->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $bets->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.bet.index', compact(['bets', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $bet = Bet::find($id);
        if (Hash::check($request->old_password, $bet->password)) {

            $bet->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.bet.changepassword');
    }
}
