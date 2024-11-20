@extends('layouts.app')
@section('content')
<!-- Datatables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    Vtuber Data
                </div>
                <div class="card-body">
                    @if(Auth::check())
                    <div style="margin: 5px;">
                        <a href="#" class="btn btn btn-success" data-toggle="modal" data-target="#vtuber_new_modal"><i class="fa fa-user-plus"></i> Add New Vtuber</a>
                    </div>
                    @endif
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Picture</th>
                                <th>Name</th>
                                <th>Alias/Nickname</th>
                                <th>Agency</th>
                                <th>Debut Date</th>
                                <th>Status</th>
                                <th>Channel/Stream URL</th>
                                <th>Contents</th>
                                @if(Auth::check())
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vtubers as $vtuber)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="{{ route('front') }}/{{ $vtuber->img_url }}" id="detail_picture" class="img-thumbnail rounded mx-auto d-block" alt="vtuber picture" style="max-width:12em; overflow: hidden; margin: 5px;"></td>
                                <td>{{ $vtuber->name }}</td>
                                <td>{{ $vtuber->alias }}</td>
                                <td><a href="{{ route('front') }}/tag/{{ $vtuber->agency }}" class='btn btn-sm btn-primary tagbtn'>{{ $vtuber->agency }}</a></td>
                                <td>{{ $vtuber->debut->isoFormat('LL') }}</td>
                                <td>{{ $vtuber->status }}</td>
                                <td><a href="{{ $vtuber->channel_url }}">{{ $vtuber->channel_name }}</a></td>
                                <td><a href="{{ route('front') }}/tag/{{ $vtuber->name }}" class='btn btn-sm btn-primary tagbtn'>Click Here</a></td>
                                @if(Auth::check())
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example" style="margin: 2px;">
                                        <a href="#" class="btn btn-sm btn-warning open-edit-vtuber" data-toggle="modal" data-target="#vtuber_edit_modal" data-id="{{ $vtuber->id }}"><i class="fa fa-pen-square"></i> Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger open-delete-vtuber" data-toggle="modal" data-target="#vtuber_delete_modal" data-id="{{ $vtuber->id }}"><i class="fa fa-trash"></i> Delete</a>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Add New -->
<div class="modal fade" tabindex="-1" role="dialog" id="vtuber_new_modal">
    <div class="modal-dialog" role="document">
        <form action="{{ route('vtuberStore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Vtuber</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- row 1 name -->
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                        <div class="col-md-6">
                            <input name="name" id="addName" class="form-control" required />
                        </div>
                    </div>
                    <!-- row 2 alias -->
                    <div class="form-group row">
                        <label for="alias" class="col-md-4 col-form-label text-md-right">Alias/Nickname</label>
                        <div class="col-md-6">
                            <input name="alias" id="addAlias" class="form-control" required />
                        </div>
                    </div>
                    <!-- row 3 agency -->
                    <div class="form-group row">
                        <label for="agency" class="col-md-4 col-form-label text-md-right">Agency</label>
                        <div class="col-md-6">
                            <input name="agency" id="addAgency" class="form-control" required />
                        </div>
                    </div>
                    <!-- row 4 channel name -->
                    <div class="form-group row">
                        <label for="channel_name" class="col-md-4 col-form-label text-md-right">Channel Name</label>
                        <div class="col-md-6">
                            <input name="channel_name" id="addChannelName" class="form-control" required />
                        </div>
                    </div>
                    <!-- row 5 channel url -->
                    <div class="form-group row">
                        <label for="channel_url" class="col-md-4 col-form-label text-md-right">Channel URL</label>
                        <div class="col-md-6">
                            <input name="channel_url" id="addChannelUrl" class="form-control" required />
                        </div>
                    </div>
                    <!-- row 6 debut -->
                    <div class="form-group row">
                        <label for="debut" class="col-md-4 col-form-label text-md-right">Debut</label>
                        <div class="col-md-6">
                            <input name="debut" id="addDebut" class="form-control" placeholder="yyyy-mm-dd" required />
                        </div>
                    </div>
                    <!-- row 7 status -->
                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-right">Status</label>
                        <div class="col-md-6">
                            <select name="status" id="addStatus" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <!-- row 8 picture -->
                    <div class="form-group row">
                        <label for="file" class="col-md-4 col-form-label text-md-right">Picture</label>
                        <div class="col-md-6">
                            <input type="file" name="file" accept="image/*" required>
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

