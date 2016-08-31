/**
 * Created by srapin on 30.07.16.
 */
jQuery(document).ready(function ($) {

    if ($('.widget-3 .metro').length) {
        $(".widget-3 .metro").liveTile();
    }

    if ($('#summernote').length) {
        $('#summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']]
            ]
        });
    }
});