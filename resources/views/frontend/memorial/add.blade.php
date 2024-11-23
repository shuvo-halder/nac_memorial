@extends('frontend.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-4">
                <form action="{{ route('store.obituary') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Form -->
                    <div class="card card-md shadow-sm" style="border-radius: 32px; padding: 24px">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <!-- Cover Photo -->
                                            <div class="mb-2">
                                                <p class="form-label d-block">Cover Photo</p>
                                                <label class="form-control text-muted d-flex align-items-center"
                                                    for="customSingleFile"
                                                    style="cursor: pointer; border-radius: 12px; border: 1px solid #FBA8B2; padding-block: 12px;"
                                                    id="singleFileLabel">
                                                    <i class="fas fa-upload me-3" style="color: #FBA8B2;"></i>
                                                    <small id="singleFileCount" style="margin-left: auto; color: #FBA8B2;">0
                                                        selected</small>
                                                </label>
                                                <input type="file" id="customSingleFile" name="image"
                                                    class="form-control d-none" accept="image/x-png,image/jpeg"
                                                    onchange="previewImages(this)">
                                                <!-- Preview container -->
                                                <div id="singlePreviewContainer"
                                                    style="display: flex; gap: 6px; margin-top: 10px; flex-wrap: wrap;">
                                                </div>
                                                @error('image')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <!-- Multiple Image Upload -->
                                            <div class="mb-2">
                                                <p class="form-label d-block">More Photos <small class="text-muted">(5
                                                        images
                                                        max)</small></p>
                                                <label class="form-control text-muted d-flex align-items-center"
                                                    for="customMultipleFile"
                                                    style="cursor: pointer; border-radius: 12px; border: 1px solid #FBA8B2; padding-block: 12px;"
                                                    id="multipleFileLabel">
                                                    <i class="fas fa-upload me-3" style="color: #FBA8B2;"></i>
                                                    <small id="multipleFileCount"
                                                        style="margin-left: auto; color: #FBA8B2;">0
                                                        selected</small>
                                                </label>
                                                <input type="file" multiple id="customMultipleFile"
                                                    name="additional_images[]" class="form-control d-none"
                                                    accept="image/x-png,image/jpeg" onchange="previewImages(this)"
                                                    max="5">
                                                <div id="previewContainer"
                                                    style="display: flex; gap: 6px; margin-top: 10px; flex-wrap: wrap;">
                                                </div>
                                                @error('additional_images')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Title -->
                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('app.title') }}</label>
                                        <input type="text"
                                            class="form-control custom-file-input @error('title') is-invalid @enderror"
                                            name="title" placeholder="{{ __('app.placeholder_title') }}"
                                            value="{{ old('title') }}">
                                        @error('title')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('app.description') }}</label>
                                        <textarea class="form-control custom-file-input @error('description') is-invalid @enderror" id="editor"
                                            cols="5" name="description" rows="15">{{ old('description') }}</textarea>
                                        <small class="form-hint">{{ __('app.form_hint_textarea_insert') }}</small>
                                        @error('description')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Category -->
                                    <div class="mb-3">
                                        <div class="form-label required">{{ __('app.category') }}</div>
                                        <select
                                            class="form-select custom-file-input form-control @error('category') is-invalid @enderror"
                                            name="category">
                                            <option value="">{{ __('app.select_category') }}</option>
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}"
                                                    @if (old('category') == $cat->id) {{ 'selected' }} @endif>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-lg-6">
                                    <!-- Sex -->
                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('app.sex') }}</label>
                                        <select
                                            class="form-select form-control custom-file-input @error('sex') is-invalid @enderror"
                                            name="sex">
                                            <option value="">{{ __('app.select_sex') }}</option>
                                            <option value="male" @if (old('sex') == 'male') selected @endif>
                                                {{ __('app.male') }}</option>
                                            <option value="female" @if (old('sex') == 'female') selected @endif>
                                                {{ __('app.female') }}</option>
                                        </select>
                                        @error('sex')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('app.birth_date') }}</label>
                                        <input type="date" name="birth_date" id="birth_date"
                                            class="form-control custom-file-input @error('birth_date') is-invalid @enderror"
                                            value="{{ old('birth_date') }}">
                                        @error('birth_date')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('app.death_date') }}</label>
                                        <input type="date" name="death_date" id="death_date"
                                            class="form-control custom-file-input @error('death_date') is-invalid @enderror"
                                            value="{{ old('death_date') }}">
                                        @error('death_date')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Funeral Place -->
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('app.funeral_place') }}</label>
                                        <input type="text" name="funeral_place"
                                            class="form-control custom-file-input @error('funeral_place') is-invalid @enderror"
                                            placeholder="{{ __('app.placeholder_funeral_place') }}"
                                            value="{{ old('funeral_place') }}">
                                        @error('funeral_place')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Terms and Conditions -->
                                    <div class="mb-3">
                                        <div class="form-label required">{{ __('Terms and Conditions') }}</div>
                                        <label class="form-check form-switch">
                                            <input
                                                class="form-check-input @error('terms_of_service') is-invalid @enderror"
                                                type="checkbox" value="1" name="terms_of_service"
                                                @if (old('terms_of_service') == 1) checked @endif>
                                            <span class="form-check-label">{!! __('app.accept_terms_conditions', ['url' => url('terms')]) !!}</span>
                                        </label>
                                        @error('terms_of_service')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-2 pt-3">
                                <div class="d-grid">
                                    <button type="submit" class="btn memorial-submit">Create</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
