
Hello {!! $user->name !!},
<br>
<br>
Please use the link below to set a new password:
<br>
<a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
<br>
<br>
Thanks & Regards
<br>
The Turnstr Team