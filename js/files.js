$('button').on('click tap', function (e) {
    console.log('<a href="' + $(this).data("value1") + '"></a>');


    switch ($(this).data("value0")) {
        case 0:
            var string = '';
            tinymce.activeEditor.execCommand('mceInsertContent', false, '<p><a href="'+ $(this).data("value1")+'"><img style="width:260px; height:260px;" src="' + $(this).data("value1") + '"/></a></p>');
            break;
        case 1:
            tinymce.activeEditor.execCommand('mceInsertContent', false, '<p><a class="button" href="' + $(this).data("value1") + '">Download Here</a></p>');
            break;
    }

});