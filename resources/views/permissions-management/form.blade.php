<div class="row g-9">
    <div class="col-md-6 fv-row">
        <label class="fs-6 fw-bold">
            <span class="required">Permission name:</span>
        </label>
        {{ aire()->input('name')->class('form-control form-control-solid')->placeholder('Enter permission name')->value(isset($permission->name) ? $permission->name : '') }}
    </div>
</div>
