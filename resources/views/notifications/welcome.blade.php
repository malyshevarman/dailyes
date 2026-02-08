@extends('notifications.layout.template')

@section('content')
    <table width="540 " border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"
           class="container540 hide">

        <tr>
            <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
        </tr>
        <tr>
            <td width="640" align="left" style="font-family: 'Montserrat', sans-serif;
                                                font-style: normal;
                                                font-weight: normal;
            ">
                <h1>Добро пожаловать</h1><br/>
                Поздравляем! Ваша учетная запись успешно создана.<br><br>
                <b>Первым делом</b><br><br>
                Для начала советуем заполнить свой <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="https://{{is_null($data['user']->city_slug) ? '' : $data['user']->city_slug . '.'}}dailyes.ru/cabinet/profile">профиль</a>.<br><br>

                <b>Что дальше</b><br><br>
                Чем ещё заняться на Dailyes?<br>

                <ul>
                    <li>добавьте в избранное понравившиеся <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="https://{{is_null($data['user']->city_slug) ? '' : $data['user']->city_slug . '.'}}dailyes.ru/stocks">акции</a> , на которые вы обратили своё внимание;</li>
                    <li>напишите отзыв про <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="https://{{is_null($data['user']->city_slug) ? '' : $data['user']->city_slug . '.'}}dailyes.ru/company">компании</a>, в которых вы недавно побывали и теперь готовы поделиться своим мнением с другими пользователями;</li>
                    <li>если вы — представитель компании, зарегистрируйте <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="https://{{is_null($data['user']->city_slug) ? '' : $data['user']->city_slug . '.'}}dailyes.ru/cabinet/company">бизнес‑аккаунт</a> и отвечайте на отзывы клиентов от лица компании.</li>
                </ul>

                Если у Вас есть вопросы, напишите нам на <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="mailto:biz@dailyes.ru">biz@dailyes.ru</a>. Будем рады помочь.


                <table border="0" align="center" width="540" cellpadding="0" cellspacing="0" class="">

                    <tr>
                        <td height="45" style="font-size: 20px; line-height: 45px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td height="20" style="
font-family: 'Montserrat', sans-serif;
                                                font-style: normal;
                                                font-weight: normal;
                                                font-size: 14px;
                                                line-height: 17px;">
                            С уважение,<br/>
                            команда Dailyes
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
        </tr>

    </table>
@endsection





