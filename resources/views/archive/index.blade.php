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

<table class="table table-condensed table-archive">
    @for ($i = 0; $i <= intval(count($folders) / 4); $i++)
        <tr>
            <td>
                @if (!is_null($folders[4*$i + 0]))
                    <form action="{{ URL::route('archive_folder', [$folders[4*$i + 0]]) }}" method="POST" class="form">
                        <input type="hidden" name="path" value="{{ $path }}">
                        <a class="folder-panel">
                            <div class="card style-accent">
                                <div class="card-body text-xl">
                                    {{ $folders[4*$i + 0]}}
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
                            <div class="card style-accent">
                                <div class="card-body text-xl">
                                    {{ $folders[4*$i + 1] }}
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
                            <div class="card style-accent">
                                <div class="card-body text-xl">
                                    {{ $folders[4*$i + 2] }}
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
                            <div class="card style-accent">
                                <div class="card-body text-xl">
                                    {{ $folders[4*$i + 3] }}
                                </div>
                            </div>
                        </a>
                    </form>
                @endif
            </td>
        </tr>
    @endfor
</table>

<hr>

<table class="table table-condensed table-archive">
    @for ($i = 0; $i <= intval(count($files) / 4); $i++)
    <tr>
        <td>
            @if (!is_null($files[4*$i + 0]))
                <form action="{{ URL::route('archive_folder', [$files[4*$i + 0]]) }}" method="POST" class="form">
                    <input type="hidden" name="path" value="{{ $path }}">
                    <a class="folder-panel">
                        <div class="card style-primary">
                            <div class="card-body text-xl">
                                {{ $files[4*$i + 0]}}
                            </div>
                        </div>
                    </a>
                </form>
            @endif
        </td>
        <td>
            @if (!is_null($files[4*$i + 1]))
                <form action="{{ URL::route('archive_folder', [$files[4*$i + 1]]) }}" method="POST" class="form">
                    <input type="hidden" name="path" value="{{ $path }}">
                    <a class="folder-panel">
                        <div class="card style-primary">
                            <div class="card-body text-xl">
                                {{ $files[4*$i + 1] }}
                            </div>
                        </div>
                    </a>
                </form>
            @endif
        </td>
        <td>
            @if (!is_null($files[4*$i + 2]))
                <form action="{{ URL::route('archive_folder', [$files[4*$i + 2]]) }}" method="POST" class="form">
                    <input type="hidden" name="path" value="{{ $path }}">
                    <a class="folder-panel">
                        <div class="card style-primary">
                            <div class="card-body text-xl">
                                {{ $files[4*$i + 2] }}
                            </div>
                        </div>
                    </a>
                </form>
            @endif
        </td>
        <td>
            @if (!is_null($files[4*$i + 3]))
                <form action="{{ URL::route('archive_folder', [$files[4*$i + 3]]) }}" method="POST" class="form">
                    <input type="hidden" name="path" value="{{ $path }}">
                    <a class="folder-panel">
                        <div class="card style-primary">
                            <div class="card-body text-xl">
                                {{ $files[4*$i + 3] }}
                            </div>
                        </div>
                    </a>
                </form>
            @endif
        </td>
    </tr>
    @endfor
</table>
@stop

@section('js-down')
{!! HTML::script('js/archive.js') !!}
@stop
