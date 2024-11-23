@extends('admin.layouts.app')
@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title text-muted">
                        {{ __('Error Pages') }}
                    </div>
                    <span class="card-subtitle">
                        {{ __('Manage error pages for your web application.') }}
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
                        {{ __('Error Pages') }}
                    </h2>
                </div>

                <table class="table card-table table-vcenter">
                    <thead>
                        <tr>
                            <th class="w-1">{{ __('ID') }}</th>
                            <th>{{ __('Error Code') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Message') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($errorPages as $errorPage)
                            <tr id="error-page-{{ $errorPage->id }}">
                                {{-- ID --}}
                                <td class="text-muted">
                                    {{ $errorPage->id }}
                                </td>
                                {{-- Error Code --}}
                                <td>
                                    <span class="text-muted font-weight-bold">
                                        {{ $errorPage->error_code }}
                                    </span>
                                </td>
                                {{-- Title --}}
                                <td>
                                    <span class="text-muted">
                                        {{ $errorPage->error_title }}
                                    </span>
                                </td>
                                {{-- Message --}}
                                <td>
                                    <span class="text-muted">
                                        {{ Str::limit($errorPage->error_message, 100, '...') }}
                                    </span>
                                </td>
                                {{-- Created At --}}
                                <td>
                                    {{ $errorPage->created_at->format('d/m/Y - H:i:s') }}
                                </td>

                                {{-- Actions --}}
                                <td class="text-end">
                                    <span class="dropdown">
                                        <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                            data-bs-toggle="dropdown">Actions</button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.error_page.edit', $errorPage->id) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                                    <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                                    <line x1="16" y1="5" x2="19" y2="8" />
                                                </svg>
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

            {{ $errorPages->links() }}

        </div>
    </div>
@endsection
