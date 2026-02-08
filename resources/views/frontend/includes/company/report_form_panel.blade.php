<div class="report-panel">
    <a class="auth-panel__close reportPanel"><img src="/images/icons/close.svg"/></a>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <span class="report-panel__title">Почему вы жалуетесь на эту компанию?</span>
            </div>
            <form id="respform" action="{{ route('frontend.company.report', $company) }}" method="post" style="margin-top: 70px"
                  class="col-md-12">
                {{ csrf_field() }}
                <div class="d-flex">
                    <input name="checkbox[0]" value="В описании указана не верная информация" type="checkbox"
                           id="report1" class="report-checkbox"/>
                    <label for="report1" class="label-report"></label>
                    <label for="report1" class="report-checkbox-text">В описании указана не верная
                        информация</label>
                </div>
                <div class="d-flex">
                    <input name="checkbox[1]" value="Фотографии не соответствуют действительности" type="checkbox"
                           id="report2" class="report-checkbox"/>
                    <label for="report2" class="label-report"></label>
                    <label for="report2" class="report-checkbox-text">Фотографии не соответствуют
                        действительности</label>
                </div>
                <div class="d-flex">
                    <input name="checkbox[2]" value="Компания не существует" type="checkbox" id="report3"
                           class="report-checkbox"/>
                    <label for="report3" class="label-report"></label>
                    <label for="report3" class="report-checkbox-text">Компания не существует</label>
                </div>
                <div class="d-flex">
                    <input type="checkbox" id="report4" class="report-checkbox"/>
                    <label for="report4" class="label-report"></label>
                    <label for="report4" class="report-checkbox-text">Проблема в другом</label>
                </div>
                <div class="report-textarea">
                    <textarea name="text" class="report-area"></textarea><br>
                </div>
                <div>
                    <button type="submit" class="report-submit">Отправить</button>
                </div>
            </form>
            <h3 class="message-resp">Спасибо, что поделились данной информацией!<br>В ближайшее время мы проверим эту компанию.<br>
                <button onclick="$('.reportPanel').click();" class="response-button">Хорошо</button>
            </h3>
        </div>
    </div>
</div>