<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Call;
use Carbon\Carbon;
use Auth;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=[];
        $user = Auth::user();

        if($user->role == 1){
            
            $calls = Call::whereBetween('created_at', 
            [
                Carbon::now()->startOfMonth(), 
                Carbon::now()->endOfMonth()
            ])->get();

        }else{

            $calls = Call::where('user',$user->id)->whereBetween('created_at', 
            [
                Carbon::now()->startOfMonth(), 
                Carbon::now()->endOfMonth()
            ])->get();

        }
       
        $totalCalls = $calls->count();
        $totalDuration = $calls->sum('duration');
        $data['totalCalls'] = $totalCalls;
        $data['totalDuration'] = $totalDuration;
        return view('components.body',["data"=>$data]);
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
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }
}
