// JavaScript Document
// common lib
// 認証碼產生函數，配合imagecode.php，arial.ttf
// 範例
// gencode01(55,30,10,6,"black","white",5,50,5,"yzm2","new");
//codewidth=影象寬
//codeheight=影像高
//ftx=文字定位x
//fty=文字定位y
//bgcolor=影像背景顏色black,white,gray,green,red,blue可用
//ftcolor=文字顏色black,white,gray,green,red,blue可用
//ftsize=文字大小(1-5)
//codecomplex=碼畫面複雜度1-9999
//codeLength=認證碼長度
//wfield=要寫入的欄位id
//selmod=選擇模式(new：第一次產生，renew：更新認証碼)
function gencode01(codewidth, codeheight, ftx, fty, bgcolor, ftcolor, ftsize, codecomplex,codeLength, wfield, selmode) {
  var num = generateCode(codeLength);
  var yzm2 = document.getElementById(wfield);
  if (selmode == "new") {
    document.write("<img name='codeimg' id='codeimg' src='imagecode.php?num=" + num + "&codewidth=" + codewidth + "&codeheight=" + codeheight + "&ftx=" + ftx + "&fty=" + fty + "&bgcolor=" + bgcolor + "&ftcolor=" + ftcolor + "&ftsize=" + ftsize + "&codecomplex=" + codecomplex + "'>");
  }
  else {
    document.codeimg.src = "imagecode.php?num=" + num + "&codewidth=" + codewidth + "&codeheight=" + codeheight + "&ftx=" + ftx + "&fty=" + fty + "&bgcolor=" + bgcolor + "&ftcolor=" + ftcolor + "&ftsize=" + ftsize + "&codecomplex=" + codecomplex;
  }

  yzm2.value = num;
}
function gencode02(codewidth, codeheight, ftx, fty, bgcolor, ftcolor, ftsize, codecomplex, wfield, selmode) {
  var num1 = Math.round(Math.random() * 1000000);//随机小数放大
  var num = num1.toString().substr(0, 4);//取4位整数
  var yzm2 = document.getElementById(wfield);
  if (selmode == "new") {
    document.write("<img name='codeimg02' id='codeimg02' src='imagecode.php?num=" + num + "&codewidth=" + codewidth + "&codeheight=" + codeheight + "&ftx=" + ftx + "&fty=" + fty + "&bgcolor=" + bgcolor + "&ftcolor=" + ftcolor + "&ftsize=" + ftsize + "&codecomplex=" + codecomplex + "'>");
  }
  else {
    document.codeimg02.src = "imagecode.php?num=" + num + "&codewidth=" + codewidth + "&codeheight=" + codeheight + "&ftx=" + ftx + "&fty=" + fty + "&bgcolor=" + bgcolor + "&ftcolor=" + ftcolor + "&ftsize=" + ftsize + "&codecomplex=" + codecomplex;
  }

  yzm2.value = num;
}
//認證碼產生generateCode(characters) ，characters產生的字元長度
function generateCode(characters) {
  /* list all possible characters, similar looking characters and vowels have been removed */
  var possible = '2345789ABCDFGHKMNRSTWXYZ';
  var code = '';
  var i = 0;
  var len = possible.length;
  while (i < characters) {
    // code += substr(possible, mt_rand(0, strlen(possible)-1), 1);
    code = code + possible.substr(Math.floor(Math.random() * len), 1);
    i++;
  }
  return code;
}
// JavaScript Document
// common lib
// 認証碼產生函數，配合CaptchaSecurityImages.php
// 範例
// getcaptcha_img(影象寬,影象高,亂數字碼長度，"影像背景顏色16進位","文字顏色16進位",雜訊顏色16進位,50,"yzm2","new");
//codewidth=影象寬
//codeheight=影像高
//ftx=文字定位x
//fty=文字定位y
//bgcolor=影像背景顏色black,white,gray,green,red,blue可用
//ftcolor=文字顏色black,white,gray,green,red,blue可用
//ftsize=文字大小
//codecomplex=碼畫面複雜度1-200
//wfield=要寫入的欄位id
//selmod=選擇模式(new：第一次產生，renew：更新認証碼)
function getcaptcha_img(width, height, chart, hex_bg_color, hex_text_color, hex_noise_color, wfield, selmode) {
  var rand = generateCode(chart);
  var yzm2 = document.getElementById(wfield);
  if (selmode == "new") {
    document.write("<img name='codeimg03' id='codeimg03' src='CaptchaSecurityImages.php?width=" + width + "&height=" + height + "&characters=" + chart + "&hex_bg_color=" + hex_bg_color + "&hex_text_color=" + hex_text_color + "&hex_noise_color=" + hex_noise_color + "&code=" + rand + "'>");
  }
  else {
    document.codeimg03.src = "CaptchaSecurityImages.php?width=" + width + "&height=" + height + "&characters=" + chart + "&hex_bg_color=" + hex_bg_color + "&hex_text_color=" + hex_text_color + "&hex_noise_color=" + hex_noise_color + "&code=" + rand;
  }
  yzm2.value = rand;
}

