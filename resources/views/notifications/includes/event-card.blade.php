<tr>
            <td width="640" align="center" style="font-family: 'Montserrat', sans-serif;
                                                font-style: normal;
                                                font-weight: normal;">
                <table width="278" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="ffffff">
                    <tr>
                        <td class="card" width="278">
                            <table border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="ffffff">
                                <tr>
                                    <td>
                                        <a href="{{ route('frontend.event.show', $event) }}">
                                            <img style="width:100%;" src="{{ $event->image_url }}" alt="{{$event->name}}"/>
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
                                        <a style="color: #171717;text-decoration: none;" href="{{ route('frontend.event.show', $event) }}">{{ $event->name }}</a>
                                    </td>
                                </tr>
                                @if($event->tags->count() > 0)
                                <tr>
                                    <td class="events-block__tag">
                                        <a href="{{ route('frontend.city.event.tag.show', $event->tags[0]) }}"
                                            class="events-block__group-a" style="text-decoration: none;">
                                            <span class="events-block__group" style="padding: 3px 8px;
                                            background: #f2f7fa;
                                            color: #5e7b96;
                                            font-size: 12px;
                                            font-family: 'Montserrat',sans-serif;
                                            font-style: normal;
                                            font-weight: 300;">{{ $event->tags[0]->name }}</span>
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
                                    color: #171717;">
                                        <a style="text-decoration: none;" href="{{ route('frontend.company.show', $event->company) }}">{{ $event->company->name }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="events-block__text-desc" style="font-family: 'Montserrat', sans-serif;
                                    font-style: normal;
                                    font-weight: normal;
                                    font-size: 13px;
                                    padding-top: 10px;
                                    color: #171717;">
                                        @if($event->status == 'active')
                                            Дата окончания: {{is_null($event->end) ? "бессрочная" : $event->end->locale('ru')->isoFormat('D MMMM YYYY') }}
                                        @elseif($event->status == 'before')
                                            Дата начала: {{ $event->start->locale('ru')->isoFormat('D MMMM YYYY') }}
                                        @elseif($event->status == 'after')
                                            Завершено
                                        @endif
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
                                        <img style="padding-left: 0;" src="https://dailyes.ru/images/icons/email_icons/thumb-up-blue.png"/> {{ $event->rec }}%
                                        <img style="padding-left: 18px;padding-right: 4px;" src="https://dailyes.ru/images/icons/email_icons/star-blue.png"/> {{ round($event->star, 1) }}
                                        <img style="padding-left: 18px;padding-right: 4px;" src="https://dailyes.ru/images/icons/email_icons/eye.png"/> {{ $event->views }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
