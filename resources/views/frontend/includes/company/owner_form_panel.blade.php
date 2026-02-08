<div class="owner-panel">
    <a class="auth-panel__close reportPanel"><img src="/images/icons/close.svg"/></a>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <span class="owner-panel__first-letter">{{ mb_substr($company->name,0,1,"UTF-8") }}</span>
                <span class="report-panel__title"> {{$company->name}}</span>
            </div>
            <div class="col-md-12 d-flex" style="justify-content: space-between;">
                <div class="owner-panel__p">
                    <p>
                        Подтвердите, что это ваша компания. Следите за новыми отзывами. Вступайте в диалог с вашими клиетами и привлекайте новых. Становитесь лучше.
                    </p>
                </div>
                <div class="owner-panel__icons">
                    <div style="margin-bottom: 10px;">
                        <img style="margin-right: 10px;" src="/images/icons/thumb-up-white.svg"/> {{ $company->rec }}%
                    </div>
                    <div style="margin-bottom: 10px;">
                        <img style="margin-right: 10px;" src="/images/icons/star-white.svg"/> {{ round($company->star, 1) }}
                    </div>
                    <div style="margin-bottom: 10px;">
                        <img style="margin-right: 10px;" src="/images/icons/eye-white.svg"/> {{ $company->views }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <owner-form :company="{{$company}}"></owner-form>
            </div>
            <div class="col-md-12">
                <div class="owner-panel__p-two">
                    <p style="color:#fff;">
                        Это займёт пару минут. Для подтверждения бизнес-акаунта вам потребуется доступ к электронной почте. <br>
                        Если у Вас что-то не получается, напишите нам и мы активируем личный кабинет через менеджера: <a href="mailto:biz@dailyes.ru" style="color:#fff;">biz@dailyes.ru</a>
                    </p>
                </div>
            </div>
            <h3 class="message-resp">Спасибо, что поделились данной информацией!<br>В ближайшее время мы проверим эту компанию.<br>
                <button onclick="$('.reportPanel').click();" class="response-button">Хорошо</button>
            </h3>
        </div>
    </div>
</div>