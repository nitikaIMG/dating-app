<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Guard string. // web, api
     * 
     * @var string
     */
    protected $guard = 'web';

    /**
     * Authentication driver.
     *
     * @var \Illuminate\Auth\SessionGuard|\Tymon\JWTAuth\JWTGuard
     */
    protected $auth;

    protected $_e_data = [];

    public function __construct()
    {
        $this->auth = $this->authManager();
    }


    protected function authManager()
    {
        return auth($this->guard);
    }

    /**
     * Return current logged in user.
     *
     * @return \App\Models\User|null
     */
    public function user()
    {
        if( !$this->auth ) {
            $this->auth = $this->authManager();
        }
        
        return $this->auth->user();
    }

    protected function validation_error_response(Validator $validator)
    {
        $_errors = $validator->errors()->messages();

        return response()->json([
            'status' => false,
            'data' => [
                'error' => $_errors
            ]
        ]);
    }

}
