@extends('layouts.app')
@section('content')
<!-- Datatables -->
<div class="container-fluid">
    <div class="row justify-content-center" style="margin-bottom: 20px;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body" style="margin: auto;">
                    Search Result for {{ $key }}. {{ $posts_count }} results found. </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        @include('postlist')
    </div>
</div>
@endsection