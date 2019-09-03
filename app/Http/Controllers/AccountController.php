<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/28
 * Time: 9:43
 */

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AccountController extends Controller
{
    protected $accountService;

    public function __construct()
    {
        $this->accountService = app('AccountService');
    }

    public function getAll()
    {
        $this->accountService->getAll();
    }

    public function register(Request $request)
    {
        if($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name'     => 'required',
                'email'    => 'required|email',
                'password' => 'required'
            ]);
  //          dd($request->all());
            $data = [
                'errors'         => $validator->errors()->all(),
                'request_params' => $request->all(),
            ];
            if ($validator->fails()) {
                return view('register.register',$data);
            }
            $userData = $this->accountService->ldapCheck($request->all());
            if ($userData) {
                return view('register.register',$userData);
            }

            $this->accountService->ldapStore($request->all());
            $successData = $this->accountService->ldapLoginSuccess();
            return view('register.register',$successData);


        }
        return view('register.register');
    }

    public function login(Request $request)
    {
        if($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(), [
                'name'     => 'required',
                'password' => 'required'
            ]);
            $data = [
                'errors'         => $validator->errors()->all(),
                'request_params' => $request->all(),
            ];
            if ($validator->fails()) {
                return view('register.index',$data);
            }
            $res = $this->accountService->ldapLogin($request->all());
            if ($res) {
                $successData = $this->accountService->ldapLoginSuccess();
                return view('register.index',$successData);
            } else {
                $data = [
                    'errors'         => ['登录失败，用户名或者密码不匹配！'],
                    'request_params' => $request->all(),
                ];
                return view('register.index',$data);
            }


        }

        return view('register.index');
    }

    //修改密码
    public function changePassword(Request $request)
    {
        if($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(), [
                'name'     => 'required',
                'password' => 'required',
                'newPassword' => 'required'
            ]);
            $data = [
                'errors'         => $validator->errors()->all(),
                'request_params' => $request->all(),
            ];
            if ($validator->fails()) {
                return view('register.change',$data);
            }
            $checkData = $this->accountService->passwordCheck($request->all());
            if ($checkData) {
                return view('register.change',$checkData);
            }
            $this->accountService->passwordChange($request->all());
            $successData = $this->accountService->ldapLoginSuccess();
            return view('register.change',$successData);

        }
        return view('register.change');
    }

    //找回密码
    public function findPassword(Request $request)
    {
        $data = [];
        if($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(), [
                'email'    => 'required|email',
            ]);
            $data = [
                'errors'         => $validator->errors()->all(),
                'request_params' => $request->all(),
            ];
            if ($validator->fails()) {
                return view('register.forgot',$data);
            }
            $checkData = $this->accountService->emailCheck($request->all());
            if ($checkData) {
                return view('register.forgot',$checkData);
            }
            $data = $this->accountService->sendEmail($request->all());
        }
        return view('register.forgot', $data);
    }

    //重置密码
    public function resetPassword(Request $request, $verifyCode='')
    {
        if($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(), [
                'email'    => 'required|email',
            ]);
            $data = [
                'errors'         => $validator->errors()->all(),
                'request_params' => $request->all(),
            ];
            if ($validator->fails()) {
                return view('register.reset', $data);
            }

            $res = $this->accountService->passwordReset($request->all());
            if ($res == null) {
                return redirect('/account/login');
            }
            return redirect('/account/reset/'.$request->all()['verifyCode']);
        }

        try {
            $verifyCodeArr = decrypt($verifyCode);
        } catch (DecryptException $e) {
            return response('访问链接格式有误，请检查！', 401);
        }

        $verifyTimeOut = $this->accountService->verifyUrlTimeOut($verifyCodeArr);
        $verifyCode = ['verifyCode' => $verifyCode];
        $data = [
            'request_params' => array_merge($verifyCodeArr, $verifyCode),
        ];
        if ($verifyTimeOut) {
            $data = array_merge($data, $verifyTimeOut);
        }

        return view('register.reset',$data);
    }

}