@extends('layouts.template')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row my-2">
                <div class="col-6">
                    <h1 class="ml-3 text-dark">List Pertanyaan</h1>
                </div><!-- /.col -->

                @guest
                @else
                <div class="col-6 text-right">
                    <a href="/form" class="btn btn-primary">Ajukan Pertanyaan</a>
                </div><!-- /.col -->
                @endguest


            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-8 mx-auto">

                    @forelse ($pertanyaan as $row)
                    <div class="card">
                        <div class="card-body">
                            <a href="/detail/{{ $row->id }}">
                                <h5 class="text-blue">{{ $row->title }}</h5>
                            </a>
                            @php ($desc = substr($row->content, 0, 190))
                            <p class="card-text text-justify">{!! $desc !!} . . . .</p>
                            <div class="row">
                                <div class="col-7">
                                    <div class="form-inline">
                                        @php ($tag = App\Pertanyaan::find($row->id))
                                        @foreach ($tag->tags as $key)
                                            <span class="badge badge-info px-2 py-2 mr-1 mt-1">{{ $key->tag_name }}</span>
                                        @endforeach

                                        {{-- <span class="badge badge-info px-2 py-2 mr-1 mt-1">python</span>
                                        <span class="badge badge-info px-2 py-2 mr-1 mt-1">python</span> --}}
                                    </div>

                                    <div class="user-block mt-4">
                                        <img class="img-circle img-bordered-sm"
                                            src="{{ asset('adminlte/images/1.png') }}" alt="user image">
                                        <span class="username">
                                            @php ($query = App\Pertanyaan::find($row->id))
                                            @php ($name = App\User::find($query->users->id))
                                            {{ $name->profile->full_name }}
                                        </span>
                                        <span class="description">{{ $name->profile->reputasi ? $name->profile->reputasi : 0}} reputasi</span>
                                    </div>
                                </div>
                                <div class="col-5">
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
                                                <a href="/up/{{ $row->id }}" class="btn btn-outline-dark btn-sm mr-2 mb-3" id="up">
                                                    <i class="fas fa-arrow-up"></i>
                                                </a>
                                                <p>votes</p>
                                                <a href="/down/{{ $row->id }}" class="btn btn-outline-dark btn-sm ml-2 mb-3" id="down">
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
                                        <div class="form-group text-center mt-3">
                                            @php ($count = App\Jawaban::where('question_id', $row->id)->count())
                                            <label class="mb-n2">
                                                <h2>{{ $count }}</h2>
                                            </label>
                                            <p>answers</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Data Masih Kosong</h3>
                        </div>
                    </div>
                    @endforelse



                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-dark">Pertanyaan Saya</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @guest
                                    <li class="list-group-item text-center">Anda Belum Login</li>
                                @else
                                    @forelse ($pertanyaan as $row)
                                        @if ($row->user_id == Auth::id())
                                            <li class="list-group-item"><a href="/detail/{{ $row->id }}">{{ $row->title }}</a></li>
                                        @endif
                                    @empty
                                        <li class="list-group-item text-center">Data Anda Masih Kosong</li>
                                    @endforelse

                                @endguest

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

@endsection