/*
// <script type="text/javascript">
//check form 表單參數檢查
//起動參數
//
// YY_checkform('表單名稱','欄位名稱','檢查參數','控制訊息','錯誤訊息',......一直設定所有欄位);return document.MM_returnValue
// 檢查參數
  #1_100=數字1-100間(手機：#0_9999999999)
  #q=需要輸入值，值不限
  S=需要輸入email格式
  ^\([0-9][0-9]\)\/\([0-9][0-9]\)\/\([0-9]{4}\)$#2#1#3=日期dd/mm/yyyy
  ^\([0-9][0-9]\)\\-\([0-9]{4}\)$#3#1#2 =日期mm-yyyy，值取得阵列只有2个，dd=没有设定#3,mm=#1,yyyy=#2
  ^\(0[0-9]|1[0-9]|2[0-3]\)\:\([0-5][0-9]\)$','4'=時間24:59(24小時制)，同时可用来检查通用格式比对
  ^\([0-9]{10}\)$','4'=10码比对手机门号  
  #field=需相同內容的欄位名稱
// 控制訊息
  0：文字
  1：數字
  2：需要輸入email格式
  3：日期
  4：時間，同时可用来检查通用格式比对
  6：配合檢查參數的欄位名稱，內容需相同#field
// 例：
// <form onsubmit="YY_checkform('form1','id','#1_100','1','Field \'id\' is not valid.','username','#q','0','Field \'username\' is not valid.','mobile','#1_9','1','Field \'mobile\' is not valid.','special','S','2','Field \'special\' is not valid.','ordertime','^\([0-9][0-9]\)\/\([0-9][0-9]\)\/\([0-9]{4}\)$#2#1#3','3','Field \'ordertime\' is not valid.','captcha','#recaptcha','6','Field \'captcha\' is not valid.','select','#q','1','Field \'select\' is not valid.');return document.MM_returnValue">
// 最後YY_checkform需加上return document.MM_returnValue
// javascript程式如下：
*/
function MM_findObj(n, d) { //v4.01
  var p, i, x; if (!d) d = document; if ((p = n.indexOf("?")) > 0 && parent.frames.length) {
    d = parent.frames[n.substring(p + 1)].document; n = n.substring(0, p);
  }
  if (!(x = d[n]) && d.all) x = d.all[n]; for (i = 0; !x && i < d.forms.length; i++) x = d.forms[i][n];
  for (i = 0; !x && d.layers && i < d.layers.length; i++) x = MM_findObj(n, d.layers[i].document);
  if (!x && d.getElementById) x = d.getElementById(n); return x;
}

