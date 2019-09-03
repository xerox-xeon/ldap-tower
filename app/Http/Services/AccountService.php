<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/28
 * Time: 9:47
 */

namespace App\Http\Services;

use Carbon\Carbon;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Ldap\Entry;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetConfirmation;


class AccountService
{
    protected $config;
    protected $ldap;

    public function __construct()
    {
        $this->config = [
            'ldap_server'      => env('LDAP_SERVER'),
            'ldap_base_dn'     => env('LDAP_BASE_DN'),
            'ldap_username'    => env('LDAP_ADMIN_USERNAME'),
            'ldap_password'    => env('LDAP_ADMIN_PASSWORD'),
            'ldap_user_domain' => env('LDAP_USER_DOMAIN'),
        ];
        $this->ldap   = $this->ldapCreate();

    }

    private function getLdapPassWd($passWord)
    {
        return '{MD5}' . base64_encode(md5($passWord, true));
    }

    public function ldapCreate()
    {
        $ldap = Ldap::create('ext_ldap', ['connection_string' => $this->config['ldap_server']]);
        $ldap->bind($this->config['ldap_username'], $this->config['ldap_password']);
        return $ldap;
    }

    public function ldapLogin($data)
    {
        $data         = array_map('trim', $data);
        $uid          = $data['name'];
        $userPassword = $this->getLdapPassWd($data['password']);

        $query   = $this->ldap->query($this->config['ldap_base_dn'], '(&(uid=' . $uid . ')(userpassword=' . $userPassword . '))');
        $results = $query->execute()->toArray();
        return $results;
    }


    //用户检测是否存在
    public function ldapCheck($data)
    {
        $json    = [];
        $data    = array_map('trim', $data);
        $query   = $this->ldap->query($this->config['ldap_base_dn'], '(|(uid=' . $data['name'] . ')(mail=' . $data['email'] . '))');
        $results = $query->execute()->toArray();
        if ($results) {
            $json = [
                'request_params' => $data,
                'errors'         => [
                    '注册失败，用户或邮箱已存在 ' . $results[0]->getDn(),
                ]
            ];
        }
        return $json;
    }

    //修改密码检测
    public function passwordCheck($data)
    {
        $json = [];
        $data = array_map('trim', $data);
        $res  = $this->ldapLogin($data);
        if (!$res) {
            $json = [
                'request_params' => $data,
                'errors'         => [
                    '修改密码失败，原密码无效！',
                ]
            ];
            return $json;
        }
        if ($data['password'] == $data['newPassword']) {
            $json = [
                'request_params' => $data,
                'errors'         => [
                    '修改密码失败，新密码和原密码相同！',
                ]
            ];
        }
        return $json;

    }

    //邮箱检测
    public function emailCheck($data)
    {
        $json    = [];
        $data    = array_map('trim', $data);
        $email   = $data['email'];
        $query   = $this->ldap->query($this->config['ldap_base_dn'], '(mail=' . $email . ')');
        $results = $query->execute()->toArray();
        if (!$results) {
            $json = [
                'request_params' => $data,
                'errors'         => [
                    '邮箱地址不存在！',
                ]
            ];
        } else {
            $entry       = $results[0];
            $description = $entry->getAttribute('description');
            if ($description) {
                $json = [
                    'request_params' => $data,
                    'errors'         => [
                        '重置密码邮件已发送，请查收邮件！',
                    ]
                ];
            }
        }
        return $json;
    }

    //修改用户密码
    public function passwordChange($data)
    {
        $data            = array_map('trim', $data);
        $userPassword    = $this->getLdapPassWd($data['password']);
        $userNewPassword = $this->getLdapPassWd($data['newPassword']);
        $entryManager    = $this->ldap->getEntryManager();
        $query           = $this->ldap->query($this->config['ldap_base_dn'], '(&(uid=' . $data['name'] . ')(userpassword=' . $userPassword . '))');
        $result          = $query->execute();
        $entry           = $result[0];
        $entry->setAttribute('userPassword', [$userNewPassword]);
        $entryManager->update($entry);

    }

