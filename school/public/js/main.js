console.log('...');

$('#saveStudent').click(function () {
    $('#mode_insert_st').val('insert');
});

$('#deleteStudent').click(function () {
    $('#mode_delete_st').val('delete');
});

$('#saveCourse').click(function () {
    $('#mode_insert_cr').val('insert');
});

$('#deleteCourse').click(function () {
    $('#mode_delete_cr').val('delete');
});

$('#deleteCourseYes').click(function () {
    $('#delete_course').val('yes');
});

$('#deleteCourseNo').click(function () {
    $('#delete_course').val('no');
});

$('#deleteStudentYes').click(function () {
    $('#delete_student').val('yes');
});

$('#deleteStudentNo').click(function () {
    $('#delete_student').val('no');
});

$('#deleteAdminYes').click(function () {
    $('#delete_admin').val('yes');
});

$('#deleteAdminNo').click(function () {
    $('#delete_admin').val('no');
});

$('#inputFile').on('change', function () {
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
})

$(document).ready(function () {
    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
    });

    $('.btn-file :file').on('fileselect', function (event, label) {

        var input = $(this).parents('.input-group').find(':text'),
            log = label;

        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }

    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-upload').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#inputFile").change(function () {
        readURL(this);
    });
});


  $('#inputFile').on('change', function() {

    var mimeType = (this.files[0].type);
    var size = (this.files[0].size/1024/1024).toFixed(2); 

    let mimeTypeArray = ['image/png','image/gif','image/bmp','image/jpeg','image/jpg'];
    
    $(this).removeClass('input-validation-error').next('span').text('');

    if(mimeTypeArray.indexOf(mimeType) == -1){
        
        this.files[0].fileName = null;
        $('#inputFile').val("");
        $("#save").attr("disabled", "disabled");    
        $(this).addClass('input-validation-error').next('span').text('Mime type should one of following types: jpg, png, gif, jpeg, bmp. Please shoose another image!').css("color","red");

    }else if(size > 1){
    
        this.files[0].fileName = null;
        $('#inputFile').val("");
        $("#save").attr("disabled", "disabled");    
        $(this).addClass('input-validation-error').next('span').text('Filesize must 1mb or below. Please shoose another image!').css("color","red");

    }else{
        $("#save").removeAttr("disabled"); 
    }
  });  