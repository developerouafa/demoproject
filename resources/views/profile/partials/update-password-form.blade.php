<div class="card">
    <div class="card-body">
        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')

                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label"> {{__('message.Current Password')}} </label>
                        </div>
                        <div class="col-md-9">
                            <x-text-input id="current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">{{__('message.New Password')}}</label>
                        </div>
                        <div class="col-md-9">
                            <x-text-input id="password" name="password" type="password" class="form-control" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">{{__('message.Confirm Password')}}</label>
                        </div>
                        <div class="col-md-9">
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                </div>

            <div class="flex items-center gap-4">
                <div class="card-footer text-left">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{__('message.Update Password')}}</button>
                </div>

                @if (session('status') === 'password-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    </div>
</div>
