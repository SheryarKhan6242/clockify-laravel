<div class="row g-9">
    <div class="col-md-6 fv-row">
        <label class="fs-6 fw-bold">
            <span class="required">Name</span>
        </label>
        {{ aire()->input('name')->class('form-control form-control-solid')->placeholder('Enter Name')->value(isset($user->name) ? $user->name : '') }}
    </div>
    <div class="col-md-6 fv-row">
        <label class="fs-6 fw-bold">
            <span class="required">Username</span>
        </label>
        {{ aire()->input('username')->class('form-control form-control-solid')->placeholder('Enter Username')->value(isset($user->username) ? $user->username : '') }}
    </div>
    <div class="col-md-6 fv-row">
        <label class="fs-6 fw-bold">
            <span class="required">Email</span>
        </label>
        {{ aire()->email('email')->id('email')->class('form-control form-control-solid')->placeholder('Enter Your Email')->value(isset($user->email) ? $user->email : '') }}
    </div>
    <div class="col-md-6 fv-row">
        <label class="fs-6 fw-bold">
            <span class="required">Role</span>
        </label>
        {{ aire()->select(Spatie\Permission\Models\Role::where('name', '!=', 'super-admin')->pluck('name', 'name')->prepend('Select role', ''),'roles','')->id('roles')->class('form-control form-control-solid selectjs2')->value(isset($user->roles) && isset($user->roles->first()->name) ? $user->roles->first()->name : '') }}
    </div>
</div>
