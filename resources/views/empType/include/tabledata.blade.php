<div class="table-responsive" >
    <table class="table align-middle table-row-dashed fs-6 gy-5 table-row" id="table" >
        <thead>
        <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
            <th class="min-w-125px">ID</th>
            <th class="min-w-125px">TYPE</th>
            <th class="text-end min-w-100px">Actions</th>
        </tr>
        </thead>
        <tbody class="text-gray-600 fw-bold" id="tbody_render">
            @foreach ($empTypes as $type)
                <tr>
                    <td>{{$type->id}}</td>
                    <td>{{$type->name}}</td>
                    <td>@include('empType.actions', ['id' => $type->id]) </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    @if(isset($types))
                        {!! $types->links('layouts.pagination') !!}
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
</div>