Dropzone.autoDiscover = false;

var myDropzone = new Dropzone('#statements-dropzone', {
    url: '/students-knowledge-level',
    maxFiles: 3,
    acceptedFiles: '.csv',
    uploadMultiple: true,
    autoProcessQueue: false,
    addRemoveLinks: true,
    parallelUploads: 3,

    renameFilename: function (filename) {
        return new Date().getTime() + '_' + filename;
    },

    dictInvalidFileType: 'Файлы должны иметь формат CSV',
    dictMaxFilesExceeded: 'Необходимо загрузить три файла!',
    dictRemoveFile: 'Отменить',

    success: function(file, response) {
        window.location.replace("/students-knowledge-level");
    },

    error: function(file, response) {
        window.location.replace("/students-knowledge-level/" + response);
    }

});

$('#eval-level').click(function(){
    myDropzone.processQueue();
});

