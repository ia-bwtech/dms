<?php

namespace App\Http\Controllers\Handicapper;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Mail\Complain as MailComplain;
use App\Models\Bet;
use App\Models\Complain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class ComplainController extends Controller
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
        //     // if (auth()->complain()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $complains = Complain::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                // dd($request->all());
                $complains = $complains->where('complains.is_handicapper', $request->is_handicapper);
            }
            if ($request->date_start != null && $request->date_end != null) {
                $complains->whereBetween('created_at', [$request->date_start, $request->date_end]);
            }
            $complains = $complains->paginate(25);
        } else {

            $complains = Complain::where(function ($query) use ($request) {
                $query->where('subject', 'like', '%' . $request->keyword . '%')
                    ->orWhereHas('user', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->keyword . '%');
                    })
                    ->orWhereHas('package', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->keyword . '%')
                            ->orWhereHas('user', function ($query1) use ($request) {
                                $query1->where('name', 'like', '%' . $request->keyword . '%');
                            });
                    });
            })
                ->where('user_id', auth()->user()->id)
                ->paginate(25)->setPath('');
        }


        $data = view('admin.complain.complaintable', compact('complains'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $complains->total(),
            'pagination' => (string) $complains->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = Complain::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {


        if (!$request->keyword) {
            $complains = Complain::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(25);
        } else {
            $complains = Complain::where(function ($query) use ($request) {
                $query->where('subject', 'like', '%' . $request->keyword . '%')
                    ->orWhereHas('user', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->keyword . '%');
                    })
                    ->orWhereHas('package', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->keyword . '%')
                            ->orWhereHas('user', function ($query1) use ($request) {
                                $query1->where('name', 'like', '%' . $request->keyword . '%');
                            });
                    });
            })
                ->where('user_id', auth()->user()->id)
                ->paginate(25)->setPath('');
        }

        $roles = Role::all();

        return view('admin.complain.index', compact(['complains', 'roles']));
    }

    public function customers(Request $request)
    {
        if (!$request->keyword) {
            $complains = Complain::orderBy('created_at', 'desc')->where('role_id', 2)->paginate(25);
        } else {
            $complains = Complain::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%');

            $complains = $complains->where('role_id', 2)->paginate(25)->setPath('');

            $pagination = $complains->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.customer.index', compact(['complains', 'roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.complain.create', compact('roles'));
    }

    public function profile()
    {
        return view('admin.complain.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Complain::create($request->except('user_id') + ['user_id' => auth()->user()->id]);

        $data = [
            'email' => auth()->user()->email,
            'name' => auth()->user()->name,
            'subject' => $request->subject,
            'complain' => $request->complain
        ];
        Mail::to('blindsidebets@demo-customweb.com')->send(new MailComplain($data));
        return redirect()->route('handicapperscrm.complains.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if ($request->ajax()) {
            if ($request->keyword == null || $request->keyword == ' ') {
                $bets = Bet::where('complain_id', $id)->orderBy('created_at', 'desc');
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
                    ->where('complain_id', $id)
                    ->paginate(25)->setPath('');
                if ($request->date_start != null && $request->date_end != null) {
                    $bets = Bet::where(function ($query) use ($request) {
                        $query->where('sport', 'like', '%' . $request->keyword . '%')
                            ->orWhere('league', 'like', '%' . $request->keyword . '%')
                            ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                            ->orWhere('game_id', 'like', '%' . $request->keyword . '%');
                    })
                        ->where('complain_id', 68)
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
        $complain = Complain::find($id);
        return view('admin.complain.show', compact('complain'));
    }

    public function betfilter($request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function edit(complain $complain)
    {
        $roles = Role::all();
        return view("admin.complain.edit", compact('complain', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, complain $complain)
    {

        $complain->update($request->all());
        return redirect()->route('handicapperscrm.complains.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\complain  $complain
     * @return \Illuminate\Http\Response
     */
    public function destroy(complain $complain)
    {
        $complain->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->complainid;
        $complain = Complain::find(auth()->complain()->id);
        if ($request->hasFile('dp')) {
            if (auth()->complain()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/complaindp/'.auth()->complain()->dp;
                $image_path = public_path('images/complaindp/') . auth()->complain()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/complaindp');
            $image->move($destinationPath, $name);
            $complain->dp = $name;
            $complain->save();
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
        $filename = public_path("images/complaindp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/complaindp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/complaindp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $complains = Complain::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $complains = $complains->where('complains.role_id', $request->role_id);
        }
        $complains = $complains->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $complains->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.complain.index', compact(['complains', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $complain = Complain::find($id);
        if (Hash::check($request->old_password, $complain->password)) {

            $complain->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.complain.changepassword');
    }
}
