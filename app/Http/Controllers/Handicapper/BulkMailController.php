<?php

namespace App\Http\Controllers\Handicapper;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Mail\RegistrationAlert;
use App\Models\Bet;
use App\Models\BulkMail;
use App\Models\BulkMailRecipient;
use App\Models\Game;
use App\Models\League;
use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class BulkMailController extends Controller
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
        //     // if (auth()->bulkmail()->role_id != 1) {
        //     //     return redirect()->route('shop.index');
        //     // }

        //     return $next($request);
        // });
    }
    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $bulkmails = BulkMail::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                // dd($request->all());
                $bulkmails = $bulkmails->where('bulkmails.is_handicapper', $request->is_handicapper);
            }
            if ($request->date_start != null && $request->date_end != null) {
                $bulkmails->whereBetween('created_at', [$request->date_start, $request->date_end]);
            }
            $bulkmails = $bulkmails->paginate(25);
        } else {

            $bulkmails = BulkMail::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $bulkmails->appends(array(
                'keyword' => $request->keyword
            ));

            if ($request->date_start != null && $request->date_end != null) {
                $bulkmails = BulkMail::where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->keyword . '%')
                        ->orWhere('email', 'like', '%' . $request->keyword . '%')
                        ->orWhere('id', 'like', '%' . $request->keyword . '%')
                        ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                        ->paginate(25)->setPath('');
                })
                    ->whereBetween('created_at', [$request->date_start, $request->date_end])
                    ->paginate(25)->setPath('');
            }
        }


        $data = view('admin.bulkmail.bulkmailtable', compact('bulkmails'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $bulkmails->total(),
            'pagination' => (string) $bulkmails->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = BulkMail::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {
        // $leagues=League::all();
        // Team::where('league','NCAA')->where('sport','football')->update(['league'=>'NCAAF']);
        // Team::where('league','NCAA')->where('sport','basketball')->update(['league'=>'NCAAB']);
        // foreach($leagues as $league){
        //     $teams=Team::where('league',$league->name)->pluck('team_name');
        //     // dd($teams);
        //     $games=Game::where('league',$league->name)->whereNotIn('home_team',$teams)->delete();
        //     $games=Game::where('league',$league->name)->whereNotIn('away_team',$teams)->delete();
        // }

        // // dd($games[5]);
        // dd('done');
        if (!$request->keyword) {
            $bulkmails = BulkMail::orderBy('created_at', 'desc')->paginate(25);
        } else {
            $bulkmails = BulkMail::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->paginate(25)->setPath('');
            $pagination = $bulkmails->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.bulkmail.index', compact(['bulkmails', 'roles']));
    }

    public function customers(Request $request)
    {
        if (!$request->keyword) {
            $bulkmails = BulkMail::orderBy('created_at', 'desc')->where('role_id', 2)->paginate(25);
        } else {
            $bulkmails = BulkMail::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%');

            $bulkmails = $bulkmails->where('role_id', 2)->paginate(25)->setPath('');

            $pagination = $bulkmails->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.customer.index', compact(['bulkmails', 'roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('admin.bulkmail.create', compact('users'));
    }

    public function profile()
    {
        return view('admin.bulkmail.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $emails = User::whereIn('id', $request->user_ids)->pluck('email');
        $data = [
            'subject' => $request->subject,
            'content' => $request->text,

        ];
        SendEmail::dispatch($emails, $data);
        $bulkmail=BulkMail::create($request->all());
        foreach($request->user_ids as $user_id){
            BulkMailRecipient::create(['mail_id'=>$bulkmail->id,'user_id'=>$user_id]);
        }
        return redirect()->route('handicapperscrm.bulkmails.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\bulkmail  $bulkmail
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if ($request->ajax()) {
            if ($request->keyword == null || $request->keyword == ' ') {
                $bets = Bet::where('bulkmail_id', $id)->orderBy('created_at', 'desc');
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
                    ->where('bulkmail_id', $id)
                    ->paginate(25)->setPath('');
                if ($request->date_start != null && $request->date_end != null) {
                    $bets = Bet::where(function ($query) use ($request) {
                        $query->where('sport', 'like', '%' . $request->keyword . '%')
                            ->orWhere('league', 'like', '%' . $request->keyword . '%')
                            ->orWhere('market_name', 'like', '%' . $request->keyword . '%')
                            ->orWhere('game_id', 'like', '%' . $request->keyword . '%');
                    })
                        ->where('bulkmail_id', 68)
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
        $bulkmail = BulkMail::find($id);
        return view('admin.bulkmail.show', compact('bulkmail'));
    }

    public function betfilter($request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\bulkmail  $bulkmail
     * @return \Illuminate\Http\Response
     */
    public function edit(bulkmail $bulkmail)
    {
        $roles = Role::all();
        return view("admin.bulkmail.edit", compact('bulkmail', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\bulkmail  $bulkmail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, bulkmail $bulkmail)
    {
        if ($request->password != '' && $request->password != null) {
            $bulkmail->update($request->except('password') + ['password' => Hash::make($request->password)]);
        } else {
            $bulkmail->update($request->except('password'));
        }
        return redirect()->route('handicapperscrm.bulkmails.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\bulkmail  $bulkmail
     * @return \Illuminate\Http\Response
     */
    public function destroy(bulkmail $bulkmail)
    {
        $bulkmail->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->bulkmailid;
        $bulkmail = BulkMail::find(auth()->bulkmail()->id);
        if ($request->hasFile('dp')) {
            if (auth()->bulkmail()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/bulkmaildp/'.auth()->bulkmail()->dp;
                $image_path = public_path('images/bulkmaildp/') . auth()->bulkmail()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/bulkmaildp');
            $image->move($destinationPath, $name);
            $bulkmail->dp = $name;
            $bulkmail->save();
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
        $filename = public_path("images/bulkmaildp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/bulkmaildp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/bulkmaildp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $bulkmails = BulkMail::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $bulkmails = $bulkmails->where('bulkmails.role_id', $request->role_id);
        }
        $bulkmails = $bulkmails->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $bulkmails->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.bulkmail.index', compact(['bulkmails', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $bulkmail = BulkMail::find($id);
        if (Hash::check($request->old_password, $bulkmail->password)) {

            $bulkmail->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.bulkmail.changepassword');
    }
}
