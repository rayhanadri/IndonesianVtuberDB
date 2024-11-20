@extends('layouts.app')

@section('content')
<!-- Datatables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    You are logged in!
                    <div id="add_new" style="margin: 5px;">
                        <a href="#" class="btn btn btn-success open-new" data-toggle="modal" data-target="#new_modal"><i class="fa fa-plus"></i> Add New</a>
                    </div>
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Picture</th>
                                <th>Name</th>
                                <th>Alt Name</th>
                                <th>Alias/Nickname</th>
                                <th>Description</th>
                                <th>Tags</th>
                                <th>URLs</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ route('front') }}/{{ $post->img_url }}" id="table_picture" class="img-thumbnail rounded mx-auto d-block" alt="{{ $post->name }} picture" style="max-width:120px; overflow: hidden; margin: 2px;">
                                </td>
                                <td>{{ $post->name }}</td>
                                <td>{{ $post->alt_name }}</td>
                                <td>{{ $post->alias }}</td>
                                <td>{{ $post->description }}</td>
                                <td>
                                    @foreach ($post->tag as $tag)
                                    ({{ $tag->type }}: {{ $tag->value }}),
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($post->url as $url)
                                    ({{ $url->type }}: {{ $url->site }}),
                                    @endforeach
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example" style="margin: 2px;">
                                        <a href="#" class="btn btn-sm btn-secondary open-new-tag" data-toggle="modal" data-target="#tag_new_modal" data-id="{{ $post->id }}"><i class="fa fa-tags"></i> New Tag</a>
                                        <a href="#" class="btn btn-sm btn-secondary open-delete-tag" data-toggle="modal" data-target="#tag_delete_modal" data-id="{{ $post->id }}"><i class="fa fa-tag"></i> Delete Tag</a>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="Basic example" style="margin: 2px;">
                                        <a href="#" class="btn btn-sm btn-secondary open-new-url" data-toggle="modal" data-target="#url_new_modal" data-id="{{ $post->id }}"><i class="fa fa-link"></i> New URL</a>
                                        <a href="#" class="btn btn-sm btn-secondary open-delete-url" data-toggle="modal" data-target="#url_delete_modal" data-id="{{ $post->id }}"><i class="fa fa-unlink"></i> Delete URL</a>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="Basic example" style="margin: 2px;">
                                        <a href="#" class="btn btn-sm btn-primary open-detail" data-toggle="modal" data-target="#detail_modal" data-id="{{ $post->id }}"> <i class="fa fa-info-circle"></i> Info</a>
                                        <a href="#" class="btn btn-sm btn-success"><i class="fa fa-file"></i> Post</a>
                                        <a href="#" class="btn btn-sm btn-warning open-edit" data-toggle="modal" data-target="#edit_modal" data-id="{{ $post->id }}"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="#" class="btn btn-sm btn-danger open-delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $post->id }}"><i class="fa fa-trash"></i> Delete</a>
                                    </div>
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
<div class="modal fade" tabindex="-1" role="dialog" id="new_modal">
    <div class="modal-dialog" role="document">
        <form action="{{ route('postNew') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Vtuber</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless" style="width:90%; margin: auto;">
                        <tbody>
                            <tr>
                                <th scope="row">Name</th>
                                <td><input name="name" id="addName" class="form-control" required /></td>
                            </tr>
                            <tr>
                                <th scope="row">Alternative Name</th>
                                <td><input name="alt_name" id="addAltName" class="form-control" required /></td>
                            </tr>
                            <tr>
                                <th scope="row">Alias</th>
                                <td><input name="alias" id="addAlias" class="form-control" /></td>
                            </tr>
                            <tr>
                                <th scope="row">Description</th>
                                <td><textarea name="description" id="addDescription" class="form-control"></textarea></td>
                            </tr>
                            <tr>
                                <th scope="row">Debut Date</th>
                                <td><input name="debut" id="addDebut" class="form-control" placeholder="yyyy-mm-dd" required /></td>
                            </tr>
                            <tr>
                                <th>Picture File</th>
                                <td><input type="file" name="file" required></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Save" class="btn btn-primary" />
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal New Tag -->
<div class="modal fade" tabindex="-1" role="dialog" id="tag_new_modal">
    <div class="modal-dialog" role="document">
        <form action="{{ route('tagNew') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless" style="width:90%; margin: auto;">
                        <tbody>
                            <tr>
                                <th scope="row">Type</th>
                                <td><select id="tagTypeAdd" name="type" class="form-control select" required>
                                        <option value="status">Status</option>
                                        <option value="affiliation">Affiliation</option>
                                        <option value="language">Language</option>
                                        <option value="character">Character</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Value</th>
                                <td><input name="value" id="tagValueAdd" class="form-control" required /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <input type="text" id="tagPostIdAdd" name="id_post" value="" required />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Save" class="btn btn-primary" />
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete Tag -->
<div class="modal fade" tabindex="-1" role="dialog" id="tag_delete_modal">
    <div class="modal-dialog" role="document">
        <form action="{{ route('tagNew') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="tag_delete_pool">

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <!-- <input type="submit" value="Save" class="btn btn-primary" /> -->
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal New URL -->
<div class="modal fade" tabindex="-1" role="dialog" id="url_new_modal">
    <div class="modal-dialog" role="document">
        <form action="{{ route('urlNew') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless" style="width:90%; margin: auto;">
                        <tbody>
                            <tr>
                                <th scope="row">Site</th>
                                <td><select id="urlSiteAdd" name="site" class="form-control select" required>
                                        <option value="youtube">Youtube</option>
                                        <option value="twitter">Twitter</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Type</th>
                                <td><select id="urlTypeAdd" name="type" class="form-control select" required>
                                        <option value="channel">Channel/Stream URL</option>
                                        <option value="social">Social Media URL</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Name</th>
                                <td><input name="name" id="urlNameeAdd" class="form-control" required /></td>
                            </tr>
                            <tr>
                                <th scope="row">Value</th>
                                <td><input name="value" id="urlValueAdd" class="form-control" required /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <input type="text" id="urlPostIdAdd" name="id_post" value="" required />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Save" class="btn btn-primary" />
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete URL -->
<div class="modal fade" tabindex="-1" role="dialog" id="url_delete_modal">
    <div class="modal-dialog" role="document">
        <form action="{{ route('tagNew') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="url_delete_pool">

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <!-- <input type="submit" value="Save" class="btn btn-primary" /> -->
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" tabindex="-1" role="dialog" id="edit_modal">
    <div class="modal-dialog" role="document">
        <form action="{{ route('postUpdate') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Vtuber Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless" style="width:90%; margin: auto;">
                        <tbody>
                            <tr>
                                <th scope="row">Name</th>
                                <td><input name="name" id="editName" class="form-control" required /></td>
                            </tr>
                            <tr>
                                <th scope="row">Alternative Name</th>
                                <td><input name="alt_name" id="editAltName" class="form-control" required /></td>
                            </tr>
                            <tr>
                                <th scope="row">Alias</th>
                                <td><input name="alias" id="editAlias" class="form-control" /></td>
                            </tr>
                            <tr>
                                <th scope="row">Description</th>
                                <td><textarea name="description" id="editDescription" class="form-control"></textarea></td>
                            </tr>
                            <tr>
                                <th scope="row">Debut Date</th>
                                <td><input name="debut" id="editDebut" class="form-control" placeholder="yyyy-mm-dd" required /></td>
                            </tr>
                            <tr>
                                <th>Picture File</th>
                                <td><input type="file" name="file"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <input type="text" id="PostIdEdit" name="id_post" value="" required />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Save" class="btn btn-primary" />
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" tabindex="-1" role="dialog" id="delete_modal">
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
                <form action="{{ route('postDestroy') }}" method="post">
                    @csrf
                    <input type="text" id="PostIdDelete" name="id_post" value="" required />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Yes, Delete" class="btn btn-danger" />
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" tabindex="-1" role="dialog" id="detail_modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vtubers Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" id="detail_picture" class="img-thumbnail rounded mx-auto d-block" alt="vtuber picture" style="max-width:250px; overflow: hidden; margin: 5px;">
                <div class="card" id="detail_card">
                    <div class="card-header">Information Details</div>
                    <div class="card-body">
                        <table class="table table-borderless" style="width:90%; margin: auto;">
                        <tbody>
                            <tr>
                                <th scope="row">Name</th>
                                <td><span id="name_detail"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Alternative Name</th>
                                <td><span id="alt_name_detail" ></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Nickame/Alias</th>
                                <td><span id="alias_detail" ></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Description</th>
                                <td><p id="description_detail" ></p></td>
                            </tr>
                            <tr>
                                <th scope="row">Affiliation</th>
                                <td><span id="affiliation_detail"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Debut</th>
                                <td><span id="debut_detail"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Status</th>
                                <td><span id="status_detail"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Language</th>
                                <td><span id="language_detail"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Channel/Stream URL</th>
                                <td><span id="url_stream_detail"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Social Media URL</th>
                                <td><span id="url_social_detail"></span></td>
                            </tr>
                            <tr>
                                <th scope="row">Tags</th>
                                <td><span id="tags_detail"></span></td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- <input type="text" id="id" name="id" value="" hidden/> -->
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    });

    $(document).on("click", ".open-new-tag", function() {
        /* passing data dari view button detail ke modal */
        var id_post = $(this).data('id');
        $(".modal-footer #tagPostIdAdd").val(id_post);
    });

    $(document).on("click", ".open-new-url", function() {
        /* passing data dari view button detail ke modal */
        var id_post = $(this).data('id');
        $(".modal-footer #urlPostIdAdd").val(id_post);
    });

    $(document).on("click", ".open-delete-tag", function() {
        /* passing data dari view button detail ke modal */
        var id_post = $(this).data('id');
        // $(".modal-body #id").val(thisDataAnggota);
        var linkDetail = "{{ route('front') }}/show/" + id_post;
        $.get(linkDetail, function(data) {
            //deklarasi var obj JSON data detail anggota
            var obj = data;
            var tags = data.tag;
            // empty element
            $("#tag_delete_pool").empty();

            tags.forEach(element => {
                $("#tag_delete_pool").append("<a href='{{ route('front') }}/destroy_tag/" + element.id + "' class='btn btn-sm btn-danger' style='margin: 2px;'>" + element.type + ": " + element.value + " <i class='fa fa-trash'></i></a> ");
            });

        });

    });

    $(document).on("click", ".open-delete-url", function() {
        /* passing data dari view button detail ke modal */
        var id_post = $(this).data('id');
        // $(".modal-body #id").val(thisDataAnggota);
        var linkDetail = "{{ route('front') }}/show/" + id_post;
        $.get(linkDetail, function(data) {
            //deklarasi var obj JSON data detail anggota
            var obj = data;
            var urls = data.url;
            // empty element
            $("#url_delete_pool").empty();

            urls.forEach(element => {
                $("#url_delete_pool").append("<a href='{{ route('front') }}/destroy_url/" + element.id + "' class='btn btn-sm btn-danger' style='margin: 2px;'>" + element.site + ": " + element.name + " <i class='fa fa-trash'></i></a> ");
            });

        });
    });

    $(document).on("click", ".open-edit", function() {
        /* passing data dari view button detail ke modal */
        var id_post = $(this).data('id');
        $(".modal-footer #PostIdEdit").val(id_post);
        var linkDetail = "{{ route('front') }}/show/" + id_post;
        $.get(linkDetail, function(data) {
            //deklarasi var obj JSON data detail anggota
            var obj = data;

            //initialization
            $("#editName").val(data.name);
            $("#editAltName").val(data.alt_name);
            $("#editAlias").val(data.alias);
            $("#editDescription").val(data.description);
            $("#editDebut").val(data.debut);
        });
    });

    $(document).on("click", ".open-delete", function() {
        /* passing data dari view button detail ke modal */
        var id_post = $(this).data('id');
        $(".modal-footer #PostIdDelete").val(id_post);
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
            $("#alt_name_detail").empty();
            $("#alias_detail").empty();
            $("#description_detail").empty();
            $("#status_detail").empty();
            $("#affiliation_detail").empty();
            $("#language_detail").empty();
            $("#tags_detail").empty();
            $("#url_stream_detail").empty();
            $("#url_social_detail").empty();
            // data initialization
            $("#name_detail").html(obj.name);
            $("#alt_name_detail").html(obj.alt_name);
            $("#alias_detail").html(obj.alias);
            $("#description_detail").html(obj.description);
            $("#debut_detail").html(obj.debut_date);
            $("#status").html(obj.status);
            tags.forEach(element => {
                console.log(element);
                if (element.type == "status") {
                    $("#status_detail").append("<a href='{{ route('front') }}/tag/" + element.value + "' class='tagbtn btn btn-sm btn-primary'>" + element.value + "</a>");
                } else if (element.type == "affiliation") {
                    $("#affiliation_detail").append("<a href='{{ route('front') }}/tag/" + element.value + "' class='tagbtn btn btn-sm btn-primary'>" + element.value + "</a>" + " ");
                } else if (element.type == "language") {
                    $("#language_detail").append("<a href='{{ route('front') }}/tag/" + element.value + "' class='tagbtn btn btn-sm btn-primary'>" + element.value + "</a>" + " ");
                } else {
                    $("#tags_detail").append("<a href='{{ route('front') }}/tag/" + element.value + "' class='tagbtn btn btn-sm btn-primary'>" + element.value + "</a>" + " ");
                }
            });
            urls.forEach(element => {
                if (element.site == "youtube") {
                    $("#url_stream_detail").append('<a href="' + element.value + '" class="tagbtn btn btn-sm btn-danger">' + '<i class="fab fa-youtube"></i> ' + element.name + '</a> ');
                } else if (element.site == "twitter") {
                    $("#url_social_detail").append('<a href="' + element.value + '" class="tagbtn btn btn-sm btn-info">' + '<i class="fab fa-twitter"></i> ' + element.name + '</a> ');
                }
            });

            //base root project url + url dari db
            var picture_link = "{{ route('front') }}/" + obj.img_url;
            $("#detail_picture").attr('src', picture_link);
        });
    });
</script>
@endsection