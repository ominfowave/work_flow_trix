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
    $client_name = $client_email = $client_phone = $client_status = '';

    if(old('name') && old('name') !== ''){
        $client_name = old('name');
    }else if(isset($client->name)){
        $client_name = $client->name;
    }

    if(old('email') && old('email') !== ''){
        $client_email = old('email');
    }else if(isset($client->email)){
        $client_email = $client->email;
    }

    if(old('phone') && old('phone') !== ''){
        $client_phone = old('phone');
    }else if(isset($client->phone)){
        $client_phone = $client->phone;
    }


    if(old('status') !== null){
        $client_status = old('status');
    }else if(isset($client->status)){
        $client_status = $client->status;
    }

@endphp 
<div class="form-input create-form-details">
    <input type="text" placeholder="Client Name" name="name" class="test" value="{{$client_name}}">
</div>

<div class="form-input create-form-details">
    <input type="text" placeholder="Client-Email" name="email" value="{{$client_email}}">
</div>

<div class="form-input create-form-details">
    <input type="number" placeholder="Contact No" name="phone" value="{{$client_phone}}">
</div>

<div class="form-input create-form-details">
    <input type="password" placeholder="Password" name="password" value="" class="jsPassword">
</div>

@if (!isset($client->id))
    <div class="form-details create-client-form-details">
        <div class="toggle-container">
            <label class="cust_switch">
            <input type="checkbox" {{$client_status == 'active' ? 'checked' : ''}} name="status" class="jsStatus" data-isform="1" value="active"/>
            <span class="cust_slider"></span>
            </label>
            <span class="label">Status</span>
        </div>
    </div>
@endif

<script src="{{asset('./js/jquery.min.js')}}"></script>    
<script src="{{asset('./js/jquery.validate.js')}}"></script>    

@include('client.script')
    