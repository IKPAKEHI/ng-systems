var jcrop_api;

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
};

function checkForm() {
    if (parseInt($('#w').val())) return true;
    $('.error').html('Please select a crop region and then press Upload').show();
    return false;
};

function updateInfo(e) {
    $('#x1').val(e.x);
    $('#y1').val(e.y);
    $('#x2').val(e.x2);
    $('#y2').val(e.y2);
    $('#w').val(e.w);
    $('#h').val(e.h);
};

function clearInfo() {
    $('.info #w').val('');
    $('.info #h').val('');
};

function fileSelectHandler(input) {
    var oFile = input.files[0];
    $('.error').hide();
    var rFilter = /^(image\/jpeg|image\/png)$/i;
    if (! rFilter.test(oFile.type)) {
        $('.error').html('Please select a valid image file (jpg and png are allowed)').show();
        return;
    }
    if (oFile.size > 250 * 1024) {
        $('.error').html('You have selected too big file, please select a one smaller image file').show();
        return;
    }
    var oImage = document.getElementById('preview');
    var oReader = new FileReader();
        oReader.onload = function(e) {
        delete_jcrop();
        oImage.src = e.target.result;
        oImage.onload = function () {
            if (!limitByClientWidth(oImage.width)){
              oImage.width = (document.documentElement.clientWidth / 100) * 70;
            }
            if (!limitByClientHeight(oImage.height)){
              oImage.height = (document.documentElement.clientHeight / 100) * 60;            
            }
            
            document.getElementById("img_width").value = oImage.width;
            document.getElementById("img_height").value = oImage.height;
            if (oImage.width >= 300) {
               document.getElementById("block_resize").style.marginLeft = oImage.width + "px";
            } else {
                document.getElementById("block_resize").style.marginLeft = oImage.naturalWidth + "px";
            }
            make_jcrop();
            $('#filesize').val(sResultFileSize);
            $('#filetype').val(oFile.type);
            $('#filedim').val(oImage.naturalWidth + ' x ' + oImage.naturalHeight);
        };
    };       
    oReader.readAsDataURL(oFile);
}

function make_jcrop() {
    var boundx, boundy;

    $('#preview').Jcrop({
        minSize: [300, 300], // min crop size
        maxSize: [300, 300],
        setSelect: [1,1,300,300],
        aspectRatio : 1, // keep aspect ratio 1:1
        bgFade: true, // use fade effect
        bgOpacity: .3, // fade opacity
        onChange: updateInfo,
        onSelect: updateInfo,
        onRelease: clearInfo
    }, function(){
        // use the Jcrop API to get the real image size
        var bounds = this.getBounds();
        boundx = bounds[0];
        boundy = bounds[1];
        // Store the Jcrop API in the jcrop_api variable
        jcrop_api = this;
    });
}

function delete_jcrop(){
    if (jcrop_api){
        jcrop_api.destroy();
        jcrop_api = NaN;
    }
}
function check_img1() {
    if (!jcrop_api) {
        alert("Перед отправкой выбирите картинку и область обрезки!");
    }
}