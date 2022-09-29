$(document).ready(function(){
        $('#typeFilter').on('change', function() {
            let type_id = $('#typeFilter').children("option:selected").val();
            $('tbody > tr').each(function(i,elem) {
                if($(elem).attr('data-type') !== 'type-' + type_id) $(elem).hide();
                else $(elem).css('display', 'block');
            });
        })
    });

