<?php

namespace App\Http\Controllers\API\Traits;

trait GeneralTrait
{
    public function getCurrentLang()
    {
        return app()->getLocale();
    }

    public function returnError($errNum , $msg)
    {
        return response()->json([
            
            'status' => false,
            'errNum' => $errNum,
            'msg' => $msg

        ]);
    }

    public function returnSuccessMessage($msg = "" , $errNum = "S000")
    {
        return [
            'status' => true,
            'errNum' => $errNum,
            'msg' => $msg
        ];
    }

    public function returnData($key , $value , $msg)
    {
        return response()->json([

            'status' => true,
            'errNum' => "S000",
            'msg' => $msg,
            $key => $value
        ]);
    }

    public function returnValidationError($code = "E001" ,$validator)
    {
        return $this->returnError($code , $validator->errors()->first());
    }

    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());

        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }   
    
    public function getErrorCode($input)
    {
        if ($input == 'name') {
            
            return 'E0011';

        }elseif ($input == 'email') {
            
            return 'E007';

        }elseif ($input == 'password') {
            
            return 'E002';

        }elseif ($input == 'mobile') {
            
            return 'E003';

        }else {
            
            return "";
        }
    }
}
