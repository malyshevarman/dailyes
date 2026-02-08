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
                Ссылка на сайт: {{(isset($data['data']['site_link']) ? $data['data']['site_link'] : '')}}<br>
                E-mail: {{$data['data']['mail']}}<br>
                Описание: {{$data['data']['description']}}<br>
            </td>
        </tr>
        <tr>
            <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
        </tr>

    </table>
@endsection





