<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5 table-row" id="table">
        <tbody class="text-gray-600 fw-bold" id="tbody_render">
        @foreach ($requests as $leave)
            <tr>
                <td><img src="{{ asset('assets/images/users/widget-table-pic1.jpg')}}" alt="user" class="rounded-circle" width="45" height="45" /></td>
                <td style="padding: 10px 0;">
                    <h5 class="text-light mb-0 font-16 font-weight-light">{{ "First name" }}</h5>
                    <span class="text-muted font-14">{{ "Engineer" }}</span>
                </td>
                <td class="text-end">
                    <a href="#" id="{{$leave->id}}" class="font-14 font-weight-light" style="color: #fff;">View Reason</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>