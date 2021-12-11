<?php

namespace App\Http\Controllers\Api;

use App\employee;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;


class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        // list employee
        $employee = employee::all();
        $response = [
            'success' => true ,
            'message' => 'employee list ',
            'data'=> $employee,
        ];

        return response()->json($response);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // add employee
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'=>'required|unique:users,email',
            'password'=>'required',
            'mobile'=>'required'

        ]);
        if ($validator->fails())
        {
            $response = [
                'success' => false ,
                'message' => 'validation error,'. $validator->errors()->all(),
                'data'=> "",
            ];

            return response()->json($response);
        }else {

            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');
            $mobile = $request->input('mobile');

            $user = new User();
            $user->password = Hash::make($password);
            $user->email = $email;
            $user->name = $name;
            $user->user_type = 'emp';
            if($user->save()){

                $employee = employee::create([
                        'user_id' => $user->id,
                        'name' => $name,
                        'mobile' => $mobile,
                        'status' => 1
                ]);

                if($employee){
                    $response = [
                        'success' => true,
                        'message' => 'Success, employee added thanks',
                        'data'=> "",
                    ];
                }else{
                    $response = [
                        'success' => false,
                        'message' => 'Fail, employee not added',
                        'data'=> '',
                    ];
                }

            }else{
                $response = [
                    'success' => false,
                    'message' => 'Fail, user not added',
                    'data'=> '',
                ];
            }
            return response()->json($response);




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
    public function deactivate($id)
    {

        // activate / deactivate employee
        $employee = employee::find($id);
        if($employee){

            if($employee->status) {
                $employee->status = 0;
                $employee->save();
                $response = [
                    'success' => true,
                    'message' => 'success, employee deactivated',
                    'data' => '',
                ];
                return response()->json($response);
            }else{
                $employee->status = 1;
                $employee->save();
                $response = [
                    'success' => true,
                    'message' => 'success, employee activated',
                    'data' => '',
                ];
                return response()->json($response);
            }
        }else{

            $response = [
                'success' => false,
                'message' => 'Fail, employee not found',
                'data'=> '',
            ];
            return response()->json($response);
        }
    }
}
