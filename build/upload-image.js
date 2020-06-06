(function ($) {
    $(function () {
        let image_form = $('.image-form');
        let image_file = image_form.find('.file');

        image_file.on('change', function (e) {
            // 通常動作を止める
            e.preventDefault();

            let data = new FormData;

            data.append('action', 'upload-attachment');
            data.append('async-upload', image_file[0].files[0]);
            data.append('name', image_file[0].files[0].name);
            data.append('_wpnonce', data_name.nonce);

            $.ajax({
                url: data_name.upload_url,
                data: data,
                processData: false,
                contentType: false,
                dataType: 'json',
                type: 'POST',
            })
                .then(
                    function (data) {
                        console.log('complete!');
                        console.log(data);
                    },
                    function (jqXHR, textStatus, errorThrown) {
                        console.log('error!');
                        console.log('jqXHR');
                        console.log(jqXHR);
                        console.log('textStatus');
                        console.log(textStatus);
                        console.log('errorThrown');
                        console.log(errorThrown);
                    }
                );
        });
    });
})(jQuery);