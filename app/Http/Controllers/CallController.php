<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Call;
use DataTables;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use App\Http\Requests\CallRequest;

class CallController extends Controller
{
    public function index(Request $request)
    {
        
        $data;
        $data = Call::latest()->get();
        $user = Auth::user();
        if($user->role == 1){

            $data = Call::latest()->get();

        }else{

            $data = Call::where('user',$user->id)->latest()->get();

        }
        return $data;
        
    }
        

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CallRequest $request)
    {
        $result = ['success' => '', 'error' => ''];   

        
        $call_id = [
            'id' => $request->call_id
        ];

        $callDetails = [
                            'name' => $request->name,
                            'phone_number' => $request->phone,
                            'date' => $request->dated,
                            'client' => $request->client_name,
                            'status' => $request->status,
                            'duration' => $request->duration,
                            'comments' => $request->comments,
                            'purpose' => $request->purpose,
                            'user'    => Auth::id(),
                            
                        ];  

        if(Call::updateOrCreate($call_id,$callDetails)){

            $result['success'] = 'Call Details Details saved successfully.';
        
        }else{
        
            $result['error'] = 'Some Problem Occured.';
        
        }  
        
       return response()->json($result);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
        $call = Call::find($id);
        $call->date = Carbon::parse($call->date)->format('Y-m-d');
        return response()->json($call);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = Call::find($id);
            if($vehicle){
                if($vehicle->delete()){

                    return response()->json(['success'=>'Call Details deleted successfully.']);
                }else{

                    return response()->json(['error'=>'Some Problem Occured.']);

                }
            
            }else{

                return response()->json(['error'=>'Data unavailable']);
                
            }
    }
    

}