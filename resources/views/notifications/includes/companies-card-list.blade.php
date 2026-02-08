@php
    $arr = [];
    for($i = 0; $i < $companies->count();$i+=2) {
        $arr[] = $companies->slice($i, 2);
    }
@endphp

@foreach($arr as $companies)
<tr>
        <td width="640" align="center" style="font-family: 'Montserrat', sans-serif;
                                                font-style: normal;
                                                font-weight: normal;">
            @foreach($companies as $key => $company)
                <table width="{{count($companies) > 1 ? '260' : '278'}}" class="{{count($companies) > 1 ? (($key % 2) == 0 ? 'event-card-left' : 'event-card-right') : 'event-card-center'}}" border="0" cellpadding="0" cellspacing="0" bgcolor="ffffff">
                    <tr>
                        <td class="card" width="{{count($companies) > 1 ? '260' : '278'}}" style="padding:5px;">
                            <table border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="ffffff">
                                <tr>
                                    <td>
                                        <a href="{{ route('frontend.company.show', $company) }}">
                                            <img style="width:100%;" src="{{ $company->image_url }}" alt="{{$company->name}}"/>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="events-block__title" style="padding-top: 15px;
                                    font-family: 'Montserrat', sans-serif;
                                    font-style: normal;
                                    font-weight: 700;
                                    font-size: 18px;
                                    padding-bottom: 10px;
                                    line-height: 24px;
                                    height: 45px;
                                    vertical-align: top;
                                    text-align: left;">
                                        <a style="color: #171717;text-decoration: none;" href="{{ route('frontend.company.show', $company) }}">{{ $company->name }}</a>
                                    </td>
                                </tr>
                                @if($company->tags->count() > 0)
                                <tr>
                                    <td class="events-block__tag">
                                        <a href="{{ route('frontend.city.company.tag.show', $company->tags[0]) }}"
                                            class="events-block__group-a" style="text-decoration: none;">
                                            <span class="events-block__group" style="padding: 3px 8px;
                                            background: #f2f7fa;
                                            color: #5e7b96;
                                            font-size: 12px;
                                            font-family: 'Montserrat',sans-serif;
                                            font-style: normal;
                                            font-weight: 300;">{{ $company->tags[0]->name }}</span>
                                        </a>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="events-block__text-desc" style="font-family: 'Montserrat', sans-serif;
                                    font-style: normal;
                                    font-weight: normal;
                                    font-size: 13px;
                                    padding-top: 10px;
                                    color: #171717!important;">
                                        {{ $company->addresses->count() > 0 ? (isset($current_address) ? $current_address : $company->addresses[0]->address) : '' }}{{ $company->addresses->count() > 1 ? ' и еще ' : ''}} <span>{{ $company->addresses->count() > 1 ? ($company->addresses->count() - 1). ' ' . pular(($company->addresses->count() - 1), ['адрес', 'адреса', 'адресов']) : '' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="events-block__text-icons v-align" style="font-family: 'Montserrat', sans-serif;
                                    font-style: normal;
                                    font-weight: 300;
                                    font-size: 12px;
                                    color: #5E7B96;
                                    padding-top: 20px;
                                    padding-bottom: 50px;">
                                        <img style="padding-left:0;" src="https://dailyes.ru/images/icons/email_icons/thumb-up-black.png"/>
                                        <span>{{ $company->rec }}</span>
                                        <img class="star" src="https://dailyes.ru/images/icons/email_icons/star.png"/>
                                        <span>{{ round($company->star, 1) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            @endforeach
            </td>
</tr>
@endforeach
