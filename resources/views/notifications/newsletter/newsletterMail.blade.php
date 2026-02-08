@extends('notifications.layout.newsletter')
@php
    if(count($data['newsletter']->data['events']) > 0) {
        $events = App\Event::find(\Illuminate\Support\Arr::pluck($data['newsletter']->data['events'], 'id'));
    } else if (count($data['newsletter']->data['companies']) > 0) {
        $companies = App\Company::find(\Illuminate\Support\Arr::pluck($data['newsletter']->data['companies'], 'id'));
    }
@endphp
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
            <td width="640" colspan="{{isset($events) && $events->count() > 1 ? '3' : (isset($companies) && $companies->count() > 1 ? '2' : '1')}}" align="left" style="font-family: 'Montserrat', sans-serif;
                                                font-style: normal;
                                                font-weight: normal;
            ">
                {!!str_replace(array("city", "user"), array($data['newsletter']->city['name'], $data['user']->name), $data['newsletter']->text)!!}
            </td>
        </tr>
        <tr>
            <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
        </tr>
        @if(isset($events))
            @include('notifications.includes.event-card-list', ['events' => $events])
        @elseif (isset($companies))
            @include('notifications.includes.companies-card-list', ['companies' => $companies])
        @endif
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


<!-- Акции -->
<!-- $data['newsletter']->events -->

<!-- Компании -->
<!-- $data['newsletter']->companies -->
