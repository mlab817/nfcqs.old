<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NFCQS</title>
    <?php $noCache = rand(); ?>

	<link href="{{ asset('vendor/font-awesome-5.0.6/web-fonts-with-css/css/fontawesome-all.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/login.min.css?' . $noCache) }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="{{ asset('/img/da-logo.png') }}" class="login-logo" />
        </div>
        <div class="system-name">
            <h2>NFCQS</h2>
        </div>
        <div class="login-wrapper">
            @if (count($errors) > 0)
                <div class="alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-angle-right"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="alert">
                    <strong><i class="fas fa-lock"></i> Login Form</strong>
                </div>
            @endif
            <form method="POST" action="{{ url('/login') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="text" name="email" value="{{ old('email') }}" placeholder="Email" autocomplete="on" />
                <input type="password" name="password" placeholder="Password" autocomplete="off" />
                <input type="submit" value="Sign in" />
            </form>
        </div>
    </div>
</body>
</html>
