@if(!$company->published)
    <div class="col-md-12 warning-block mh">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-left">
                    <div class="warning-block__text">
                        <div class="v-align"><img src="/images/icons/shut-down.svg"/> Компания проверяется модератором
                        </div>
                    </div>
                </div>
                {{--<div class="col-md-6 warning-block__right">
                    <div class="v-align">
                        <div class="warning-block__nav">
                            <a href="{{ route('cabinet.company.stat', $company) }}">
                                <div class="warning-block__nav-stat"></div>
                            </a>
                            <a href="{{ route('cabinet.company.edit', $company) }}">
                                <div class="warning-block__nav-pencil"></div>
                            </a>
                        </div>
                        <a href="{{ route('api.cabinet.company.status', $company->id)}}" class="warning-block__stop">Снять с публикации</a>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
@endif