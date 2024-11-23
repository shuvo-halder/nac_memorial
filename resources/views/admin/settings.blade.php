@extends('admin.layouts.app')
@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title text-muted">
                        {{ __('Settings') }}
                    </div>
                    <span class="card-subtitle">
                        {{ __('Take control of your web application.') }}
                    </span>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        {{ __('Update Settings') }}
                    </h2>
                </div>
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5">

                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Application Name') }}</label>
                                    <input type="text"
                                        value="{{ !empty(old('app_name')) ? old('app_name') : $settings::find('app_name')->value }}"
                                        class="form-control @error('app_name') is-invalid @enderror" name="app_name"
                                        placeholder="">

                                    @error('app_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ __('Application Tagline') }}</label>
                                    <input type="text"
                                        value="{{ !empty(old('app_tagline')) ? old('app_tagline') : $settings::find('app_tagline')->value }}"
                                        class="form-control @error('app_tagline') is-invalid @enderror" name="app_tagline"
                                        placeholder="">

                                    @error('app_tagline')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ __('Application Description') }}</label>
                                    <textarea name="app_description" class="form-control" data-bs-toggle="autosize" placeholder=""
                                        style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 56px;">{{ !empty(old('app_description')) ? old('app_description') : $settings::find('app_description')->value }}</textarea>

                                    @error('app_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>



                                <div class="mb-3">
                                    <label
                                        class="form-label required">{{ __('How many results to show per page?') }}</label>
                                    <input type="number"
                                        value="{{ !empty(old('num_of_results')) ? old('num_of_results') : $settings::find('num_of_results')->value }}"
                                        class="form-control @error('num_of_results') is-invalid @enderror"
                                        name="num_of_results">
                                    <small
                                        class="form-hint">{{ __('NOTE: Indicates how many results to show per page. This is also the same for category results, search etc.') }}</small>

                                    @error('num_of_results')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <label
                                        class="form-label required">{{ __('How many comments to show at a time?') }}</label>
                                    <input type="number"
                                        value="{{ !empty(old('num_comments_at_time')) ? old('num_comments_at_time') : $settings::find('num_comments_at_time')->value }}"
                                        class="form-control @error('num_comments_at_time') is-invalid @enderror"
                                        name="num_comments_at_time">
                                    <small
                                        class="form-hint">{{ __('NOTE: Indicate how many comments should be shown at a time in the "comments" section of a post and not how many to show overall.') }}</small>

                                    @error('num_comments_at_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <div class="form-label required">{{ __('New entries') }}</div>
                                    <small
                                        class="text-muted">{{ __('By checking the box you accept that all new entries by users will be published immediately. In any case, you will be able to manage the contents later.') }}</small>
                                    <label class="form-check form-switch mt-2">
                                        <input type="hidden" name="new_entries" value="0">
                                        <input class="form-check-input @error('new_entries') is-invalid @enderror"
                                            type="checkbox" value="1" name="new_entries"
                                            {{ old('new_entries', $settings::find('new_entries')->value) == '1' ? 'checked="checked"' : '' }}>
                                    </label>

                                    @error('new_entries')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                                <div class="mb-3">
                                    <div class="form-label required">{{ __('New comments') }}</div>
                                    <small
                                        class="text-muted">{{ __('By checking the box you accept that all new comments will be immediately public. In any case, you will be able to manage the contents later.') }}</small>
                                    <label class="form-check form-switch mt-2">
                                        <input type="hidden" name="new_comments" value="0">
                                        <input class="form-check-input @error('new_comments') is-invalid @enderror"
                                            type="checkbox" value="1" name="new_comments"
                                            {{ old('new_comments', $settings::find('new_comments')->value) == '1' ? 'checked="checked"' : '' }}>
                                    </label>

                                    @error('new_comments')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label required">{{ __('Memorial Description Lenght') }}</label>
                                    <input type="text"
                                        value="{{ !empty(old('description_min_length')) ? old('description_min_length') : $settings::find('description_min_length')->value }}"
                                        class="form-control @error('description_min_length') is-invalid @enderror"
                                        name="description_min_length" placeholder="Enter Number">

                                    @error('description_min_length')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-lg-7">
                                <fieldset class="form-fieldset">

                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('Google reCAPTCHA Site Key') }}</label>
                                        <input type="text"
                                            value="{{ !empty(old('recaptcha_site_key')) ? old('recaptcha_site_key') : $settings::find('recaptcha_site_key')->value }}"
                                            class="form-control @error('recaptcha_site_key') is-invalid @enderror"
                                            name="recaptcha_site_key" placeholder="Enter your Site Key">

                                        @error('recaptcha_site_key')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('Google reCAPTCHA Secret Key') }}</label>
                                        <input type="text"
                                            value="{{ !empty(old('recaptcha_secret_key')) ? old('recaptcha_secret_key') : $settings::find('recaptcha_secret_key')->value }}"
                                            class="form-control @error('recaptcha_secret_key') is-invalid @enderror"
                                            name="recaptcha_secret_key" placeholder="Enter your Secret Key">

                                        @error('recaptcha_secret_key')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Google Client ID -->
                                    <div class="mb-3 pt-4">
                                        <label class="form-label required">{{ __('Google Client ID') }}</label>
                                        <input type="text"
                                            value="{{ !empty(old('google_client_id')) ? old('google_client_id') : $settings::find('google_client_id')->value }}"
                                            class="form-control @error('google_client_id') is-invalid @enderror"
                                            name="google_client_id" placeholder="Enter Google Client ID">

                                        @error('google_client_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Google Client Secret -->
                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('Google Client Secret') }}</label>
                                        <input type="text"
                                            value="{{ !empty(old('google_client_secret')) ? old('google_client_secret') : $settings::find('google_client_secret')->value }}"
                                            class="form-control @error('google_client_secret') is-invalid @enderror"
                                            name="google_client_secret" placeholder="Enter Google Client Secret">

                                        @error('google_client_secret')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Google Redirect URI -->
                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('Google Redirect URI') }}</label>
                                        <input type="text"
                                            value="{{ !empty(old('google_redirect_uri')) ? old('google_redirect_uri') : $settings::find('google_redirect_uri')->value }}"
                                            class="form-control @error('google_redirect_uri') is-invalid @enderror"
                                            name="google_redirect_uri" placeholder="Enter Google Redirect URI">

                                        @error('google_redirect_uri')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Facebook Client ID -->
                                    <div class="mb-3 pt-4">
                                        <label class="form-label required">{{ __('Facebook Client ID') }}</label>
                                        <input type="text"
                                            value="{{ !empty(old('facebook_client_id')) ? old('facebook_client_id') : $settings::find('facebook_client_id')->value }}"
                                            class="form-control @error('facebook_client_id') is-invalid @enderror"
                                            name="facebook_client_id" placeholder="Enter Facebook Client ID">

                                        @error('facebook_client_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Facebook Client Secret -->
                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('Facebook Client Secret') }}</label>
                                        <input type="text"
                                            value="{{ !empty(old('facebook_client_secret')) ? old('facebook_client_secret') : $settings::find('facebook_client_secret')->value }}"
                                            class="form-control @error('facebook_client_secret') is-invalid @enderror"
                                            name="facebook_client_secret" placeholder="Enter Facebook Client Secret">

                                        @error('facebook_client_secret')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Facebook Redirect URI -->
                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('Facebook Redirect URI') }}</label>
                                        <input type="text"
                                            value="{{ !empty(old('facebook_redirect_uri')) ? old('facebook_redirect_uri') : $settings::find('facebook_redirect_uri')->value }}"
                                            class="form-control @error('facebook_redirect_uri') is-invalid @enderror"
                                            name="facebook_redirect_uri" placeholder="Enter Facebook Redirect URI">

                                        @error('facebook_redirect_uri')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>



                            </div>
                        </div>

                    </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-lime">{{ __('Save Changes') }}</button>
            </div>
            </form>

        </div>
    </div>
    </div>
@endsection
