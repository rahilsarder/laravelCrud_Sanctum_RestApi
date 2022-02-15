<?php

namespace App\Http\Controllers;


use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;



class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->isAdmin;

        if($user == 0){

            return response()->json([

                'message' => Auth::user(),

            ]);

        }

        return response()->json([
            'message' => Employee::all(),
        ]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Check if the user is an Admin User
        $user = Auth::user()->isAdmin;

        if($user == 0){
            return response()->json([
                'message' => 'Not Permitted'
            ], Response::HTTP_UNAUTHORIZED);
        }


        // HTTP request body validation
        $request->validate([

            'first_name' => 'required',
            'last_name' => 'required',
            'users_id' => 'required',
            'department_id' => 'required',
        ]);


        // Checking if the Employee's User_ID is unique or not
        $input_id = $request->input('users_id');

        if(Employee::where('users_id',$input_id)->first()){
          return response()->json([
            'message' => 'User already is an employee'
          ], 405);
        }

        // Creating new Employee record
        $employee = Employee::create([

            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'users_id' => $request->input('users_id'),
            'department_id' => $request->input('department_id'),
            'dutyTime_id' => $request->input('dutyTime_id')
        ]);


        return response()->json([

            'message' => $employee
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
      $user = Auth::user()->isAdmin;

      if($user == 0){
          return response()->json([
              'message' => 'Not Permitted'
          ], Response::HTTP_UNAUTHORIZED);
      }

      $employee = Employee::find($id);

      if(!$employee){
        return response()->json(['message' => 'The Employee doesnt exist'
      ], Response::HTTP_NOT_FOUND);
      }

      $employee->delete();

      return response()->json(['message' => 'The Employee has been deleted successfully']);

    }

    public function showRelations()
    {
      // Check if the user is an Admin User
      $user = Auth::user()->isAdmin;

      if($user == 0){
          return response()->json([
              'message' => 'Not Permitted'
          ], Response::HTTP_UNAUTHORIZED);
      }

      $employees = Employee::with(['user', 'department', 'dutyTime'])->get();

      return response()->json([
        $employees
      ], Response::HTTP_ACCEPTED);


    }
}
