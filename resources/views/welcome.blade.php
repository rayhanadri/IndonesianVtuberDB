

@extends('layouts.app')
@section('content')
<!-- Datatables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>


<div class="container-fluid">
    <div class="row justify-content-center" style="margin-bottom: 20px;">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">New Update</div>

                <div class="card-body">
                    Data here
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center">
                    Data Vtuber
                </div>
                <div class="card-body">
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Picture</th>
                                <th>Name</th>
                                <th>Alias/Nickname</th>
                                <th>Description</th>
                                <th>Channel/Stream URL</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($vtubers as $vtuber)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>pict</td>
                                <td>{{ $vtuber->name }}</td>
                                <td>{{ $vtuber->alias }}</td>
                                <td>{{ $vtuber->description }}</td>
                                <td><a href="{{ $vtuber->channel_url }}">{{ $vtuber->channel_name }}</a></td>
                                <td>details</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    1
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
                        Data here
                        <div class="detail_data">Name: <span id="name_detail"></span></div>
                        <div class="detail_data">Alternative Name: <span id="alt_name_detail"></span></div>
                        <div class="detail_data">Affiliation: <span id="affiliation_detail"></span></div>
                        <div class="detail_data">Debut: <span id="debut_detail"></span></div>
                        <div class="detail_data">Status: <span id="status_detail"></span></div>
                        <div class="detail_data">Language: <span id="language_detail"></span></div>
                        <div class="detail_data">Channel/Stream URL: <span id="url_stream_detail"></span></div>
                        <div class="detail_data">Social Media URL: <span id="url_social_detail"></span></div>
                        <div class="detail_data">Tags: <span id="tags_detail"></span></div>
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
} );

$(document).on("click", ".close-detail", function() {
    $('#detail_card').hide();
} );

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
                    $("#status_detail").append("<a href='{{ route('front') }}/tag/"+ element.value +"' class='btn btn-sm btn-primary'>" + element.value + "</a>");
                }
                else if (element.type == "affiliation") {
                    $("#affiliation_detail").append("<a href='{{ route('front') }}/tag/"+ element.value +"' class='btn btn-sm btn-primary'>" + element.value + "</a>" + " ");
                }
                else if (element.type == "language") {
                    $("#language_detail").append("<a href='{{ route('front') }}/tag/"+ element.value +"' class='btn btn-sm btn-primary'>" + element.value + "</a>" + " ");
                } else {
                    $("#tags_detail").append("<a href='{{ route('front') }}/tag/"+ element.value +"' class='btn btn-sm btn-primary'>" + element.value + "</a>" + " ");
                }
            });
            urls.forEach(element => {
                if (element.site == "youtube") {
                    $("#url_stream_detail").append('<a href="'+ element.value +'" class="btn btn-sm btn-danger">'+ '<i class="fab fa-youtube"></i> ' + element.name +'</a> ');
                }
                else if (element.site == "twitter") {
                    $("#url_social_detail").append('<a href="'+ element.value +'" class="btn btn-sm btn-info">'+ '<i class="fab fa-twitter"></i> ' + element.name +'</a> ');
                }
            });
            
            //base root project url + url dari db
            var picture_link = "{{ route('front') }}/" + obj.img_url;
            $("#detail_picture").attr('src', picture_link);
        });
    });
</script>
@endsection
