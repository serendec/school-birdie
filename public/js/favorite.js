$(function() {
    $('.favorite-btn').click(function() {
        const button = $(this);
        const videoCategory = button.data('video_category');;
        const videoCategoryId = button.data('video_category_id');;
        const video = button.data('video');

        $.ajax({
            url: '/favorite/toggle',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                video_category: videoCategory,
                video_category_id: videoCategoryId,
                video: video,
            },
            success: function(response) {
                if (response.status === 'favorited') {
                    button.find('i').addClass('favorited');
                } else {
                    button.find('i').removeClass('favorited');
                }
            }
        });
    });
});