    //重置用户密码
    public function passwordReset($data)
    {
        $data         = array_map('trim', $data);
        $timestamp    = Carbon::now()->timestamp;
        $userPassword = $this->getLdapPassWd($data['password']);
        $entryManager = $this->ldap->getEntryManager();
        $query        = $this->ldap->query($this->config['ldap_base_dn'], '(mail=' . $data['email'] . ')');
        $result       = $query->execute();
        $entry        = $result[0];
        $description  = $entry->getAttribute('description');

        //检测是否过期
        if ($timestamp <= $description[0]) {
            $entry->setAttribute('userPassword', [$userPassword]);
            $entry->setAttribute('description', []);
            $entryManager->update($entry);
            return null;
        } else {
            $data = [
                'errors' => ['msg' => '重置链接时间已经过期，重置密码失败！'],
            ];
            return $data;
        }

    }

    //链接过期时间检测
    public function verifyUrlTimeOut($data)
    {
        $json        = [];
        $data        = array_map('trim', $data);
        $timestamp   = Carbon::now()->timestamp;
        $query       = $this->ldap->query($this->config['ldap_base_dn'], '(mail=' . $data['email'] . ')');
        $result      = $query->execute();
        $entry       = $result[0];
        $description = $entry->getAttribute('description');

        //检测是否过期
        //dd($timestamp , $description[0]);
        if ($timestamp > $description[0]) {
            $json = [
                'errors' => ['verifyUrlTimeOut' => '重置链接URL已过期失效！'],
            ];
        }
        return $json;
    }

    //用户注册成功
    public
    function ldapLoginSuccess()
    {
        $domain     = env('LDAP_USER_DOMAIN');
        $devOpsItem = [
            'ops'     => 'http://ops.' . $domain,
            'jenkins' => 'http://jenkins.ops.' . $domain,
            'gitlab'  => 'http://git.ops.' . $domain,
            'wiki'    => 'http://wiki.ops.' . $domain,
        ];
        $json       = [
            'login_success' => $devOpsItem,
        ];
        return $json;
    }

    //保存注册用户
    public
    function ldapStore($data)
    {
        $data          = array_map('trim', $data);
        $givenName     = mb_substr($data['cnname'], 0, 1, 'utf-8');
        $sn            = mb_substr($data['cnname'], 1, 10, 'utf-8') ? mb_substr($data['cnname'], 1, 10, 'utf-8') : $givenName;
        $uidNumberTime = Carbon::now()->timestamp;
        $record        = [
            'cn'              => $data['name'],
            'uid'             => $data['name'],
            'mail'            => $data['email'],
            'givenname'       => $givenName, //姓
            'sn'              => $sn,//名
            'userpassword'    => $this->getLdapPassWd($data['password']),   //密码
            'homedirectory'   => '/home/users/' . $data['name'],
            'loginshell'      => '/bin/bash',
            'gidnumber'       => '0',
            'uidnumber'       => $uidNumberTime, //唯一
            'expireTimeStamp' => $uidNumberTime, //过期时间
            'objectclass'     => [
                'posixAccount', 'top', 'inetOrgPerson'
            ]
        ];
        $entry         = new Entry('uid=' . $record['uid'] . ',' . $this->config['ldap_base_dn'], $record);
        $entryManager  = $this->ldap->getEntryManager();
        $entryManager->add($entry);


    }


    /**
     * @param $data
     * @return array
     */
    public function sendEmail($data)
    {
        $url = $this->setExpireDate($data);
//
//        Mail::raw('MinHow, ' . $url, function ($message) use ($data) {
//            $to = trim($data['email']);
//            $message->sender('noreply@test.com');
//            $message->to($to)->subject('测试邮件');
//        });
        $to = trim($data['email']);
        Mail::to($to)->send(new ResetConfirmation($url));
        $json       = [
            'login_success' => ['email' => $to]
        ];
        return $json;
    }

    /**
     * @param $data
     * @return string
     */
    public function setExpireDate($data)
    {
        $expireTimeStamp = Carbon::tomorrow()->timestamp;
        $data            = array_map('trim', $data);
        $email           = $data['email'];
        $expireArr       = [
            'email'     => $data['email'],
            'timeStamp' => $expireTimeStamp,
        ];
        $expireData      = encrypt($expireArr);
        $entryManager    = $this->ldap->getEntryManager();
        $query           = $this->ldap->query($this->config['ldap_base_dn'], '(mail=' . $email . ')');
        $result          = $query->execute();
        $entry           = $result[0];
        $entry->setAttribute('description', [$expireTimeStamp]);
        $entryManager->update($entry);
        return url('/account/reset/' . $expireData);
    }
}