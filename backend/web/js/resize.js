  var ie = 0;
  var op = 0;
  var ff = 0;
  var preview; // Основной блок
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
    preview = document.getElementById("preview"); // Получаем основной блок
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
  	delete_jcrop();
    var point = getXY(obj_event);
    w_block = preview.clientWidth; // Текущая ширина блока
    h_block = preview.clientHeight; // Текущая высота блока
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
  	// make_jcrop();
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
    if (pixelCount / heightInVH > 60)
      return (false);
    return (true);    
  }  

  function resizeBlock(obj_event) {
    var point = getXY(obj_event);
    new_w = delta_w + point[0]; // Изменяем новое приращение по ширине
    new_h = delta_h + point[1]; // Изменяем новое приращение по высоте
   if (new_w > 299 && limitByClientWidth(new_w)) {
      preview.style.width = new_w + "px"; // Устанавливаем новую ширину блока
      document.getElementById("img_width").value = new_w + "px";
    }
    if (new_w > 297 && limitByClientWidth(new_w)) {
      block_r.style.marginLeft = new_w + "px";
    }    
    if (new_h > 299 && limitByClientHeight(new_h)) {
     preview.style.height = new_h + "px"; // Устанавливаем новую высоту блока
     document.getElementById("img_height").value = new_h + "px";
    }

    /* Если блок выходит за пределы экрана, то устанавливаем максимальные значения для ширины и высоты */
    if (preview.offsetLeft + preview.clientWidth > clientWidth()) preview.style.width = (clientWidth() - preview.offsetLeft) + "px";
    if (preview.offsetTop + preview.clientHeight > clientHeight()) preview.style.height = (clientHeight() - preview.offsetTop) + "px";
  }

