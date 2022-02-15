<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\DutyTime;

class DutyTimesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->isAdmin;

        if($user ==0){
          return response()->json([
            'message' => "Permission denied"
          ], Response::HTTP_UNAUTHORIZED);
        }

        $dutyTimes = DutyTime::all();

        return response()->json([$dutyTimes], Response::HTTP_ACCEPTED);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $user = Auth::user()->isAdmin;

      if($user ==0){
        return response()->json([
          'message' => "Permission denied"
        ], Response::HTTP_UNAUTHORIZED);
      }

      $request->validate([
        'name' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
      ]);

      $dutyTimes = DutyTime::create([
        'name' => $request->input('name'),
        'start_time' => $request->input('start_time'),
        'end_time' => $request->input('end_time'),
      ]);

      return response()->json([
        'message' => $dutyTimes,
      ], Response::HTTP_CREATED);


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
      $user = Auth::user()->isAdmin;

      if($user ==0){
        return response()->json([
          'message' => "Permission denied"
        ], Response::HTTP_UNAUTHORIZED);
      }

      $dutyTime = DutyTime::find($id);

      if(!$dutyTime){
        return response()->json(['message' => 'DutyTime doesnt exist'
      ], Response::HTTP_NOT_FOUND);
      }

      return response()->json([$dutyTime], Response::HTTP_ACCEPTED);
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
        $user = Auth::user()->isAdmin;

        if($user ==0){
          return response()->json([
            'message' => "Permission denied"
          ], Response::HTTP_UNAUTHORIZED);
        }

        $dutyTime = DutyTime::findOrFail($id);

        $dutyTime->update($request->all());

        // $dutyTime = DutyTime::where('id', $id)->update([$request->all()]);

        return response()->json([$dutyTime], Response::HTTP_ACCEPTED);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user()->isAdmin;

        if($user ==0){
          return response()->json([
            'message' => "Permission denied"
          ], Response::HTTP_UNAUTHORIZED);
        }

        $dutyTime = DutyTime::find($id);

        if(!$dutyTime){
          return response()->json(['message' => 'DutyTime doesnt exist'
        ], Response::HTTP_NOT_FOUND);
        }

        $dutyTime->delete();


        return response()->json(['message' => 'The DutyTime is successfully deleted'
      ], Response::HTTP_ACCEPTED);
    }

    public function showRelations()
    {
        $user = Auth::user()->isAdmin;

        if($user ==0){
          return response()->json([
            'message' => "Permission denied"
          ], Response::HTTP_UNAUTHORIZED);
        }

        $dutyTime = DutyTime::with('employee')->get();

        return response()->json([$dutyTime], Response::HTTP_ACCEPTED);

    }




}
