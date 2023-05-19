<div class="row g-9">
    <div class="col-md-6 fv-row">
        <label class="fs-6 fw-bold">
            <span class="required">Name</span>
        </label>
        {{ aire()->input('name')->placeholder('Template Name')->id('name')->class('form-control form-control-solid')->value(isset($template->name) ? $template->name : '') }}
    </div>
    <div class="col-md-6 fv-row">
        <label class="fs-6 fw-bold">
            <span class="required">Subject</span>
        </label>
        {{ aire()->input('subject')->placeholder('Subject')->id('subject')->class('form-control form-control-solid')->value(isset($template->subject) ? $template->subject : '') }}
    </div>
</div>
<div class="row g-9">
    <div class="col-md-12 fv-row">
        <label class="fs-6 fw-bold">
            <span class="required">Body</span>
        </label>
        {{ aire()->textarea('content')->class('ckeditor mt-2')->rows(3)->cols(40)->value(isset($template->body) ? $template->body : '') }}
    </div>
</div>

