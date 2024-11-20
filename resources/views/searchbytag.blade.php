@extends('layouts.app')
@section('content')
<!-- Datatables -->
<div class="container-fluid">
    <div class="row justify-content-center" style="margin-bottom: 20px;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body" style="margin: auto;">
                    Tag: <a href="{{ route('front') }}/tag/{{ $tag }}" class='btn btn-primary'>{{ $tag }} | {{ $posts_count }} </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        @include('postlist')
    </div>
</div>
@endsection