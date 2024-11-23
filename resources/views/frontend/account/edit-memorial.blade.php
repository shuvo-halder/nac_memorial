@extends('frontend.master')

@section('content')
    <section id="blog_posts">
        <div class="bg">
            <div class="container">

                @if (session('success'))
                    <div id="floating-alert" class="alert alert-success text-dark alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row gy-3">

                    <div class="col-md-4">
                        <div class="account-links shadow-sm h-100">
                            <h3>Update your Account</h3>
                            <p>Edit your personal details</p>

                            <nav class="nav flex-column">
                                <a class="nav-link " href="{{ route('account') }}"><i class="fas fa-cog"></i>Setting</a>
                                <a class="nav-link active" href="{{ route('my-memorial') }}"><i
                                        class="fas fa-newspaper"></i></i>My
                                    Memorial</a>
                                <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="fas fa-sign-out-alt"></i>Logout</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display: none;">
                                    @csrf
                                </form>
                            </nav>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <form action="{{ route('update-memorial', $item->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card shadow-sm p-3" style="border-radius: 32px">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-lg-12">


                                            <!-- Upload images -->
                                            <div class="row">
                                                <!-- Single Image Upload Field -->
                                                <div class="col-md-4">
                                                    <div class="mb-2">
                                                        <p class="form-label d-block">Cover Photo</p>

                                                        <!-- Label for custom file input -->
                                                        <label class="form-control text-muted d-flex align-items-center"
                                                            for="customSingleFile"
                                                            style="cursor: pointer; border-radius: 12px; border: 1px solid #FBA8B2; padding-block: 12px;"
                                                            id="singleFileLabel">
                                                            <i class="fas fa-upload me-3" style="color: #FBA8B2;"></i>
                                                            <small id="singleFileCount"
                                                                style="margin-left: auto; color: #FBA8B2;">Update
                                                                here</small>
                                                        </label>
                                                        <input type="file" id="customSingleFile" name="image"
                                                            class="form-control d-none" accept="image/x-png,image/jpeg"
                                                            onchange="previewImages(this)">

                                                        <!-- Preview container for single image -->
                                                        <div id="singlePreviewContainer"
                                                            style="display: flex; gap: 6px; margin-top: 10px; flex-wrap: wrap;">
                                                            <img src="{{ asset($item->getThumb()) }}"
                                                                style="max-width:60px; height: 45px; object-fit: cover; object-position: center; border-radius: 5px;">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Multiple Image Upload Field -->
                                                <div class="col-md-8">
                                                    <div class="mb-2">
                                                        <p class="form-label d-block">More Photos <small
                                                                class="text-muted">(5
                                                                images max)</small></p>

                                                        <!-- Label for custom file input -->
                                                        <label class="form-control text-muted d-flex align-items-center"
                                                            for="customMultipleFile"
                                                            style="cursor: pointer; border-radius: 12px; border: 1px solid #FBA8B2; padding-block: 12px;"
                                                            id="multipleFileLabel">
                                                            <i class="fas fa-upload me-3" style="color: #FBA8B2;"></i>
                                                            <small id="multipleFileCount"
                                                                style="margin-left: auto; color: #FBA8B2;">Update
                                                                here</small>
                                                        </label>
                                                        <input type="file" multiple id="customMultipleFile"
                                                            name="additional_images[]" class="form-control d-none"
                                                            accept="image/x-png,image/jpeg" onchange="previewImages(this)">

                                                        <!-- Preview container for multiple images -->
                                                        <div id="previewContainer"
                                                            style="display: flex; gap: 6px; margin-top: 10px; flex-wrap: wrap;">
                                                            @foreach ($item->additionalImages as $image)
                                                                <img src="{{ asset('img/obituary/' . $item->id . '/additional/' . $image->filename) }}"
                                                                    style="max-width:60px; height: 45px; object-fit: cover; object-position: center; border-radius: 5px;">
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Title -->
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('app.title') }}</label>
                                                <input type="text"
                                                    class="form-control custom-file-input @error('title') is-invalid @enderror"
                                                    name="title" placeholder="{{ __('app.placeholder_title') }}"
                                                    value="{{ !empty(old('title')) ? old('title') : $item->title }}">

                                                @error('title')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                            <!-- Description -->
                                            <div class="mb-3">
                                                <label class="form-label required">{{ __('app.description') }}</label>
                                                <textarea class="form-control custom-file-input @error('description') is-invalid @enderror" id="editor"
                                                    cols="5" name="description" rows="15">{{ !empty(old('description')) ? old('description') : strip_tags($item->description) }}</textarea>
                                                <small class="form-hint">{{ __('app.form_hint_textarea_insert') }}</small>

                                                @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                            <!-- Categoria -->
                                            <div class="mb-3">
                                                <div class="form-label required">{{ __('app.category') }}</div>
                                                <select
                                                    class="form-select custom-file-input form-control @error('category') is-invalid @enderror"
                                                    name="category">
                                                    <option value="">{{ __('app.select_category') }}</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->id }}"
                                                            @if (old('category', $item->category_id) == $cat->id) {{ 'selected' }} @endif>
                                                            {{ $cat->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('category')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>

                                        </div>


                                        <div class="col-lg-12">

                                            <div class="row">

                                                <div class="mb-3">
                                                    <label class="form-label required">{{ __('app.sex') }}</label>



                                                    <select
                                                        class="form-select form-control custom-file-input @error('sex') is-invalid @enderror"
                                                        name="sex">
                                                        <option value="">{{ __('app.select_sex') }}</option>
                                                        <option value="">{{ __('app.select_sex') }}</option>
                                                        <option value="male"
                                                            @if (old('sex', $item->details->sex) == 'male') selected @endif>
                                                            {{ __('app.male') }}</option>
                                                        <option value="female"
                                                            @if (old('sex', $item->details->sex) == 'female') selected @endif>
                                                            {{ __('app.female') }}</option>
                                                    </select>

                                                    @error('sex')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror

                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label
                                                            class="form-label required">{{ __('app.birth_date') }}</label>
                                                        <input type="date" name="birth_date"
                                                            class="form-control custom-file-input @error('birth_date') is-invalid @enderror"
                                                            value="{{ !empty(old('birth_date')) ? old('birth_date') : $item->details->birth_date }}">

                                                        @error('birth_date')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label
                                                            class="form-label required">{{ __('app.death_date') }}</label>
                                                        <input type="date" name="death_date"
                                                            class="form-control custom-file-input @error('death_date') is-invalid @enderror"
                                                            value="{{ !empty(old('death_date')) ? old('death_date') : $item->details->death_date }}">

                                                        @error('death_date')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('app.funeral_place') }}</label>
                                                        <input type="text" name="funeral_place"
                                                            class="form-control custom-file-input @error('funeral_place') is-invalid @enderror"
                                                            placeholder="{{ __('app.placeholder_funeral_place') }}"
                                                            value="{{ !empty(old('funeral_place')) ? old('funeral_place') : $item->details->funeral_place }}">

                                                        @error('funeral_place')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 pt-3">
                                        <div class="d-grid">
                                            <button type="submit" class="btn memorial-submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
