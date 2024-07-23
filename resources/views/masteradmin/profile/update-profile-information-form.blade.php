
<div class="card-header">
    <h3 class="card-title">{{ __('Personal Information') }}</h3>
</div>
<form method="post" action="{{ route('business.profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
@csrf
@method('patch')
<?php //dd($user); ?>
<div class="card-body2">
    <div class="row pad-5">
        <div class="col-md-6">
            <div class="form-group">
                <x-input-label for="user_first_name" :value="__('First Name')" />
                <x-text-input id="user_first_name" name="user_first_name" type="text" class="mt-1 block w-full" :value="old('user_first_name', $user->user_first_name)"
                    required autofocus autocomplete="user_first_name" placeholder="Enter First Name" />
                <x-input-error class="mt-2" :messages="$errors->get('user_first_name')" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <x-input-label for="user_last_name" :value="__('Last Name')" />
                <x-text-input id="user_last_name" name="user_last_name" type="text" class="mt-1 block w-full" :value="old('user_last_name', $user->user_last_name)"
                    required autofocus autocomplete="name" placeholder="Enter Last Name"/>
                <x-input-error class="mt-2" :messages="$errors->get('user_last_name')" />
            </div>
        </div>
      
        <div class="col-md-6">
            <div class="form-group">
                <x-input-label for="country" :value="__('Country')" />
                <select class="form-control select2" style="width: 100%;" id="country" name="country_id" required>
                    <option >Select a Country...</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('country_id', $user->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }} ({{ $country->iso2 }})</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('country_id')" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <x-input-label for="state" :value="__('Province/State')" />
                <select class="form-control select2" style="width: 100%;" id="state" name="state_id" required>
                    <option >Select a State...</option>
                    @foreach($states as $state)
                        <option value="{{ $state->id }}" {{ $state->id == old('state_id', $selectedStateId) ? 'selected' : '' }}>
                            {{ $state->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('state_id')" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <x-input-label for="user_city_name" :value="__('City')" />
                <x-text-input id="user_city_name" name="user_city_name" type="text" class="mt-1 block w-full" :value="old('user_city_name', $user->user_city_name)"
                     autofocus autocomplete="user_city_name" placeholder="Enter A City"/>
                <x-input-error class="mt-2" :messages="$errors->get('user_city_name')" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <x-input-label for="user_pincode" :value="__('Postal/ZIP Code')" />
                <x-text-input id="user_pincode" name="user_pincode" type="text" class="mt-1 block w-full" :value="old('user_pincode', $user->user_pincode)"
                     autofocus autocomplete="user_pincode" placeholder="Enter a Zip Code"/>
                <x-input-error class="mt-2" :messages="$errors->get('user_pincode')" />
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Profile Image</label>
                <div>
                    <input type="file" name="image" accept="image/*" class="add_btn fileinput-button">
                    @if (Auth::guard('masteradmins')->user()->user_image)
                        <a href="{{ url(env('IMAGE_URL').'masteradmin/profile_image/' . Auth::guard('masteradmins')->user()->user_image) }} " target="_blank"><div title="{{ Auth::guard('masteradmins')->user()->user_image }}" class="ptm pbm">{{ Auth::guard('masteradmins')->user()->user_image }}</div></a>
                    @endif
                    <!-- <button class="add_btn fileinput-button"><i class="fas fa-upload mr-2"></i>Choose file here</button> -->
                    <span>Please upload a valid image file. Size of image should not be more than 2MB.</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row py-20 px-10">
        <div class="col-md-12 text-center">
            <button type="submit" class="add_btn">{{ __('Save Changes') }}</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Profile Updated successfully.') }}</p>
            @endif

        </div>
    </div>
</div>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
    $(document).ready(function() {
        $('.select2').select2();
        $('#country').change(function() {
            var countryId = $(this).val();
            // alert(countryId);
            if (countryId) {
                $.ajax({
                    url : '{{ env('APP_URL') }}{{ config('global.businessAdminURL') }}/states/' + countryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#state').empty();
                        $('#state').append('<option value="">Select a State...</option>');
                        $.each(data, function(key, value) {
                            $('#state').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#state').empty();
                $('#state').append('<option value="">Select a State...</option>');
            }
        });
    });
</script>