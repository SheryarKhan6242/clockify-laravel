@extends('layouts.app')
@section('content')
<div class="card">
    <div class="ui-block-title">
        <h5 class="title font-weight-bold pt-3 ps-4">Edit Template</h5>
    </div>
    <div class="card-body">      
        <div class="row">
           {{ aire()->open(route('template.update', ['id' => $template->id]))
           ->rules([
                    'name' => 'required',
                    'subject' => 'required',
                    'content' => 'required',
            ])
            ->bind($template)
            ->encType('multipart/form-data')
            }}
            @include('emailTemplate.form')
            {{ aire()->submit('Update Template')->class('float-end btn btn-md btn-success btn-change') }}
            <a href="{{url()->previous()}}" id="btnClosePopup" class="float-end btn btn-md btn-danger btn-change inline-block text-base rounded p-2 px-4 text-white bg-blue-600 border-blue-700 hover:bg-blue-700 hover:border-blue-900 ms-2">Cancel</a>               
            {{ aire()->close() }}
        </div>
    </div>
</div>
@endsection

@section('footer')

@endsection

@push('header-css')
<style>
    .ck.ck-editor__main > .ck-editor__editable{
        height: 150px;
    }
</style>
@endpush

@push('header-scripts')

@endpush

@push('modals')

@endpush

@push('footer-scripts')

@endpush