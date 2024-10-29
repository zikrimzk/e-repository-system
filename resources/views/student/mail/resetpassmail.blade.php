<x-mail::message>
# Reset Password Request

<p>
    Hi {{ $data['name'] }} ! ,
    We have received a request to reset the password for your account.
    To complete the process, click on the link below.
</p>

<a href="{{ route('studentResetPasswordSent',$data['id']) }}">Reset Password</a>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>