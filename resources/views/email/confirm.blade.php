Hello {{$user->name}}

You have changed your email.
Please verify again.
Link: {{route('verify', $user->verification_token)}}