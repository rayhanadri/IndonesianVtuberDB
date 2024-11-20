<div class="col-md-8">
    @foreach ($posts as $post)
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-header text-center">
            @if( $post->type == "Picture" )
            <h4><i class="fa fa-image"></i> <a href="{{ route('front') }}/p/{{ $post->id }}">{{ $post->title }}</a></h4>
            @elseif ( $post->type == "Clip" )
            <h4><i class="fa fa-film"></i> <a href="{{ route('front') }}/p/{{ $post->id }}">{{ $post->title }}</a></h4>
            @else
            <h4><i class="fa fa-file"></i> <a href="{{ route('front') }}/p/{{ $post->id }}">{{ $post->title }}</a></h4>
            @endif
            <div>Posted: {{ $post->created_at->isoFormat('LLLL') }}</div>
        </div>
        <div class="card-body text-center">
            @if($post->type == "Clip")
            <?php
            $link  = $post->content;
            $watch = array("https://www.youtube.com/watch?v=");
            $embed   = array("https://www.youtube.com/embed/");

            $embed_link = str_replace($watch, $embed, $link);
            ?>
            <div class="videoWrapper">
                <iframe width="560" height="315" class="myIframe" src="{{ $embed_link }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            @elseif($post->type == "Picture")
            <img src="{{ $post->content }}" id="content picture" class="rounded mx-auto d-block" alt="vtuber picture" style="max-width:100%; overflow: hidden;">
            @else
            {{ $post->content }}
            @endif
            <p>{{ $post->caption }}</p>
            <hr>
            Tags:
            @foreach ( $post->tag as $tag )
            <a href="{{ route('front') }}/tag/{{ $tag->tagname }}" class='btn btn-sm btn-primary tagbtn'>{{ $tag->tagname }}</a>
            @endforeach
        </div>
        @if(Auth::check())
        <div class="card-footer text-center">
            <div class="btn-group" role="group" aria-label="Basic example" style="margin: 2px;">
                <a href="#" class="btn btn-sm btn-secondary open-new-tag" data-toggle="modal" data-target="#tag_new_modal" data-id="{{ $post->id }}"><i class="fa fa-tags"></i> New Tag</a>
                <a href="#" class="btn btn-sm btn-secondary open-delete-tag" data-toggle="modal" data-target="#tag_delete_modal" data-id="{{ $post->id }}"><i class="fa fa-times"></i> Delete Tag</a>
            </div>
            <div class="btn-group" role="group" aria-label="Basic example" style="margin: 2px;">
                <a href="#" class="btn btn-sm btn-warning open-edit" data-toggle="modal" data-target="#edit_modal" data-id="{{ $post->id }}"><i class="fa fa-pen-square"></i> Edit Post</a>
                <a href="#" class="btn btn-sm btn-danger open-delete" data-toggle="modal" data-target="#delete_modal" data-id="{{ $post->id }}"><i class="fa fa-trash"></i> Delete Post</a>
            </div>
        </div>
        @endif
    </div>
    @endforeach
    {{ $posts->links('vendor.pagination.bootstrap-4') }}
</div>
<!-- Modal Edit -->
<div class="modal fade" tabindex="-1" role="dialog" id="edit_modal">
    <div class="modal-dialog" role="document">
        <form action="{{ route('postEdit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- row 1 type -->
                    <div class="form-group row">
                        <label for="type" class="col-md-4 col-form-label text-md-right">Type</label>
                        <div class="col-md-6">
                            <select name="type" id="editType" class="form-control">
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
                            <input name="title" id="editTitle" class="form-control" placeholder="Post title" required />
                        </div>
                    </div>
                    <!-- row 3 content -->
                    <div class="form-group row">
                        <label for="content" class="col-md-4 col-form-label text-md-right">Content</label>
                        <div class="col-md-6">
                            <textarea name="content" id="editContent" class="form-control" placeholder="URL youtube clips or direct link image. Example yt link: https://www.youtube.com/watch?v=XXXXXXXXXXX."></textarea>
                        </div>
                    </div>
                    <!-- row 4 caption -->
                    <div class="form-group row">
                        <label for="caption" class="col-md-4 col-form-label text-md-right">Caption</label>
                        <div class="col-md-6">
                            <textarea name="caption" id="editCaption" class="form-control" placeholder="Content description or caption."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <input type="text" id="PostIdEdit" name="id_post" value="" required hidden />
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
                    <input type="text" id="PostIdDelete" name="id_post" value="" required hidden />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" value="Yes, Delete" class="btn btn-danger" />
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal New Tag -->
<div class="modal fade" tabindex="-1" role="dialog" id="tag_new_modal">
    <div class="modal-dialog" role="document">
        <form action="{{ route('tagStore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="tags" class="col-md-4 col-form-label text-md-right">Tags (Separated by comma space)</label>
                        <div class="col-md-6">
                            <textarea name="tags" id="tagsAdd" class="form-control" placeholder="Example: Hana Macchia, Nijisanji ID, Meme" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <input type="text" id="tagPostIdAdd" name="id_post" value="" required hidden />
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
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // $('.myIframe').css('height', $(window).height() + 'px');
        $('.pagination').addClass("justify-content-center");
        // $('#example').DataTable();
    });

    $(document).on("click", ".open-edit", function() {
        /* passing data dari view button detail ke modal */
        var id_post = $(this).data('id');
        $(".modal-footer #PostIdEdit").val(id_post);
        var linkDetail = "{{ route('front') }}/post/show/" + id_post;
        $.get(linkDetail, function(data) {
            //deklarasi var obj JSON data detail anggota
            var obj = data;

            // initialize
            $("#editType").val(data.type);
            $("#editTitle").val(data.title);
            $("#editContent").val(data.content);
            $("#editCaption").val(data.caption);
        });
    });

    $(document).on("click", ".open-new-tag", function() {
        /* passing data dari view button detail ke modal */
        var id_post = $(this).data('id');
        $(".modal-footer #tagPostIdAdd").val(id_post);
    });

    $(document).on("click", ".open-delete-tag", function() {
        /* passing data dari view button detail ke modal */
        var id_post = $(this).data('id');
        // $(".modal-body #id").val(thisDataAnggota);
        var linkDetail = "{{ route('front') }}/post/show/" + id_post;
        $.get(linkDetail, function(data) {
            //deklarasi var obj JSON data detail anggota
            var obj = data;
            var tags = data.tag;
            // empty element
            $("#tag_delete_pool").empty();

            tags.forEach(element => {
                $("#tag_delete_pool").append("<a href='{{ route('front') }}/tag_destroy/" + element.id + "' class='btn btn-sm btn-danger' style='margin: 2px;'>" + element.tagname + " <i class='fa fa-trash'></i></a> ");
            });

        });
    });

    $(document).on("click", ".open-delete", function() {
        /* passing data dari view button detail ke modal */
        var id_post = $(this).data('id');
        $(".modal-footer #PostIdDelete").val(id_post);
    });
</script>
