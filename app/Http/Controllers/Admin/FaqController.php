<?php

namespace App\Http\Controllers\Admin;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Models\FAQ;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class FAQController extends Controller
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
        //     // if (auth()->faq()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $faqs = FAQ::orderBy('created_at', 'desc');

            $faqs = $faqs->paginate(25);
        } else {


            $faqs = FAQ::where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });

            $faqs = $faqs->paginate(25)->setPath('');
            $pagination = $faqs->appends(array(
                'keyword' => $request->keyword
            ));
        }


        $data = view('admin.faq.ajaxtable', compact('faqs'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $faqs->total(),
            'pagination' => (string) $faqs->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = FAQ::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {


        if (!$request->keyword) {
            $faqs = FAQ::orderBy('created_at', 'desc')->paginate(25);
        } else {
            $faqs = FAQ::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $faqs->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.faq.index', compact(['faqs', 'roles']));
    }

    public function customers(Request $request)
    {
        if (!$request->keyword) {
            $faqs = FAQ::orderBy('created_at', 'desc')->where('role_id', 2)->paginate(25);
        } else {
            $faqs = FAQ::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%');

            $faqs = $faqs->where('role_id', 2)->paginate(25)->setPath('');

            $pagination = $faqs->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.customer.index', compact(['faqs', 'roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.faq.create', compact('roles'));
    }

    public function profile()
    {
        return view('admin.faq.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        FAQ::create($request->all());
        return redirect()->route('admins.faqs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(faq $faq)
    {
        return view('admin.faq.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(faq $faq)
    {
        $roles = Role::all();
        return view("admin.faq.edit", compact('faq', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, faq $faq)
    {

        $faq->update($request->all());
        return redirect()->route('admins.faqs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(faq $faq)
    {
        $faq->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->faqid;
        $faq = FAQ::find(auth()->faq()->id);
        if ($request->hasFile('dp')) {
            if (auth()->faq()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/faqdp/'.auth()->faq()->dp;
                $image_path = public_path('images/faqdp/') . auth()->faq()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/faqdp');
            $image->move($destinationPath, $name);
            $faq->dp = $name;
            $faq->save();
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
        $filename = public_path("images/faqdp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/faqdp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/faqdp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $faqs = FAQ::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $faqs = $faqs->where('faqs.role_id', $request->role_id);
        }
        $faqs = $faqs->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $faqs->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.faq.index', compact(['faqs', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $faq = FAQ::find($id);
        if (Hash::check($request->old_password, $faq->password)) {

            $faq->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.faq.changepassword');
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



            // Log::error('Won faq: ' + $item->odd_name);
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
        $user = User::with('faqs')->where('id', $user_id)->first();
        if (count($user->faqs) != 0) {

            $verifiedRisk = 0;
            $unverifiedRisk = 0;
            foreach ($user->faqs as $item) {
                if ($item->status == 0) {                        //Check for active or inactive faqs
                    if ($item->is_won != 2) {                    //Check for non refunded faqs
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
