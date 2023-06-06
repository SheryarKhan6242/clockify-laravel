<div class="btn-group float-end" role="group" aria-label="Basic example">
    <div>
        <a href="{{route('roles-management.edit', ['role' => $role->id])}}" class="menu-link px-3" data-kt-users-table-filter="delete_row">Edit</a>
    </div>
    <div>
        <a href="{{route('roles-management.destroy', ['role' => $role->id])}}" class="menu-link px-3" data-kt-users-table-filter="delete_row">Delete</a>
    </div>
</div>    