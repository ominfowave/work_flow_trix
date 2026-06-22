@extends('layouts.main')
@section('title', 'Users Update')

@section("content")
    <!-- New Message -->
    <div id="new_message" class="newmessage-details">
         <!-- create admin -->
        <div id="create_client_list" class="newmessage-details">
            <div class="createproject-desc">
                <div class="leftarrow">
                    <a href="{{route('admin.index')}}">
                        <button type="button" id=""><img src="{{asset('/images/right-arrow.svg')}}" alt=""></button>
                    </a>
                </div>
                <h2>Update User</h2>
            </div>
            <div class="create-form-main">
                <form action="{{route('admin.update', $admin->id)}}" method="POST" class="adminForm">
                    <div class="create-form-main">

                    @csrf
                    @method('PUT')
                    @include('admin.form')
                    <div class="submit-btn"><button type="submit">Update</button></div> 
                    </div>
                </form>
            </div>
        </div>
        <!-- end create admin -->
    </div>
    <!-- end New Message -->
@endsection