@extends('admin.layouts.app')

@section('content')
    <!-- Email Content Index Page -->
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                    <div class="page-title text-muted">
                        {{ __('Email Content Settings') }}
                    </div>
                    <span class="card-subtitle">
                        {{ __('Manage email content used for notifications.') }}
                    </span>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">

                </div>
            </div>
        </div>

        <div class="page-body">
            <div class="container-xl">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">
                            {{ __('Email Content List') }}
                        </h2>
                    </div>

                    <table class="table card-table table-vcenter">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Key') }}</th>
                                <th>{{ __('Subject') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Created') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emailContents as $emailContent)
                                <tr>
                                    <td>{{ $emailContent->id }}</td>
                                    <td>{{ $emailContent->key }}</td>
                                    <td>{{ $emailContent->subject }}</td>
                                    <td>{{ $emailContent->title }}</td>
                                    <td>{{ $emailContent->created_at->format('d/m/Y - H:i:s') }}</td>
                                    <td class="text-end">
                                        <span class="dropdown">
                                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport"
                                                data-bs-toggle="dropdown">Actions</button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.email_content.edit', $emailContent->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M5 12h14M12 5l7 7-7 7" />
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

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $emailContents->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
