@component('mail::message')
# 重置密码
你好！

要重置密码，请单击以下链接并输入新密码：

@component('mail::button', ['url' => $resetPasswordUrl])
点击重置密码
@endcomponent

谢谢<br>
{{ env('APP_NAME') }}<br>
{{ env('APP_DOMAIN') }}
@endcomponent