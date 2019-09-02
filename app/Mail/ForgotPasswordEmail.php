<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/31
 * Time: 13:53
 */

namespace App\Mail;

use Illuminate\Mail\Mailable;

class RegisterConfirmation extends Mailable
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('register.forgotEmail');
    }
}