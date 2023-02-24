<?php

namespace App\Http\Controllers\Admin;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Models\ReferralCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class ReferralCodeController extends Controller
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
        //     // if (auth()->referralcode()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $referralcodes = ReferralCode::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                // dd($request->all());
                $referralcodes = $referralcodes->where('referralcodes.is_handicapper', $request->is_handicapper);
            }
            $referralcodes = $referralcodes->paginate(25);
        } else {

            $referralcodes = ReferralCode::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $referralcodes->appends(array(
                'keyword' => $request->keyword
            ));
        }


        $data = view('admin.referralcode.ajaxtable', compact('referralcodes'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $referralcodes->total(),
            'pagination' => (string) $referralcodes->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = ReferralCode::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {


        if (!$request->keyword) {
            $referralcodes = ReferralCode::orderBy('created_at', 'desc')->paginate(25);
        } else {
            $referralcodes = ReferralCode::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $referralcodes->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.referralcode.index', compact(['referralcodes', 'roles']));
    }

    public function customers(Request $request)
    {
        if (!$request->keyword) {
            $referralcodes = ReferralCode::orderBy('created_at', 'desc')->where('role_id', 2)->paginate(25);
        } else {
            $referralcodes = ReferralCode::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%');

            $referralcodes = $referralcodes->where('role_id', 2)->paginate(25)->setPath('');

            $pagination = $referralcodes->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.customer.index', compact(['referralcodes', 'roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.referralcode.create', compact('roles'));
    }

    public function profile()
    {
        return view('admin.referralcode.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        ReferralCode::create($request->except('password') + ['password' => Hash::make($request->password)]);
        return redirect()->route('admins.referralcodes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\referralcode  $referralcode
     * @return \Illuminate\Http\Response
     */
    public function show(referralcode $referralcode)
    {
        return view('admin.referralcode.show', compact('referralcode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\referralcode  $referralcode
     * @return \Illuminate\Http\Response
     */
    public function edit(referralcode $referralcode)
    {
        $roles = Role::all();
        return view("admin.referralcode.edit", compact('referralcode', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\referralcode  $referralcode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, referralcode $referralcode)
    {
        if ($request->password != '' && $request->password != null) {
            $referralcode->update($request->except('password') + ['password' => Hash::make($request->password)]);
        } else {
            $referralcode->update($request->except('password'));
        }
        return redirect()->route('admins.referralcodes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\referralcode  $referralcode
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $referralcode = ReferralCode::find($id);
        $referralcode->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->referralcodeid;
        $referralcode = ReferralCode::find(auth()->referralcode()->id);
        if ($request->hasFile('dp')) {
            if (auth()->referralcode()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/referralcodedp/'.auth()->referralcode()->dp;
                $image_path = public_path('images/referralcodedp/') . auth()->referralcode()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/referralcodedp');
            $image->move($destinationPath, $name);
            $referralcode->dp = $name;
            $referralcode->save();
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
        $filename = public_path("images/referralcodedp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/referralcodedp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/referralcodedp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $referralcodes = ReferralCode::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $referralcodes = $referralcodes->where('referralcodes.role_id', $request->role_id);
        }
        $referralcodes = $referralcodes->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $referralcodes->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.referralcode.index', compact(['referralcodes', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $referralcode = ReferralCode::find($id);
        if (Hash::check($request->old_password, $referralcode->password)) {

            $referralcode->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.referralcode.changepassword');
    }
}
