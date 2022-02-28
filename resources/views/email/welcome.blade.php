Hello {{$user->name}}

Thanks for creating your account.

Click this link to verify for account:

Link: {{route('verify', $user->verification_token)}}