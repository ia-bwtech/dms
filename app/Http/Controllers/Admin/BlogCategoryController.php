<?php

namespace App\Http\Controllers\Admin;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class BlogCategoryController extends Controller
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
        //     // if (auth()->blogcategory()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $blogcategories = BlogCategory::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                $blogcategories = $blogcategories->where('blogcategories.is_handicapper', $request->is_handicapper);
            }
            if ($request->date_start != null && $request->date_end != null) {
                $blogcategories->whereBlogCategoryween('created_at', [$request->date_start, $request->date_end]);
            }
            if ($request->is_verified != null || $request->is_verified === 0) {
                $blogcategories = $blogcategories->where('is_verified', $request->is_verified);
            }
            if ($request->is_won != null || $request->is_won === 0) {
                $blogcategories = $blogcategories->where('is_won', $request->is_won);
            }
            if ($request->status != null || $request->status === 0) {
                $blogcategories = $blogcategories->where('status', $request->status);
            }
            $blogcategories = $blogcategories->paginate(25);
        } else {


            $blogcategories = BlogCategory::where(function ($query) use ($request) {
                $query->where('sport', 'like', '%' . $request->keyword . '%')
                    ->orWhere('league', 'like', '%' . $request->keyword . '%')
                    ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('is_won', 'like', '%' . $request->keyword . '%')
                    ->orWhere('game_id', 'like', '%' . $request->keyword . '%');
            });
            if ($request->is_verified != null || $request->is_verified === 0) {
                $blogcategories = $blogcategories->where('is_verified', $request->is_verified);
            }
            if ($request->is_won != null || $request->is_won === 0) {
                $blogcategories = $blogcategories->where('is_won', $request->is_won);
            }
            if ($request->status != null || $request->status === 0) {
                $blogcategories = $blogcategories->where('status', $request->status);
            }
            $blogcategories = $blogcategories->paginate(25)->setPath('');

            if ($request->date_start != null && $request->date_end != null) {
                $blogcategories = BlogCategory::where(function ($query) use ($request) {
                    $query->where('sport', 'like', '%' . $request->keyword . '%')
                        ->orWhere('league', 'like', '%' . $request->keyword . '%')
                        ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                        ->orWhere('is_won', 'like', '%' . $request->keyword . '%')
                        ->orWhere('game_id', 'like', '%' . $request->keyword . '%');
                })
                    ->whereBlogCategoryween('created_at', [$request->date_start, $request->date_end])
                    ->paginate(25)->setPath('');
            }
            $pagination = $blogcategories->appends(array(
                'keyword' => $request->keyword
            ));
        }


        $data = view('admin.blogcategory.blogcategorytable', compact('blogcategories'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $blogcategories->total(),
            'pagination' => (string) $blogcategories->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = BlogCategory::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {
        if (!$request->keyword) {
            $blogcategories = BlogCategory::orderBy('created_at', 'desc')->paginate(25);
        } else {
            $blogcategories = BlogCategory::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $blogcategories->appends(array(
                'keyword' => $request->keyword
            ));
        }

        return view('admin.blogcategory.index', compact(['blogcategories']));
    }

    public function customers(Request $request)
    {
        if (!$request->keyword) {
            $blogcategories = BlogCategory::orderBy('created_at', 'desc')->where('role_id', 2)->paginate(25);
        } else {
            $blogcategories = BlogCategory::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%');

            $blogcategories = $blogcategories->where('role_id', 2)->paginate(25)->setPath('');

            $pagination = $blogcategories->appends(array(
                'keyword' => $request->keyword
            ));
        }

        return view('admin.customer.index', compact(['blogcategories']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blogcategory.create');
    }

    public function profile()
    {
        return view('admin.blogcategory.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        BlogCategory::create($request->except('password') + ['password' => Hash::make($request->password)]);
        return redirect()->route('admins.blogcategories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\blogcategory  $blogcategory
     * @return \Illuminate\Http\Response
     */
    public function show(blogcategory $blogcategory)
    {
        return view('admin.blogcategory.show', compact('blogcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\blogcategory  $blogcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(blogcategory $blogcategory)
    {
        $roles = Role::all();
        return view("admin.blogcategory.edit", compact('blogcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\blogcategory  $blogcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, blogcategory $blogcategory)
    {

        $blogcategory->update($request->all());
        return redirect()->route('admins.blogcategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\blogcategory  $blogcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(blogcategory $blogcategory)
    {
        Blog::where('category_id',$blogcategory->id)->update(['category_id'=>1]);
        $blogcategory->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->blogcategoryid;
        $blogcategory = BlogCategory::find(auth()->blogcategory()->id);
        if ($request->hasFile('dp')) {
            if (auth()->blogcategory()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/blogcategorydp/'.auth()->blogcategory()->dp;
                $image_path = public_path('images/blogcategorydp/') . auth()->blogcategory()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/blogcategorydp');
            $image->move($destinationPath, $name);
            $blogcategory->dp = $name;
            $blogcategory->save();
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
        $filename = public_path("images/blogcategorydp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/blogcategorydp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/blogcategorydp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $blogcategories = BlogCategory::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $blogcategories = $blogcategories->where('blogcategories.role_id', $request->role_id);
        }
        $blogcategories = $blogcategories->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $blogcategories->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.blogcategory.index', compact(['blogcategories']));
    }

    public function updatepassword($id, Request $request)
    {
        $blogcategory = BlogCategory::find($id);
        if (Hash::check($request->old_password, $blogcategory->password)) {

            $blogcategory->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.blogcategory.changepassword');
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



            // Log::error('Won blogcategory: ' + $item->odd_name);
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
        $user = User::with('blogcategories')->where('id', $user_id)->first();
        if (count($user->blogcategories) != 0) {

            $verifiedRisk = 0;
            $unverifiedRisk = 0;
            foreach ($user->blogcategories as $item) {
                if ($item->status == 0) {                        //Check for active or inactive blogcategories
                    if ($item->is_won != 2) {                    //Check for non refunded blogcategories
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
