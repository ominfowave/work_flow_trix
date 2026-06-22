@if(session('error'))
<div class="custom-alert">
    <ul style="margin:0; padding-left:18px;">
        @foreach(session('error') as $field => $messages)
                    <li>{{ $messages }}</li>
            @endforeach
        </ul>
    </div>
@endif
@php
    $full_name = $user_name = $admin_status = '';

    if(old('full_name') && old('full_name') !== ''){
        $full_name = old('full_name');
    }else if(isset($admin->full_name)){
        $full_name = $admin->full_name;
    }

    if(old('name') && old('name') !== ''){
        $user_name = old('name');
    }else if(isset($admin->name)){
        $user_name = $admin->name;
    }




    if(old('status') !== null){
        $admin_status = old('status');
    }else if(isset($admin->status)){
        $admin_status = $admin->status;
    }

@endphp 
<div class="form-input create-form-details">
    <input type="text" placeholder="Full Name" name="full_name" class="" value="{{$full_name}}" autocomplete="full_name">
</div>

<div class="form-input create-form-details">
    <input type="text" placeholder="User Name" name="name" class="" value="{{$user_name}}" autocomplete="name">
</div>

 <div class="form-input create-form-details">
    <div class="select-project-ddl">
        <select name="role_id">
            <option id="" selected disabled>Select Role</option>
            @if(count($roles) > 0)
                @foreach ($roles as $id => $item)
                    <option value="{{ $id }}" {{ isset($admin) && $admin->role_id == $id ? 'selected' : '' }}>{{ $item }}</option>
                @endforeach
            @endif
        </select>
        <img src="{{asset('/images/down-arrow.svg')}}" alt="">
    </div>
</div>
                                
<div class="form-input create-form-details">
    <div class="select-project-ddl">
        <select name="tech_id">
            <option id="" selected disabled>Select Tech</option>
            @if(count($techs) > 0)
                @foreach ($techs as $id => $tech)
                    <option value="{{ $id }}" {{ isset($admin) && $admin->tech_id == $id ? 'selected' : ''}}>{{ $tech }}</option>
                @endforeach
            @endif
        </select>
        <img src="{{asset('/images/down-arrow.svg')}}" alt="">
    </div>
</div>

<div class="form-input create-form-details">
    <input type="password" placeholder="Password" name="password" value="" class="jsPassword" autocomplete="new-password">
</div>

@if (!isset($admin->id))
<div class="form-details create-client-form-details">
    <div class="toggle-container">
        <label class="cust_switch">
        <input type="checkbox" name="status" class="jsStatus" data-isform="1" value="active" {{ $admin_status === 'active' ? 'checked' : '' }} />
        <span class="cust_slider"></span>
        </label>
        <span class="label">Status</span>
    </div>
</div>
@endif

<script src="{{asset('./js/jquery.min.js')}}"></script>    
<script src="{{asset('./js/jquery.validate.js')}}"></script>    

@include('admin.script')
    