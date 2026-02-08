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
                Имя: {{$data['data']['name']}}<br>
                Телефон: {{$data['data']['phone']}}<br>
                Город: {{$data['data']['city']}}<br>
                E-mail: {{$data['data']['mail']}}<br>
                Причина обращения: {{$data['data']['subject']}}<br>
                Описание: {{$data['data']['description']}}<br><br>
                @if(isset($data['data']['attachment']))
                                                            <table border="0" align="center" width="196" cellpadding="0" cellspacing="0" bgcolor="1D86E0" style="border-radius: 3px;cursor:pointer;">

                                <tr>
                                    <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td align="center" style="font-family: 'Montserrat', sans-serif;color: #ffffff; font-size: 14px;  line-height: 20px;">


                                        <div style="line-height: 20px;">
                <a href="https://dailyes.ru/storage/{{$data['data']['attachment']}}" style="font-family: 'Montserrat', sans-serif;
                                            color: #ffffff; text-decoration: none;
                                                                font-style: normal;
                                                                font-weight: 500;
                                                                font-size: 16px;
                                                                line-height: 20px;">Файл</a>
                                                            </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                                </tr>

                            </table>
                @endif
            </td>
        </tr>
        <tr>
            <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
        </tr>

    </table>
@endsection





