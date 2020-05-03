// profile info
$(document).on('blur', '#profileInfoInput', function(){
    if(formValidate('#profileInfoForm')){
        var sProfileId = $(this).parent().parent().parent().attr('id')
        var sProfileType = $(this).parent().parent().parent().attr('profile-type')
        var sUpdateKey = $(this).attr('data-update')
        var sNewValue = $(this).val()
        $.ajax({
            url : 'apis/api-update-profile.php',
            method : 'POST',
            data : { id:sProfileId , key:sUpdateKey , value:sNewValue , type:sProfileType }
        })
        .done(function(response){
            if(response == 0){
                $('#updateMsg').html('Update not registered, please confirm input is valid').css("color","rgb(255, 128, 128)");
                $('#updateMsg').fadeOut(4000, function(){$('#updateMsg').css({"display":"grid"}).html('')});
                console.log(response)
            }
            if(response != 0){
                console.log('Profile has been updated')
                $('#updateMsg').html('Profile has been updated').css("color","rgb(0, 160, 0)");
                $('#updateMsg').fadeOut(4000, function(){$('#updateMsg').css({"display":"grid"}).html('')});
                if(sUpdateKey == 'firstname'){$('#profileH1').html('Hello, '+ sNewValue)}
                //setTimeout(function(){$('#updateMsg').css()}, 4000);
                console.log(response)
            }
        })
        .fail(function(){
            console.log('Something went wrong')
        })
    }
})

// property info
$(document).on('blur', '#propertyInfoInput', function(){
    if(formValidate('#PropertyInfoForm')){
        var sPropertyId = $(this).parent().parent().parent().parent().attr('id')
        var sUpdateKey = $(this).attr('data-update')
        var sNewValue = $(this).val()
        $.ajax({
            url : 'apis/api-update-property.php',
            method : 'POST',
            data : { id:sPropertyId , key:sUpdateKey , value:sNewValue }
        })
        .done(function(response){
            if(response == 0){
                $('#updateMsg').html('Update not registered, please confirm input is valid').css("color","rgb(255, 128, 128)");
                $('#updateMsg').fadeOut(4000, function(){$('#updateMsg').css({"display":"grid"}).html('')});
                console.log(response)
            }
            if(response != 0){
                console.log('Property has been updated')
                $('#updateMsg').html('Property has been updated').css("color","rgb(0, 160, 0)");
                $('#updateMsg').fadeOut(4000, function(){$('#updateMsg').css({"display":"grid"}).html('')});
                console.log(response)
            }
        })
        .fail(function(){
            console.log('Something went wrong')
        })
    }
})

// profile image
$(document).ready(function(){
    $("#profileImgFileId").change(function(){
        console.log('change registered')
        var sProfileId = $(this).parent().parent().parent().attr('id')
        var sProfileType = $(this).parent().parent().parent().attr('profile-type')
        var fd = new FormData();
        var files = $('#profileImgFileId')[0].files[0];
        fd.append('imgFile',files);
        fd.append('profileId',sProfileId);
        fd.append('profileType',sProfileType);
        $.ajax({
            url: 'apis/api-upload-profile-image.php', //?id=12f3dc7bacaf57b8a14f&type=agents
            method: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(isNaN(response)){
                    $("#profileImg").attr("src",response); 
                    $('#updateMsg').html('Image has been updated').css("color","rgb(0, 160, 0)");
                    $('#updateMsg').fadeOut(4000, function(){$('#updateMsg').css({"display":"grid"}).html('')});
                    console.log(response)
                }
                if(response == 1){
                    $('#updateMsg').html('File is missing, please select an image').css("color","rgb(255, 128, 128)");
                    $('#updateMsg').fadeOut(4000, function(){$('#updateMsg').css({"display":"grid"}).html('')});
                    console.log(response)
                }
                if(response == 2){
                    $('#updateMsg').html('The uploaded file is not a valid image file. It must be jpg / jpeg / png / gif').css("color","rgb(255, 128, 128)");
                    $('#updateMsg').fadeOut(4000, function(){$('#updateMsg').css({"display":"grid"}).html('')});
                    console.log(response)
                }
                if(response == 3){
                    $('#updateMsg').html('The uploaded file is too small').css("color","rgb(255, 128, 128)");
                    $('#updateMsg').fadeOut(4000, function(){$('#updateMsg').css({"display":"grid"}).html('')});
                    console.log(response)
                }
                if(response == 4){
                    $('#updateMsg').html('The uploaded file is too large').css("color","rgb(255, 128, 128)");
                    $('#updateMsg').fadeOut(4000, function(){$('#updateMsg').css({"display":"grid"}).html('')});
                    console.log(response)
                }
            },
        });
    });
});

// property image
$(document).ready(function(){
    $("#propertyImgFileId").change(function(){
        console.log('change registered')
        var sPropertyId = $(this).parent().parent().parent().attr('id')
        var fd = new FormData();
        var files = $('#propertyImgFileId')[0].files[0];
        fd.append('imgFile',files);
        fd.append('propertyId',sPropertyId);
        $.ajax({
            url: 'apis/api-upload-property-image.php', //?id=12f3dc7bacaf57b8a14f&type=agents
            method: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(isNaN(response)){
                    $("#propertyImg").attr("src",response); 
                    $('#updateMsg').html('Image has been updated').css("color","rgb(0, 160, 0)");
                    $('#updateMsg').fadeOut(4000, function(){$('#updateMsg').css({"display":"grid"}).html('')});
                    console.log(response)
                }
                if(response == 1){
                    $('#updateMsg').html('File is missing, please select an image').css("color","rgb(255, 128, 128)");
                    $('#updateMsg').fadeOut(4000, function(){$('#updateMsg').css({"display":"grid"}).html('')});
                    console.log(response)
                }
                if(response == 2){
                    $('#updateMsg').html('The uploaded file is not a valid image file. It must be jpg / jpeg / png / gif').css("color","rgb(255, 128, 128)");
                    $('#updateMsg').fadeOut(4000, function(){$('#updateMsg').css({"display":"grid"}).html('')});
                    console.log(response)
                }
                if(response == 3){
                    $('#updateMsg').html('The uploaded file is too small').css("color","rgb(255, 128, 128)");
                    $('#updateMsg').fadeOut(4000, function(){$('#updateMsg').css({"display":"grid"}).html('')});
                    console.log(response)
                }
                if(response == 4){
                    $('#updateMsg').html('The uploaded file is too large').css("color","rgb(255, 128, 128)");
                    $('#updateMsg').fadeOut(4000, function(){$('#updateMsg').css({"display":"grid"}).html('')});
                    console.log(response)
                }
            },
        });
    });
});