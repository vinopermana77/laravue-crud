<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\EmployeeDetail;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::all();
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $employee
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required'],
            'email' => ['required'],
            'gender' => ['required','in:Male,Female'],
            'address' => ['required']
        ]);
        
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            Employee::create($request->all());
            return response()->json([
                'message' => 'Data created',
                Response::HTTP_CREATED
            ],Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to create data' . $e->errorInfo
            ], Response::HTTP_BAD_REQUEST);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $employee
        ], Response::HTTP_OK);
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
        $employee = Employee::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required|in:Male,Female',
            'address' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $employee->update($request->all());
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Data updated'
            ],Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to update data' . $e->errorInfo
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        try {
            $employee->delete();
            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => 'Data deleted'
            ],Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to delete data' . $e->errorInfo
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
