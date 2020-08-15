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
                <div class="col-8">
                    <h1 class="ml-3 text-dark">{{ $pertanyaan->title }}</h1>
                </div><!-- /.col -->


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
                        <div class="card-body">
                            <p class="card-text text-justify">{!! $pertanyaan->content !!}</p>

                            <div class="row">
                                <div class="col-8">
                                    <div class="form-inline">
                                        @foreach ($pertanyaan->tags as $key)
                                            <span class="badge badge-info px-2 py-2 mr-1 mt-1">{{ $key->tag_name }}</span>
                                        @endforeach
                                    </div>



                                    <div class="user-block mt-4">
                                        <img class="img-circle img-bordered-sm"
                                            src="{{ asset('adminlte/images/1.png') }}" alt="user image">
                                        <span class="username">
                                            @php ($name = App\User::find($pertanyaan->user_id))
                                            {{ $name->profile->full_name }}
                                        </span>
                                        <span class="description">{{ $name->profile->reputasi ? $name->profile->reputasi : 0}} reputasi</span>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <div class="row justify-content-center mx-2">
                                        <div class="form-group text-center mr-5 mt-3">
                                            <label class="mb-n2">
                                                <h2>{{ $pertanyaan->vote ? $pertanyaan->vote : 0 }}</h2>
                                            </label>

                                            @guest
                                            <span style="display: flex;">
                                                <p>votes</p>
                                            </span>
                                            @else
                                            @if ($pertanyaan->user_id != Auth::id())
                                            <span style="display: flex;">
                                                <a href="/upper/{{ $pertanyaan->id }}" class="btn btn-outline-dark btn-sm mr-2 mb-3" id="up">
                                                    <i class="fas fa-arrow-up"></i>
                                                </a>
                                                <p>votes</p>
                                                <a href="/downper/{{ $pertanyaan->id }}" class="btn btn-outline-dark btn-sm ml-2 mb-3" id="down">
                                                    <i class="fas fa-arrow-down"></i>
                                                </a>
                                            </span>
                                            @else
                                            <span style="display: flex;">
                                                <p>votes</p>
                                            </span>
                                            @endif
                                            @endguest

                                        </div>
                                    </div>
                                </div>

                                @if($pertanyaan->user_id == Auth::id())
                                <div class="col-6" style="display: flex;">
                                    <a href="/edit/{{ $pertanyaan->id }}/pertanyaan" class="btn btn-dark btn-sm">edit</a>
                                    <form action="/delete/{{ $pertanyaan->id }}/pertanyaan" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="delete" class="btn btn-danger btn-sm mx-1">
                                    </form>
                                </div>
                                @endif

                                <div class="col-12">
                                    <ul class="list-group list-group-flush">
                                        <hr>

                                        @forelse ($komentar as $row)

                                        <li class="list-group-item">
                                            {{ $row->content }}
                                            {{-- @php ($per = App\Pertanyaan::find($row->id)) --}}
                                            @php ($name = App\User::find($row->user_id))

                                             - <span class="text-blue">{{ $name->profile->full_name }}</span>
                                            @if ($name->profile->user_id == Auth::id())
                                             - <a href="/edit/{{ $row->id }}/komentarpertanyaan" class="text-gray">edit</a>
                                             - <a href="/delete/{{ $row->id }}/komentarpertanyaan" class="text-gray">hapus</a>
                                            @endif

                                        </li>

                                        @empty
                                        <div class="my-n4"></div>
                                        @endforelse

                                        <hr>
                                    </ul>

                                    @guest

                                    @else
                                        <form action="/detail/{{ $pertanyaan->id }}/pertanyaan" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="komentar">Komentar</label>
                                                <input type="text" name="komentar_per" class="form-control" id="komentar">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">komentar</button>
                                        </form>
                                    @endguest



                                </div>
                            </div>
                        </div>
                    </div>
                    @php ($count = App\Jawaban::where('question_id', $pertanyaan->id)->count())
                    <h4 class="mb-4">{{ $count }} Answer</h4>
                    @forelse ($jawaban as $row)
                    @php ($id = $row->id)
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text text-justify">{!! $row->content !!}</p>
                            <div class="row">
                                <div class="col-8">
                                    <div class="user-block mt-4">
                                        <img class="img-circle img-bordered-sm"
                                            src="{{ asset('adminlte/images/1.png') }}" alt="user image">
                                        <span class="username">
                                            @php ($name = App\User::find($row->user_id))
                                            {{ $name->profile->full_name }}
                                        </span>
                                        <span class="description">{{ $name->profile->reputasi ? $name->profile->reputasi : 0}} reputasi</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row justify-content-center mx-2">
                                        <div class="form-group text-center mr-5 mt-3">
                                            <label class="mb-n2">
                                                <h2>{{ $row->vote ? $row->vote : 0 }}</h2>
                                            </label>

                                            @guest
                                            <span style="display: flex;">
                                                <p>votes</p>
                                            </span>
                                            @else
                                            @if ($row->user_id != Auth::id())
                                            <span style="display: flex;">
                                                <a href="/up/{{ $row->id }}/jawaban" class="btn btn-outline-dark btn-sm mr-2 mb-3" id="up">
                                                    <i class="fas fa-arrow-up"></i>
                                                </a>
                                                <p>votes</p>
                                                <a href="/down/{{ $row->id }}/jawaban" class="btn btn-outline-dark btn-sm ml-2 mb-3" id="down">
                                                    <i class="fas fa-arrow-down"></i>
                                                </a>
                                            </span>
                                            @else
                                            <span style="display: flex;">
                                                <p>votes</p>
                                            </span>
                                            @endif
                                            @endguest

                                        </div>

                                        @if ($pertanyaan->answer_right_id == $row->id)
                                        <div class="form-group">
                                            <i class="fas fa-check text-success fa-2x"></i>
                                        </div>
                                        @endif

                                    </div>
                                </div>

                                @if($row->user_id == Auth::id())
                                <div class="col-6" style="display: flex;">
                                    <a href="/edit/{{ $row->id }}/jawaban" class="btn btn-dark btn-sm">edit</a>
                                    <form action="/delete/{{ $row->id }}/jawaban" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="delete" class="btn btn-danger btn-sm mx-1">
                                    </form>
                                </div>
                                @endif

                                @if ($pertanyaan->user_id == Auth::id())
                                <div class="col-6" style="display: flex;">
                                    <a href="/jawaban/{{ $row->id }}" class="btn btn-success btn-sm">Jawaban Tepat</a>
                                </div>
                                @endif

                                <div class="col-12">
                                    <ul class="list-group list-group-flush">
                                        <hr>
                                        @php ($komentarjawaban = App\Jawaban::find($row->id)->komentar)
                                        @forelse ($komentarjawaban as $row)

                                        <li class="list-group-item">
                                            {{ $row->content }}
                                            @php ($name = App\User::find($row->user_id))

                                             - <span class="text-blue">{{ $name->profile->full_name }}</span>
                                            @if ($name->profile->user_id == Auth::id())
                                             - <a href="/edit/{{ $row->id }}/komentarjawaban" class="text-gray">edit</a>
                                             - <a href="/delete/{{ $row->id }}/komentarjawaban" class="text-gray">hapus</a>
                                            @endif
                                        </li>

                                        @empty
                                            <div class="my-n4"></div>
                                        @endforelse

                                        <hr>
                                    </ul>

                                    @guest
                                    @else
                                    <form action="/detail/{{ $id }}/jawaban" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="komentar">Komentar</label>
                                            <input type="text" name="komentar_jaw" class="form-control" id="komentar">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">komentar</button>
                                    </form>
                                    @endguest

                                </div>
                            </div>
                        </div>
                    </div>

                    @empty

                    @endforelse


                    <div class="card mt-5">

                        @guest

                        @else

                            @if ($pertanyaan->user_id != Auth::id())
                            <form action="/detail/{{ $pertanyaan->id }}" method="post">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="content">Jawaban Anda</label>
                                        <textarea name="content" id="content" class="form-control my-editor"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Posting Jawaban Anda</button>
                                </div>
                            </form>
                            @endif

                        @endguest

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
    path_absolute : "/",
    selector: "textarea.my-editor",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };

  tinymce.init(editor_config);
</script>
@endpush
