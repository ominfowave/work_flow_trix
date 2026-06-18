@extends('layouts.main')
@section("content")
    <div id="new_message" class="newmessage-details">
         <!-- create tech -->
        <div id="create_client_list" class="newmessage-details">
            <div class="createproject-desc">
                <div class="leftarrow">
                    <a href="{{route('tech.index')}}">
                        <button type="button" id=""><img src="{{asset('/images/right-arrow.svg')}}" alt=""></button>
                    </a>
                </div>
                <h2>Update Tech</h2>
            </div>
            <div class="create-form-main">
                <form action="{{route('tech.update', $tech->id)}}" method="post" class="techForm" enctype="multipart/form-data">
                    <div class="create-form-main">
                        @method('PUT')
                        @csrf
                        @include('tech.form')
                        <div class="submit-btn jsSubmit"><button type="submit">Update</button></div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end create tech -->
    </div>
@endsection