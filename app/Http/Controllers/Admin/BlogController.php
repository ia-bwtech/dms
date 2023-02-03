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

class BlogController extends Controller
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
        //     // if (auth()->blog()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $blogs = Blog::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                $blogs = $blogs->where('blogs.is_handicapper', $request->is_handicapper);
            }
            if ($request->date_start != null && $request->date_end != null) {
                $blogs->whereBlogween('created_at', [$request->date_start, $request->date_end]);
            }
            if ($request->is_verified != null || $request->is_verified === 0) {
                $blogs = $blogs->where('is_verified', $request->is_verified);
            }
            if ($request->is_won != null || $request->is_won === 0) {
                $blogs = $blogs->where('is_won', $request->is_won);
            }
            if ($request->status != null || $request->status === 0) {
                $blogs = $blogs->where('status', $request->status);
            }
            $blogs = $blogs->paginate(25);
        } else {


            $blogs = Blog::where(function ($query) use ($request) {
                $query->where('sport', 'like', '%' . $request->keyword . '%')
                    ->orWhere('league', 'like', '%' . $request->keyword . '%')
                    ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('is_won', 'like', '%' . $request->keyword . '%')
                    ->orWhere('game_id', 'like', '%' . $request->keyword . '%');
            });
            if ($request->is_verified != null || $request->is_verified === 0) {
                $blogs = $blogs->where('is_verified', $request->is_verified);
            }
            if ($request->is_won != null || $request->is_won === 0) {
                $blogs = $blogs->where('is_won', $request->is_won);
            }
            if ($request->status != null || $request->status === 0) {
                $blogs = $blogs->where('status', $request->status);
            }
            $blogs = $blogs->paginate(25)->setPath('');

            if ($request->date_start != null && $request->date_end != null) {
                $blogs = Blog::where(function ($query) use ($request) {
                    $query->where('sport', 'like', '%' . $request->keyword . '%')
                        ->orWhere('league', 'like', '%' . $request->keyword . '%')
                        ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                        ->orWhere('is_won', 'like', '%' . $request->keyword . '%')
                        ->orWhere('game_id', 'like', '%' . $request->keyword . '%');
                })
                    ->whereBlogween('created_at', [$request->date_start, $request->date_end])
                    ->paginate(25)->setPath('');
            }
            $pagination = $blogs->appends(array(
                'keyword' => $request->keyword
            ));
        }


        $data = view('admin.blog.blogtable', compact('blogs'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $blogs->total(),
            'pagination' => (string) $blogs->links()
        ]);
    }

    public function index(Request $request)
    {


        if (!$request->keyword) {
            $blogs = Blog::orderBy('created_at', 'desc')->paginate(25);
        } else {
            $blogs = Blog::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $blogs->appends(array(
                'keyword' => $request->keyword
            ));
        }


        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blogcategories = BlogCategory::all();
        return view('admin.blog.create', compact('blogcategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_string = $this->removeTags($request->blog);
        $a = \Str::random(5);
        $blog = Blog::create($request->except('blog') + ['blog' => $new_string]);
        $banner = $request->file('banner');
        $nameonly = preg_replace('/\..+$/', '', $banner->getClientOriginalName());
        $filename = $nameonly . '_' . $a . '.' . $banner->getClientOriginalExtension();
        $banner->move('images', $filename);
        Blog::where('id', $blog->id)->update(['banner' => $filename]);
        return redirect()->route('admins.blogs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(blog $blog)
    {
        return view('admin.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(blog $blog)
    {
        $blogcategories = BlogCategory::all();
        return view("admin.blog.edit", compact('blog', 'blogcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, blog $blog)
    {


        $new_string = $this->removeTags($request->blog);

        $a = \Str::random(5);
        $blog->update($request->except('blog') + ['blog' => $new_string]);
        if ($request->hasFile('banner')) {

            $banner = $request->file('banner');
            $nameonly = preg_replace('/\..+$/', '', $banner->getClientOriginalName());
            $filename = $nameonly . '_' . $a . '.' . $banner->getClientOriginalExtension();
            $banner->move('images', $filename);
            Blog::where('id', $blog->id)->update(['banner' => $filename]);
        }

        return redirect()->route('admins.blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(blog $blog)
    {
        $blog->delete();
        return redirect()->back();
    }

    public function save_image(Request $request, $id)
    {
        // $id = $request->blogid;
        $blog = Blog::find($id);
        if ($request->hasFile('image')) {
            $nnn = date('YmdHis');
            $completeFileName = $request->file('image')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('image');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/blogimage');
            $image->move($destinationPath, $name);
            $blog->image = $name;
            $blog->save();
            return 1;
        }
    }


    public function filter(Request $request)
    {

        $blogs = Blog::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $blogs = $blogs->where('blogs.role_id', $request->role_id);
        }
        $blogs = $blogs->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $blogs->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.blog.index', compact(['blogs', 'roles']));
    }
}
