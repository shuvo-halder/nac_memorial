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
                        <div class="card shadow-sm p-3" style="border-radius: 32px">
                            <div style="max-height: 600px; overflow-y: auto; padding-right: 8px;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Image</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($items as $item)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset($item->getThumb()) }}" alt="Sample Title"
                                                        width="50" height="50"
                                                        style="object-fit: cover; object-position: center; border-radius: 5px;">
                                                </td>
                                                <td>{{ Str::limit($item->title, 30) }}</td>
                                                <td>
                                                    @if ($item->status)
                                                        <small class="text-success">
                                                            Published
                                                        </small>
                                                    @else
                                                        <small class="text-danger">
                                                            Waiting
                                                        </small>
                                                    @endif

                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('edit-memorial', $item) }}" target="_blank"
                                                            class="btn btn-sm" style="background: #FBE8D2;"><i
                                                                class="fas fa-edit"></i></a>


                                                        <a href="{{ route('show.obituary', [$item->id, $item->slug]) }}"
                                                            target="_blank" class="btn btn-sm"
                                                            style="background: #FBA8B2;"><i class="fas fa-eye"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <p class="text-muted">No post found</p>
                                        @endforelse



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
@endsection
