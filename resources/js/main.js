import $ from 'jquery';

function sendAjax(url, data, callback, type){
    data = data || {};
    if (typeof type == 'undefined') type = 'json';
    $.ajax({
        type: 'post',
        url: url,
        data: data,
        // processData: false,
        // contentType: false,
        dataType: type,
        beforeSend: function(request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        },
        success: function(json){
            if (typeof callback == 'function') {
                callback(json);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
            alert('Не удалось выполнить запрос! Ошибка на сервере.');
        },
    });
}

let url;

$('#get-url').click(function () {
    alert('ok');
})

$('#clear').click(function () {
    sendAjax('/delete-fiels', {}, function (){
        $('#yt').empty();
        $('#rt').empty();
        $('#res').empty();
        $('#name').empty();
        $('#error').empty();
        $('#get-url').attr('disabled', true);
    });
})

//  https://youtu.be/k9Lzmx_Rflg?si=KTC6AQaXNxOt1efK

$('#yt').change(function (){
    const value = $(this).val();
    const link = value.startsWith("https://youtu.be/");
    const linkLive = value.startsWith("https://www.youtube.com/live/");

    if (!link && !linkLive) {
        $('#error').html('Некорректная ссылка');
        $('#get-url').attr('disabled', true);
        return;
    } else if (linkLive) {
        let str = $(this).val().replace('https://www.youtube.com/live/', '');
        let index = str.indexOf('?');
        url = str.slice(0, index);
        $('#get-url').attr('disabled', false);
    } else {
        url = value;
        $('#get-url').attr('disabled', false);
    }
    getNameFromUrl();
})

const getNameFromUrl = () => {
    $('#get-url').addClass('loading');
    $('#res').empty();
    sendAjax('/get-name', {url}, function (json) {
        if (json.success && json.text) {
            $('#get-url').attr('disabled', false);
            $('#name').html(json.text);
        } else {
            $('#name').html('Не удалось получить имя.');
        }
    })
}

$('#get-url').click(function () {
    let btn = $(this);
    btn.text('Скачивание...');
    btn.attr('disabled', true);
    btn.addClass('loading');
    $('#res').empty();
    sendAjax('/get-file', {url}, function (json) {
        if (json.success) {
            btn.attr('disabled', true);
            btn.text('Получить файл');
            $('#name').empty();
            let img = '';
            if (json.webp) {
                img = `
                      <picture>
                      <source type="image/webp" srcset="${json.thumb}">
                      <img class="d-block mx-auto mx-lg-0" src="${json.thumb}"
                           width="360" height="203" style="border-radius: 12px;" alt="cover">
                      </picture>`;
            } else {
                img = `
                    <img class="d-block" src="${json.thumb}"
                         width="360" height="203" style="border-radius: 12px;" alt="cover">`;
            }
            const download = `<div class="mt-2 text-white">${json.name}</div>
                          <a href="${json.file}" type="audio/mp3" download class="btn btn-success mt-2 btn-lg">Скачать</a>`
            $('#res').append(img);
            $('#res').append(download);

        } else {
            btn.attr('disabled', true);
            btn.text('Получить файл');
            const error = `
                   <div class="text-danger">
                     <p>Error!</p>
                     <p class="text-info">${json.error}</p>
                   </div>
            `;
            $('#res').append(error);
        }
    })
})
