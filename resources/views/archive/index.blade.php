@extends('templates.base')
@section('head')
<title>Архив</title>
{!! HTML::style('css/archive.css') !!}
@stop

@section('content')
@if (!is_null($prev_folder))
    @if ($prev_folder == 'archive')
        <form action="{{ URL::route('archive_index') }}" method="GET" class="form">
    @else
        <form action="{{ URL::route('archive_folder', [$prev_folder]) }}" method="POST" class="form">
    @endif
        <input type="hidden" name="path" value="{{ $prev_path }}">
        <a class="folder-panel">
            <span class="demo-icon-hover text-xl">
                <i class="md md-reply"> Назад </i>
            </span>
        </a>
    </form>
<br>
@endif

@if (!empty($folders))
    <table class="table table-condensed table-archive" id="folder-table">
        @for ($i = 0; $i <= intval(count($folders) / 4); $i++)
            <tr>
                <td>
                    @if (!is_null($folders[4*$i + 0]))
                        <form action="{{ URL::route('archive_folder', [$folders[4*$i + 0]]) }}" method="POST" class="form">
                            <input type="hidden" name="path" value="{{ $path }}">
                            <a class="folder-panel">
                                <div class="card card-bordered style-accent">
                                    <div class="card-head">
                                        <header>
                                            <span class="demo-icon-hover text-medium">
                                                <i class="md md-folder"> Папка </i>
                                            </span>
                                        </header>
                                    </div>
                                    <div class="card-body style-default-bright">
                                        <p class="text-xl">{{ $folders[4*$i + 0] }}</p>
                                    </div>
                                </div>
                            </a>
                        </form>
                    @endif
                </td>
                <td>
                    @if (!is_null($folders[4*$i + 1]))
                        <form action="{{ URL::route('archive_folder', [$folders[4*$i + 1]]) }}" method="POST" class="form">
                            <input type="hidden" name="path" value="{{ $path }}">
                            <a class="folder-panel">
                                <div class="card card-bordered style-accent">
                                    <div class="card-head">
                                        <header>
                                            <span class="demo-icon-hover text-medium">
                                                <i class="md md-folder"> Папка </i>
                                            </span>
                                        </header>
                                    </div>
                                    <div class="card-body style-default-bright">
                                        <p class="text-xl">{{ $folders[4*$i + 1] }}</p>
                                    </div>
                                </div>
                            </a>
                        </form>
                    @endif
                </td>
                <td>
                    @if (!is_null($folders[4*$i + 2]))
                        <form action="{{ URL::route('archive_folder', [$folders[4*$i + 2]]) }}" method="POST" class="form">
                            <input type="hidden" name="path" value="{{ $path }}">
                            <a class="folder-panel">
                                <div class="card card-bordered style-accent">
                                    <div class="card-head">
                                        <header>
                                            <span class="demo-icon-hover text-medium">
                                                <i class="md md-folder"> Папка </i>
                                            </span>
                                        </header>
                                    </div>
                                    <div class="card-body style-default-bright">
                                        <p class="text-xl">{{ $folders[4*$i + 2] }}</p>
                                    </div>
                                </div>
                            </a>
                        </form>
                    @endif
                </td>
                <td>
                    @if (!is_null($folders[4*$i + 3]))
                            <form action="{{ URL::route('archive_folder', [$folders[4*$i + 3]]) }}" method="POST" class="form">
                                <input type="hidden" name="path" value="{{ $path }}">
                                <a class="folder-panel">
                                    <div class="card card-bordered style-accent">
                                        <div class="card-head">
                                            <header>
                                                <span class="demo-icon-hover text-medium">
                                                    <i class="md md-folder"> Папка </i>
                                                </span>
                                            </header>
                                        </div>
                                        <div class="card-body style-default-bright">
                                            <p class="text-xl">{{ $folders[4*$i + 3] }}</p>
                                        </div>
                                    </div>
                                </a>
                            </form>
                    @endif
                </td>
            </tr>
        @endfor
    </table>
@endif

<hr>

