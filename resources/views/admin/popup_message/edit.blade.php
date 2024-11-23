@extends('admin.layouts.app')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title text-muted">
                        {{ __('Edit Message for Key') }}
                    </div>
                    <span class="card-subtitle">
                        {{ __('Modify the message associated with the key.') }}
                    </span>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.popup') }}" class="btn btn-secondary">
                            {{ __('Back to List') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col">
                    <form action="{{ route('admin.popup.update', $key->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Form -->
                        <div class="card card-md rounded-3 shadow">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <fieldset class="form-fieldset">
                                            <!-- Key (Read-Only) -->
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Key') }}</label>
                                                <input type="text"
                                                    class="form-control @error('key') is-invalid @enderror"
                                                    name="key" value="{{ old('key', $key->key) }}" readonly>
                                                @error('key')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-lg-6">
                                        <fieldset class="form-fieldset">
                                            <!-- Message -->
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('Message') }}</label>
                                                <textarea class="form-control @error('message') is-invalid @enderror"
                                                    name="message" rows="3"
                                                    placeholder="{{ __('Enter message') }}">{{ old('message', $key->message) }}</textarea>
                                                @error('message')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-end">
                                <div class="d-flex">
                                    <a href="{{ route('admin.popup') }}"
                                        class="btn btn-link">{{ __('Cancel') }}</a>
                                    <button type="submit" class="btn btn-blue ms-auto">{{ __('Update Message') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
