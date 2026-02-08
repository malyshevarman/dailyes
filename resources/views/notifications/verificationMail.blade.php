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
                <h1>Подтверждение регистрации</h1><br/>
                Привет, <b>{{$data['name']}}</b>!<br><br>
                Благодарим Вас за регистрацию на сайте <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="https://dailyes.ru/">dailyes.ru</a> .<br>
                Что бы получить доступ ко всем возможностям нашего сервиса, подтвердите адрес своей электронной почты.

                <table border="0" align="center" width="540" cellpadding="0" cellspacing="0" class="">
                    <tr>
                        <td height="40" style="font-size: 10px; line-height: 40px;">&nbsp;</td>
                    </tr>
                    <tr>

                        <td align="center">
                            <table border="0" align="center" width="196" cellpadding="0" cellspacing="0" bgcolor="1D86E0" style="border-radius: 3px;cursor:pointer;">

                                <tr>
                                    <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td align="center" style="font-family: 'Montserrat', sans-serif;color: #ffffff; font-size: 14px;  line-height: 20px;">


                                        <div style="line-height: 20px;">
                                            <a href="{{$actionUrl}}" style="font-family: 'Montserrat', sans-serif;
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
                        </td>
                    </tr>
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