function YY_checkform() { //v4.65
  //copyright (c)1998,2002 Yaromat.com
  var args = YY_checkform.arguments; var myDot = true; var myV = ''; var myErr = ''; var addErr = false; var myReq;
  for (var i = 1; i < args.length; i = i + 4) {
    if (args[i + 1].charAt(0) == '#') { myReq = true; args[i + 1] = args[i + 1].substring(1); } else { myReq = false }
    var myObj = MM_findObj(args[i].replace(/\[\d+\]/ig, ""));
    myV = myObj.value;
    if (myObj.type == 'text' || myObj.type == 'password' || myObj.type == 'hidden') {
      if (myReq && myObj.value.length == 0) { addErr = true }
      if ((myV.length > 0) && (args[i + 2] == 1)) { //fromto
        var myMa = args[i + 1].split('_'); if (isNaN(parseInt(myV)) || myV < myMa[0] / 1 || myV > myMa[1] / 1) { addErr = true }
      } else if ((myV.length > 0) && (args[i + 2] == 2)) {
        var rx = new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-z]{2,4}$"); if (!rx.test(myV)) addErr = true;
      } else if ((myV.length > 0) && (args[i + 2] == 3)) { // date
        var myMa = args[i + 1].split("#"); var myAt = myV.match(myMa[0]);
        if (myAt) {
          var myD = (myAt[myMa[1]]) ? myAt[myMa[1]] : 1; var myM = myAt[myMa[2]] - 1; var myY = myAt[myMa[3]];
          var myDate = new Date(myY, myM, myD);
          if (myDate.getFullYear() != myY || myDate.getDate() != myD || myDate.getMonth() != myM) { addErr = true };
        } else { addErr = true }
      } else if ((myV.length > 0) && (args[i + 2] == 4)) { // time
        var myMa = args[i + 1].split("#"); var myAt = myV.match(myMa[0]); if (!myAt) { addErr = true }
      } else if (myV.length > 0 && args[i + 2] == 5) { // check this 2
        var myObj1 = MM_findObj(args[i + 1].replace(/\[\d+\]/ig, ""));
        if (myObj1.length) myObj1 = myObj1[args[i + 1].replace(/(.*\[)|(\].*)/ig, "")];
        if (!myObj1.checked) { addErr = true }
      } else if (myV.length >= 0 && args[i + 2] == 6) { // the same	  
        var myObj1 = MM_findObj(args[i + 1]);
        if (myV != myObj1.value) { addErr = true }
      } else if (myV.length >= 0 && args[i + 2] == 7) { // the same 允许栏位空白比对
        addErr = false;
        var myObj1 = MM_findObj(args[i + 1]);
        if (myV != myObj1.value) { addErr = true }
      }
    } else
      if (!myObj.type && myObj.length > 0 && myObj[0].type == 'radio') {
        var myTest = args[i].match(/(.*)\[(\d+)\].*/i);
        var myObj1 = (myObj.length > 1) ? myObj[myTest[2]] : myObj;
        if (args[i + 2] == 1 && myObj1 && myObj1.checked && MM_findObj(args[i + 1]).value.length / 1 == 0) { addErr = true }
        if (args[i + 2] == 2) {
          var myDot = false;
          for (var j = 0; j < myObj.length; j++) { myDot = myDot || myObj[j].checked }
          if (!myDot) { myErr += '* ' + args[i + 3] + '\n' }
        }
      } else if (myObj.type == 'checkbox') {
        if (args[i + 2] == 1 && myObj.checked == false) { addErr = true }
        if (args[i + 2] == 2 && myObj.checked && MM_findObj(args[i + 1]).value.length / 1 == 0) { addErr = true }
      } else if (myObj.type == 'select-one' || myObj.type == 'select-multiple') {
        if (args[i + 2] == 1 && myObj.selectedIndex / 1 == 0) { addErr = true }
      } else if (myObj.type == 'textarea') {
        if (myV.length < args[i + 1]) { addErr = true }
      }
    if (addErr) { myErr += '* ' + args[i + 3] + '\n'; addErr = false }
  }
  // if (myErr!=''){alert('The required information is incomplete or contains errors:\t\t\t\t\t\n\n'+myErr)}
  if (myErr != '') { alert(myErr); }
  document.MM_returnValue = (myErr == '');
}
//產生md5編碼(d)傳入值，並回傳編碼結果
/*
 * A JavaScript implementation of the RSA Data Security, Inc. MD5 Message
 * Digest Algorithm, as defined in RFC 1321.
 * Copyright (C) Paul Johnston 1999 - 2000.
 * Updated by Greg Holt 2000 - 2001.
 * See http://pajhome.org.uk/site/legal.html for details.
 */

