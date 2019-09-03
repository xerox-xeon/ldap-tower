<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/31
 * Time: 13:53
 */

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ResetConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(env('APP_NAME').'重置密码')->markdown('mail.resetPassword')->with([
            'resetPasswordUrl' => $this->data,
        ]);
    }
}