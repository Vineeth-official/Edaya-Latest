<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Call;
use DataTables;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use App\Http\Requests\CallRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            if($user->role == 1){
                $data = Call::latest()->get();

            }else{

                $data = Call::where('user',$user->id)->latest()->get();

            }
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('user', function($row){
                        
                return $row->userName->name;
            })
            ->addColumn('status', function($row){
                        
                return $row->Statuses->status;
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('created_at')) && !empty($request->get('nameNumber'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        $condition = ((Carbon::parse($row['created_at'])->format('Y-m-d') == Carbon::parse($request->get('created_at'))->format('Y-m-d') ) &&
                                    (Str::contains($row['phone_number'], $request->get('nameNumber')) ||
                                    Str::contains($row['client'], $request->get('nameNumber'))))

                                     ? true : false;
                            return $condition;

                        });
                }
                elseif (!empty($request->get('created_at')) && empty($request->get('nameNumber'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {

                        $condition = Str::contains(Carbon::parse($row['created_at'])->format('Y-m-d'), $request->get('created_at')) ? true : false;

                            // $condition =  Str::contains($row['phone_number'], $request->get('nameNumber')) ? true : false;
                            // $condition =  Str::contains($row['client'], $request->get('nameNumber')) ? true : false;
                            return $condition;
                        });
                }
                elseif (empty($request->get('created_at')) && !empty($request->get('nameNumber'))) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {

                        $condition =(Str::contains($row['phone_number'], $request->get('nameNumber')) ||
                        Str::contains($row['client'], $request->get('nameNumber')))

                         ? true : false;
                            return $condition;
                        });
                }
            })
            ->addColumn('created_at', function($row){
                        
                $created_at =Carbon::parse($row['created_at'])->format('Y-m-d');
                
                                
                return $created_at;
            })
            ->addColumn('action', function($row){
   
                                $btn = '';
                             
                                // $btn =   '<a href="javascript:void(0)" data-toggle="modal"  data-id="'.$row->id.'" title="Edit" class="edit edit-call" id="edit_hotel">
                                // <i class="fa fa-edit mr-2 text-dark"></i>
                                //          </a>'; 
                                $btn ='<button class="btn btn-light edit-call  btn-sm tx-10 " data-id="'.$row->id.'" data-toggle="modal"id="Createvehicle" data-target="#callModal"><i class="fa fa-edit mr-2 text-dark"></i></button>';

                                // $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="View" class="view-driver" id="view_hotel">
                                //                 <i class="fa fa-eye ml-2 text-info"></i>
                                //              </a>';
                                 $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="Delete" class="delete-driver" id="delete_hotel">
                                                <i class="fa fa-trash ml-2 text-dark"></i>
                                             </a><br>';
                                // $btn = $btn.$row->created_at;
                                    return $btn;
                            })
            ->rawColumns(['created_at','action','user','status'])
            ->make(true);
        }
        return view('users.index');
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
            if($vehicle->delete()){

                return response()->json(['success'=>'Call Details deleted successfully.']);
            
            }else{

                return response()->json(['success'=>'Some Problem Occured.']);
                
            }
    }
    

}
