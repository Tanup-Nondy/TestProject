<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class LicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('licenses.index');
    }

    public function get_user($id)
    {
        $user['data'] = User::where('id', $id)->first();
        echo json_encode($user);
        exit;
    }
    public function key_gen($id,$duration){
        $user=User::where('id', $id)->first();
        if($user !=null){
            $exp_date=Carbon::now()->addMonths($duration)->toDateString();
            $str=$id.'.'.$exp_date;
            $key['data']= Crypt::encryptString($str);
            echo json_encode($key);
            exit;
        }else{
            $key['data']= null;
            echo json_encode($key);
            exit;
        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function activate()
    {
        return view('licenses.activate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'license_key'       => ['required', 'unique:users']
        ]);
        $license= $request->input('license_key');
        $data= Crypt::decryptString($license);
        $id = explode(".", $data, 2)[0];    
        $exp_date = substr($data, strpos($data, ".") + 1);    
        $user=User::where('id', $id)->first();
        $user->license_key=$license;
        $user->expire_date=$exp_date;
        $user->save();
        $message='Congratulations!! Your License Has Been Activated. It will work till '.date("d/m/Y", strtotime($exp_date));
        return redirect()->back()->with('success',$message); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\r  $r
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
