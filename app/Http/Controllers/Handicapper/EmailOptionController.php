<?php

namespace App\Http\Controllers\Handicapper;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Models\EmailOption;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class EmailOptionController extends Controller
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
        //     // if (auth()->emailoption()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $emailoptions = EmailOption::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                $emailoptions = $emailoptions->where('emailoptions.is_handicapper', $request->is_handicapper);
            }
            if ($request->date_start != null && $request->date_end != null) {
                $emailoptions->whereEmailOptionween('created_at', [$request->date_start, $request->date_end]);
            }
            if ($request->is_verified != null || $request->is_verified === 0) {
                $emailoptions = $emailoptions->where('is_verified', $request->is_verified);
            }
            if ($request->is_won != null || $request->is_won === 0) {
                $emailoptions = $emailoptions->where('is_won', $request->is_won);
            }
            if ($request->status != null || $request->status === 0) {
                $emailoptions = $emailoptions->where('status', $request->status);
            }
            $emailoptions = $emailoptions->where('user_id', auth()->user()->id);
            $emailoptions = $emailoptions->paginate(25);
        } else {

            $emailoptions = EmailOption::where(function ($query) use ($request) {
                $query->where('sport', 'like', '%' . $request->keyword . '%')
                    ->orWhere('league', 'like', '%' . $request->keyword . '%')
                    ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('is_won', 'like', '%' . $request->keyword . '%')
                    ->orWhere('game_id', 'like', '%' . $request->keyword . '%');
            });
            if ($request->is_verified != null || $request->is_verified === 0) {
                $emailoptions = $emailoptions->where('is_verified', $request->is_verified);
            }
            if ($request->is_won != null || $request->is_won === 0) {
                $emailoptions = $emailoptions->where('is_won', $request->is_won);
            }
            if ($request->status != null || $request->status === 0) {
                $emailoptions = $emailoptions->where('status', $request->status);
            }
            $emailoptions = $emailoptions->where('user_id', auth()->user()->id)->paginate(25)->setPath('');

            if ($request->date_start != null && $request->date_end != null) {
                $emailoptions = EmailOption::where(function ($query) use ($request) {
                    $query->where('sport', 'like', '%' . $request->keyword . '%')
                        ->orWhere('league', 'like', '%' . $request->keyword . '%')
                        ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                        ->orWhere('is_won', 'like', '%' . $request->keyword . '%')
                        ->orWhere('game_id', 'like', '%' . $request->keyword . '%');
                });
                if ($request->is_verified != null || $request->is_verified === 0) {
                    $emailoptions = $emailoptions->where('is_verified', $request->is_verified);
                }
                if ($request->is_won != null || $request->is_won === 0) {
                    $emailoptions = $emailoptions->where('is_won', $request->is_won);
                }
                if ($request->status != null || $request->status === 0) {
                    $emailoptions = $emailoptions->where('status', $request->status);
                }
                $emailoptions = $emailoptions->where('user_id', auth()->user()->id)->whereEmailOptionween('created_at', [$request->date_start, $request->date_end])->paginate(25)->setPath('');
            }
            $pagination = $emailoptions->appends(array(
                'keyword' => $request->keyword
            ));
        }


        $data = view('admin.emailoption.emailoptiontable', compact('emailoptions'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $emailoptions->total(),
            'pagination' => (string) $emailoptions->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = EmailOption::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {


        if ($request->keyword == null || $request->keyword == ' ') {
            $emailoptions = EmailOption::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                // dd($request->all());
                $emailoptions = $emailoptions->where('emailoptions.is_handicapper', $request->is_handicapper);
            }
            if ($request->date_start != null && $request->date_end != null) {
                $emailoptions->whereEmailOptionween('created_at', [$request->date_start, $request->date_end]);
            }
            $emailoptions = $emailoptions->where('user_id', auth()->user()->id);
            $emailoptions = $emailoptions->paginate(25);
        } else {

            $emailoptions = EmailOption::where(function ($query) use ($request) {
                $query->where('sport', 'like', '%' . $request->keyword . '%')
                    ->orWhere('league', 'like', '%' . $request->keyword . '%')
                    ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('is_won', 'like', '%' . $request->keyword . '%')
                    ->orWhere('game_id', 'like', '%' . $request->keyword . '%');
            })
                ->where('user_id', auth()->user()->id)
                ->paginate(25)->setPath('');
            if ($request->date_start != null && $request->date_end != null) {
                $emailoptions = EmailOption::where(function ($query) use ($request) {
                    $query->where('sport', 'like', '%' . $request->keyword . '%')
                        ->orWhere('league', 'like', '%' . $request->keyword . '%')
                        ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                        ->orWhere('is_won', 'like', '%' . $request->keyword . '%')
                        ->orWhere('game_id', 'like', '%' . $request->keyword . '%');
                })
                    ->where('user_id', auth()->user()->id)
                    ->whereEmailOptionween('created_at', [$request->date_start, $request->date_end])
                    ->paginate(25)->setPath('');
            }
            $pagination = $emailoptions->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.emailoption.index', compact(['emailoptions', 'roles']));
    }

    public function customers(Request $request)
    {
        if (!$request->keyword) {
            $emailoptions = EmailOption::orderBy('created_at', 'desc')->where('role_id', 2)->paginate(25);
        } else {
            $emailoptions = EmailOption::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%');

            $emailoptions = $emailoptions->where('role_id', 2)->paginate(25)->setPath('');

            $pagination = $emailoptions->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.customer.index', compact(['emailoptions', 'roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.emailoption.create', compact('roles'));
    }

    public function profile()
    {
        return view('admin.emailoption.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        EmailOption::create($request->all());
        return redirect()->route('handicapperscrm.emailoptions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\emailoption  $emailoption
     * @return \Illuminate\Http\Response
     */
    public function show(emailoption $emailoption)
    {
        return view('admin.emailoption.show', compact('emailoption'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\emailoption  $emailoption
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $emailoption = EmailOption::where('user_id', auth()->user()->id)->first();
        return view("admin.emailoption.edit", compact('emailoption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\emailoption  $emailoption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, emailoption $emailoption)
    {

        $emailoption->update($request->all());
        // $this->updateStats($emailoption, $request->is_won);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\emailoption  $emailoption
     * @return \Illuminate\Http\Response
     */
    public function destroy(emailoption $emailoption)
    {
        $emailoption->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->emailoptionid;
        $emailoption = EmailOption::find(auth()->emailoption()->id);
        if ($request->hasFile('dp')) {
            if (auth()->emailoption()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/emailoptiondp/'.auth()->emailoption()->dp;
                $image_path = public_path('images/emailoptiondp/') . auth()->emailoption()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/emailoptiondp');
            $image->move($destinationPath, $name);
            $emailoption->dp = $name;
            $emailoption->save();
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
        $filename = public_path("images/emailoptiondp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/emailoptiondp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/emailoptiondp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $emailoptions = EmailOption::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $emailoptions = $emailoptions->where('emailoptions.role_id', $request->role_id);
        }
        $emailoptions = $emailoptions->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $emailoptions->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.emailoption.index', compact(['emailoptions', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $emailoption = EmailOption::find($id);
        if (Hash::check($request->old_password, $emailoption->password)) {

            $emailoption->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.emailoption.changepassword');
    }

    public function updateStats($item, $result)
    {
        if ($result == 1) {
            if ($item->is_verified == 1) {
                $item->user->verified_units += $item->to_win;
                $item->user->verified_wins += 1;
                $item->user->verified_plays += 1;
                $item->user->save();

                $item->is_won = 1;
                $item->status = 0;
                $item->save();
            } else if ($item->is_verified == 0) {
                $item->user->unverified_units += $item->to_win;
                $item->user->unverified_wins += 1;
                $item->user->unverified_plays += 1;
                $item->user->save();

                $item->is_won = 1;
                $item->status = 0;
                $item->save();
            }



            // Log::error('Won emailoption: ' + $item->odd_name);
        } else if ($result == 0) {
            if ($item->is_verified == 1) {
                $item->user->verified_wins -= 1;
                $item->user->verified_units -= $item->risk;
                $item->user->verified_losses += 1;
                $item->user->verified_plays += 1;
                $item->user->save();

                $item->is_won = 0;
                $item->status = 0;
                $item->save();
            } else if ($item->is_verified == 0) {
                $item->user->unverified_wins -= 1;
                $item->user->unverified_units -= $item->risk;
                $item->user->unverified_losses += 1;
                $item->user->unverified_plays += 1;

                $item->user->save();

                $item->is_won = 0;
                $item->status = 0;
                $item->save();
            }
        }
    }
    public function calculateStats1($user_id)
    {
        $user = User::with('emailoptions')->where('id', $user_id)->first();
        if (count($user->emailoptions) != 0) {

            $verifiedRisk = 0;
            $unverifiedRisk = 0;
            foreach ($user->emailoptions as $item) {
                if ($item->status == 0) {                        //Check for active or inactive emailoptions
                    if ($item->is_won != 2) {                    //Check for non refunded emailoptions
                        if ($item->is_verified == 1) {
                            $verifiedRisk += $item->risk;
                        } else if ($item->is_verified == 0) {
                            $unverifiedRisk += $item->risk;
                        }
                    }
                }
            }

            if ($user->is_verified == 1) {
                //Calculating Win Loss Percentage
                $total = $user->verified_wins + $user->verified_losses;
                if ($total > 0) {
                    dd($user->id);
                    $user->verified_win_loss_percentage = ($user->verified_wins / $total) * 100;
                    $user->verified_win_loss_percentage = round($user->verified_win_loss_percentage, 1);
                    $user->save();
                }

                //Calculating ROI
                if ($verifiedRisk != 0) {
                    $user->verified_roi = ($user->verified_units / $verifiedRisk) * 100;
                    $user->verified_roi = round($user->verified_roi, 1);
                    $user->save();
                }
            } else if ($user->is_verified == 0) {
                //Calculating Win Loss Percentage
                $total = $user->unverified_wins + $user->unverified_losses;
                if ($total > 0) {
                    $user->unverified_win_loss_percentage = ($user->unverified_wins / $total) * 100;
                    $user->unverified_win_loss_percentage = round($user->unverified_win_loss_percentage, 1);
                    $user->save();
                }

                //Calculating ROI
                if ($unverifiedRisk != 0) {
                    $user->unverified_roi = ($user->unverified_units / $unverifiedRisk) * 100;
                    $user->unverified_roi = round($user->unverified_roi, 1);
                    $user->save();
                }
            }
        }

        return;
    }
}
