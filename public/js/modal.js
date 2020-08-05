$('.modal-show').hide();
$('.btn-show').hide();

$(document).ready(function() {

    $('.modal-show').show();
    $('.btn-show').show();

    $('#app').on('click', '.modal-show', function(event) {
        event.preventDefault();

        var me = $(this),
            url = me.attr('href'),
            title = me.attr('title');

        $('.modal-dialog').removeAttr("style");

        $(".modal-body").html(
            '<center><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            '</div></center>');
        $('#modal-title').text(title);
        $('#modal-btn-save').removeAttr("style");
        $('#modal-btn-save').removeClass('hide')
            .text(me.hasClass('edit') ? 'Perbaharui' : 'Simpan');
        $('#modal-btn-save').addClass(me.hasClass('edit') ? 'edit' : '');

        if (me.attr('size')) {
            $('.modal-dialog').attr('style', 'max-width: ' + me.attr('size') + ';');
        }

        if (me.attr('reload-page')) {
            $('#modal-btn-save').addClass('reload');
        }

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(response) {
                $('#modal-body').html(response);
            },

            error: function(xhr) {

                swal({
                    type: 'error',
                    title: 'Failed',
                    text: ''
                });

                console.log(xhr);
            }
        });

        $('#modal').modal('show');
    });

    $('#app').on('click', '.btn-show', function(event) { //tanpa tombol create
        event.preventDefault();

        var me = $(this),
            url = me.attr('href'),
            title = me.attr('title');

        $(".modal-body").html(
            '<center><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">' +
            '<span class="sr-only">Loading...</span>' +
            '</div></center>');

        $('#modal-title').text(title);
        $('#modal-btn-save').hide();

        if (me.attr('size')) {
            $('.modal-dialog').attr('style', 'max-width: ' + me.attr('size') + ';');
        }

        $.ajax({
            url: url,
            dataType: 'html',
            success: function(response) {
                $('#modal-body').html(response);
            }
        });

        $('#modal').modal('show');
    })

    $('#app').on('click', '.btn-update', function(event) {
        event.preventDefault();

        var me = $(this),
            url = me.attr('href'),
            title = me.attr('title'),
            csrf_token = $('meta[name="csrf-token"]').attr('content');

        swal({
            title: '' + title + ' ?',
            text: 'the action cannot be undo',
            type: 'success',
            showCancelButton: true,
            confirmButtonColor: '#357A3F',
            cancelButtonColor: '#3085d6',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        '_method': 'PUT',
                        '_token': csrf_token
                    },

                    success: function(response) {
                        swal(
                            "Sukses Mengubah",
                            "Data berhasil Diubah!", "success"
                        ).then(function() {
                            $('#appTable').DataTable().ajax.reload();
                        });
                    },
                    error: function(xhr) {

                        swal({
                            type: 'error',
                            title: 'Failed',
                            text: ''
                        });

                        console.log(xhr);
                    }
                });
            }
        });
    });

    $('#app').on('click', '.btn-reject', function(event) {
        event.preventDefault();

        var me = $(this),
            url = me.attr('href'),
            title = me.attr('title'),
            csrf_token = $('meta[name="csrf-token"]').attr('content');

        swal({
            title: '' + title + ' ?',
            text: 'Aksi ini tidak dapat diurungkan',
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#357A3F',
            cancelButtonColor: '#3085d6',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        '_method': 'PUT',
                        '_token': csrf_token
                    },

                    success: function(response) {
                        console.log(response);
                        swal({
                            type: 'success',
                            title: 'Sukses!',
                            text: 'Data berhasil Ditolak!'
                        }).then(function() {
                            $('#appTable').DataTable().ajax.reload();
                        });

                    },
                    error: function(xhr) {
                        swal({
                            type: 'error',
                            title: 'Failed',
                            text: ''
                        });
                        console.log(xhr);
                    }
                });
            }
        });
    });

    $('#app').on('click', '.btn-delete', function(event) {
        event.preventDefault();

        var me = $(this),
            url = me.attr('href'),
            title = me.attr('title'),
            csrf_token = $('meta[name="csrf-token"]').attr('content');

        swal({
            title: 'Ingin Menghapus Data ' + title + ' ?',
            text: 'penghapusan data secara permanen!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },

                    success: function(response) {

                        swal({
                            type: 'success',
                            title: 'Sukses!',
                            text: 'Data berhasil dihapus!'
                        }).then(function() {

                            if (me.hasClass('reload')) {
                                location.reload();
                            } else {
                                $('#appTable').DataTable().ajax.reload();
                            }
                        });

                    },
                    error: function(xhr) {
                        swal({
                            type: 'error',
                            title: 'Gagal menghapus',
                            text: ''
                        })
                        console.log(xhr);
                    }
                });
            }
        });
    });

    $('#modal-btn-save').click(function(event) {
        event.preventDefault();

        var form = $('#modal-body form'),
            url = form.attr('action'),
            method = $('input[name=_method]').val() == undefined ? 'POST' : 'POST';

        $('#modal-btn-save').text('Harap tunggu ').append('<i class="fa fa-refresh fa-spin"></i>').attr('disabled', 'disabled');

        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.text-danger').remove();

        var form_data = new FormData($('form')[0]);

        if (document.getElementById('ckeditor')) {
            //fetch to controller
            form_data.append("ckeditor", CKEDITOR.instances.ckeditor.getData());
        }

        // console.log(CKEDITOR.instances.ckeditor.getData());
        $.ajax({
            url: url,
            method: method,
            data: form_data, //form.serialize(),
            processData: false,
            contentType: false,
            success: function(response) {

                console.log(response);
                form.trigger('reset');
                $('#modal').modal('hide');
                $('#modal-btn-save').text('Simpan').prop("disabled", false);

                if ($('#modal-btn-save').hasClass('reload')) {
                    swal(
                        "Sukses Menambahkan", "Data berhasil ditambah!", "success"
                    ).then(function() {
                        location.reload();
                    });
                } else {

                    if ($('#modal-btn-save').hasClass('edit')) {
                        swal(
                            "Sukses Mengubah", "Data berhasil diubah!", "success"
                        ).then(function() {
                            $('#appTable').DataTable().ajax.reload();
                        });
                    } else {
                        swal(
                            "Sukses Menambahkan", "Data berhasil ditambah!", "success"
                        ).then(function() {
                            $('#appTable').DataTable().ajax.reload();
                        });
                    }

                }

                $('#modal-btn-save').removeClass('edit')
            },
            error: function(xhr) {
                var res = xhr.responseJSON;
                if ($.isEmptyObject(res) == false) {
                    $.each(res.errors, function(key, value) {
                        jQuery("input[name=" + key + "]").addClass(' is-invalid')
                            .after('<div class="text-danger"><strong>' + value + '</strong></div>');
                        jQuery("select[name=" + key + "]").addClass(' is-invalid')
                            .after('<div class="text-danger"><strong>' + value + '</strong></div>');
                        jQuery("textarea[name=" + key + "]").addClass(' is-invalid')
                            .after('<div class="text-danger"><strong>' + value + '</strong></div>');
                    });
                }

                $('#modal-btn-save').text('Simpan').prop("disabled", false);
                console.log(xhr);
            }
        })
    });

    $('#app').on('click', '.pop', function(event) {
        event.preventDefault();

        var me = $(this),
            src = me.attr('src'),
            title = me.attr('title');

        $('.modal-footer').html('');

        $(".modal-body").html(
            '<img src="' + src + '" class="imagepreview" style="width: 100%;" >');

        $('#modal-title').text(title);
        $('#modal').modal('show');
    })
});