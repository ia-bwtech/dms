<?php

namespace App\Http\Controllers\Bettor;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class GameController extends Controller
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
        //     // if (auth()->game()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $games = Game::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                // dd($request->all());
                $games = $games->where('games.is_handicapper', $request->is_handicapper);
            }
            $games = $games->paginate(25);
        } else {

            $games = Game::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $games->appends(array(
                'keyword' => $request->keyword
            ));
        }


        $data = view('admin.game.ajaxtable', compact('games'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $games->total(),
            'pagination' => (string) $games->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = Game::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {


            if (!$request->keyword) {
                $games = Game::orderBy('created_at', 'desc')->paginate(25);
            } else {
                $games = Game::where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('id', 'like', '%' . $request->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                    ->paginate(25)->setPath('');
                $pagination = $games->appends(array(
                    'keyword' => $request->keyword
                ));
            }

        $roles = Role::all();

        return view('admin.game.index', compact(['games', 'roles']));
    }

    public function customers(Request $request)
    {
            if (!$request->keyword) {
                $games = Game::orderBy('created_at', 'desc')->where('role_id',2)->paginate(25);
            } else {
                $games = Game::where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('id', 'like', '%' . $request->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $request->keyword . '%');

                    $games=$games->where('role_id',2)->paginate(25)->setPath('');

                    $pagination = $games->appends(array(
                        'keyword' => $request->keyword
                    ));
            }

        $roles = Role::all();

        return view('admin.customer.index', compact(['games', 'roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.game.create', compact('roles'));
    }

    public function profile()
    {
        return view('admin.game.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Game::create($request->except('password') + ['password' => Hash::make($request->password)]);
        return redirect()->route('bettorscrm.games.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(game $game)
    {
        return view('admin.game.show',compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(game $game)
    {
        $roles = Role::all();
        return view("admin.game.edit", compact('game', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, game $game)
    {
        if($request->password!='' && $request->password!=null){
            $game->update($request->except('password')+['password'=>Hash::make($request->password)]);

        }
        else{
            $game->update($request->except('password'));
        }
        return redirect()->route('bettorscrm.games.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(game $game)
    {
        $game->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->gameid;
        $game = Game::find(auth()->game()->id);
        if ($request->hasFile('dp')) {
            if (auth()->game()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/gamedp/'.auth()->game()->dp;
                $image_path = public_path('images/gamedp/') . auth()->game()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/gamedp');
            $image->move($destinationPath, $name);
            $game->dp = $name;
            $game->save();
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
        $filename = public_path("images/gamedp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/gamedp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/gamedp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $games = Game::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $games = $games->where('games.role_id', $request->role_id);
        }
        $games = $games->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $games->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.game.index', compact(['games', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $game = Game::find($id);
        if (Hash::check($request->old_password, $game->password)) {

            $game->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.game.changepassword');
    }
}
