@extends('admin.layouts.app')
@section('content')

<div class="container-xl">
    <!-- Page title -->
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <div class="page-title text-muted">
                    {{ __('Edit Error Page') }}
                </div>
                <span class="card-subtitle">
                    {{ __('Update error code, title, and message.') }}
                </span>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <form action="{{ route('admin.error_page.update', $errorPage->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card card-md rounded-3 shadow">
                <div class="card-body">
                    <!-- Error Code -->
                    <div class="mb-3">
                        <label class="form-label required">{{ __('Error Code') }}</label>
                        <input type="text" class="form-control @error('error_code') is-invalid @enderror"
                               name="error_code" value="{{ old('error_code', $errorPage->error_code) }}"
                               placeholder="{{ __('e.g., 404') }}" readonly>
                        @error('error_code')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Error Title -->
                    <div class="mb-3">
                        <label class="form-label required">{{ __('Error Title') }}</label>
                        <input type="text" class="form-control @error('error_title') is-invalid @enderror"
                               name="error_title" value="{{ old('error_title', $errorPage->error_title) }}"
                               placeholder="{{ __('e.g., Page Not Found') }}">
                        @error('error_title')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Error Message -->
                    <div class="mb-3">
                        <label class="form-label required">{{ __('Error Message') }}</label>
                        <textarea class="form-control @error('error_message') is-invalid @enderror"
                                  name="error_message" rows="4"
                                  placeholder="{{ __('Enter a descriptive error message') }}">{{ old('error_message', $errorPage->error_message) }}</textarea>
                        @error('error_message')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('admin.error_page') }}" class="btn btn-link">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('Update Error Page') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
