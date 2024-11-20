<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <style>
        .detail_data {
            margin: 2px;
        }

        .tagbtn {
            margin: 2px;
        }

        .videoWrapper {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 */
            height: 0;
            overflow: hidden;
        }

        .videoWrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('public/js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'IVDB') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tagIndex') }}">Tags</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clipIndex') }}">Clips</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pictureIndex') }}">Pictures</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vtuberData') }}">Vtuber</a>
                        </li>
                        @if(Auth::check())
                        <li class="nav-item">
                            <a href="#" class="nav-link" data-toggle="modal" data-target="#new_post_modal"> New Post</a>
                        </li>
                        @endif
                    </ul>
                    <form action="{{ route('postSearch') }}" class="form-inline my-2 my-lg-0" method="get">
                        <input class="form-control mr-sm-2" name="key" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script id="dsq-count-scr" src="//indovtuberdb.disqus.com/count.js" async></script>
</body>

<!-- Modal Add New -->
<div class="modal fade" tabindex="-1" role="dialog" id="new_post_modal">
    <div class="modal-dialog" role="document">
        <form action="{{ route('postStore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- row 1 type -->
                    <div class="form-group row">
                        <label for="type" class="col-md-4 col-form-label text-md-right">Type</label>
                        <div class="col-md-6">
                            <select name="type" id="addType" class="form-control">
                                <option value="Clip">Clip</option>
                                <option value="Picture">Picture</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <!-- row 2 title -->
                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
                        <div class="col-md-6">
                            <input name="title" id="addTitle" class="form-control" placeholder="Post title" required />
                        </div>
                    </div>
                    <!-- row 3 content -->
                    <div class="form-group row">
                        <label for="content" class="col-md-4 col-form-label text-md-right">Content</label>
                        <div class="col-md-6">
                            <textarea name="content" id="addContent" class="form-control" placeholder="URL youtube clips or direct link image. Example yt link: https://www.youtube.com/watch?v=XXXXXXXXXXX or https://youtu.be/XXXXXXXXXXX"></textarea>
                        </div>
                    </div>
                    <!-- row 4 caption -->
                    <div class="form-group row">
                        <label for="caption" class="col-md-4 col-form-label text-md-right">Caption</label>
                        <div class="col-md-6">
                            <textarea name="caption" id="addCaption" class="form-control" placeholder="Content description or caption"></textarea>
                        </div>
                    </div>
                    <!-- row 5 tags -->
                    <div class="form-group row">
                        <label for="tags" class="col-md-4 col-form-label text-md-right">Tags (separated by comma space)</label>
                        <div class="col-md-6">
                            <textarea name="tags" id="addTags" class="form-control" placeholder="Example: Hana Macchia, Nijisanji ID, Meme"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Save" class="btn btn-primary" />
                </div>
            </div>
        </form>
    </div>
</div>

</html>
