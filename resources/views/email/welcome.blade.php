Hello {{$user->name}}

Thanks for creating your account.

Click this link to verify for account:

Link: {{route('verify', $user->verification_token)}}

@component('mail::message')
Hello {{$user->name}}


Thanks for creating your account.

Click this link to verify for account:

@component('mail::button', ['url' => route('verify', $user->verification_token)])
VERIFY ACCOUNT
@endcomponent

Thanks,
{{ config('app.name') }}
@endcomponent