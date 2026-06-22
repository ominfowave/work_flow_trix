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

@endphp 
<div class="form-input create-form-details">
    <input type="text" placeholder="Tech Name" name="tech_name" value="{{$tech->tech_name ?? ''}}">
</div>

<div class="uploadfile-details create-form-details">
    <div class="form-input">
        <label class="attachment-box attachment-file">
            <div class="attachment-text">Upload Files</div>
            <div class="upload-btn file-uploaded"><img src="{{asset('/images/file-upload.svg')}}" alt=""></div>
            <input type="file" name="tech_icon" class="tech_icon" />
        </label>
    </div>
    @if (isset($tech->tech_icon))
        <img src="{{asset('/tech_image/'. $tech->tech_icon)}}" class="tech_icon_edit" style="width: 50px; height:50px;">
    @endif
</div>

@if (!isset($tech->id))
<div class="form-details create-client-form-details">
    <div class="toggle-container">
        <label class="cust_switch">
        <input type="checkbox" {{ isset($tech->status) && $tech->status == 'active' ? 'checked' : '' }} data-isform="1" name="status" class="jsStatus" value="active"/>
        <span class="cust_slider"></span>
        </label>
        <span class="label">Status</span>
    </div>
</div>
@endif

<script src="{{asset('./js/jquery.min.js')}}"></script>    
<script src="{{asset('./js/jquery.validate.js')}}"></script>    

@include('tech.script')
    