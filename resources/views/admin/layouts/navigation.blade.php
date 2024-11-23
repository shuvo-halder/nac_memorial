<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand">
            <a href="{{ url('admin') }}">
                <img srcset="{{ asset('assets/frontend/images/remove.png') }}" width="180px" height="40px"
                    alt="" title="{{ __('Nac.Memorial') }}" class="navbar-brand-image">
            </a>
        </h1>

        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu" aria-expanded="false">
                    <span class="avatar avatar-sm"
                        style="background-image: url({{ asset(Auth::user()->getAvatar()) }})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Str::limit(Auth::user()->name, 12) }}</div>
                        <div class="mt-1 small text-muted">{{ Str::limit(Auth::user()->email, 12) }}</div>
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav pt-lg-3">

                <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <polyline points="5 12 3 12 12 3 21 12 19 12"></polyline>
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            {{ __('Dashboard') }}
                        </span>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('admin/users') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.users') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            {{ __('Users') }}
                        </span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <div class="nav-link">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="3" y1="21" x2="21" y2="21" />
                                <path d="M10 21v-4a2 2 0 0 1 4 0v4" />
                                <line x1="10" y1="5" x2="14" y2="5" />
                                <line x1="12" y1="3" x2="12" y2="8" />
                                <path d="M6 21v-7m-2 2l8 -8l8 8m-2 -2v7" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            {{ __('Obituaries') }}
                        </span>
                    </div>
                    <div class="dropdown-menu show">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item d-flex align-items-center gap-2 {{ request()->is('admin/obituaries') ? 'active' : '' }}"
                                    href="{{ route('admin.obituaries') }}">
                                    <svg fill="currentColor" width="15" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 384 512">
                                        <path
                                            d="M64 464c-8.8 0-16-7.2-16-16L48 64c0-8.8 7.2-16 16-16l160 0 0 80c0 17.7 14.3 32 32 32l80 0 0 288c0 8.8-7.2 16-16 16L64 464zM64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-293.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0L64 0zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0z" />
                                    </svg>
                                    {{ __('Posts') }}
                                </a>
                                {{-- <a class="dropdown-item d-flex align-items-center gap-2 {{ request()->is('admin/obituary/create') ? 'active' : '' }}"
                                    href="{{ route('admin.obituary.create') }}">
                                    <svg fill="currentColor" width="15" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                        <path
                                            d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm80-224h-64v-64c0-13.3-10.7-24-24-24s-24 10.7-24 24v64h-64c-13.3 0-24 10.7-24 24s10.7 24 24 24h64v64c0 13.3 10.7 24 24 24s24-10.7 24-24v-64h64c13.3 0 24-10.7 24-24s-10.7-24-24-24z" />
                                    </svg>

                                    {{ __('Create Obituary') }}
                                </a> --}}
                                <a class="dropdown-item d-flex align-items-center gap-2 {{ request()->is('admin/categories') ? 'active' : '' }}"
                                    href="{{ route('admin.categories') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M9 4h3l2 2h5a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                        <path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" />
                                    </svg>
                                    {{ __('Categories') }}
                                </a>

                                <a class="dropdown-item d-flex align-items-center gap-2 {{ request()->is('admin/comments') ? 'active' : '' }}"
                                    href="{{ route('admin.comments') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 20l1.3 -3.9a9 8 0 1 1 3.4 2.9l-4.7 1" />
                                        <line x1="12" y1="12" x2="12" y2="12.01" />
                                        <line x1="8" y1="12" x2="8" y2="12.01" />
                                        <line x1="16" y1="12" x2="16" y2="12.01" />
                                    </svg>
                                    {{ __('Comments') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </li>




                <li class="nav-item dropdown">
                    <div class="nav-link">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                <!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path
                                    d="M64 464c-8.8 0-16-7.2-16-16L48 64c0-8.8 7.2-16 16-16l160 0 0 80c0 17.7 14.3 32 32 32l80 0 0 288c0 8.8-7.2 16-16 16L64 464zM64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-293.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0L64 0zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0z" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            {{ __('Blog') }}
                        </span>
                    </div>
                    <div class="dropdown-menu show">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item d-flex align-items-center gap-2 {{ request()->is('admin/blog/posts') ? 'active' : '' }}"
                                    href="{{ route('admin.blog.posts') }}">
                                    <svg fill="currentColor" width="15" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 384 512">
                                        <!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path
                                            d="M64 464c-8.8 0-16-7.2-16-16L48 64c0-8.8 7.2-16 16-16l160 0 0 80c0 17.7 14.3 32 32 32l80 0 0 288c0 8.8-7.2 16-16 16L64 464zM64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-293.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0L64 0zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0z" />
                                    </svg>
                                    {{ __('Posts') }}
                                </a>

                                <a class="dropdown-item d-flex align-items-center gap-2 {{ request()->is('admin/blog/posts/create') ? 'active' : '' }}"
                                    href="{{ route('admin.blog.posts.create') }}">
                                    <svg fill="currentColor" width="15" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                        <path
                                            d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm80-224h-64v-64c0-13.3-10.7-24-24-24s-24 10.7-24 24v64h-64c-13.3 0-24 10.7-24 24s10.7 24 24 24h64v64c0 13.3 10.7 24 24 24s24-10.7 24-24v-64h64c13.3 0 24-10.7 24-24s-10.7-24-24-24z" />
                                    </svg>

                                    {{ __('Create Blog') }}
                                </a>

                                <a class="dropdown-item d-flex align-items-center gap-2 {{ request()->is('admin/blog/categories') ? 'active' : '' }}"
                                    href="{{ route('admin.blog.categories') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M9 4h3l2 2h5a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                        <path d="M17 17v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" />
                                    </svg>
                                    {{ __('Categories') }}
                                </a>

                                <a class="dropdown-item d-flex align-items-center gap-2 {{ request()->is('admin/blog/comments') ? 'active' : '' }}"
                                    href="{{ route('admin.blog.comments') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 20l1.3 -3.9a9 8 0 1 1 3.4 2.9l-4.7 1" />
                                        <line x1="12" y1="12" x2="12" y2="12.01" />
                                        <line x1="8" y1="12" x2="8" y2="12.01" />
                                        <line x1="16" y1="12" x2="16" y2="12.01" />
                                    </svg>
                                    {{ __('Comments') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </li>


                <li class="nav-item {{ request()->is('admin/message') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.message') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 7h18a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2H3a2 2 0 0 1 -2 -2V9a2 2 0 0 1 2 -2" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>

                        </span>
                        <span class="nav-link-title">
                            {{ __('Messages') }}
                        </span>
                    </a>
                </li>



                <li class="nav-item {{ request()->is('admin/pages') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.pages') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11">
                                </path>
                                <line x1="8" y1="8" x2="12" y2="8"></line>
                                <line x1="8" y1="12" x2="12" y2="12"></line>
                                <line x1="8" y1="16" x2="12" y2="16"></line>
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            {{ __('Pages') }}
                        </span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <div class="nav-link">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <!-- Icon for Content -->
                                <path
                                    d="M64 64H448V128H64V64zM64 192H448V256H64V192zM64 320H448V384H64V320zM64 448H448V512H64V448z" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            {{ __('Content') }}
                        </span>
                    </div>
                    <div class="dropdown-menu show">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">

                                <a class="dropdown-item {{ request()->is('admin/social_links') ? 'active' : '' }}"
                                    href="{{ route('admin.social_links') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M12 21l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.18L12 21z">
                                        </path>
                                    </svg> {{ __('Social Link') }}
                                </a>

                                <a class="dropdown-item {{ request()->is('admin/page_titles') ? 'active' : '' }}"
                                    href="{{ route('admin.page_titles') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="3" y="4" width="18" height="16" rx="2" />
                                        <line x1="3" y1="8" x2="21" y2="8" />
                                        <line x1="5" y1="11" x2="19" y2="11" />
                                        <line x1="5" y1="14" x2="19" y2="14" />
                                    </svg>
                                    {{ __('Page Title') }}
                                </a>

                                <a class="dropdown-item {{ request()->is('admin/popup') ? 'active' : '' }}"
                                    href="{{ route('admin.popup') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M3 7h18a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2H3a2 2 0 0 1 -2 -2V9a2 2 0 0 1 2 -2" />
                                        <path d="M3 7l9 6l9 -6" />
                                    </svg>
                                    {{ __('Pop Message') }}
                                </a>

                                <a class="dropdown-item {{ request()->is('admin/page_images') ? 'active' : '' }}"
                                    href="{{ route('admin.page_images') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="3" y="3" width="18" height="18" rx="2" />
                                        <circle cx="8" cy="8" r="1.5" fill="currentColor" />
                                        <path d="M4 18l5 -5c.928 -.893 2.072 -.893 3 0l5 5" />
                                        <path d="M14 14l3 -3c.928 -.893 2.072 -.893 3 0l0 4" />
                                    </svg>

                                    {{ __('Memorial Images') }}
                                </a>

                                <a class="dropdown-item {{ request()->is('admin/email_content') ? 'active' : '' }}"
                                    href="{{ route('admin.email_content') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M3 7h18a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2H3a2 2 0 0 1 -2 -2V9a2 2 0 0 1 2 -2" />
                                        <path d="M3 7l9 6l9 -6" />
                                    </svg>

                                    {{ __('Email Content') }}
                                </a>

                                <a class="dropdown-item {{ request()->is('admin/error_page') ? 'active' : '' }}"
                                    href="{{ route('admin.error_page') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 9v2m0 4v.01" />
                                        <path d="M12 3c4.97 0 9 4.03 9 9s-4.03 9-9 9-9-4.03-9-9 4.03-9 9-9z" />
                                    </svg>
                                    {{ __('Error Page') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </li>



                <li class="nav-item {{ request()->is('admin/settings') ? 'active' : '' }} dropdown">
                    <a class="nav-link" href="{{ route('admin.settings') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            {{ __('Settings') }}
                        </span>
                    </a>

                    <div class="dropdown-menu show">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">

                                <a class="dropdown-item {{ request()->is('admin/footer') ? 'active' : '' }}"
                                    href="{{ route('admin.footer') }}">
                                    <svg class="icon me-2" fill="currentColor" width="15"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                        <path
                                            d="M64 0C28.7 0 0 28.7 0 64v384c0 35.3 28.7 64 64 64h256c35.3 0 64-28.7 64-64V128L256 0H64zm224 32 96 96h-96V32zM64 480c-8.8 0-16-7.2-16-16V368h288v96c0 8.8-7.2 16-16 16H64zM64 320V64h176v104c0 13.3 10.7 24 24 24h104v128H64z" />
                                        <rect x="64" y="368" width="256" height="16"
                                            fill="rgba(0, 0, 0, 0.2)" />
                                    </svg>
                                    {{ __('Footer') }}
                                </a>
                                {{-- <a class="dropdown-item {{ request()->is('admin/settings/about') ? 'active' : '' }}"
                                    href="{{ route('admin.about') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <line x1="4" y1="6" x2="20" y2="6" />
                                        <line x1="4" y1="12" x2="20" y2="12" />
                                        <line x1="4" y1="18" x2="16" y2="18" />
                                    </svg> {{ __('A Propos') }}
                                </a>

                                <a class="dropdown-item {{ request()->is('admin/settings/terms') ? 'active' : '' }}"
                                    href="{{ route('admin.terms') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M10 16.5l2 -3l2 3m-2 -3v-2l3 -1m-6 0l3 1" />
                                        <circle cx="12" cy="7.5" r=".5" fill="currentColor" />
                                    </svg> {{ __('Terms of use') }}
                                </a> --}}
                            </div>
                        </div>
                    </div>

                </li>

                <li class="nav-item">
                    <a class="nav-link bg-green-lt" href="{{ url('/') }}" target="_blank">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1" />
                            </svg>
                        </span>
                        <span class="nav-link-title strong">
                            {{ __('Visit the site') }}
                        </span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</aside>

<header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu" aria-expanded="false">
                    <span class="avatar avatar-sm"
                        style="background-image: url({{ asset(Auth::user()->getAvatar()) }})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Str::limit(Auth::user()->name, 12) }}</div>
                        <div class="mt-1 small text-muted">{{ Str::limit(Auth::user()->email, 12) }}</div>
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form-1').submit();">{{ __('Logout') }}</a>
                    <form id="logout-form-1" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
