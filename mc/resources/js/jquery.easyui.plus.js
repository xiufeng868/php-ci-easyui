$.extend({
    messageBoxEx: function(title, msg, time) {
        $.messager.show({
            title: title,
            msg: msg,
            width: '30%',
            height: 'auto',
            timeout: time,
            showType: 'fade', //null,slide,fade,show
            style: {
                left: '',
                right: 5,
                top: '',
                bottom: -document.body.scrollTop - document.documentElement.scrollTop + 25
            }
        });
    }
});

//window居中
var easyuiPanelOnOpen = function(left, top) {
    var iframeWidth = $(this).parent().parent().width();
    var iframeHeight = $(this).parent().parent().height();
    var windowWidth = $(this).parent().width();
    var windowHeight = $(this).parent().height();
    var setWidth = (iframeWidth - windowWidth) / 2;
    var setHeight = (iframeHeight - windowHeight) / 2;
    $(this).parent().css({ /* 修正面板位置 */
        left: setWidth,
        top: setHeight
    });
    if (iframeHeight < windowHeight) {
        $(this).parent().css({ /* 修正面板位置 */
            left: setWidth,
            top: 0
        });
    }
    $(".window-shadow").hide();
};
$.fn.window.defaults.onOpen = easyuiPanelOnOpen;
