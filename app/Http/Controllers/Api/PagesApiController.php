<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admin\app\Models\TermsandCondition;
use Modules\Admin\app\Models\PrivacyPolicy;
use Validator;

class PagesApiController extends Controller
{
    /* --- function for casting--- */
    function allString($object)
    {
        // Get the object's attributes
        $attributes = $object->getAttributes();

        // Iterate through the attributes and apply conversions
        foreach ($attributes as $key => &$value) {
            if (is_null($value)) {
                $value = "";
            } elseif (is_numeric($value) && !is_float($value)) {
                // Convert numeric values to integers (excluding floats)
                $value = (string) $value;
            }
            // Add more conditions for other types if needed
        }

        // Set the modified attributes back to the object
        $object->setRawAttributes($attributes);
        return $object;
    }


    /* --- Privacy Policy api --- */
    public function PrivacyPolicy(Request $request)
    {
        $header = $request->header('Authorization');
        if(empty($header)){
            $message = "Authorization Token is required.";
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $message
            ],422);
        }else{
            if($header == "Bearer JzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkMkJSEyXiopIiw"){
                try{
                    $get_privacy_policy = PrivacyPolicy::first();
                    if(!empty($get_privacy_policy)){
                        /*--- TYPE CAST DATA */
                        $data = $this->allString($get_privacy_policy);
                        return response()->json([
                            'status'      => true,
                            'status_code' => 200, 
                            'message'     => 'Data Retrieve Successfully!.',
                            'data'        =>  $data,
                        ],200);
                    }
                }catch(\Exception $exception){
                    return response()->json([
                        'status' => false,
                        'status_code' => 422,
                        'error'  => $exception->getMessage(),
                    ],422);
                }
            }else{
                $message = "Authorization Token is Incorrect.";
                return response()->json([
                    'status'      => false,
                    'status_code' => 422,
                    'message'     => $message,
                ],422);
            }
        }
    }  

    /* --- Terms and Conditions api --- */
    public function TermsandConditions(Request $request)
    {
        $header = $request->header('Authorization');
        if(empty($header)){
            $message = "Authorization Token is required.";
            return response()->json([
                'status'      => false,
                'status_code' => 422,
                'message'     => $message
            ],422);
        }else{
            if($header == "Bearer JzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkMkJSEyXiopIiw"){
                $get_terms_and_conditions = TermsandCondition::first();

                if(!empty($get_terms_and_conditions)){
                    /*--- TYPE CAST DATA */
                    $data = $this->allString($get_terms_and_conditions);
                    return response()->json([
                        'status'      => true,
                        'status_code' => 200, 
                        'message'     => 'Data Retrieve Successfully!.',
                        'data'        =>  $data,
                    ],200);
                }else{
                    return response()->json([
                        'status'      => false,
                        'status_code' => 422,
                        'message'     => 'Record not found.!',
                    ],422);
                }

            }else{
                $message = "Authorization Token is Incorrect.";
                return response()->json([
                    'status'      => false,
                    'status_code' => 422,
                    'message'     => $message,
                ],422);
            }
        }
    }   
}
