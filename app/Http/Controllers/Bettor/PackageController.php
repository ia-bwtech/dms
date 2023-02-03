<?php

namespace App\Http\Controllers\Bettor;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class PackageController extends Controller
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
        //     // if (auth()->package()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        // dd($request->all());
        if ($request->keyword == null || $request->keyword == ' ') {
            $packages = Package::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                $packages = $packages->where('packages.is_handicapper', $request->is_handicapper);
            }
            if ($request->date_start != null && $request->date_end != null) {
                $packages->whereBetween('created_at', [$request->date_start, $request->date_end]);
            }
            $packages = $packages->where('user_id', auth()->user()->id)->paginate(25);
        } else {


            $packages = Package::where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('price', 'like', '%' . $request->keyword . '%')
                    ->orWhere('description', 'like', '%' . $request->keyword . '%')
                    ->orWhere('duration', 'like', '%' . $request->keyword . '%');
            })
                ->where('user_id', auth()->user()->id)
                ->paginate(25)->setPath('');

            if ($request->date_start != null && $request->date_end != null) {
                $packages = Package::where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->keyword . '%')
                        ->orWhere('price', 'like', '%' . $request->keyword . '%')
                        ->orWhere('description', 'like', '%' . $request->keyword . '%')
                        ->orWhere('duration', 'like', '%' . $request->keyword . '%');
                })
                    ->whereBetween('created_at', [$request->date_start, $request->date_end])
                    ->paginate(25)->setPath('');
            }
            $pagination = $packages->appends(array(
                'keyword' => $request->keyword
            ));
        }


        $data = view('admin.package.packagetable', compact('packages'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $packages->total(),
            'pagination' => (string) $packages->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = Package::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {

        $subscriptions=Subscription::where('user_id',auth()->user()->id)->orderBy('id','desc')->paginate(25);
        return view('admin.subscription.index', compact('subscriptions'));
    }

    public function customers(Request $request)
    {
        if (!$request->keyword) {
            $packages = Package::orderBy('created_at', 'desc')->where('role_id', 2)->paginate(25);
        } else {
            $packages = Package::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%');

            $packages = $packages->where('role_id', 2)->paginate(25)->setPath('');

            $pagination = $packages->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.customer.index', compact('packages', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.package.create', compact('roles'));
    }

    public function profile()
    {
        return view('admin.package.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Package::create($request->all());
        return redirect()->route('bettorscrm.packages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(package $package)
    {
        return view('admin.package.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(package $package)
    {
        $roles = Role::all();
        return view("admin.package.edit", compact('package', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, package $package)
    {
        if ($request->password != '' && $request->password != null) {
            $package->update($request->except('password') + ['password' => Hash::make($request->password)]);
        } else {
            $package->update($request->except('password'));
        }
        return redirect()->route('bettorscrm.packages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(package $package)
    {
        $package->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->packageid;
        $package = Package::find(auth()->package()->id);
        if ($request->hasFile('dp')) {
            if (auth()->package()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/packagedp/'.auth()->package()->dp;
                $image_path = public_path('images/packagedp/') . auth()->package()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/packagedp');
            $image->move($destinationPath, $name);
            $package->dp = $name;
            $package->save();
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
        $filename = public_path("images/packagedp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/packagedp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/packagedp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $packages = Package::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $packages = $packages->where('packages.role_id', $request->role_id);
        }
        $packages = $packages->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $packages->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.package.index', compact(['packages', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $package = Package::find($id);
        if (Hash::check($request->old_password, $package->password)) {

            $package->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.package.changepassword');
    }
}
