$(() => {
  $('#group_num').on('change', async function() {
    const groupId = +this.value;
    let students;
    try {
      students = await post('/personal_account/get_students_by_group', {
        groupId: groupId,
      });
    } catch (er) {
      alert(er.message);
      return;
    }
    const studentsEls = students.map(x => {
      const a = document.createElement('a');
      a.classList.add('student');
      a.textContent = `${x.first_name} ${x.last_name}`;
      a.href = `/personal_account/student/${x.id}`;
      return a;
    });
    const studentsDiv = document.querySelector('.students');
    studentsDiv.innerHTML = '';
    studentsDiv.append(...studentsEls);
  });

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
});
