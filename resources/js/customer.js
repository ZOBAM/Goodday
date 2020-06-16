//preview image to be uploaded
$('#customer_passport').change(function(){
    var imgRef = $(this).attr('id');
    //alert(imgRef[6]);
    var file = this.files[0];
    var reader = new FileReader();
    reader.onload = function(e){
        //alert("image loaded!");
        //var prevImg = 'image_'+imgRef[6]+'_preview';
        $('#place_holder').attr('src',e.target.result)
    }
    reader.readAsDataURL(file);
})
$('#place_holder').click(function(){
    let placeHolderImgId = $(this).attr('id');
    //alert(targetInputElem);
    $('#customer_passport').click();
})

