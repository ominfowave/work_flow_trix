@extends('layouts.main')
@section("content")
    <!-- New Message -->
    <div id="new_message" class="newmessage-details">
         <!-- create user -->
        <div id="create_client_list" class="newmessage-details">
            <div class="createproject-desc">
                <div class="leftarrow">
                    <a href="{{route('admin.index')}}">
                        <button type="button" id=""><img src="{{asset('/images/right-arrow.svg')}}" alt=""></button>
                    </a>
                </div>
                <h2>Create User</h2>
            </div>
            <div class="create-form-main">
                <form action="{{route('admin.store')}}" method="post" class="adminForm">
                    <div class="create-form-main">
                        @include('admin.form')
                        @csrf
                        <div class="submit-btn"><button type="submit">Submit</button></div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end create user -->
    </div>
    <!-- end New Message -->
@endsection