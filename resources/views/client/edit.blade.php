@extends('layouts.main')
@section('title', 'Clients Update')

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
                <h2>Update Client</h2>
            </div>
            <div class="create-form-main">
                <form action="{{route('client.update', $client->id)}}" method="POST" class="clientForm">
                    @csrf
                    @method('PUT')
                    @include('client.form')
                    <div class="submit-btn"><button type="submit">Update</button></div>
                </form>
            </div>
        </div>
        <!-- end create client -->
    </div>
    <!-- end New Message -->
@endsection