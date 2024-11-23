@extends('admin.layouts.app')

@section('content')
    <!-- Email Content Edit Form -->
    <div class="container-xl">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title text-muted">
                        {{ __('Email Content Settings') }}
                    </div>
                    <span class="card-subtitle">
                        {{ __('Manage the content of email notifications.') }}
                    </span>
                </div>
            </div>
        </div>

        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">
                            {{ __('Edit Email Content') }}
                        </h2>
                    </div>

                    <!-- Form to edit email content -->
                    <form action="{{ route('admin.email_content.update', $emailContent->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <!-- Key Field -->
                            <div class="mb-3">
                                <label for="key" class="form-label">{{ __('Key') }}</label>
                                <input type="text" id="key" name="key" class="form-control"
                                    value="{{ old('key', $emailContent->key) }}" required readonly>
                            </div>

                            <!-- Subject Field -->
                            <div class="mb-3">
                                <label for="subject" class="form-label">{{ __('Subject') }}</label>
                                <input type="text" id="subject" name="subject" class="form-control"
                                    value="{{ old('subject', $emailContent->subject) }}">
                            </div>

                            <!-- Title Field -->
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('Title') }}</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    value="{{ old('title', $emailContent->title) }}">
                            </div>

                            <!-- Sub Title Field -->
                            <div class="mb-3">
                                <label for="sub_title" class="form-label">{{ __('Sub Title') }}</label>
                                <input type="text" id="sub_title" name="sub_title" class="form-control"
                                    value="{{ old('sub_title', $emailContent->sub_title) }}">
                            </div>

                            <!-- Content Field -->
                            <div class="mb-3">
                                <label for="content" class="form-label">{{ __('Content') }}</label>
                                <textarea id="content" name="content" class="form-control" rows="5">{{ old('content', $emailContent->content) }}</textarea>
                            </div>

                            <!-- Footer Field -->
                            <div class="mb-3">
                                <label for="footer" class="form-label">{{ __('Footer') }}</label>
                                <textarea id="footer" name="footer" class="form-control" rows="3">{{ old('footer', $emailContent->footer) }}</textarea>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                            <a href="{{ route('admin.email_content') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
