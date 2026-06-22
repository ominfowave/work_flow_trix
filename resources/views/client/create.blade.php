@extends('layouts.main')
@section("content")
    <!-- New Message -->
    <div id="new_message" class="newmessage-details">
         <!-- create client -->
        <div id="create_client_list" class="newmessage-details">
            <div class="createproject-desc">
                <div class="leftarrow">
                    <a href="{{route('client.index')}}">
                        <button type="button" id=""><img src="{{asset('/images/right-arrow.svg')}}" alt=""></button>
                    </a>
                </div>
                <h2>Create Client</h2>
            </div>
            <div class="create-form-main">
                <form action="{{route('client.store')}}" method="post" class="clientForm">
                    <div class="create-form-main">
                        @include('client.form')
                        @csrf
                        <div class="submit-btn"><button type="submit">Submit</button></div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end create client -->
    </div>
    <!-- end New Message -->
@endsection