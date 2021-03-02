let alert = $('#alert');

$('#count').click( (e) => {
    e.preventDefault();
    let count = $('input[name="count"]').val()
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
                error: function (jqXHR,status , message){
                    message = ''
                    if(jqXHR.status === 401){
                        message = 'Token has been expired'
                    }else if(jqXHR.status < 200 || jqXHR.status > 204){
                        message = 'Invalid input data'
                    }
                    alert.removeClass('none')
                    alert.addClass('error')
                    alert.text(status)
                }
            })
        }


    }
})



$('#test').click( (e) =>{
    e.preventDefault();
    let id = [
        3086679,
        3086677,
        3086675,
    ];
    $.ajax({
        url: 'https://c33cfbe51eca.ngrok.io/widget/export',
       method: 'post',
        data: {
            id : id
        },
        success: function (data){
            console.log('yes');
            //window.location.href = '/widget/download';
            alert.removeClass('none');
            alert.addClass('success');
            alert.text(data);
        },
        error: function (error){
            alert.removeClass('none');
            alert.addClass('error');
            alert.text(error);
        }
        }
    )
})
