<?php

namespace App\Http\Controllers\Admin;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Models\Odd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class OddController extends Controller
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
        //     // if (auth()->odd()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $odds = Odd::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                // dd($request->all());
                $odds = $odds->where('odds.is_handicapper', $request->is_handicapper);
            }
            $odds = $odds->paginate(25);
        } else {

            $odds = Odd::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $odds->appends(array(
                'keyword' => $request->keyword
            ));
        }


        $data = view('admin.odd.ajaxtable', compact('odds'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $odds->total(),
            'pagination' => (string) $odds->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = Odd::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {


            if (!$request->keyword) {
                $odds = Odd::orderBy('created_at', 'desc')->paginate(25);
            } else {
                $odds = Odd::where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('id', 'like', '%' . $request->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                    ->paginate(25)->setPath('');
                $pagination = $odds->appends(array(
                    'keyword' => $request->keyword
                ));
            }

        $roles = Role::all();

        return view('admin.odd.index', compact(['odds', 'roles']));
    }

    public function customers(Request $request)
    {
            if (!$request->keyword) {
                $odds = Odd::orderBy('created_at', 'desc')->where('role_id',2)->paginate(25);
            } else {
                $odds = Odd::where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('id', 'like', '%' . $request->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $request->keyword . '%');

                    $odds=$odds->where('role_id',2)->paginate(25)->setPath('');

                    $pagination = $odds->appends(array(
                        'keyword' => $request->keyword
                    ));
            }

        $roles = Role::all();

        return view('admin.customer.index', compact(['odds', 'roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.odd.create', compact('roles'));
    }

    public function profile()
    {
        return view('admin.odd.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Odd::create($request->except('password') + ['password' => Hash::make($request->password)]);
        return redirect()->route('admins.odds.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\odd  $odd
     * @return \Illuminate\Http\Response
     */
    public function show(odd $odd)
    {
        return view('admin.odd.show',compact('odd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\odd  $odd
     * @return \Illuminate\Http\Response
     */
    public function edit(odd $odd)
    {
        $roles = Role::all();
        return view("admin.odd.edit", compact('odd', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\odd  $odd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, odd $odd)
    {
        if($request->password!='' && $request->password!=null){
            $odd->update($request->except('password')+['password'=>Hash::make($request->password)]);

        }
        else{
            $odd->update($request->except('password'));
        }
        return redirect()->route('admins.odds.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\odd  $odd
     * @return \Illuminate\Http\Response
     */
    public function destroy(odd $odd)
    {
        $odd->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->oddid;
        $odd = Odd::find(auth()->odd()->id);
        if ($request->hasFile('dp')) {
            if (auth()->odd()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/odddp/'.auth()->odd()->dp;
                $image_path = public_path('images/odddp/') . auth()->odd()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/odddp');
            $image->move($destinationPath, $name);
            $odd->dp = $name;
            $odd->save();
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
        $filename = public_path("images/odddp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/odddp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/odddp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $odds = Odd::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $odds = $odds->where('odds.role_id', $request->role_id);
        }
        $odds = $odds->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $odds->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.odd.index', compact(['odds', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $odd = Odd::find($id);
        if (Hash::check($request->old_password, $odd->password)) {

            $odd->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.odd.changepassword');
    }
}
