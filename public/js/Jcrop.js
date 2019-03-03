var fileId="";
//var JCropper;
var JcropAPI = null;
var _IMG_SELECTORN_NAME = '#jcrop_target';
var _IMG_PHOTO = new Image();
var _IMG_PHOTO_NEW = new Image();
        
$(window).load(function(){
    //画像ファイルを変更
    $(document).on("change", '.fileData', function (data){
        document.body.style.cursor = 'wait';
        fileId = $(this).context.id.replace( 'fileData', '');
        var reader = new FileReader();
        reader.onload = function(e) {
            _IMG_PHOTO = new Image(); //イメージオブジェクト生成
            //$(_IMG_SELECTORN_NAME).attr("src",reader.result);

            _IMG_PHOTO.src = reader.result;
            _IMG_PHOTO.onload = function() {
                //JcropAPIのクリア
                if(JcropAPI!=null){
                    JcropAPI.destroy();
                    JcropAPI=null;
                }
                //座標のクリア
                clearCoords();
                var orientation = getOrientation(_IMG_PHOTO.src);
                _TW = _IMG_PHOTO.naturalWidth;
                _TH = _IMG_PHOTO.naturalHeight;
                var imgNew = rotate(_IMG_PHOTO,_TW,_TH,orientation);
                $(_IMG_SELECTORN_NAME).attr("src",imgNew);
            	_IMG_PHOTO_NEW = new Image(); //イメージオブジェクト生成
            	_IMG_PHOTO_NEW.src = imgNew;
	        _IMG_PHOTO_NEW.onload = function() {
        	        //イメージをトリミング
                editTrimmingImage(_TW, _TH);
                document.body.style.cursor = 'auto';
                location.href="#open01";
            	};
            };
        }
        reader.readAsDataURL($(this).context.files[0]);
        if($(this).context.hasOwnProperty("files")){
                $(this).context.files = [];
        }
        $('#' + $(this).context.id).val('');
    });
    //クリッピングボタンクリック
    $('#btnCrop').click(function() {
        if($("#w").val()==""){
            alert("切り取り範囲を選択してください。");
            return false;
        }
        var img = getDataURL();
        $("#image_thum").attr("src",img);
        $("#image_src").val(img);
        location.href="#";
    });
} );

var boundx, boundy;
function editTrimmingImage(tw, th) {
    var s = fixImageSize(tw, th);
    $(_IMG_SELECTORN_NAME).width(s.maxWidth);
    $(_IMG_SELECTORN_NAME).height(s.maxHeight);
    $("#jcrop_target").Jcrop({
        onChange: updatePreview,
        onSelect:   showCoords,
        onRelease:  clearCoords,
        trueSize: [tw,th],
        boxWidth: s.maxWidth,
        boxHeight: s.maxHeight,
        aspectRatio: 1
    },function(){
	//JCropper = this;
	JcropAPI = $(_IMG_SELECTORN_NAME).data('Jcrop');
        var bounds = this.getBounds();
        boundx = bounds[0];
        boundy = bounds[1];
    });
}

function checkCoords() {
    if(parseInt($("#w").val())) return true;
    return false;
}

function showCoords(c)
{
    $('#x1').val(c.x);
    $('#y1').val(c.y);
    $('#x2').val(c.x2);
    $('#y2').val(c.y2);
    $('#w').val(c.w);
    $('#h').val(c.h);
    
    updatePreview(c);
};

  function clearCoords()
  {
    $('#x1').val("");
    $('#y1').val("");
    $('#x2').val("");
    $('#y2').val("");
    $('#w').val("");
    $('#h').val("");
  };


function updatePreview(c) {
    if (parseInt(c.w) > 0)
    {
        var cW = $("photo_viewer").width();
        var vH = $("photo_viewer").height();
 
        
        var rx = cW / c.w;
        var ry = vH / c.h;

        $("#preview").css({
            width: Math.round(rx * boundx) + 'px',
            height: Math.round(ry * boundy) + 'px',
            marginLeft: '-' + Math.round(rx * c.x) + 'px',
            marginTop: '-' + Math.round(ry * c.y) + 'px'
        });
    }
}


function getDataURL(){
	    //var s = fixImageSize(tw, th);

            var width = _IMG_BOX_WIDTH;
            var height = _IMG_BOX_WIDTH;
            var canvas = document.createElement("canvas");
               // canvas.clearRect(width, height);
            var w = parseInt($('#w').val());
            var h = parseInt($('#h').val());
            var x1 = parseInt($('#x1').val());
            var y1 = parseInt($('#y1').val());
            var dx = 0 - parseInt(w)/2 + width/2;
            var dy = 0 - parseInt(h)/2 + height/2;
            var dw = width;
            var dh = height;
            var sh = w;
            var sw = h;
            var sx = x1;
            var sy = y1;
            canvas.width = width;
            canvas.height = height;
            var context = canvas.getContext("2d");

            context.drawImage(_IMG_PHOTO_NEW, sx, sy, sw, sh, 0, 0, dw, dh);
            var img_png_src = canvas.toDataURL();
            $("#thumb").attr("src",img_png_src);
            return img_png_src;
}
