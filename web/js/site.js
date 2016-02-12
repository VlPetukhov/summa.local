/**
 * Main JS file
 */
(function($){
    $(document).on('submit', '.image-delete-frm', function( $e ){
        $e.preventDefault();

        function deleteImage( $form )
        {
            var $input = $form.children('.image-form-imageId').first(),
                $container = $form.closest('div.image-container'),
                $emptyMessage = $('#gallery-is-empty');

            $.post(
                '/site/delete',
                {
                    'imageId': $input.val()
                },
                function( data ){
                    if ( !data.error ) {
                        $container.remove();
                        if (data.totalCount < 1) {
                            $emptyMessage.removeClass('hidden');
                        } else {
                            $emptyMessage.addClass('hidden');
                        }
                    }
                },
                'json'
            );
        }

        deleteImage( $(this) );
    })
})(jQuery);