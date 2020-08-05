$(document).ready(function() {
    //this function only for form without FILE UPLOAD!
    $(".form-validate").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var submitText = $(this).find(':submit').text();
        var submit = $(this).find(':submit').attr('disabled', 'disabled').text('Please Wait ... ').append('<i class="fa fa-refresh fa-spin"></i>').attr('disabled', 'disabled');

        var form = $(this);
        var url = form.attr('action');
        var method = form.attr('method') != "POST" ? "POST" : form.attr('method');

        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.text-danger').remove();


        $.ajax({
            type: method,
            url: url,
            data: form.serialize(),
            success: function(data) {

                // iziToast.success({
                //     title: 'Success',
                //     message: 'Data Has Been Updated',
                //     position: 'bottomRight'
                // });

                submit.removeAttr("disabled").text(submitText);

                setInterval(function() {
                    location.reload();
                }, 1000);

            },
            error: function(xhr) {
                var res = xhr.responseJSON;
                console.log(xhr);
                console.log(res);
                if ($.isEmptyObject(res) == false) {


                    var msg = '';
                    $.each(res.errors, function(key, value) {
                        msg += 'Field ' + key + ' - ' + value + '<br>';

                        if (jQuery("[name=" + key + "]").next().hasClass('chosen-container')) { //if select contain choosen
                            jQuery("[name=" + key + "]").nextAll().slice(0, 2).after('<div class="text-danger"><strong>' + value + '</strong></div>');
                            jQuery("[name=" + key + "]").parent().parent().addClass('has-error');
                        } else if (jQuery("[name=" + key + "]").hasClass('image_id')) {
                            jQuery("[name=" + key + "]").addClass(' is-invalid').nextAll().slice(-1, 2).parent().after('<div class="text-danger" style="margin-top:0px"><strong>' + value + '</strong></div>');
                            jQuery("[name=" + key + "]").parent().parent().parent().addClass('has-error');
                        } else if (jQuery("[name=" + key + "]").hasClass('password')) {
                            jQuery("[name=" + key + "]").addClass(' is-invalid').nextAll().slice(-1, 2).parent().after('<div class="text-danger" style="margin-top:0px"><strong>' + value + '</strong></div>');
                            jQuery("[name=" + key + "]").parent().parent().parent().addClass('has-error');
                        } else {
                            jQuery("[name=" + key + "]").addClass(' is-invalid').after('<div class="text-danger"><strong>' + value + '</strong></div>');
                            jQuery("[name=" + key + "]").parent().parent().addClass('has-error');
                        }
                    });

                    // iziToast.warning({
                    //     title: 'Field need to be filled',
                    //     message: msg,
                    //     position: 'bottomRight'
                    // });
                }
                submit.empty().append('<i class="fa fa-floppy-o" aria-hidden="true"></i><span> Submit</span>').prop("disabled", false);

            }
        });
    });
});