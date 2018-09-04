<!DOCTYPE html>
<html>
<head>

    <title></title>
      <script type="text/javascript" src="js/jquery.min.js"></script>
    <style type="text/css">
        #block {
      display: flex;
          background-color: #ff0;
          min-height: 300px;
          min-width: 300px;
          position: relative;
      margin: 0;
      padding: 0;
          /*width: 180px;*/
        }
        #block_resize {
          background-color: #000;
          bottom: 0;
          cursor: se-resize;
          height: 30px;
          margin-top: 0px;
          /*position: absolute;*/
          margin-left: 300px;
          width: 30px;
        }
        #target {
          width: 30px;
          height: 30px;
          background-color: black;
        }
    </style>


<script type="text/javascript">


  var ie = 0;
  var op = 0;
  var ff = 0;
  var block; // Основной блок
  var block_r; // Блок для изменения размеров
  var delta_w = 0; // Изменение по ширине
  var delta_h = 0; // Изменение по высоте
  /* После загрузки страницы */
  onload = function () {
    /* Определяем браузер */
    var browser = navigator.userAgent;
    if (browser.indexOf("Opera") != -1) op = 1;
    else {
      if (browser.indexOf("MSIE") != -1) ie = 1;
      else {
        if (browser.indexOf("Firefox") != -1) ff = 1;
      }
    }
    block = document.getElementById("block"); // Получаем основной блок
    block_r = document.getElementById("block_resize"); // Получаем блок для изменения размеров
    document.onmouseup = clearXY; // Ставим обработку на отпускание кнопки мыши
   // block_r.onmousedown = saveWH; // Ставим обработку на нажатие кнопки мыши
  }
  /* Функция для получения текущих координат курсора мыши */

  function getXY(obj_event) {
    if (obj_event) {
      x = obj_event.pageX;
      y = obj_event.pageY;
    }
    else {
      x = window.event.clientX;
      y = window.event.clientY;
      if (ie) {
        y -= 2;
        x -= 2;
      }
    }
    return new Array(x, y);
  }
  function saveWH(obj_event) {
    var point = getXY(obj_event);
    w_block = block.clientWidth; // Текущая ширина блока
    h_block = block.clientHeight; // Текущая высота блока
    delta_w = w_block - point[0]; // Измеряем текущую разницу между шириной и x-координатой мыши
    delta_h = h_block - point[1]; // Измеряем текущую разницу между высотой и y-координатой мыши
    /* Ставим обработку движения мыши для разных браузеров */
    document.onmousemove = resizeBlock;
    if (op || ff) document.addEventListener("onmousemove", resizeBlock, false);
    return false; // Отключаем стандартную обработку нажатия мыши
  }
  /* Функция для измерения ширины окна */
  function clientWidth() {
    return document.documentElement.clientWidth == 0 ? document.body.clientWidth : document.documentElement.clientWidth;
  }
  /* Функция для измерения высоты окна */
  function clientHeight() {
    return document.documentElement.clientHeight == 0 ? document.body.clientHeight : document.documentElement.clientHeight;
  }
  /* При отпускании кнопки мыши отключаем обработку движения курсора мыши */
  function clearXY() {
    document.onmousemove = null;
  }

  function limitByClientWidth(pixelCount) {
    var clientDevicWidth = document.documentElement.clientWidth;
    var widthInVW = clientDevicWidth / 100;
    if (pixelCount / widthInVW > 70)
      return (false);
    return (true);
  }

  function limitByClientHeight(pixelCount) {
    var clientDevicWHeight = document.documentElement.clientHeight;
    var heightInVH = clientDevicHeight / 100;
    if (pixelCount / heightInVH > 70)
      return (false);
    return (true);    
  }
 
  function resizeBlock(obj_event) {
    var point = getXY(obj_event);
    new_w = delta_w + point[0]; // Изменяем новое приращение по ширине
    new_h = delta_h + point[1]; // Изменяем новое приращение по высоте
    if (new_w > 299 && limitByClientWidth(new_w)) {
      block.style.width = new_w + "px"; // Устанавливаем новую ширину блока

    }
    if (new_w > 297 && limitByClientWidth(new_w)) {
      block_r.style.marginLeft = new_w + "px";
    }
    if (new_h > 299 && limitByClientHeight(new_h)) {
     block.style.height = new_h + "px"; // Устанавливаем новую высоту блока
    }

    /* Если блок выходит за пределы экрана, то устанавливаем максимальные значения для ширины и высоты */
    if (block.offsetLeft + block.clientWidth > clientWidth()) block.style.width = (clientWidth() - block.offsetLeft) + "px";
    if (block.offsetTop + block.clientHeight > clientHeight()) block.style.height = (clientHeight() - block.offsetTop) + "px";
  }
    function readURL(input) {
        var oFile = input.files[0];
        var rFilter = /^(image\/jpeg|image\/png)$/i;
        if (!rFilter.test(oFile.type) || oFile.size > 250 * 1024) {  
          return;
        }
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var img = document.getElementById('block');
            reader.onload = function (e) {
                img.src = e.target.result;
                img.onload = function(e) {
                    if (!limitByClientWidth(img.width))
                      img.width = (document.documentElement.clientWidth / 100) * 70;
                    if (!limitByClientHeight(img.height))
                      img.height = (document.documentElement.clientHeight / 100) * 60;
                    if (img.width > 300) {
                        document.getElementById("block_resize").style.marginLeft = img.width + "px";
                    } else {
                        document.getElementById("block_resize").style.marginLeft = img.naturalWidth + "px";
                    }          
                };
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

// $(document).ready(function() {
//       $("#block_resize").on('click touchstart', function() {
//         alert(document.documentElement.clientWidth);
//     });
// })
</script>

</head>
<body>
    <div>
    <img id="block" src="http://placehold.it/180" alt="your image" />
    <div id="block_resize" onmousedown="saveWH()"></div>
    
</div>
    <input type='file' onchange="readURL(this);" />
    <div id="target"></div>



</body>
</html>