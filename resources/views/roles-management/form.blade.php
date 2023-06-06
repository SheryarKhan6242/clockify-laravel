<div class="row">
    <div class="col-md-6 fv-row">
        <label class="fs-6 fw-bold">
            <span class="required">Role Name:</span>
        </label>
        {{ aire()->input('name')->class('form-control form-control-solid')->placeholder('Enter role name')->value(isset($role->name) ? $role->name : '') }}
    </div>
    <label class="col-lg-12 fs-6 fw-bold">Permissions:</label>
    {{-- {{ $role->permissions[0]['pivot']->permission_id }} --}}
    @foreach ($permissions as $key => $permission)
        <div class="col-lg-3 fv-row">
            {{ aire()->checkbox('permission_names[]', $permission->name)->value($permission->id)->class('form-check-input')->checked(in_array($permission->id, $selectedPermissions ?? []) ? true : false) }}
        </div>
    @endforeach

</div>
