<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('message.deleteaccount') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('message.mssgdelete') }}
        </p>
    </header>

        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')
            <div class="mt-6">
                <x-input-label for="password" value="Password" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    placeholder="{{__('message.Password')}}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>
            <br>
            <div class="mt-6 flex justify-end">
                <button type="submit" class="btn btn-danger">
                    {{ __('message.deleteaccount') }}
                </button>
            </div>
        </form>
</section>
