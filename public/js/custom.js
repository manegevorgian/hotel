$(document).ready(function(){
    $('#typeFilter').on('change', function() {
        let page = $(location).attr('href').split('page=')[1];
        let type_id = $('#typeFilter').children("option:selected").val();
        if(page === undefined) {
            page = 1;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "rooms/filter",
            data: {
                "page": page,
                "type_id": type_id,
            },
            cache: false,
            type: "POST",
            success: function(response) {
                let actions = '';
                $('tbody').empty();
                for(let room of response.rooms.data){
                    let bookedClass = "";
                    if(response.userBooked.includes(room.id)){
                        bookedClass = 'class ="table-info"' ;
                    }
                    if(response.admin === 1) {
                        actions =
                            '<td><a href='+window.location.origin+'/rooms/edit?'+ room.id +' class="btn btn-outline-secondary px-5">Edit</a></td>'+
                        '<td>' +
                        '<form action="/rooms/destroy/'+ room.id + '" method="post">' +
                        '<input type="hidden" name="_token" value="'+ $('meta[name="csrf-token"]').attr('content') +'">' +
                        '<input type="hidden" name="_method" value="DELETE">' +
                        '<button class="btn btn-outline-danger" type="submit">Delete</button>' +
                        '</form>' +
                        '</td>'
                    }
                    $('tbody').append(' <tr ' + bookedClass + '>' +
                        '<td>' + room.id +'</td>' + '<td >'+room.type.name+'</td>' +
                        '<td><a class="btn btn-outline-primary px-5" href='+window.location.origin+'/booking/create/'+ room.id + '>Book</a></td>' + actions + '</tr>');
                }
            }
        })













             type_id = $('#typeFilter').children("option:selected").val();
            $('tbody > tr').each(function(i,elem) {
                if($(elem).attr('data-type') !== 'type-' + type_id) $(elem).hide();
                else $(elem).css('display', 'block');
            });
        })
    });

