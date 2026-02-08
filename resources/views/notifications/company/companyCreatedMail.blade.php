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
                <h1>Модерация бизнес-аккаунта</h1><br>
                Уважаемый(ая) <b>{{$data['user']->name}}{{$data['user']->surname ? ' ' . $data['user']->surname : ''}}</b>!
                <br>
                <br>
                Вы заполнили заявку на создание бизнес-аккаунта для компании <b>"{{$data['company']->name}}"</b>. После успешной её модерации, вы сможете публиковать проходящие акции и официально отвечать на оставленные отзывы всем пользователям от лица вашей компании.
                <br>
                <br>
                Если у Вас остались вопросы, напишите нам на <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="mailto:biz@dailyes.ru">biz@dailyes.ru</a> – мы с радостью поможем!
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
