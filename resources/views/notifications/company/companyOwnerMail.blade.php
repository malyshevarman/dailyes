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
                <h1>Подтверждение прав на компанию</h1><br>
                Пожалуйста, нажмите кнопку ниже, чтобы подтвердить права на компанию <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="https://{{is_null($data['user']->city_slug) ? 'dailyes.ru' : $data['user']->city_slug . '.dailyes.ru'}}{{ route('frontend.company.show', $data['data']['company'], false) }}"><b>"{{$data['data']['company']->name}}"</b></a>.<br>
                <br>
                <br>
            </td>
        </tr>
        <tr>
            <td align="center" style="font-family: 'Montserrat', sans-serif;color: #ffffff; font-size: 14px;  line-height: 20px;">


                <table border="0" align="center" width="196" cellpadding="0" cellspacing="0" bgcolor="1D86E0" style="border-radius: 3px;cursor:pointer;">

                                <tr>
                                    <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td align="center" style="font-family: 'Montserrat', sans-serif;color: #ffffff; font-size: 14px;  line-height: 20px;">


                                        <div style="line-height: 20px;">
                                            <a href="{{route('api.cabinet.company.owner', ['company' => $data['data']['company'], 'token' => $data['data']['company']->verify_token, 'user_id' => $data['data']['user_id']])}}" style="font-family: 'Montserrat', sans-serif;
                                            color: #ffffff; text-decoration: none;
                                                                font-style: normal;
                                                                font-weight: 500;
                                                                font-size: 16px;
                                                                line-height: 20px;">Подтвердить</a>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                </tr>

                            </table>
                            <br>
                            <br>
            </td>
        </tr>
        <tr>
            <td width="640" align="left" style="font-family: 'Montserrat', sans-serif;
                                                font-style: normal;
                                                font-weight: normal;
            ">
                Если что-то не получается, напишите нам и мы активируем вам личный кабинет через менеджера: <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="mailto:biz@dailyes.ru">biz@dailyes.ru</a>.
                <br>
                <br>
                Если вы не понимаете в чем дело, никаких дальнейших действий не требуется.
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
