<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "The :attribute must be accepted.",
	"active_url"           => "The :attribute is not a valid URL.",
	"after"                => "The :attribute must be a date after :date.",
	"alpha"                => "The :attribute may only contain letters.",
	"alpha_dash"           => "The :attribute may only contain letters, numbers, and dashes.",
	"alpha_num"            => "The :attribute may only contain letters and numbers.",
	"array"                => "The :attribute must be an array.",
	"before"               => "The :attribute must be a date before :date.",
	"between"              => [
		"numeric" => "The :attribute must be between :min and :max.",
		"file"    => "The :attribute must be between :min and :max kilobytes.",
		"string"  => "The :attribute must be between :min and :max characters.",
		"array"   => "The :attribute must have between :min and :max items.",
	],
	"boolean"              => "The :attribute field must be true or false.",
	"confirmed"            => "The :attribute confirmation does not match.",
	"date"                 => "The :attribute is not a valid date.",
	"date_format"          => "The :attribute does not match the format :format.",
	"different"            => "The :attribute and :other must be different.",
	"digits"               => "The :attribute must be :digits digits.",
	"digits_between"       => "The :attribute must be between :min and :max digits.",
	"email"                => "The :attribute must be a valid email address.",
	"filled"               => "The :attribute field is required.",
	"exists"               => "The selected :attribute is invalid.",
	"image"                => "The :attribute must be an image.",
	"in"                   => "The selected :attribute is invalid.",
	"integer"              => "The :attribute must be an integer.",
	"ip"                   => "The :attribute must be a valid IP address.",
	"max"                  => [
		"numeric" => "The :attribute may not be greater than :max.",
		"file"    => "The :attribute may not be greater than :max kilobytes.",
		"string"  => "The :attribute may not be greater than :max characters.",
		"array"   => "The :attribute may not have more than :max items.",
	],
	"mimes"                => "The :attribute must be a file of type: :values.",
	"min"                  => [
		"numeric" => "The :attribute must be at least :min.",
		"file"    => "The :attribute must be at least :min kilobytes.",
		"string"  => "The :attribute must be at least :min characters.",
		"array"   => "The :attribute must have at least :min items.",
	],
	"not_in"               => "The selected :attribute is invalid.",
	"numeric"              => "The :attribute must be a number.",
	"regex"                => "The :attribute format is invalid.",
	"required"             => "The :attribute field is required.",
	"required_if"          => "The :attribute field is required when :other is :value.",
	"required_with"        => "The :attribute field is required when :values is present.",
	"required_with_all"    => "The :attribute field is required when :values is present.",
	"required_without"     => "The :attribute field is required when :values is not present.",
	"required_without_all" => "The :attribute field is required when none of :values are present.",
	"same"                 => "The :attribute and :other must match.",
	"size"                 => [
		"numeric" => "The :attribute must be :size.",
		"file"    => "The :attribute must be :size kilobytes.",
		"string"  => "The :attribute must be :size characters.",
		"array"   => "The :attribute must contain :size items.",
	],
	"unique"               => "The :attribute has already been taken.",
	"url"                  => "The :attribute format is invalid.",
	"timezone"             => "The :attribute must be a valid zone.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
		'attribute-name' => [
			'rule-name' => 'custom-message',
		], 'book_title' => array(
            'required' => 'Введите название книги.',
            'between' => 'Название книги должно содержать от :min и до :max символов.',
            'unique_title_and_author' => 'Книга с таким названием и автором уже существует.',
        ), 'book_author' => array(
            'required' => 'Введите название автора.',
            'between' => 'Имя автора должно содержать от :min и до :max символов.',
        ),'book_description' => array(
            'required' => 'Введите описание книги.',
            'between' => 'Описание книги должно содержать от :min и до :max символов.',
        ),'book_format' => array(
            'required' => 'Введите формат книги.',
            'between' => 'формат книги должен содержать от :min и до :max символов.',
        ),'book_publisher' => array(
            'required' => 'Введите издательство.',
            'between' => 'Название издательство должно содержать от :min и до :max символов.',
        ),'picture' => array(
            'required' => 'Выберите изображение.',
            'image' => 'Данный файл не является изображением.',
        ), 'book_genre_id' => array ('required' => 'Выберите жанр книги'),
        'lecture_name' => array(
            'required' => 'Введите название лекции.',
            'between' => 'Название лекции должно содержать от :min и до :max символов.',
        ),
        'lecture_text' => array(
            'min' => 'Текст лекции должен содержать минимум :min символов.',
        ),
        'id_section' => array(
            'required' => 'Выберите раздел.',
        ),
        'doc_file' => array(
            'mimes' => 'Файл должен быть формата doc или docx.'
        ),
        'ppt_file' => array(
            'mimes' => 'Файл должен быть формата ppt или pptx.'
        ),
        'id_lecture' => array(
            'required' => 'Выберите лекцию.',
            'required_if' => 'Для создания ссылки выберите лекцию.'
        ),
        'definition_name' => array(
            'required' => 'Введите название термина.',
            'between' => 'Название термина должно содержать от :min и до :max символов.',
        ),
        'definition_content' => array(
            'required' => 'Введите определение термина.',
            'between' => 'Определение термина должно содержать от :min и до :max символов.',
        ),
        'name_anchor' => array(
            'required_if' => 'Для создания ссылки укажите её название.',
            'min' => 'Название ссылки долно содержать от :min символов'
        ),
        'theorem_name' => array(
            'required' => 'Введите название теоремы.',
            'between' => 'Название теоремы должно содержать от :min и до :max символов.',
        ),
        'theorem_content' => array(
            'required' => 'Введите формулировку теоремы.',
            'between' => 'Формулировка теоремы должно содержать от :min и до :max символов.',
        ),
        'name_person' => array(
            'required' => 'Введите ФИО персоналии.',
            'between' => 'ФИО персоналии должно содержать от :min и до :max символов.',
        ),
        'year_birth' => array(
            'required' => 'Введите дату рождения.',
            'date_format' => 'Неправильный формат даты рождения.',
            'size' => 'Даты рождения должна содержать 4 символа.',
        ),
        'year_death' => array(
            'required' => 'Введите дату смерти.',
            'date_format' => 'Неправильный формат даты смерти.',
            'size' => 'Даты смерти должна содержать 4 символа.',
        ),
        'person_text' => array(
            'required' => 'Введите текст персоналии.',
            'min' => 'Текст персоналии должнен содержать минимум :min символов.',
        ),'name' => array(
            'required' => 'Введите название.',
            'between' => 'Название должно содержать содержать от :min и до :max символов.',
        ),'education_material_file' => array(
            'required' => 'Выберите файл.',
            'mimes' => 'Файл должен быть формата doc/pdf.',
        ),'section_plan_name' => array(
            'required' => 'Введите название раздела.'
        ),'is_exam' => array(
            'required' => 'Выберите тип раздела.',
        ),
        'section_num' => array(
            'required' => 'Введите порядковый номер раздела.',
            'integer' => 'Номер раздела должен быть числом',
            'min' => 'Номер раздела должен быть не меньше 1',
            'unique' => 'Номер раздела в данном учебном плане уже существует'
        ), 'lecture_plan_name' => array(
            'required' => 'Введите название лекции.'
        ),'lecture_plan_num' => array(
            'required' => 'Введите порядковый номер лекции.',
            'integer' => 'Номер лекции должен быть числом',
            'min' => 'Номер лекции должен быть не меньше 1',
            'unique' => 'Номер лекции в данном учебном плане уже существует'
        ), 'seminar_plan_name' => array(
            'required' => 'Введите название семинара.'
        ),'seminar_plan_num' => array(
            'required' => 'Введите порядковый номер семинара.',
            'integer' => 'Номер семинара должен быть числом',
            'min' => 'Номер семинара должен быть не меньше 1',
            'unique' => 'Номер семинара в данном учебном плане уже существует'
        ), 'control_work_plan_name' => array(
            'required' => 'Введите название К.М,.'
        ),'max_points' => array(
            'required' => 'Введите макс балл за К.М..',
            'between' => 'Макс балл за К.М. должен быть от :min и до :max .',
            'numeric' => 'Макс балл за К.М. семинара должен быть числом',
        ), 'control_work_plan_type'=> array(
            'required' => 'Введите тип К.М..',

        ), 'course_plan_name'=> array(
            'required' => 'Введите название учебного плана',

        ),'course_plan_desc'=> array(
            'required' => 'Введите описание учебного плана',

        ),
        'max_controls'=> array(
            'required' => 'Введите макс балл за "Контрольные мероприятия в семестре"',
            'numeric' => 'Макс балл за "Контрольные мероприятия в семестре" должен быть числом',
            'between' => 'Макс балл за "Контрольные мероприятия в семестре" должен быть от 0 до 100'

        ),'max_seminars'=> array(
            'required' => 'Введите макс балл за раздел "Посещение семинаров"',
            'numeric' => 'Макс балл за раздел "Посещение семинаров" должен быть числом',
            'between' => 'Макс балл за "Посещение семинаров" должен быть от 0 до 100',

        ),'max_seminars_work'=> array(
            'required' => 'Введите макс балл за раздел"Работа на семинарах"',
            'numeric' => 'Макс балл за раздел "Работа на семинарах" должен быть числом',
            'between' => 'Макс балл за раздел "Работа на семинарах" должен быть от 0 до 100',

        ),'max_lecrures'=> array(
            'required' => 'Введите макс балл за раздел "Посещение лекций"',
            'numeric' => 'Макс балл за раздел "Посещение лекций" должен быть числом',
            'between' => 'Макс балл за "Посещение лекций" должен быть от 0 до 100',

        ),'max_exam'=> array(
            'required' => 'Введите макс балл за раздел "Зачет (экзамен)"',
            'numeric' => 'Макс балл за разел "Зачет (экзамен)" должен быть числом',
            'between' => 'Макс балл за раздел "Зачет (экзамен)"  должен быть от 0 до 100',

        ),'class_work_point'=> array(
            "between" => "Балл за работу на семинаре должен быть от :min до :max.",
            'required' => 'Введите балл за работу на семинаре (мин. знач = 0)',
            'numeric' => 'Балл за работу на семинаре должен быть числом',

        ), 'control_work_points' => array(
            "between" => "Балл за контрольное мероприятие должен быть от :min до :max.",
            'required' => 'Введите балл за контрольное мероприятие (мин. знач = 0)',
            'numeric' => 'Балл за контрольное мероприятие должен быть числом',

        )
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [],

];
