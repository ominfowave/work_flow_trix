@extends('layouts.main')
@section("content")
    <!-- New Message -->
    <div id="new_message" class="newmessage-details">
         <!-- create project -->
        <div id="create_project_list" class="newmessage-details">
            <div class="createproject-desc">
                <div class="leftarrow">
                    <a href="{{route('project.index')}}">
                        <button type="button" id=""><img src="{{asset('/images/right-arrow.svg')}}" alt=""></button>
                    </a>
                </div>
                <h2>Create Project</h2>
            </div>
            <form action="{{route('project.store')}}" method="post" class="projectForm" enctype="multipart/form-data">
                @include('project.form')
                @csrf
                <div class="submit-btn"><button type="submit">Submit</button></div>
            </form>

        </div>
        <!-- end create project -->
    </div>
    <!-- end New Message -->
@endsection