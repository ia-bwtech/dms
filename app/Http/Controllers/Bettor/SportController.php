<?php

namespace App\Http\Controllers\Bettor;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class SportController extends Controller
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
        //     // if (auth()->sport()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $sports = Sport::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                // dd($request->all());
                $sports = $sports->where('sports.is_handicapper', $request->is_handicapper);
            }
            $sports = $sports->paginate(25);
        } else {

            $sports = Sport::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $sports->appends(array(
                'keyword' => $request->keyword
            ));
        }


        $data = view('admin.sport.sporttable', compact('sports'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $sports->total(),
            'pagination' => (string) $sports->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = Sport::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {


            if (!$request->keyword) {
                $sports = Sport::orderBy('created_at', 'desc')->paginate(25);
            } else {
                $sports = Sport::where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('id', 'like', '%' . $request->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                    ->paginate(25)->setPath('');
                $pagination = $sports->appends(array(
                    'keyword' => $request->keyword
                ));
            }

        $roles = Role::all();

        return view('admin.sport.index', compact(['sports', 'roles']));
    }

    public function customers(Request $request)
    {
            if (!$request->keyword) {
                $sports = Sport::orderBy('created_at', 'desc')->where('role_id',2)->paginate(25);
            } else {
                $sports = Sport::where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('id', 'like', '%' . $request->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $request->keyword . '%');

                    $sports=$sports->where('role_id',2)->paginate(25)->setPath('');

                    $pagination = $sports->appends(array(
                        'keyword' => $request->keyword
                    ));
            }

        $roles = Role::all();

        return view('admin.customer.index', compact(['sports', 'roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.sport.create', compact('roles'));
    }

    public function profile()
    {
        return view('admin.sport.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Sport::create($request->except('password') + ['password' => Hash::make($request->password)]);
        return redirect()->route('bettorscrm.sports.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function show(sport $sport)
    {
        return view('admin.sport.show',compact('sport'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function edit(sport $sport)
    {
        $roles = Role::all();
        return view("admin.sport.edit", compact('sport', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, sport $sport)
    {
        if($request->password!='' && $request->password!=null){
            $sport->update($request->except('password')+['password'=>Hash::make($request->password)]);

        }
        else{
            $sport->update($request->except('password'));
        }
        return redirect()->route('bettorscrm.sports.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function destroy(sport $sport)
    {
        $sport->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->sportid;
        $sport = Sport::find(auth()->sport()->id);
        if ($request->hasFile('dp')) {
            if (auth()->sport()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/sportdp/'.auth()->sport()->dp;
                $image_path = public_path('images/sportdp/') . auth()->sport()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/sportdp');
            $image->move($destinationPath, $name);
            $sport->dp = $name;
            $sport->save();
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
        $filename = public_path("images/sportdp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/sportdp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/sportdp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $sports = Sport::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $sports = $sports->where('sports.role_id', $request->role_id);
        }
        $sports = $sports->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $sports->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.sport.index', compact(['sports', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $sport = Sport::find($id);
        if (Hash::check($request->old_password, $sport->password)) {

            $sport->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.sport.changepassword');
    }
}
