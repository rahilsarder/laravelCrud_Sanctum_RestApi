<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AttendancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->isAdmin;

        if (!$user) {
            return response()->json([
                'message' => 'Not Permitted'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $attendance = Attendance::all();

        // $ip = $_SERVER['REMOTE_ADDR'];

        // if ($ip == '192.140.252.2') {
        //     return response()->json([
        //         'wabang' => 'awabg'
        //     ]);
        // }

        return response()->json([
            'attendances' => $attendance
        ], Response::HTTP_ACCEPTED);
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
        $user = Auth::user()->isAdmin;

        if (!$user) {
            return response()->json([
                'message' => 'Not Permitted'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $request->validate([
            'in_time' => 'required',
            'out_time' => 'required',
            'employee_id' => 'required',
        ]);

        $attendance = Attendance::create([
            'in_time' => $request->input('in_time'),
            'out_time' => $request->input('out_time'),
            'employee_id' => $request->input('employee_id'),
            'reason' => $request->input('reason')
        ]);

        return response()->json([
            'attendance' => $attendance
        ], Response::HTTP_CREATED);
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
