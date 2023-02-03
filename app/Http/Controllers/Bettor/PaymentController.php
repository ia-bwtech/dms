<?php

namespace App\Http\Controllers\Bettor;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function ajax(Request $request)
    {

        if ($request->keyword == null || $request->keyword == ' ') {
            $payments = Payment::orderBy('created_at', 'desc');
            if (isset($request->is_handicapper)) {
                // dd($request->all());
                $payments = $payments->where('payments.is_handicapper', $request->is_handicapper);
            }
            if ($request->date_start != null && $request->date_end != null) {
                $payments->whereBetween('created_at', [$request->date_start, $request->date_end]);
            }
            $payments = $payments->where('user_id', auth()->user()->id);
            $payments = $payments->paginate(25);
        } else {

            $payments = Payment::where(function ($query) use ($request) {
                $query->where('charge_id', 'like', '%' . $request->keyword . '%')
                ->orWhereHas('user',function($query) use ($request){
                    $query->where('name','like','%'.$request->keyword.'%');
                })
                ->orWhereHas('package',function($query) use ($request){
                    $query->where('name','like','%'.$request->keyword.'%')
                    ->orWhereHas('user',function($query1) use ($request){
                        $query1->where('name','like','%'.$request->keyword.'%');
                    });
                });
            })
                ->where('user_id', auth()->user()->id)
                ->paginate(25)->setPath('');

            $pagination = $payments->appends(array(
                'keyword' => $request->keyword
            ));
        }


        $data = view('admin.payment.paymenttable', compact('payments'))->render();

        return response()->json([
            'data' => $data,
            'total' => (string) $payments->total(),
            'pagination' => (string) $payments->links()
        ]);
    }

    public function locked(Request $request)
    {
        // dd($request->locked_val);
        if (isset($request->locked_id)) {
            $lead = Payment::find($request->locked_id);
            $lead->update([
                'locked' => $request->locked_val
            ]);
        }

        return 1;
    }
    public function index(Request $request)
    {


        if (!$request->keyword) {
            $payments = Payment::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(25);
        } else {

            $payments = Payment::where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('id', 'like', '%' . $request->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $request->keyword . '%');
            })
                ->where('user_id', auth()->user()->id)
                ->paginate(25)->setPath('');

            $pagination = $payments->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.payment.index', compact(['payments', 'roles']));
    }

    public function customers(Request $request)
    {
        if (!$request->keyword) {
            $payments = Payment::orderBy('created_at', 'desc')->where('role_id', 2)->paginate(25);
        } else {
            $payments = Payment::where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%');

            $payments = $payments->where('role_id', 2)->paginate(25)->setPath('');

            $pagination = $payments->appends(array(
                'keyword' => $request->keyword
            ));
        }

        $roles = Role::all();

        return view('admin.customer.index', compact(['payments', 'roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.payment.create', compact('roles'));
    }

    public function profile()
    {
        return view('admin.payment.profile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Payment::create($request->except('password') + ['password' => Hash::make($request->password)]);
        return redirect()->route('payments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(payment $payment)
    {
        $roles = Role::all();
        return view("admin.payment.edit", compact('payment', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, payment $payment)
    {

        $payment->update($request->all());
        return redirect()->route('payments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(payment $payment)
    {
        $payment->delete();
        return redirect()->back();
    }

    public function save_image(Request $request)
    {
        // $id = $request->paymentid;
        $payment = Payment::find(auth()->user()->id);
        if ($request->hasFile('dp')) {
            if (auth()->user()->dp != null) {
                // $image_path = 'D:/xampp/htdocs/constructionchatt/public/images/paymentdp/'.auth()->user()->dp;
                $image_path = public_path('images/paymentdp/') . auth()->user()->dp;
                // dd($image_path);
                unlink($image_path);
            }
            $nnn = date('YmdHis');
            $completeFileName = $request->file('dp')->getClientOriginalName();
            $fileNameOnly = pathinfo($completeFileName, PATHINFO_FILENAME);
            $image = $request->file('dp');
            $name = str_replace(' ', '_', $fileNameOnly) . '-' . time() . $nnn . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/paymentdp');
            $image->move($destinationPath, $name);
            $payment->dp = $name;
            $payment->save();
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
        $filename = public_path("images/paymentdp/" . $imagename);
        $degrees = $request->angle;
        if ($request->angle == 90) {
            $degrees = 270;
        }
        if ($request->angle == 270) {
            $degrees = 90;
        }
        // $img=Intervention\Image\Facades\Image::make($filename);
        // $img->rotate($degrees);
        // $img->save(public_path('images/paymentdp/rotated.jpg'));
        // // Load the image(
        // $source = imagecreatefromjpeg($filename);
        // // Rotate
        // $rotate = imagerotate($source, $degrees, 0);
        // // and save it on your server...
        // imagejpeg($rotate, public_path('images/paymentdp/ahkgsdhas.jpg') );
        $img_new = imagecreatefromjpeg($filename);
        $img_new = imagerotate($img_new, $degrees, 0);
        // Save rotated image
        imagejpeg($img_new, $filename, 80);
    }


    public function filter(Request $request)
    {

        $payments = Payment::orderBy('created_at', 'desc');

        $roles = Role::orderBy('created_at', 'desc');

        if (isset($request->role_id)) {
            $payments = $payments->where('payments.role_id', $request->role_id);
        }
        $payments = $payments->paginate(25);
        $roles = $roles->paginate(25);

        $pagination = $payments->appends(array(
            'role_id' => $request->role_id,

        ));

        return view('admin.payment.index', compact(['payments', 'roles']));
    }

    public function updatepassword($id, Request $request)
    {
        $payment = Payment::find($id);
        if (Hash::check($request->old_password, $payment->password)) {

            $payment->update(['password' => Hash::make($request->password)]);
            return redirect()->back()->with(['message' => 'Action Successful']);
        } else {
            return redirect()->back()->with(['message' => 'Password Mismatch']);
        }
    }

    public function changepassword()
    {
        return view('admin.payment.changepassword');
    }
}
