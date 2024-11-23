@extends('admin.layouts.app')
@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title text-muted">
                        {{ __('Footer Descriptions') }}
                    </div>
                    <span class="card-subtitle">
                        {{ __('Manage the footer information displayed on your website.') }}
                    </span>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">

                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="card table-responsive">
                <div class="card-header">
                    <h2 class="card-title">
                        {{ __('Footer Descriptions') }}
                    </h2>
                </div>

                <table class="table card-table table-vcenter">
                    <thead>
                        <tr>
                            <th class="w-1">{{ __('ID') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Address') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Created') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($footerDescriptions as $description)
                            <tr>
                                <td class="text-muted">
                                    {{ $description->id }}
                                </td>
                                <td>
                                    {{ Str::limit($description->description, 50, '...') }}
                                </td>
                                <td>
                                    {{ $description->address }}
                                </td>
                                <td>
                                    {{ $description->phone }}
                                </td>
                                <td>
                                    {{ $description->email }}
                                </td>
                                <td>
                                    {{ $description->created_at->format('d/m/Y - H:i:s') }}
                                </td>
                                <td class="text-end">
                                    <span class="dropdown">
                                        <button class="btn dropdown-toggle align-text-top"
                                            data-bs-toggle="dropdown">Actions</button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.footer.edit', $description->id) }}">
                                                {{ __('Edit') }}
                                            </a>

                                        </div>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
