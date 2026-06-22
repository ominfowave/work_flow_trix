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
    <input type="text" placeholder="Role Name" name="name" value="{{ isset($role) ? $role->name : old('name') }}" required>
</div>

<div class="create-role-main">
    <h3>Permissions</h3>
    <div class="user-client-project">
        <div class="sub-user-client-project jsPerParent">
            <div class="custom-checkbox-group">
                <label class="custom-checkbox">
                    <input type="checkbox" id="" class="jsModulePer" {{ isset($permissions) && in_array('user-view', $permissions) && in_array('user-edit', $permissions) && in_array('user-add', $permissions) && in_array('user-delete', $permissions) ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                    <span class="label-text">User</span>
                </label>
            </div>

            <div class="user-view-add-edit-delete">
                <div class="custom-checkbox-group">
                    <label class="custom-checkbox user-checkbox">
                        <input type="checkbox" id="" name="permissions[]" class="per_list" value="user-view" {{ isset($permissions) && in_array('user-view', $permissions) ? 'checked' : '' }}>
                        <span class="checkmark jscheckmark"></span>
                        <span class="label-text">View</span>
                    </label>
                </div>

                <div class="custom-checkbox-group">
                    <label class="custom-checkbox user-checkbox">
                        <input type="checkbox" id="" name="permissions[]" class="per_list" value="user-edit" {{ isset($permissions) && in_array('user-edit', $permissions) ? 'checked' : '' }}>
                        <span class="checkmark jscheckmark"></span>
                        <span class="label-text" >Edit</span>
                    </label>
                </div>

                <div class="custom-checkbox-group">
                    <label class="custom-checkbox user-checkbox">
                        <input type="checkbox" id="" name="permissions[]" class="per_list" value="user-add" {{ isset($permissions) && in_array('user-add', $permissions) ? 'checked' : '' }}>
                        <span class="checkmark jscheckmark"></span>
                        <span class="label-text" >Add</span>
                    </label>
                </div>

                <div class="custom-checkbox-group">
                    <label class="custom-checkbox user-checkbox">
                        <input type="checkbox" id="" name="permissions[]" class="per_list" value="user-delete" {{ isset($permissions) && in_array('user-delete', $permissions) ? 'checked' : '' }}>
                        <span class="checkmark jscheckmark"></span>
                        <span class="label-text" >Delete</span>
                    </label>
                </div>
            </div>
        </div>

        
        <div class="sub-user-client-project jsPerParent">
            <div class="custom-checkbox-group">
                <label class="custom-checkbox">
                    <input type="checkbox" id="" class="jsModulePer" {{ isset($permissions) && in_array('client-view', $permissions) && in_array('client-edit', $permissions) && in_array('client-add', $permissions) && in_array('client-delete', $permissions) ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                    <span class="label-text">Client</span>
                </label>
            </div>

            <div class="user-view-add-edit-delete">
                <div class="custom-checkbox-group">
                    <label class="custom-checkbox user-checkbox">
                        <input type="checkbox" id=""  name="permissions[]" class="per_list" value="client-view" {{ isset($permissions) && in_array('client-view', $permissions) ? 'checked' : '' }}>
                        <span class="checkmark jscheckmark"></span>
                        <span class="label-text">View</span>
                    </label>
                </div>

                <div class="custom-checkbox-group">
                    <label class="custom-checkbox user-checkbox">
                        <input type="checkbox" id=""  name="permissions[]" class="per_list" value="client-edit" {{ isset($permissions) && in_array('client-edit', $permissions) ? 'checked' : '' }}>
                        <span class="checkmark jscheckmark"></span>
                        <span class="label-text">Edit</span>
                    </label>
                </div>

                <div class="custom-checkbox-group">
                    <label class="custom-checkbox user-checkbox">
                        <input type="checkbox" id=""  name="permissions[]" class="per_list" value="client-add" {{ isset($permissions) && in_array('client-add', $permissions) ? 'checked' : '' }}>
                        <span class="checkmark jscheckmark"></span>
                        <span class="label-text">Add</span>
                    </label>
                </div>

                <div class="custom-checkbox-group">
                    <label class="custom-checkbox user-checkbox">
                        <input type="checkbox" id="" name="permissions[]" class="per_list" value="client-delete" {{ isset($permissions) && in_array('client-delete', $permissions) ? 'checked' : '' }}>
                        <span class="checkmark jscheckmark"></span>
                        <span class="label-text">Delete</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="sub-user-client-project jsPerParent">
            <div class="custom-checkbox-group">
                <label class="custom-checkbox">
                    <input type="checkbox" id="" class="jsModulePer" {{ isset($permissions) && in_array('project-view', $permissions) && in_array('project-edit', $permissions) && in_array('project-add', $permissions) && in_array('project-delete', $permissions) ? 'checked' : '' }}>
                    <span class="checkmark"></span>
                    <span class="label-text">Project</span>
                </label>
            </div>

            <div class="user-view-add-edit-delete">
                <div class="custom-checkbox-group">
                    <label class="custom-checkbox user-checkbox">
                        <input type="checkbox" id="" name="permissions[]" class="per_list" value="project-view" {{ isset($permissions) && in_array('project-view', $permissions) ? 'checked' : '' }}>
                        <span class="checkmark jscheckmark"></span>
                        <span class="label-text">View</span>
                    </label>
                </div>

                <div class="custom-checkbox-group">
                    <label class="custom-checkbox user-checkbox">
                        <input type="checkbox" id="" name="permissions[]" class="per_list" value="project-edit" {{ isset($permissions) && in_array('project-edit', $permissions) ? 'checked' : '' }}>
                        <span class="checkmark jscheckmark"></span>
                        <span class="label-text">Edit</span>
                    </label>
                </div>

                <div class="custom-checkbox-group">
                    <label class="custom-checkbox user-checkbox">
                        <input type="checkbox" id="" name="permissions[]" class="per_list" value="project-add" {{ isset($permissions) && in_array('project-add', $permissions) ? 'checked' : '' }}>
                        <span class="checkmark jscheckmark"></span>
                        <span class="label-text">Add</span>
                    </label>
                </div>

                <div class="custom-checkbox-group">
                    <label class="custom-checkbox user-checkbox">
                        <input type="checkbox" id="" name="permissions[]" class="per_list" value="project-delete" {{ isset($permissions) && in_array('project-delete', $permissions) ? 'checked' : '' }}>
                        <span class="checkmark jscheckmark"></span>
                        <span class="label-text">Delete</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

@if (!isset($role->id))
<div class="form-details create-client-form-details">
    <div class="toggle-container">
        <label class="cust_switch">
        <input type="checkbox" checked name="status" value="active" class="jsStatus" data-isform="1"/>
        <span class="cust_slider"></span>
        </label>
        <span class="label">Status</span>
    </div>
</div>
@endif

<script src="{{asset('./js/jquery.min.js')}}"></script>    
<script src="{{asset('./js/jquery.validate.js')}}"></script>    

@include('role.script')
    