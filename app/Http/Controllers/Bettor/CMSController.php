<?php

namespace App\Http\Controllers\Bettor;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Models\CMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class CMSController extends Controller
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
        //     // if (auth()->cms()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $cmss = CMS::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                // dd($request->all());
                $cmss = $cmss->where('cmss.is_handicapper', $request->is_handicapper);
            }
            if ($request->date_start != null && $request->date_end != null) {
                $cmss->whereCMSween('created_at', [$request->date_start, $request->date_end]);
            }
            $cmss = $cmss->paginate(25);
        } else {

            $cmss = CMS::where('sport', 'like', '%' . $request->keyword . '%')
                ->orWhere('league', 'like', '%' . $request->keyword . '%')
                ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                ->orWhere('is_won', 'like', '%' . $request->keyword . '%')
                ->orWhere('game_id', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            if ($request->date_start != null && $request->date_end != null) {
                $cmss = CMS::where(function ($query) use ($request) {
                    $query->where('sport', 'like', '%' . $request->keyword . '%')
                        ->orWhere('league', 'like', '%' . $request->keyword . '%')
                        ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                        ->orWhere('is_won', 'like', '%' . $request->keyword . '%')
                        ->orWhere('game_id', 'like', '%' . $request->keyword . '%');
                })
                    ->whereCMSween('created_at', [$request->date_start, $request->date_end])
                    ->paginate(25)->setPath('');
            }
            $pagination = $cmss->appends(array(
                'keyword' => $request->keyword
            ));
        }


        $data = view('admin.cms.cmstable', compact('cmss'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $cmss->total(),
            'pagination' => (string) $cmss->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = CMS::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {

        $cmss = CMS::groupBy('page')->orderBy('id')->get();
        return view('admin.cms.index', compact('cmss'));
    }

    public function customers(Request $request)
    {
        if (!$request->keyword) {
            $cmss = CMS::orderBy('created_at', 'desc')->where('role_id', 2)->paginate(25);
        } else {
            $cmss = CMS::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%');

            $cmss = $cmss->where('role_id', 2)->paginate(25)->setPath('');

            $pagination = $cmss->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.customer.index', compact(['cmss', 'roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.cms.create', compact('roles'));
    }

    public function profile()
    {
        return view('admin.cms.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($page, Request $request)
    {

        $x = count($request->all());
        $items = $request->all();
        $keys = array_keys($items);
        for ($i = 1; $i < $x; $i++) {
            $cms = CMS::where('slug', $keys[$i])->first();
            if ($cms->type == 'file') {
                if($request->hasFile($keys[$i])){
                    $filename = $this->saveimage($request->file($keys[$i]));
                    CMS::where('slug', $keys[$i])->update(['content' => '/images/cms/'.$filename]);
                }
            }
            else{
                CMS::where('slug', $keys[$i])->update(['content' => $items[$keys[$i]]]);
            }
        }
        return redirect()->route('bettorscrm.cmss.index');
    }

    public function saveimage($file)
    {
        $nnn = date('YmdHis');
        $completeFileName = $file->getClientOriginalName();
        $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
        $image = $file;
        $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images/cms');
        $image->move($destinationPath, $name);
        return $name;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function show(cms $cms)
    {
        return view('admin.cms.show', compact('cms'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function edit($page)
    {
        $cms_fields = CMS::where('page', $page)->get();
        return view("admin.cms.edit", compact('cms_fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cms $cms)
    {
        if ($request->password != '' && $request->password != null) {
            $cms->update($request->except('password') + ['password' => Hash::make($request->password)]);
        } else {
            $cms->update($request->except('password'));
        }
        return redirect()->route('bettorscrm.cmss.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function destroy(cms $cms)
    {
        $cms->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->cmsid;
        $cms = CMS::find(auth()->cms()->id);
        if ($request->hasFile('dp')) {
            if (auth()->cms()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/cmsdp/'.auth()->cms()->dp;
                $image_path = public_path('images/cmsdp/') . auth()->cms()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/cmsdp');
            $image->move($destinationPath, $name);
            $cms->dp = $name;
            $cms->save();
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
        $filename = public_path("images/cmsdp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/cmsdp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/cmsdp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $cmss = CMS::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $cmss = $cmss->where('cmss.role_id', $request->role_id);
        }
        $cmss = $cmss->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $cmss->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.cms.index', compact(['cmss', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $cms = CMS::find($id);
        if (Hash::check($request->old_password, $cms->password)) {

            $cms->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.cms.changepassword');
    }
}
