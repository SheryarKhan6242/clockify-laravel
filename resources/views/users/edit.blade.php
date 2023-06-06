@extends('layouts.app')
@section('content')
    <div class="card mb-2">
        <div class="ui-block-title">
            <h5 class="title font-weight-bold pt-3 ps-4">Edit User</h5>
        </div>
        <div class="card-body p-10 p-lg-15">
            {{ aire()->open(route('updateUser', ['id' => $user->id]))->rules([
                    'name' => 'required',
                    'username' => 'required',
                    'email' => 'required',
                    'roles' => 'required',
                ])->id('kt_invoice_form')->bind($user) }}
            @include('users.form')
            <div class="row">
                <label class="col-lg-4 fs-6 fw-bold fs-6">Status:</label>
                <div class="col-lg-8 fv-row ">
                    <label class="form-check form-switch form-check-custom form-check-solid">
                        {{ aire()->checkbox('status')->class('form-check-input')->id('status')->checked(isset($user->status) && $user->status == 1 ? $user->status : 0) }}
                    </label>
                </div>
                <div class="d-flex justify-content-end pt-7">
                    <a href="{{ url()->previous() }}" class="btn btn-danger me-2">Cancel</a>
                    <button type="submit"
                        class="btn btn-success">{{ isset($user) ? 'Update User' : 'Add User' }}
                    </button>
                </div>
            </div>
            {{ aire()->close() }}
        </div>
    </div>
@endsection

@section('footer')
@endsection

@push('header-css')
@endpush

@push('header-scripts')
@endpush

@push('footer-scripts')
    <script>
        //USED LATER WHEN WE FILL UP CITIES ON EDIT
        if ($('[id^="country"]').length) {
            console.log("filling cities");
            var country_id = $('#country').val();
            var country_ids = document.querySelectorAll("#country");
            var city_ids = document.querySelectorAll("#city");
            var ids = document.querySelectorAll("#experience_id");

            // url = '/cities-selected'
            // if (location.hostname == 'localhost')
            //     url = '/dbaportal/public/cities-selected'

            // for(var i = 0; i < country_ids.length; i++)
            // {
            //     let country_id = country_ids[i].value
            //     let city_id = city_ids[i].value
            //     let id = ids[i].value
            //     $.ajax({

            //         url: url,
            //         method: 'post',
            //         cache: false,
            //         //contentType: false,
            //         //processData: false,
            //         data: { country_id: country_id, user_id: user_id, city_id: city_id }

            //     }).done(function(responseData) {
            //         $('.city-wrapper_'+id).html(responseData);
            //     }).fail(function(responseData) {

            //     }).always(function() {
            //         $(".preloader").hide();
            //     });
            // }
        }


        function cities(event) {
            console.log("select cities")
            url = '/cities/'
            if (location.hostname == 'localhost')
                url = '/foredimensions/public/cities/'
            var country_id = event.value;
            $(".preloader").show();

            $.ajax({

                url: url + country_id,
                method: 'get',
                cache: false,
                contentType: false,
                processData: false,
                data: {
                    country_id: country_id
                }

            }).done(function(responseData) {
                $('#city').replaceWith(responseData)
                // $('.city-wrapper').html(responseData);

            }).fail(function(responseData) {

            }).always(function() {

                $(".preloader").hide();

            });
        }
    </script>
@endpush
