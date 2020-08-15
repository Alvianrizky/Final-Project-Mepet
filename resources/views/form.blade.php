@extends('layouts.template')

@push('style')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@endpush

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row my-2 justify-content-center">
                <div class="col-4">
                    <h1 class="text-center text-dark">Ajukan pertanyaan</h1>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-8 mx-auto">
                    <div class="card">
                        @if ($pertanyaan == 'Pertanyaan')
                        <form action="/update/{{ $query->id }}/pertanyaan" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="title">Judul</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $query->title) }}">
                                </div>
                                <div class="form-group">
                                    <label for="content">Pertanyaan</label>
                                    <textarea name="content" id="content" class="form-control my-editor" >{!! old('content',  $query->content) !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="tag" class="mb-n3">Tags</label><br>
                                    <small>pisahkan dengan ' , ' jika lebih dari satu tag contoh :
                                        python,php,java</small>
                                    <input type="text" class="form-control mt-1" id="tag" name="tag" {{ old('tag', '') }}>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        @else
                        <form action="/" method="post">
                            @csrf
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="title">Judul</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="content">Pertanyaan</label>
                                    <textarea name="content" id="content" class="form-control my-editor" >{!! old('content', '') !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="tag" class="mb-n3">Tags</label><br>
                                    <small>pisahkan dengan ' , ' jika lebih dari satu tag contoh :
                                        python,php,java</small>
                                    <input type="text" class="form-control mt-1" id="tag" name="tag" {{ old('tag', '') }}>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        @endif

                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

@endsection

@push('script')
<script>
    var editor_config = {
        path_absolute: "/",
        selector: "textarea.my-editor",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
        file_browser_callback: function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                'body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document
                .getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        }
    };

    tinymce.init(editor_config);
</script>
@endpush
