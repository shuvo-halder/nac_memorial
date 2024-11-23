@extends('admin.layouts.app')
@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        {{ __('Edit Footer Description') }}
                    </h2>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.footer.update', $footerDescription->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card mt-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Description') }}</label>
                        <textarea name="description" class="form-control">{{ $footerDescription->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Address') }}</label>
                        <input type="text" name="address" class="form-control" value="{{ $footerDescription->address }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Phone') }}</label>
                        <input type="text" name="phone" class="form-control" value="{{ $footerDescription->phone }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Email') }}</label>
                        <input type="email" name="email" class="form-control" value="{{ $footerDescription->email }}">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
