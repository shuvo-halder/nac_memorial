<section id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="footer">
                    <div class="logo">
                        <a href="{{ route('index') }}">
                            <img style="height: 120px; width: auto;"
                                src="{{ asset('assets/frontend/images/hero/logo1.png') }}" alt="footer">
                        </a>
                    </div>

                    <div class="text">
                        <p><a href="{{ route('index') }}">nac.memorial</a>
                            {{ $footerDescription->description }}</p>
                    </div>

                    <div class="social">
                        @foreach ($socialLinks as $link)
                            <a href="{{ $link->url }}" target="_blank">
                                <i class="{{ $link->icon }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="col-md-2 pt-5 d-none d-lg-block">
                <h5>Categories</h5>
                <ul class="list-unstyled">
                    @foreach ($categories as $category)
                        <li><a href="{{ route('category', [$category->id, $category->slug]) }}"
                                class="text-light">{{ Str::before($category->name, ' ') }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-2 pt-5 d-none d-lg-block">
                <h5>Pages</h5>
                <ul class="list-unstyled">
                    @foreach ($pages as $page)
                        <li><a href="{{ route('page.show', [$page->id, $page->slug]) }}"
                                class="text-light">{{ Str::limit($page->title, 15) }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-2 pt-5">
                <h5>Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('contact') }}" class="text-light">Contacts</a></li>
                </ul>
            </div>

            <div class="col-md-2 pt-5">
                <h5>Contact us</h5>
                <ul class="list-unstyled">
                    <li>
                        <p>{{ $footerDescription->address }}</p>
                    </li>
                    <li>
                        <p>Call Us: {{ $footerDescription->phone }}</p>
                    </li>
                    <li>
                        <p>{{ $footerDescription->email }}</p>
                    </li>
                </ul>
            </div>


        </div>
    </div>
</section>
