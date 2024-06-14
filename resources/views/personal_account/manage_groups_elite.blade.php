@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Назначить группы</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/full.css') !!}
    {!! HTML::style('css/personal_account/manage_groups_elite_common.css') !!}
    {!! HTML::style('css/personal_account/manage_groups_elite.css') !!}
    {!! HTML::style('css/personal_account/super_checkbox.css') !!}
@stop

@section('background')
    full
@stop

@section('content')
    <div class="mge-root">
        <div class="mge-subpages">
            <a href="/manage_groups" class="mge-subpage-btn" disabled>
                Группы
            </a>
            <a href="/manage_groups_by_teachers" class="mge-subpage-btn">
                Преподаватели
            </a>
        </div>
        <div class="mge-cards">
            @foreach ($groups as $g)
                <div class="mge-card" data-group-id="{{ $g['id'] }}">
                    <div class="mge-card-group">
                        {{ $g['name'] }}
                    </div>
                    <div class="mge-card-teachers">
                        @foreach ($g['teachers'] as $t)
                            <div class="mge-card-teacher">
                                {{ $t['lastName'] }}
                                {{ $t['firstName'] }}
                                <button type="button" class="close mge-remove-teacher" data-teacher-id="{{ $t['id'] }}">
                                    &times;
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="mge-card-btn-add" data-toggle="modal" data-target="#mgeAddUsersModal">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 7H9V1C9 0.734784 8.89464 0.48043 8.70711 0.292893C8.51957 0.105357 8.26522 0 8 0C7.73478 0 7.48043 0.105357 7.29289 0.292893C7.10536 0.48043 7 0.734784 7 1V7H1C0.734784 7 0.48043 7.10536 0.292893 7.29289C0.105357 7.48043 0 7.73478 0 8C0 8.26522 0.105357 8.51957 0.292893 8.70711C0.48043 8.89464 0.734784 9 1 9H7V15C7 15.2652 7.10536 15.5196 7.29289 15.7071C7.48043 15.8946 7.73478 16 8 16C8.26522 16 8.51957 15.8946 8.70711 15.7071C8.89464 15.5196 9 15.2652 9 15V9H15C15.2652 9 15.5196 8.89464 15.7071 8.70711C15.8946 8.51957 16 8.26522 16 8C16 7.73478 15.8946 7.48043 15.7071 7.29289C15.5196 7.10536 15.2652 7 15 7Z" fill="currentColor"/>
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal fade mge-modal-bg" id="mgeAddUsersModal" tabindex="-1" role="dialog" aria-labelledby="#mgeAddUsersModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mge-modal-header">
                    <h5 class="modal-title mge-modal-title" id="mgeAddUsersModalLabel">
                        Группа
                        <span class="mge-modal-group">...</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mge-modal-body">
                    <div>Выберите преподавателей для добавления:</div>
                    <div class="mge-modal-teachers"></div>
                    <div>
                        <button type="button" class="btn btn-primary mge-select-all">Выбрать всех (или убрать)</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary mge-modal-save">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js-down')
    {!! HTML::script('js/personal_account/manage_groups_elite.js') !!}
@stop