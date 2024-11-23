@extends('frontend.master')

@section('content')
    <section id="contact_form">
        @if (session('failed'))
            <div id="floating-alert" class="alert alert-success text-dark alert-dismissible fade show" role="alert">
                {{ session('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <div class="card" style="padding: 30px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="image rounded overflow-hidden d-none d-lg-block h-100">
                                        <img src="{{ asset('assets/frontend/images/memorial1.png') }}" alt=""
                                            style="height: 100%; width: auto; object-fit: cover; object-position: center;">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <div class="text pb-4">
                                                <h1 class="display-5">Contact Us</h1>
                                                <i>Get in touch with us – we’d love to hear from you!</i>
                                            </div>
                                        </div>

                                        <!-- Name Field -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <input type="text" class="form-control" name="name" placeholder="Name"
                                                    value="{{ optional(auth()->user())->name }}" />
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Email Field -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <input type="email" class="form-control" name="email"
                                                    placeholder="E-mail" value="{{ optional(auth()->user())->email }}" />
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Subject Field -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" class="form-control" name="subject"
                                                    placeholder="Subject" />
                                                @error('subject')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Message Field -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <textarea class="form-control" name="message" rows="6" placeholder="Message"></textarea>
                                                @error('message')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Mandatory Checkbox -->
                                        <div class="col-md-12 mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <!-- Checkbox -->
                                                <div class="form-check mb-0">
                                                    <input type="checkbox"
                                                        class="form-check-input @error('accept_terms') is-invalid @enderror"
                                                        name="accept_terms" id="accept_terms">
                                                    <label class="form-check-label text-muted small" for="accept_terms">
                                                        By checking this box, I accept that the Nac.Memorial site uses the
                                                        data entered in this form in order to be contacted as part of the
                                                        commercial relationship that would result from it.
                                                    </label>
                                                </div>
                                                <!-- Error message for the checkbox -->

                                            </div>

                                            @error('accept_terms')
                                                <small class="text-danger mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <div class="my-3">
                                                <div class="recaptcha-container">
                                                    {!! NoCaptcha::display() !!}
                                                    @error('g-recaptcha-response')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Submit Button -->
                                        <div class="col-md-3">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary custom-btn">Send
                                                    Message</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
