<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $page_name }} - {{ $site_name }}</title>

    <meta name="msapplication-TileColor" content="#206bc4" />
    <meta name="theme-color" content="#206bc4" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/frontend/images/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('adm/css/tabler.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adm/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" />

    <style>
        p {
            margin: 0;
        }

        #floating-alert {
            position: fixed;
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050;
            width: 90%;
            max-width: 600px;
            background: white;
            border-radius: 30px;
            color: #252525;
        }

        .tox.tox-tinymce {
            height: 300px !important;
        }

        .blog-desc .tox.tox-tinymce {
            height: 600px !important;
        }

        .tox-statusbar {
            display: none !important;
        }

        .tox-tinymce {
            border: 1px solid #dadcde !important;
            border-radius: 4px;
        }

        .tox .tox-edit-area::before {
            border: 1px solid transparent !important;
        }

        @media (prefers-color-scheme: dark) {
            .fl-main-container .fl-container.fl-flasher {
                background-color: rgb(255, 255, 255) !important;
                color: rgb(0, 0, 0) !important;
            }
        }
    </style>

    <script type="text/javascript">
        "use strict";
        var APP_URL = {!! json_encode(url('/')) !!};
    </script>
</head>

<body class="font-sans antialiased">
    <div class="wrapper">
        @include('admin.layouts.navigation')
        <div class="page-wrapper">
            @yield('content')
            @include('admin.layouts.footer')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('adm/js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('adm/libs/jquery/dist/jquery.min.js') }}"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/vc9y1hw2e4ll30xels1zg8fnbz0zp643mw1e8q55igd818h1/tinymce/7/tinymce.min.js">
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            // Select All Checkbox Logic
            $('#master').on('click', function() {
                $(".sub_chk").prop('checked', $(this).is(':checked'));
            });

            // Delete Selected Rows
            $('.delete_all').on('click', function() {
                var allVals = [];
                $(".sub_chk:checked").each(function() {
                    allVals.push($(this).attr('data-id'));
                });

                if (allVals.length <= 0) {
                    Swal.fire({
                        title: 'No Selection',
                        text: 'Please select a row to delete.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You won’t be able to revert this!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: $(this).data('url'),
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                data: {
                                    ids: allVals.join(",")
                                },
                                success: function(data) {
                                    if (data.success) {
                                        $(".sub_chk:checked").each(function() {
                                            $(this).parents("tr").remove();
                                        });
                                        Swal.fire('Deleted!', data.success, 'success');
                                    } else if (data.error) {
                                        Swal.fire('Error!', data.error, 'error');
                                    }
                                },
                                error: function(data) {
                                    Swal.fire('Error!', 'Something went wrong.',
                                        'error');
                                }
                            });
                        }
                    });
                }
            });

            // Status Update Functionality
            window.updateStatusPost = function(id, table) {
                $.ajax({
                    url: APP_URL + "/admin/change/status",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    data: {
                        id: id,
                        table: table
                    },
                    success: function(response) {
                        const badgeId = table === 'blogComment' ? `#status-post-comment-${id}` :
                            `#status-post-${id}`;
                        if (response.bool == 0) {
                            $(badgeId).removeClass("badge bg-green-lt").addClass("badge bg-red-lt")
                                .text("Disabled");
                        } else {
                            $(badgeId).removeClass("badge bg-red-lt").addClass("badge bg-green-lt")
                                .text("Active");

                        }
                        flasher.success("Status updated successfully", {
                            darkMode: false
                        });
                    },
                    error: function() {
                        flasher.error("Status cannt be updated successfully");
                    }
                });
            };
        });
    </script>

    <script>
        tinymce.init({
            selector: '#editor',
            forced_root_block: false,
            block_formats: 'Text=text',
            valid_elements: '*[*]',
            plugins: 'code emoticons',
            toolbar: 'undo redo | bold italic | code | alignleft aligncenter alignright | emoticons ',
            paste_as_text: true,
            enter: 'br',
        });
    </script>

    <script>
        tinymce.init({
            selector: '#editorbody',
            forced_root_block: false,
            block_formats: 'Text=text',
            valid_elements: '*[*]',
            plugins: 'code image imagetools emoticons',
            toolbar: 'undo redo | bold italic | code | alignleft aligncenter alignright | emoticons | image',
            paste_as_text: true,
            enter: 'br',
            file_picker_types: 'image',
            file_picker_callback: function(callback, value, meta) {
                if (meta.filetype === 'image') {
                    // Create a file input
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function() {
                        const file = this.files[0];

                        if (file) {
                            const reader = new FileReader();

                            reader.onload = function() {
                                callback(reader.result, {
                                    alt: file.name
                                });
                            };
                            reader.readAsDataURL(file);
                        }
                    };
                    input.click();
                }
            },
        });
    </script>
</body>

</html>
