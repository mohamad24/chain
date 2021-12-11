<?php

namespace App\Http\Controllers\Api;

use App\employee;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Employees_V2_Controller extends Controller
{

    // employee login
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',

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


            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {

                    $token = $user->createToken('chain Grant User')->accessToken;
                    $response = [
                        'success' => true ,
                        'message' => 'success',
                        'data'=> $token,
                    ];

                }else{
                    $response = [
                        'success' => false ,
                        'message' => 'validation error, password incorrect',
                        'data'=> "",
                    ];
                }

            }else{
                $response = [
                    'success' => false ,
                    'message' => 'validation error, email not found',
                    'data'=> "",
                ];
            }

            return response()->json($response);
        }
    }


    // employee update his profile
    public function update(Request $request){


        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',

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

            $data = $request->except('employee_id');
            $employee_id = $request->input('employee_id');

            $employee = employee::where('id',$employee_id)->first();
            if($employee){
               $result =  employee::where('id',$employee_id)->update($data);
               if($result){

                   $response = [
                       'success' => true ,
                       'message' => 'Success, profile updated',
                       'data'=> "",
                   ];

               }else{
                   $response = [
                       'success' => false ,
                       'message' => 'Fail, profile not updated',
                       'data'=> "",
                   ];
               }
            }else{
                $response = [
                    'success' => false ,
                    'message' => 'Fail, employee not found',
                    'data'=> "",
                ];
            }

            return response()->json($response);
        }

    }

}
