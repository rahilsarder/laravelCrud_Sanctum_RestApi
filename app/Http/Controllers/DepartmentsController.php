<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user()->isAdmin;

        if($user == 0){
            return response()->json([
                'message' => 'Not Permitted'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $deparmtents = Department::all();

        return response()->json(['message' => $deparmtents]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)

    {
         $user = Auth::user()->isAdmin;

         if($user == 0){
             return response()->json([
                 'message' => 'Not Permitted'
             ], Response::HTTP_UNAUTHORIZED);
         }

         $request->validate([
             'name' => 'required'
         ]);
         $name = $request->input('name');

         Department::create([
             'name' => $name
         ]);

        return response()->json([
            'message' => $name,
        ], Response::HTTP_CREATED);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        $user = Auth::user()->isAdmin;

        if($user == 0){
          return response()->json([
            'message' => 'Not Permitted'
          ]);
        }

        $department = Department::find($id);

        if(!$department){
          return response()->json([
            'message' => 'Department doesnt exist'
          ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
          'message' => $department
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $user = Auth::user()->isAdmin;

        if($user == 0){
            return response()->json([
              'message' => 'Not Permitted'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $department = Department::find($id);

        if(!$department){
            return response()->json(['message'=>"The product is invalid!"], Response::HTTP_NOT_FOUND);
        }

        $department->delete();
        return response()->json(['message' => 'The Department has been deleted successfully'], Response::HTTP_ACCEPTED);

    }

    public function showRelations()
    {
        $user = Auth::user()->isAdmin;

        if($user == 0){
            return response()->json([
              'message' => 'Not Permitted'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $department = Department::with('employee')->get();

        return response()->json([$department]);

    }

}
