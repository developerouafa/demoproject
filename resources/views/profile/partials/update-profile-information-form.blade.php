
    <div class="card">
        <div class="card-body">
                <form method="post" action="{{ route('profile.updateprofile') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')
                    <div class="mb-4 main-content-label">{{__('message.personal information')}}</div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{__('message.User Name')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}" autocomplete="name">
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{__('message.First Name')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="firstname" class="form-control" value="{{Auth::user()->firstname}}"  autofocus autocomplete="firstname" >
                                    <x-input-error class="mt-2" :messages="$errors->get('firstname')" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{__('message.last Name')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="lastname" class="form-control" value="{{Auth::user()->lastname}}"  autofocus autocomplete="lastname" >
                                    <x-input-error class="mt-2" :messages="$errors->get('lastname')" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{__('message.Nick Name')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="nickname" class="form-control" value="{{Auth::user()->nickname}}"  autofocus autocomplete="nickname" >
                                    <x-input-error class="mt-2" :messages="$errors->get('nickname')" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{__('message.Designation')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="designation" class="form-control" value="{{Auth::user()->designation}}"  autofocus autocomplete="designation" >
                                    <x-input-error class="mt-2" :messages="$errors->get('designation')" />
                                </div>
                            </div>
                        </div>
                    <div class="mb-4 main-content-label">{{__('message.contactinfo')}}</div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{__('message.Website')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="website" class="form-control" value="{{Auth::user()->website}}" autofocus autocomplete="website" >
                                    <x-input-error class="mt-2" :messages="$errors->get('website')" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{__('message.Phone')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="phone" class="form-control" value="{{Auth::user()->phone}}" autofocus autocomplete="phone" >
                                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{__('message.Address')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="address" class="form-control" value="{{Auth::user()->address}}" autofocus autocomplete="address" >
                                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                                </div>
                            </div>
                        </div>

                    <div class="mb-4 main-content-label">{{__('message.social')}}</div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{__('message.Twitter')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="twitter" class="form-control" value="{{Auth::user()->twitter}}" autofocus autocomplete="twitter" >
                                    <x-input-error class="mt-2" :messages="$errors->get('twitter')" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{__('message.Facebook')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="facebook" class="form-control" value="{{Auth::user()->facebook}}"  autofocus autocomplete="facebook" >
                                    <x-input-error class="mt-2" :messages="$errors->get('facebook')" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{__('message.Google+')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="google" class="form-control" value="{{Auth::user()->google}}"  autofocus autocomplete="google" >
                                    <x-input-error class="mt-2" :messages="$errors->get('google')" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{__('message.Linked in')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="linkedin" class="form-control" value="{{Auth::user()->linkedin}}" autofocus autocomplete="linkedin" >
                                    <x-input-error class="mt-2" :messages="$errors->get('linkedin')" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{__('message.Github')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="github" class="form-control" value="{{Auth::user()->github}}" autofocus autocomplete="github" >
                                    <x-input-error class="mt-2" :messages="$errors->get('github')" />
                                </div>
                            </div>
                        </div>
                    <div class="mb-4 main-content-label">{{__('message.about yourself')}}</div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">{{__('message.Biographical Info')}}</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="biographicalinfo" class="form-control" value="{{Auth::user()->biographicalinfo}}" autofocus autocomplete="biographicalinfo" rows="4">
                                    <x-input-error class="mt-2" :messages="$errors->get('biographicalinfo')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                                    <div class="card-footer text-left">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{__('message.Update Profile')}}</button>
                                    </div>

                            @if (session('status') === 'profile-updated')
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