<!-- Modal Edit -->
<div class="modal fade" tabindex="-1" role="dialog" id="vtuber_edit_modal">
    <div class="modal-dialog" role="document">
        <form action="{{ route('vtuberEdit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Vtuber</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- row 1 name -->
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                        <div class="col-md-6">
                            <input name="name" id="editName" class="form-control" required />
                        </div>
                    </div>
                    <!-- row 2 alias -->
                    <div class="form-group row">
                        <label for="alias" class="col-md-4 col-form-label text-md-right">Alias/Nickname</label>
                        <div class="col-md-6">
                            <input name="alias" id="editAlias" class="form-control" required />
                        </div>
                    </div>
                    <!-- row 3 agency -->
                    <div class="form-group row">
                        <label for="agency" class="col-md-4 col-form-label text-md-right">Agency</label>
                        <div class="col-md-6">
                            <input name="agency" id="editAgency" class="form-control" required />
                        </div>
                    </div>
                    <!-- row 4 channel name -->
                    <div class="form-group row">
                        <label for="channel_name" class="col-md-4 col-form-label text-md-right">Channel Name</label>
                        <div class="col-md-6">
                            <input name="channel_name" id="editChannelName" class="form-control" required />
                        </div>
                    </div>
                    <!-- row 5 channel url -->
                    <div class="form-group row">
                        <label for="channel_url" class="col-md-4 col-form-label text-md-right">Channel URL</label>
                        <div class="col-md-6">
                            <input name="channel_url" id="editChannelUrl" class="form-control" required />
                        </div>
                    </div>
                    <!-- row 6 debut -->
                    <div class="form-group row">
                        <label for="debut" class="col-md-4 col-form-label text-md-right">Debut</label>
                        <div class="col-md-6">
                            <input name="debut" id="editDebut" class="form-control" placeholder="yyyy-mm-dd" required />
                        </div>
                    </div>
                    <!-- row 7 status -->
                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-right">Status</label>
                        <div class="col-md-6">
                            <select name="status" id="editStatus" class="form-control">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <!-- row 8 picture -->
                    <div class="form-group row">
                        <label for="file" class="col-md-4 col-form-label text-md-right">Picture</label>
                        <div class="col-md-6">
                            <input type="file" name="file" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <input type="text" id="VtuberIdEdit" name="id_vtuber" value="" required hidden/>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Save" class="btn btn-primary" />
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" tabindex="-1" role="dialog" id="vtuber_delete_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 align="center"></a> <i class='fa fa-exclamation-triangle'></i> Are you sure want to delete this data?</h5>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form action="{{ route('vtuberDestroy') }}" method="post">
                    @csrf
                    <input type="text" id="VtuberIdDelete" name="id_vtuber" value="" required hidden/>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Yes, Delete" class="btn btn-danger" />
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable({
            "scrollX": true
        });
    });

    $(document).on("click", ".close-detail", function() {
        $('#detail_card').hide();
    });

    // onclick btn detail
    $(document).on("click", ".open-detail", function() {
        /* passing data dari view button detail ke modal */
        var id_post = $(this).data('id');
        // $(".modal-body #id").val(thisDataAnggota);
        var linkDetail = "{{ route('front') }}/show/" + id_post;
        $.get(linkDetail, function(data) {
            //deklarasi var obj JSON data detail anggota
            var obj = data;
            var tags = data.tag;
            var urls = data.url;
            // empty element
            $("#name_detail").empty();
            $("#status_detail").empty();
            $("#affiliation_detail").empty();
            $("#language_detail").empty();
            $("#tags_detail").empty();
            $("#url_stream_detail").empty();
            $("#url_social_detail").empty();
            // data initialization
            $("#name_detail").html(obj.name);
            $("#alt_name_detail").html(obj.alt_name);
            $("#debut_detail").html(obj.debut_date);
            $("#status").html(obj.status);
            tags.forEach(element => {
                console.log(element);
                if (element.type == "status") {
                    $("#status_detail").append("<a href='{{ route('front') }}/tag/" + element.value + "' class='btn btn-sm btn-primary'>" + element.value + "</a>");
                } else if (element.type == "affiliation") {
                    $("#affiliation_detail").append("<a href='{{ route('front') }}/tag/" + element.value + "' class='btn btn-sm btn-primary'>" + element.value + "</a>" + " ");
                } else if (element.type == "language") {
                    $("#language_detail").append("<a href='{{ route('front') }}/tag/" + element.value + "' class='btn btn-sm btn-primary'>" + element.value + "</a>" + " ");
                } else {
                    $("#tags_detail").append("<a href='{{ route('front') }}/tag/" + element.value + "' class='btn btn-sm btn-primary'>" + element.value + "</a>" + " ");
                }
            });
            urls.forEach(element => {
                if (element.site == "youtube") {
                    $("#url_stream_detail").append('<a href="' + element.value + '" class="btn btn-sm btn-danger">' + '<i class="fab fa-youtube"></i> ' + element.name + '</a> ');
                } else if (element.site == "twitter") {
                    $("#url_social_detail").append('<a href="' + element.value + '" class="btn btn-sm btn-info">' + '<i class="fab fa-twitter"></i> ' + element.name + '</a> ');
                }
            });

            //base root project url + url dari db
            var picture_link = "{{ route('front') }}/" + obj.img_url;
            $("#detail_picture").attr('src', picture_link);
        });
    });

    $(document).on("click", ".open-delete-vtuber", function() {
        /* passing data dari view button detail ke modal */
        var id_vtuber = $(this).data('id');
        $(".modal-footer #VtuberIdDelete").val(id_vtuber);
    });

    $(document).on("click", ".open-edit-vtuber", function() {
        /* passing data dari view button detail ke modal */
        var id_vtuber = $(this).data('id');
        $(".modal-footer #VtuberIdEdit").val(id_vtuber);
        var linkDetail = "{{ route('front') }}/vtuber/show/" + id_vtuber;
        $.get(linkDetail, function(data) {
            //deklarasi var obj JSON data detail anggota
            var obj = data;

            // initialize
            $("#editName").val(data.name);
            $("#editAlias").val(data.alias);
            $("#editAgency").val(data.agency);
            $("#editChannelName").val(data.channel_name);
            $("#editChannelUrl").val(data.channel_url);
            $("#editDebut").val(data.debut);
            $("#editStatus").val(data.status);
        });
    });
</script>
@endsection