@if (!empty($files))
    <table class="table table-condensed table-archive" id="file-table">
        @for ($i = 0; $i <= intval(count($files) / 4); $i++)
        <tr>
            <td>
                @if (!is_null($files[4*$i + 0]))
                    <div class="card card-bordered style-primary">
                        <div class="card-head">
                            <div class="tools">
                                <div class="btn-group">
                                    <form action="{{ URL::route('archive_download') }}" method="POST" class="download-form" style="margin-left: 0">
                                        <input type="hidden" name="file-path" value="{{ $path.$files[4*$i + 0] }}">
                                        <a class="folder-panel btn btn-icon-toggle">
                                            <span class="demo-icon-hover text-medium">
                                                <i class="md md-file-download"></i>
                                            </span>
                                        </a>
                                    </form>
                                    <form action="{{ URL::route('archive_delete') }}" method="POST" class="delete-form" style="margin-left: 0">
                                        <input type="hidden" name="file-path" value="{{ $path.$files[4*$i + 0] }}">
                                        <a class="folder-panel btn btn-icon-toggle remove-btn">
                                            <span class="demo-icon-hover text-medium">
                                                <i class="md md-delete"></i>
                                            </span>
                                        </a>
                                    </form>
                                </div>
                            </div>
                            <header>
                                <a class="file-panel">
                                    <span class="demo-icon-hover text-medium">
                                        <i class="md md-attachment"> Файл </i>
                                    </span>
                                </a>
                            </header>
                        </div>
                        <div class="card-body style-default-bright">
                            <p class="text-xl">{{ $files[4*$i + 0] }}</p>
                        </div>
                    </div>
                @endif
            </td>
            <td>
                @if (!is_null($files[4*$i + 1]))
                    <div class="card card-bordered style-primary">
                        <div class="card-head">
                            <div class="tools">
                                <div class="btn-group">
                                    <form action="{{ URL::route('archive_download') }}" method="POST" class="download-form" style="margin-left: 0">
                                        <input type="hidden" name="file-path" value="{{ $path.$files[4*$i + 1] }}">
                                        <a class="folder-panel btn btn-icon-toggle">
                                            <span class="demo-icon-hover text-medium">
                                                <i class="md md-file-download"></i>
                                            </span>
                                        </a>
                                    </form>
                                    <form action="{{ URL::route('archive_delete') }}" method="POST" class="delete-form" style="margin-left: 0">
                                        <input type="hidden" name="file-path" value="{{ $path.$files[4*$i + 1] }}">
                                        <a class="folder-panel btn btn-icon-toggle remove-btn">
                                            <span class="demo-icon-hover text-medium">
                                                <i class="md md-delete"></i>
                                            </span>
                                        </a>
                                    </form>
                                </div>
                            </div>
                            <header>
                                <a class="file-panel">
                                    <span class="demo-icon-hover text-medium">
                                        <i class="md md-attachment"> Файл </i>
                                    </span>
                                </a>
                            </header>
                        </div>
                        <div class="card-body style-default-bright">
                            <p class="text-xl">{{ $files[4*$i + 1] }}</p>
                        </div>
                </div>
                @endif
            </td>
            <td>
                @if (!is_null($files[4*$i + 2]))
                    <div class="card card-bordered style-primary">
                        <div class="card-head">
                            <div class="tools">
                                <div class="btn-group">
                                    <form action="{{ URL::route('archive_download') }}" method="POST" class="download-form" style="margin-left: 0">
                                        <input type="hidden" name="file-path" value="{{ $path.$files[4*$i + 2] }}">
                                        <a class="folder-panel btn btn-icon-toggle">
                                            <span class="demo-icon-hover text-medium">
                                                <i class="md md-file-download"></i>
                                            </span>
                                        </a>
                                    </form>
                                    <form action="{{ URL::route('archive_delete') }}" method="POST" class="delete-form" style="margin-left: 0">
                                        <input type="hidden" name="file-path" value="{{ $path.$files[4*$i + 2] }}">
                                        <a class="folder-panel btn btn-icon-toggle remove-btn">
                                            <span class="demo-icon-hover text-medium">
                                                <i class="md md-delete"></i>
                                            </span>
                                        </a>
                                    </form>
                                </div>
                            </div>
                            <header>
                                <a class="file-panel">
                                    <span class="demo-icon-hover text-medium">
                                        <i class="md md-attachment"> Файл </i>
                                    </span>
                                </a>
                            </header>
                        </div>
                        <div class="card-body style-default-bright">
                            <p class="text-xl">{{ $files[4*$i + 2] }}</p>
                        </div>
                    </div>
                @endif
            </td>
            <td>
                @if (!is_null($files[4*$i + 3]))
                    <div class="card card-bordered style-primary">
                        <div class="card-head">
                            <div class="tools">
                                <div class="btn-group">
                                    <form action="{{ URL::route('archive_download') }}" method="POST" class="download-form" style="margin-left: 0">
                                        <input type="hidden" name="file-path" value="{{ $path.$files[4*$i + 3] }}">
                                        <a class="folder-panel btn btn-icon-toggle">
                                            <span class="demo-icon-hover text-medium">
                                                <i class="md md-file-download"></i>
                                            </span>
                                        </a>
                                    </form>
                                    <form action="{{ URL::route('archive_delete') }}" method="POST" class="delete-form" style="margin-left: 0">
                                        <input type="hidden" name="file-path" value="{{ $path.$files[4*$i + 3] }}">
                                        <a class="folder-panel btn btn-icon-toggle remove-btn">
                                            <span class="demo-icon-hover text-medium">
                                                <i class="md md-delete"></i>
                                            </span>
                                        </a>
                                    </form>
                                </div>
                            </div>
                            <header>
                                <a class="file-panel">
                                    <span class="demo-icon-hover text-medium">
                                        <i class="md md-attachment"> Файл </i>
                                    </span>
                                </a>
                            </header>
                        </div>
                        <div class="card-body style-default-bright">
                            <p class="text-xl">{{ $files[4*$i + 3] }}</p>
                        </div>
                    </div>
                @endif
            </td>
        </tr>
        @endfor
    </table>
@endif
@stop

@section('js-down')
{!! HTML::script('js/archive.js') !!}
@stop
