
$('#count').click( (e) => {
    e.preventDefault();
    let count = $('input[name="count"]').val()
    let alert = $('#alert')
    if(count > 10000 || count < 0){
       alert.addClass('error')
       alert.text('Invalid count of entities')
       alert.removeClass('none')
    }else {
        requestData({count: count}, 'apiRequest/create')
       async function requestData(data, uri){
             $.ajax({
                url: uri,
                method: 'post',
                data: data,
                success: function (data){
                    let message = 'Done'
                    alert.removeClass('none')
                    alert.addClass('success')
                    alert.text(message);
                },
                error: function (jqXHR){
                    message = ''
                    if(jqXHR.status === 401){
                        message = 'Token has been expired'
                    }else if(jqXHR.status < 200 || jqXHR.status > 204){
                        message = 'Invalid input data'
                    }
                    alert.removeClass('none')
                    alert.addClass('error')
                    alert.text(message)
                }
            })
        }


    }
})


