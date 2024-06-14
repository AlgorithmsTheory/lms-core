'use strict';

(function() {
  $('.mge-card-btn-add').on('click', addClick)
  $('.mge-modal-save').on('click', saveAddClick);
  $('.mge-card-teachers').on('click', '.mge-remove-teacher', removeClick);
  $('.mge-select-all').on('click', selectAllClick);

  function selectAllClick() {
    const checkboxes = $(this).closest('.modal').find('.mge-modal-teachers .checkbox__trigger');
    const first = checkboxes.first();
    if (!first) {
      return;
    }
    const newChecked = !first.prop('checked');
    checkboxes.prop('checked', newChecked);
  }

  async function addClick() {
    const cardEl = $(this).closest('.mge-card');
    const groupId = +cardEl.attr('data-group-id');
    let resp;
    $('.mge-modal-group')
      .text('...')
      .data('group-id', groupId);
    const teachersEl = $('.mge-modal-teachers');
    teachersEl.empty();
    try {
      resp = await post('/manage_groups_other_teachers', {
        groupId: groupId,
      });
    } catch (er) {
      alert(er.message);
      return;
    }
    $('.mge-modal-group').text(resp.group.name);
    const teachers = resp.otherTeachers;
    if (teachers.length <= 0) {
      teachersEl.text('Все преподаватели уже добавлены в эту группу.');
    } else {
      for (const t of teachers) {
        const cb = checkbox(t.id, `${t.lastName} ${t.firstName}`);
        teachersEl.append(cb);
      }
    }
  }

  async function saveAddClick() {
    const btnSave = $(this);
    const modal = btnSave.closest('.modal');
    const groupId = modal.find('.mge-modal-group').data('group-id');
    if (!groupId) {
      return;
    }
    const teacherIds = [];
    modal.find('.mge-modal-teachers input:checked').each(function() {
      const teacherId = $(this).data('id');
      teacherIds.push(teacherId);
    });
    const request = {
      groupId: groupId,
      teacherIds: teacherIds,
    };
    let newTeachers;
    btnSave.prop('disabled', true);
    try {
      newTeachers = await post('/manage_groups_add_teachers_to_group', request)
    } catch (er) {
      alert(er.message);
      btnSave.prop('disabled', false);
      return;
    }
    btnSave.prop('disabled', false);
    refreshTeachers(groupId, newTeachers);
    modal.modal('hide');
  }

  async function removeClick() {
    const teacherId = +$(this).attr('data-teacher-id');
    const cardEl = $(this).closest('.mge-card');
    const groupId = +cardEl.attr('data-group-id');
    const request = {
      groupId: groupId,
      teacherId: teacherId,
    };
    let newTeachers;
    try {
      newTeachers = await post('/manage_groups_remove_teacher_from_group', request)
    } catch (er) {
      alert(er.message);
      return;
    }
    refreshTeachers(groupId, newTeachers);
  }

  function refreshTeachers(groupId, teachers) {
    const teachersEl = $(`.mge-card[data-group-id="${groupId}"] .mge-card-teachers`)
      .empty();
    for (const t of teachers) {
      const teacherEl = $(`<div class="mge-card-teacher"></div>`)
        .text(`${t.lastName} ${t.firstName}`)
        .append(`
          <button type="button" class="close mge-remove-teacher" data-teacher-id="${t.id}">
            &times;
          </button>
        `);
      teachersEl.append(teacherEl);
    }
  }

  function checkbox(id, text) {
    const html = `
      <div class="super-checkbox">
        <label class="checkbox">
          <input class="checkbox__trigger visuallyhidden" type="checkbox" />
          <span class="checkbox__symbol">
            <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 14l8 7L24 7"></path>
            </svg>
          </span>
          <p class="checkbox__textwrapper"></p>
        </label>
      </div>
    `;
    const el = $(html);
    el.find('.checkbox__textwrapper').text(text);
    el.find('.checkbox__trigger').data('id', id);
    return el;
  }

  async function post(url, data) {
    return new Promise((res, rej) => {
      $.ajax({
        cache: false,
        type: 'POST',
        url: url,
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');
            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: {
          token: 'token',
          data: JSON.stringify(data),
        },
        success: data => {
          res(data);
        },
        error: () => {
          rej(new Error('Ошибка'));
        },
      });
    });
  }
})();

