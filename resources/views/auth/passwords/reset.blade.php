<!DOCTYPE html>
<html>
<head>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/full.css') !!}
    {!! HTML::style('css/tests_list.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}
    {!! HTML::script('js/modules.js') !!}
    <title>Algorithms theory LMS</title>
</head>
<body class="full-no_access">
<div class="col-md-12 col-sm-6 card style-primary text-center">
    <h1 class="text-default-bright">Справочно-обучающая система по курсу ДМ (ТА и СВ)</h1>
</div>
<div class="container">

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="#" class="active" id="newpass-form-link">Восстановление пароля</a>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="newpass-form" method="POST" action="{{URL::route('password.request')}}" data-toggle="validator" role="form" style="display: block;">
                                {!! csrf_field() !!}
                                <input type="hidden" name="token" value="{{ $token }}">

                                @if (count($errors) > 0)
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                <div class="form-group">
                                    <input type="email" name="email" value="{{ old('email') }}" id="email" tabindex="1" class="form-control" placeholder="Email">
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Пароль">
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Подтверждение пароля">
                                </div>

                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <button type="submit" tabindex="4" class="form-control btn btn-register" value="Восстановить пароль">
                                                Восстановить пароль
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>/* ========================================================================
     * Bootstrap (plugin): validator.js v0.9.0
     * ========================================================================
     * The MIT License (MIT)
     *
     * Copyright (c) 2015 Cina Saffary.
     * Made by @1000hz in the style of Bootstrap 3 era @fat
 *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     * ======================================================================== */

    +function ($) {
        'use strict';

// VALIDATOR CLASS DEFINITION
// ==========================

        var Validator = function (element, options) {
            this.$element = $(element)
            this.options = options

            options.errors = $.extend({}, Validator.DEFAULTS.errors, options.errors)

            for (var custom in options.custom) {
                if (!options.errors[custom]) throw new Error('Missing default error message for custom validator: ' + custom)
            }

            $.extend(Validator.VALIDATORS, options.custom)

            this.$element.attr('novalidate', true) // disable automatic native validation
            this.toggleSubmit()

            this.$element.on('input.bs.validator change.bs.validator focusout.bs.validator', $.proxy(this.validateInput, this))
            this.$element.on('submit.bs.validator', $.proxy(this.onSubmit, this))

            this.$element.find('[data-match]').each(function () {
                var $this = $(this)
                var target = $this.data('match')

                $(target).on('input.bs.validator', function (e) {
                    $this.val() && $this.trigger('input.bs.validator')
                })
            })
        }

        Validator.INPUT_SELECTOR = ':input:not([type="submit"], button):enabled:visible'

        Validator.DEFAULTS = {
            delay: 500,
            html: false,
            disable: true,
            custom: {},
            errors: {
                match: 'Does not match',
                minlength: 'Сликом короткий'
            },
            feedback: {
                success: 'glyphicon-ok',
                error: 'glyphicon-remove'
            }
        }

        Validator.VALIDATORS = {
            'native': function ($el) {
                var el = $el[0]
                return el.checkValidity ? el.checkValidity() : true
            },
            'match': function ($el) {
                var target = $el.data('match')
                return !$el.val() || $el.val() === $(target).val()
            },
            'minlength': function ($el) {
                var minlength = $el.data('minlength')
                return !$el.val() || $el.val().length >= minlength
            }
        }

        Validator.prototype.validateInput = function (e) {
            var $el = $(e.target)
            var prevErrors = $el.data('bs.validator.errors')
            var errors

            if ($el.is('[type="radio"]')) $el = this.$element.find('input[name="' + $el.attr('name') + '"]')

            this.$element.trigger(e =
                    $.Event('validate.bs.validator', {relatedTarget: $el[0]}))

            if (e.isDefaultPrevented()) return

            var self = this

            this.runValidators($el).done(function (errors) {
                $el.data('bs.validator.errors', errors)

                errors.length ? self.showErrors($el) : self.clearErrors($el)

                if (!prevErrors || errors.toString() !== prevErrors.toString()) {
                    e = errors.length
                            ? $.Event('invalid.bs.validator', {relatedTarget: $el[0], detail: errors})
                            : $.Event('valid.bs.validator', {relatedTarget: $el[0], detail: prevErrors})

                    self.$element.trigger(e)
                }

                self.toggleSubmit()

                self.$element.trigger($.Event('validated.bs.validator', {relatedTarget: $el[0]}))
            })
        }

        Validator.prototype.runValidators = function ($el) {
            var errors = []
            var deferred = $.Deferred()
            var options = this.options

            $el.data('bs.validator.deferred') && $el.data('bs.validator.deferred').reject()
            $el.data('bs.validator.deferred', deferred)

            function getErrorMessage(key) {
                return $el.data(key + '-error')
                        || $el.data('error')
                        || key == 'native' && $el[0].validationMessage
                        || options.errors[key]
            }

            $.each(Validator.VALIDATORS, $.proxy(function (key, validator) {
                if (($el.data(key) || key == 'native') && !validator.call(this, $el)) {
                    var error = getErrorMessage(key)
                    !~errors.indexOf(error) && errors.push(error)
                }
            }, this))

            if (!errors.length && $el.val() && $el.data('remote')) {
                this.defer($el, function () {
                    var data = {}
                    data[$el.attr('name')] = $el.val()
                    $.get($el.data('remote'), data)
                            .fail(function (jqXHR, textStatus, error) { errors.push(getErrorMessage('remote') || error) })
                            .always(function () { deferred.resolve(errors)})
                })
            } else deferred.resolve(errors)

            return deferred.promise()
        }

        Validator.prototype.validate = function () {
            var delay = this.options.delay

            this.options.delay = 0
            this.$element.find(Validator.INPUT_SELECTOR).trigger('input.bs.validator')
            this.options.delay = delay

            return this
        }

        Validator.prototype.showErrors = function ($el) {
            var method = this.options.html ? 'html' : 'text'

            this.defer($el, function () {
                var $group = $el.closest('.form-group')
                var $block = $group.find('.help-block.with-errors')
                var $feedback = $group.find('.form-control-feedback')
                var errors = $el.data('bs.validator.errors')

                if (!errors.length) return

                errors = $('<ul/>')
                        .addClass('list-unstyled')
                        .append($.map(errors, function (error) { return $('<li/>')[method](error) }))

                $block.data('bs.validator.originalContent') === undefined && $block.data('bs.validator.originalContent', $block.html())
                $block.empty().append(errors)
                $group.addClass('has-error')

                $feedback.length
                && $feedback.removeClass(this.options.feedback.success)
                && $feedback.addClass(this.options.feedback.error)
                && $group.removeClass('has-success')
            })
        }

        Validator.prototype.clearErrors = function ($el) {
            var $group = $el.closest('.form-group')
            var $block = $group.find('.help-block.with-errors')
            var $feedback = $group.find('.form-control-feedback')

            $block.html($block.data('bs.validator.originalContent'))
            $group.removeClass('has-error')

            $feedback.length
            && $feedback.removeClass(this.options.feedback.error)
            && $feedback.addClass(this.options.feedback.success)
            && $group.addClass('has-success')
        }

        Validator.prototype.hasErrors = function () {
            function fieldErrors() {
                return !!($(this).data('bs.validator.errors') || []).length
            }

            return !!this.$element.find(Validator.INPUT_SELECTOR).filter(fieldErrors).length
        }

        Validator.prototype.isIncomplete = function () {
            function fieldIncomplete() {
                return this.type === 'checkbox' ? !this.checked :
                        this.type === 'radio' ? !$('[name="' + this.name + '"]:checked').length :
                        $.trim(this.value) === ''
            }

            return !!this.$element.find(Validator.INPUT_SELECTOR).filter('[required]').filter(fieldIncomplete).length
        }

        Validator.prototype.onSubmit = function (e) {
            this.validate()
            if (this.isIncomplete() || this.hasErrors()) e.preventDefault()
        }

        Validator.prototype.toggleSubmit = function ()
        {
            if(!this.options.disable) return

            var $btn = $('button[type="submit"], input[type="submit"]')
                    .filter('[form="' + this.$element.attr('id') + '"]')
                    .add(this.$element.find('input[type="submit"], button[type="submit"]'))

            $btn.toggleClass('disabled', this.isIncomplete() || this.hasErrors())
        }

        Validator.prototype.defer = function ($el, callback) {
            callback = $.proxy(callback, this)
            if (!this.options.delay) return callback()
            window.clearTimeout($el.data('bs.validator.timeout'))
            $el.data('bs.validator.timeout', window.setTimeout(callback, this.options.delay))
        }

        Validator.prototype.destroy = function () {
            this.$element
                    .removeAttr('novalidate')
                    .removeData('bs.validator')
                    .off('.bs.validator')

            this.$element.find(Validator.INPUT_SELECTOR)
                    .off('.bs.validator')
                    .removeData(['bs.validator.errors', 'bs.validator.deferred'])
                    .each(function () {
                        var $this = $(this)
                        var timeout = $this.data('bs.validator.timeout')
                        window.clearTimeout(timeout) && $this.removeData('bs.validator.timeout')
                    })

            this.$element.find('.help-block.with-errors').each(function () {
                var $this = $(this)
                var originalContent = $this.data('bs.validator.originalContent')

                $this
                        .removeData('bs.validator.originalContent')
                        .html(originalContent)
            })

            this.$element.find('input[type="submit"], button[type="submit"]').removeClass('disabled')

            this.$element.find('.has-error').removeClass('has-error')

            return this
        }

// VALIDATOR PLUGIN DEFINITION
// ===========================

        function Plugin(option) {
            return this.each(function () {
                var $this = $(this)
                var options = $.extend({}, Validator.DEFAULTS, $this.data(), typeof option == 'object' && option)
                var data = $this.data('bs.validator')

                if (!data && option == 'destroy') return
                if (!data) $this.data('bs.validator', (data = new Validator(this, options)))
                if (typeof option == 'string') data[option]()
            })
        }

        var old = $.fn.validator

        $.fn.validator = Plugin
        $.fn.validator.Constructor = Validator

// VALIDATOR NO CONFLICT
// =====================

        $.fn.validator.noConflict = function () {
            $.fn.validator = old
            return this
        }

// VALIDATOR DATA-API
// ==================

        $(window).on('load', function () {
            $('form[data-toggle="validator"]').each(function () {
                var $form = $(this)
                Plugin.call($form, $form.data())
            })
        })

    }(jQuery);</script>

</body>
</html>



