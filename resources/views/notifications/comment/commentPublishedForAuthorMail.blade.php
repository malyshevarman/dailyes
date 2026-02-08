@extends('notifications.layout.newsletter')

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
                <h1>Ваш отзыв по {{$data['comment']->commented_type == 'App\Event' ? 'акции' : 'компании'}} успешно опубликован</h1><br/>
                Уважаемый(ая) <b>{{$data['user']->name}}</b>!<br>
                <br>
                Спасибо, что оставили свой отзыв по {{$data['comment']->commented_type == 'App\Event' ? 'акции' : 'компании'}} <a style="font-family: 'Montserrat', sans-serif;
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 17px;
            color:#1D86E0;
            text-decoration: none;" class="link" href="https://{{is_null($data['user']->city_slug) ? 'dailyes.ru' : $data['user']->city_slug . '.dailyes.ru'}}{{$data['comment']->commented_type == 'App\Event' ? route('frontend.event.show', $data['comment']->commented, false) : route('frontend.company.show', $data['comment']->commented, false)}}">"{{$data['comment']->commented->name}}"</a>. Мы обязательно примем данную информацию к сведению.

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
