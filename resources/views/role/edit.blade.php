@extends('layouts.main')
@section("content")
    <div id="new_message" class="newmessage-details">
         <!-- create role -->
        <div id="create_client_list" class="newmessage-details">
            <div class="createproject-desc">
                <div class="leftarrow">
                    <a href="{{route('role.index')}}">
                        <button type="button" id=""><img src="{{asset('/images/right-arrow.svg')}}" alt=""></button>
                    </a>
                </div>
                <h2>Update Role</h2>
            </div>
            <div class="create-form-main">
                <form action="{{route('role.update', $role->id)}}" method="post" class="roleForm" enctype="multipart/form-data">
                    <div class="create-form-main">
                        @method('PUT')
                        @csrf
                        @include('role.form')
                        <div class="submit-btn jsSubmit"><button type="submit">Update</button></div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end create role -->
    </div>
@endsection