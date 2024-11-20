@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center" style="margin-bottom: 20px;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body" style="margin: auto;">
                    <h3><b><i class="fa fa-image"></i> Pictures</b></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center" style="margin-bottom: 20px;">
        @include('postlist')
    </div>
</div>
@endsection