/*
 * Convert a 32-bit number to a hex string with ls-byte first
 */
var hex_chr = "0123456789abcdef";
function rhex(num)
{
  str = "";
  for(j = 0; j <= 3; j++)
    str += hex_chr.charAt((num >> (j * 8 + 4)) & 0x0F) +
           hex_chr.charAt((num >> (j * 8)) & 0x0F);
  return str;
}

/*
 * Convert a string to a sequence of 16-word blocks, stored as an array.
 * Append padding bits and the length, as described in the MD5 standard.
 */
function str2blks_MD5(str)
{
  nblk = ((str.length + 8) >> 6) + 1;
  blks = new Array(nblk * 16);
  for(i = 0; i < nblk * 16; i++) blks[i] = 0;
  for(i = 0; i < str.length; i++)
    blks[i >> 2] |= str.charCodeAt(i) << ((i % 4) * 8);
  blks[i >> 2] |= 0x80 << ((i % 4) * 8);
  blks[nblk * 16 - 2] = str.length * 8;
  return blks;
}

/*
 * Add integers, wrapping at 2^32. This uses 16-bit operations internally 
 * to work around bugs in some JS interpreters.
 */
function add(x, y)
{
  var lsw = (x & 0xFFFF) + (y & 0xFFFF);
  var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
  return (msw << 16) | (lsw & 0xFFFF);
}

/*
 * Bitwise rotate a 32-bit number to the left
 */
function rol(num, cnt)
{
  return (num << cnt) | (num >>> (32 - cnt));
}

/*
 * These functions implement the basic operation for each round of the
 * algorithm.
 */
function cmn(q, a, b, x, s, t)
{
  return add(rol(add(add(a, q), add(x, t)), s), b);
}
function ff(a, b, c, d, x, s, t)
{
  return cmn((b & c) | ((~b) & d), a, b, x, s, t);
}
function gg(a, b, c, d, x, s, t)
{
  return cmn((b & d) | (c & (~d)), a, b, x, s, t);
}
function hh(a, b, c, d, x, s, t)
{
  return cmn(b ^ c ^ d, a, b, x, s, t);
}
function ii(a, b, c, d, x, s, t)
{
  return cmn(c ^ (b | (~d)), a, b, x, s, t);
}

/*
 * Take a string and return the hex representation of its MD5.
 */
