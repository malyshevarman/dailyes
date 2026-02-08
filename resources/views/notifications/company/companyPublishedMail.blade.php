@extends('notifications.layout.template')

@section('content')
    <table width="540 " border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"
        class="container540 hide">
        <tr>
            <td width="640" align="left" style="font-size: 24px; font-family: 'Montserrat', sans-serif; line-height: 29px;font-style: normal;font-weight: bold;">
            </td>
        </tr>
        <tr>
            <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
        </tr>
        <tr>
            <td width="640" align="left" style="font-family: 'Montserrat', sans-serif;
                                                font-style: normal;
                                                font-weight: normal;
            ">
                <h1>Поздравляем, ваш бизнес-аккаунт активирован</h1><br>
                Регистрация завершена. Отныне вы официальный представитель компании <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="https://{{is_null($data['user']->city_slug) ? 'dailyes.ru' : $data['user']->city_slug . '.dailyes.ru'}}{{ route('frontend.company.show', $data['company'], false) }}"><b>"{{$data['company']->name}}"</b></a> и можете общаться с клиентами от лица компании.<br>
                <br>
                С этой минуты любой ваш официальный комментарий будет виден всем пользователям Dailyes наравне с отзывами ваших клиентов.

            </td>
        </tr>
        <tr>
            <td align="center" style="font-family: 'Montserrat', sans-serif;color: #ffffff; font-size: 14px;  line-height: 20px;">


                <div style="line-height: 20px;">
                    <a href="https://{{is_null($data['user']->city_slug) ? 'dailyes.ru' : $data['user']->city_slug . '.dailyes.ru'}}/cabinet" style="font-family: 'Montserrat', sans-serif;
                    color: #ffffff; text-decoration: none;
                                        font-style: normal;
                                        font-weight: 500;
                                        font-size: 16px;
                                        line-height: 20px;">ПЕРЕЙТИ В ЛИЧНЫЙ КАБИНЕТ</a>
                </div>
            </td>
        </tr>
        <tr>
            <td width="640" align="left" style="font-family: 'Montserrat', sans-serif;
                                                font-style: normal;
                                                font-weight: normal;
            ">
                Кроме того, уже сейчас вы можете:

                <ul>
                    <li>
                        <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="https://{{is_null($data['user']->city_slug) ? 'dailyes.ru' : $data['user']->city_slug . '.dailyes.ru'}}{{ route('cabinet.company.edit', $data['company'], false) }}"><b>отредактировать профиль компании</b></a> <br> указать детальную информацию о вашей компании;
                    </li>
                    <li>
                        <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="https://{{is_null($data['user']->city_slug) ? 'dailyes.ru' : $data['user']->city_slug . '.dailyes.ru'}}{{ route('cabinet.event.create', false, false) }}"><b>разместить акцию</b></a> <br> добавить информацию по всем проходящим акциям вашей компании;
                    </li>
                    <li>
                        <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="https://{{is_null($data['user']->city_slug) ? 'dailyes.ru' : $data['user']->city_slug . '.dailyes.ru'}}/ad"><b>заказать рекламу</b></a> <br> ознакомиться со всеми рекламными возможностями на нашем сайте.
                    </li>
                </ul>

                Если у Вас есть вопросы, напишите нам на <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="mailto:biz@dailyes.ru">biz@dailyes.ru</a>. Будем рады помочь.
            </td>
        </tr>
        <tr>
            <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
        </tr>
        <tr>
            <td height="34" style="font-family: 'Montserrat', sans-serif;
                                    font-style: normal;
                                    font-weight: normal;
                                    font-size: 14px;
                                    line-height: 17px;

                                    color: #000000;
            ">
                С уважением,<br/>
                команда Dailyes
            </td>
        </tr>
    </table>
@endsection
