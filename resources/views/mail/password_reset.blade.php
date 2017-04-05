<p>Hi, {{$name}}!</p>

<p>It seems like you sent an email asking for your password to be reset.</p>

<p>Click this link below to create a new password.</p>

<p>{{route('new_password_reset', ['id' => $id, 'key' => $key])}}</p>

<p>This link will expire in 10 minutes.</p>



