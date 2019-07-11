document.write("<style type=\"text\/css\">");
document.write("#_ad-0,#_ad-1,#_ad-2,#_ad-3,#_ad-4,#_ad-5,#_ad-6,#_ad-7,#_ad-8,#_ad-9,#_ad-10,#_ad-11,#_ad-12,#_ad-13,#_ad-14,#_ad-15,#_ad-16,#_ad-17,#_ad-18,#_ad-19,#_ad-20,#_ad-21,#_ad-22 {position: relative;}");

document.write("#ad-0,#ad-1,#ad-2,#ad-3,#ad-4,#ad-5,#ad-6,#ad-7,#ad-8,#ad-9,#ad-10,#ad-11,#ad-12,#ad-13,#ad-14,#ad-15,#ad-16,#ad-17,#ad-18,#ad-19,#ad-20,#ad-21,#ad-22{position: relative;}");
document.write("<\/style>");

function loadAD(zone) {

    var m3_u = (location.protocol === 'https:' ? 'https://d1.ofweek.com/www/delivery/ajs.php' : 'http://d1.ofweek.com/www/delivery/ajs.php');
    var m3_r = Math.floor(Math.random() * 99999999999);

    if (!document.MAX_used) document.MAX_used = ',';
    document.write("<scr" + "ipt type='text/javascript' src='" + m3_u);
    document.write("?zoneid=" + zone);
    document.write('&amp;cb=' + m3_r);
    if (document.MAX_used !== ',') document.write("&amp;exclude=" + document.MAX_used);
    document.write(document.charset ? '&amp;charset=' + document.charset : (document.characterSet ? '&amp;charset=' + document.characterSet : ''));
    document.write("&amp;loc=" + escape(window.location));
    if (document.referrer) document.write("&amp;referer=" + escape(document.referrer));
    if (document.context) document.write("&context=" + escape(document.context));
    if (document.mmm_fo) document.write("&amp;mmm_fo=1");
    document.write("'><\/scr" + "ipt>");
}

function moveAD(element) {
    if (document.getElementById("_" + element) != null) {
        document.getElementById(element).appendChild(document.getElementById("_" + element));
    }
}

function showPromotion(url) {
    document.write('<iframe src=\"' + url + '\" height=\"0\" width=\"100%\" frameborder=\"0\" id=\"frame_content\" name=\"frame_content\" scrolling=\"no\"></iframe>');
}

function showPromotion1(url, height) {
    document.write('<iframe src=\"' + url + '\" height=\"0\" width=\"100%\" style=\"height: ' + height + 'px;\" frameborder=\"0\" id=\"frame_content\" name=\"frame_content\" scrolling=\"no\"></iframe>');
}

function showPromotion2(url, height) {
    document.write('<iframe src=\"' + url + '\" height=\"0\" width=\"100%\" style=\"height: ' + height + 'px;\" frameborder=\"0\" id=\"frame_content1\" name=\"frame_content1\" scrolling=\"no\"></iframe>');
}