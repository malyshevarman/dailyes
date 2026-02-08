@if($event->status == 'active' && auth()->user() && $event->user && auth()->id() == $event->user->id)
    @if($event->published)
        <div class="col-md-12 warning-block mh">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-left">
                        <div class="warning-block__text">
                            <div class="v-align"><img src="/images/icons/event-on.svg"/> Акция в работе
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 warning-block__right">
                        <div class="v-align">
                            <div class="warning-block__nav">
                                <a href="{{ route('cabinet.event.stat', $event) }}">
                                    <div class="warning-block__nav-stat"></div>
                                </a>
                                <a href="{{ route('cabinet.event.edit', $event) }}">
                                    <div class="warning-block__nav-pencil"></div>
                                </a>
                            </div>
                            <a onclick="return confirm('Вы уверены что хотите снять с публикации?');" href="{{ route('api.cabinet.event.status', $event->id)}}" class="warning-block__stop">Снять с публикации</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12 warning-block mh">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-left">
                        <div class="warning-block__text">
                            <div class="v-align"><img src="/images/icons/shut-down.svg"/> Акция
                                остановлена!
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 warning-block__right">
                        <div class="v-align">
                            <div class="warning-block__nav">
                                <a href="{{ route('cabinet.event.stat', $event) }}">
                                    <div class="warning-block__nav-stat"></div>
                                </a>
                                <a href="{{ route('cabinet.event.edit', $event) }}">
                                    <div class="warning-block__nav-pencil"></div>
                                </a>
                            </div>
                            <a href="{{ route('api.cabinet.event.status', $event->id)}}"
                               class="warning-block__public">Опубликовать</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@elseif($event->status == 'after')
    @if(auth()->user() && auth()->id() == $event->user->id)
        <div class="col-md-12 warning-block mh ">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-left">
                        <div class="warning-block__text">
                            <div class="v-align"><img src="/images/icons/shut-down.svg"/> Внимание, эта
                                акция
                                завершена!
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 warning-block__right">
                        <div class="v-align">
                            <div class="warning-block__nav">
                                <a href="{{ route('cabinet.event.stat', $event) }}">
                                    <div class="warning-block__nav-stat"></div>
                                </a>
                                <a href="{{ route('cabinet.event.edit', $event) }}">
                                    <div class="warning-block__nav-pencil"></div>
                                </a>
                            </div>
                            <a href="{{ route('cabinet.event.edit', $event) }}"
                               class="warning-block__public">Опубликовать</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12 text-center warning-block">
            <div class="warning-block__text">
                <div class="h-align"><img src="/images/icons/shut-down.svg"/> Внимание, эта акция
                    завершена!
                </div>
            </div>
        </div>
    @endif
@endif