@extends('layouts.app')
@section('content')
<!-- Datatables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center">
                    <h3><b>Tag List</b></h3>
                </div>
                <div class="card-body">
                    <table id="example" class="display" style="width:100%; text-align: center;">
                        <thead>
                            <tr>
                                <th>Tag</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tags as $tag)
                            <tr>
                                <td><a href="{{ route('front') }}/tag/{{ $tag->tagname }}">{{ $tag->tagname }}</a></td>
                                <td>{{ $tag->count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
@endsection