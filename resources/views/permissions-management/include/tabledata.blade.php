<div class="table-responsive" id="table">
    <table class="table align-middle table-row-dashed fs-6 gy-5 table-row">
        <thead>
            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                <th class="min-w-125px">NAME</th>
                <th class="min-w-125px">GUARD NAME</th>
                <th class="text-end min-w-100px">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 fw-bold">
            @foreach ($permissions as $permission)
                <tr>
                    <td >{{ $permission->name }}</td>
                    <td >{{ $permission->guard_name }}</td>
                    <td class="text-end">@include('permissions-management.actions')</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    @if (isset($permissions))
                        {!! $permissions->links('layouts.pagination') !!}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
</div>
