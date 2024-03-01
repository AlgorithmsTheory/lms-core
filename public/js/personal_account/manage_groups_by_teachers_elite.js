'use strict';

(function() {
  $('.mge-card-btn-add').on('click', addClick)
  $('.mge-modal-save').on('click', saveAddClick);
  $('.mge-card-groups').on('click', '.mge-remove-group', removeClick);
  $('.mge-select-all').on('click', selectAllClick);

  function selectAllClick() {
    const checkboxes = $(this).closest('.modal').find('.mge-modal-groups .checkbox__trigger');
    const first = checkboxes.first();
    if (!first) {
      return;
    }
    const newChecked = !first.prop('checked');
    checkboxes.prop('checked', newChecked);
  }

  async function addClick() {
    const cardEl = $(this).closest('.mge-card');
    const teacherId = +cardEl.attr('data-teacher-id');
    let resp;
    $('.mge-modal-teacher')
      .text('...')
      .data('teacher-id', teacherId);
    const groupsEl = $('.mge-modal-groups');
    groupsEl.empty();
    try {
      resp = await post('/mge_other_groups', {
        teacherId: teacherId,
      });
    } catch (er) {
      alert(er.message);
      return;
    }
    $('.mge-modal-teacher').text(`${resp.teacher.lastName} ${resp.teacher.firstName}`);
    const groups = resp.otherGroups;
    if (groups.length <= 0) {
      groupsEl.text('Все группы уже добавлены для этого преподавателя.');
    } else {
      for (const g of groups) {
        const cb = checkbox(g.id, g.name);
        groupsEl.append(cb);
      }
    }
  }

  async function saveAddClick() {
    const btnSave = $(this);
    const modal = btnSave.closest('.modal');
    const teacherId = modal.find('.mge-modal-teacher').data('teacher-id');
    if (!teacherId) {
      return;
    }
    const groupIds = [];
    modal.find('.mge-modal-groups input:checked').each(function() {
      const groupId = $(this).data('id');
      groupIds.push(groupId);
    });
    const request = {
      teacherId: teacherId,
      groupIds: groupIds,
    };
    let newGroups;
    btnSave.prop('disabled', true);
    try {
      newGroups = await post('/mge_add_groups_to_teacher', request)
    } catch (er) {
      alert(er.message);
      btnSave.prop('disabled', false);
      return;
    }
    btnSave.prop('disabled', false);
    refreshGroups(teacherId, newGroups);
    modal.modal('hide');
  }

  async function removeClick() {
    const groupId = +$(this).attr('data-group-id');
    const cardEl = $(this).closest('.mge-card');
    const teacherId = +cardEl.attr('data-teacher-id');
    const request = {
      teacherId: teacherId,
      groupId: groupId,
    };
    let newGroups;
    try {
      newGroups = await post('/mge_remove_group_from_teacher', request)
    } catch (er) {
      alert(er.message);
      return;
    }
    refreshGroups(teacherId, newGroups);
  }

  function refreshGroups(teacherId, groups) {
    const groupsEl = $(`.mge-card[data-teacher-id="${teacherId}"] .mge-card-groups`)
      .empty();
    for (const g of groups) {
      const groupEl = $(`<div class="mge-card-group"></div>`)
        .text(g.name)
        .append(`
          <button type="button" class="close mge-remove-group" data-group-id="${g.id}">
            &times;
          </button>
        `);
      groupsEl.append(groupEl);
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