// function calcMD5(str)
function MD5(str)
{
  x = str2blks_MD5(str);
  a =  1732584193;
  b = -271733879;
  c = -1732584194;
  d =  271733878;

  for(i = 0; i < x.length; i += 16)
  {
    olda = a;
    oldb = b;
    oldc = c;
    oldd = d;

    a = ff(a, b, c, d, x[i+ 0], 7 , -680876936);
    d = ff(d, a, b, c, x[i+ 1], 12, -389564586);
    c = ff(c, d, a, b, x[i+ 2], 17,  606105819);
    b = ff(b, c, d, a, x[i+ 3], 22, -1044525330);
    a = ff(a, b, c, d, x[i+ 4], 7 , -176418897);
    d = ff(d, a, b, c, x[i+ 5], 12,  1200080426);
    c = ff(c, d, a, b, x[i+ 6], 17, -1473231341);
    b = ff(b, c, d, a, x[i+ 7], 22, -45705983);
    a = ff(a, b, c, d, x[i+ 8], 7 ,  1770035416);
    d = ff(d, a, b, c, x[i+ 9], 12, -1958414417);
    c = ff(c, d, a, b, x[i+10], 17, -42063);
    b = ff(b, c, d, a, x[i+11], 22, -1990404162);
    a = ff(a, b, c, d, x[i+12], 7 ,  1804603682);
    d = ff(d, a, b, c, x[i+13], 12, -40341101);
    c = ff(c, d, a, b, x[i+14], 17, -1502002290);
    b = ff(b, c, d, a, x[i+15], 22,  1236535329);    

    a = gg(a, b, c, d, x[i+ 1], 5 , -165796510);
    d = gg(d, a, b, c, x[i+ 6], 9 , -1069501632);
    c = gg(c, d, a, b, x[i+11], 14,  643717713);
    b = gg(b, c, d, a, x[i+ 0], 20, -373897302);
    a = gg(a, b, c, d, x[i+ 5], 5 , -701558691);
    d = gg(d, a, b, c, x[i+10], 9 ,  38016083);
    c = gg(c, d, a, b, x[i+15], 14, -660478335);
    b = gg(b, c, d, a, x[i+ 4], 20, -405537848);
    a = gg(a, b, c, d, x[i+ 9], 5 ,  568446438);
    d = gg(d, a, b, c, x[i+14], 9 , -1019803690);
    c = gg(c, d, a, b, x[i+ 3], 14, -187363961);
    b = gg(b, c, d, a, x[i+ 8], 20,  1163531501);
    a = gg(a, b, c, d, x[i+13], 5 , -1444681467);
    d = gg(d, a, b, c, x[i+ 2], 9 , -51403784);
    c = gg(c, d, a, b, x[i+ 7], 14,  1735328473);
    b = gg(b, c, d, a, x[i+12], 20, -1926607734);
    
    a = hh(a, b, c, d, x[i+ 5], 4 , -378558);
    d = hh(d, a, b, c, x[i+ 8], 11, -2022574463);
    c = hh(c, d, a, b, x[i+11], 16,  1839030562);
    b = hh(b, c, d, a, x[i+14], 23, -35309556);
    a = hh(a, b, c, d, x[i+ 1], 4 , -1530992060);
    d = hh(d, a, b, c, x[i+ 4], 11,  1272893353);
    c = hh(c, d, a, b, x[i+ 7], 16, -155497632);
    b = hh(b, c, d, a, x[i+10], 23, -1094730640);
    a = hh(a, b, c, d, x[i+13], 4 ,  681279174);
    d = hh(d, a, b, c, x[i+ 0], 11, -358537222);
    c = hh(c, d, a, b, x[i+ 3], 16, -722521979);
    b = hh(b, c, d, a, x[i+ 6], 23,  76029189);
    a = hh(a, b, c, d, x[i+ 9], 4 , -640364487);
    d = hh(d, a, b, c, x[i+12], 11, -421815835);
    c = hh(c, d, a, b, x[i+15], 16,  530742520);
    b = hh(b, c, d, a, x[i+ 2], 23, -995338651);

    a = ii(a, b, c, d, x[i+ 0], 6 , -198630844);
    d = ii(d, a, b, c, x[i+ 7], 10,  1126891415);
    c = ii(c, d, a, b, x[i+14], 15, -1416354905);
    b = ii(b, c, d, a, x[i+ 5], 21, -57434055);
    a = ii(a, b, c, d, x[i+12], 6 ,  1700485571);
    d = ii(d, a, b, c, x[i+ 3], 10, -1894986606);
    c = ii(c, d, a, b, x[i+10], 15, -1051523);
    b = ii(b, c, d, a, x[i+ 1], 21, -2054922799);
    a = ii(a, b, c, d, x[i+ 8], 6 ,  1873313359);
    d = ii(d, a, b, c, x[i+15], 10, -30611744);
    c = ii(c, d, a, b, x[i+ 6], 15, -1560198380);
    b = ii(b, c, d, a, x[i+13], 21,  1309151649);
    a = ii(a, b, c, d, x[i+ 4], 6 , -145523070);
    d = ii(d, a, b, c, x[i+11], 10, -1120210379);
    c = ii(c, d, a, b, x[i+ 2], 15,  718787259);
    b = ii(b, c, d, a, x[i+ 9], 21, -343485551);

    a = add(a, olda);
    b = add(b, oldb);
    c = add(c, oldc);
    d = add(d, oldd);
  }
  return rhex(a) + rhex(b) + rhex(c) + rhex(d);
}