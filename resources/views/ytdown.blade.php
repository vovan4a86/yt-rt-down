@extends('template')

@section('title', 'Скачать аудио с YT/RT')

@section('content')
    <h1 class="mt-3 text-center">Скачать аудио:</h1>
    <div class="mb-3 mt-3">

    </div>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-yt-tab"
               data-toggle="pill" href="#pills-yt" role="tab"
               aria-controls="pills-yt" aria-selected="true">Youtube</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-rt-tab" data-toggle="pill"
               href="#pills-rt" role="tab" aria-controls="pills-rt"
               aria-selected="false">Rutube</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-yt"
             role="tabpanel" aria-labelledby="pills-yt-tab">
            <input type="text" class="form-control d-block my-3" id="yt"
                   data-type="yt" placeholder="youtube ссылка" value="https://youtu.be/k9Lzmx_Rflg?si=KTC6AQaXNxOt1efK">
        </div>

        <div class="tab-pane fade" id="pills-rt"
             role="tabpanel" aria-labelledby="pills-rt-tab">
            <input type="text" class="form-control d-block my-3" id="rt"
                   data-type="rt" placeholder="rutube ссылка">
        </div>
    </div>
    <div id="error" class="text-danger mb-2"></div>
    <div id="name" class="text-success"></div>
    <div class="d-flex justify-content-between">
        <button class="btn btn-success" id="get-url" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Получить файл
        </button>
        <button type="button" class="btn btn-danger" id="clear" aria-label="Очистить">Очистить
        </button>
    </div>

    <div id="res" class="text-center text-lg-start"></div>

@endsection

