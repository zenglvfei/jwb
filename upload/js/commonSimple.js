function iFrameHeight() {
    $("iframe").load(function(){
        var me = this;
        setTimeout(function() {
            var mainheight = $(me).contents().find("body").height()+30;
            $(me).height(mainheight);
        }, 100);
    });
}