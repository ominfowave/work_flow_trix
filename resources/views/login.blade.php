<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
    <link rel="icon" type="image/png" href="{{asset('/images/new_logo.png')}}">

    <link rel="stylesheet" href="{{asset('/css/all.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/style.css')}}" />
</head>

<body>
<div class="login-body">    
    <div class="loginbox">
        <div class="main_container">
            <form action="{{route('submitLogin')}}" method="post" >
                @csrf
                <div class="loginbox-bg">
                    <div class="logo-details login_desc"><img src="{{asset('/images/new_logo.png')}}" alt=""></div>
                    <h2>Login to Work flowtrix</h2>
                    <!-- Username -->
                    @if(session('error'))
                        <div class="custom-alert">
                            <span style="margin:0; padding-left:18px;">
                                <span>{{ session('error') }}</span>
                            </span>
                        </div>
                    @endif
                    <div class="input-box">
                        <input type="text" placeholder=" " name="name">
                        <label>User Name</label>
                    </div>
    
                    <!-- Password -->
                    <div class="input-box password-box">
                        <input type="password" id="password" placeholder=" " name="password" class="jspassword">
                        <label>Password</label>
    
                        <i class="fa-regular fa-eye-slash jsViewPass" id="eye"></i>
                    </div>
                    
                    
                    <div class="custom-checkbox-group">
                        <label class="custom-checkbox">
                            <input type="checkbox" id="remember" name="remember">
                            <span class="checkmark"></span>
                            <span class="label-text">Remember me</span>
                        </label>
                    </div>
                    
    
                    <!-- Button -->
                    <button class="login_btn" type="submit">Login</button>
    
                </div>
            </form>
        </div>
    </div>
</div>


</body>
<script src="{{asset('./js/jquery.min.js')}}"></script>    
<script>
    $(document).ready(function(){
        $(document).on("click", ".jsViewPass", function(){
            if($(this).hasClass("fa-eye-slash")){
                $(this).removeClass("fa-eye-slash").addClass("fa-eye");
                $(".jspassword").attr("type", "text");
            }else{
                $(this).addClass("fa-eye-slash").removeClass("fa-eye");
                $(".jspassword").attr("type", "password");
            }
        });
    });
</script>
</html>