@extends('cabinet.layouts.app')

@section('content')
    <div class="lk-body__breadcrumbs">
        <ul>
            <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
            <li>Компания</li>
        </ul>
    </div>
    <div class="lk-body__title">
        Компания
    </div>

    <!--
    <div class="lk-body__trigger">
        <div class="lk-body__trigger-url-nohref @if(!(boolean) request()->query('completed') && !(boolean) request()->query('moderation') && !(boolean) request()->query('rejected')) active @endif "><a href="{{ route('cabinet.company.index') }}">Активные</a></div>
        <div class="lk-body__trigger-url-nohref @if((boolean) request()->query('moderation')) active @endif "><a href="{{ route('cabinet.company.index', ['moderation' => true]) }}">На модерации</a></div>
    </div>
-->

    @if($companies->count() == 0)

        <br>
        <div class="lk-body__nav">
            <a href="{{ route('cabinet.company.create') }}"><div class="lk-body__nav-button v-align"><img src="/images/icons/round-add-button.svg" />Добавить компанию</div></a>
        </div>
        <div style="margin-left: 54px;"><a href="/placement-rules" style="text-decoration: none;font-size: 13px;" @click.prevent="$bus.$emit('showrules')">Правила размещения</a></div>


        <div class="lk-body__text">


            <div class="info_block">
                <div>У вас нет компаний.<br>
                    Чтобы люди узнали о вашей компании вы можете добавить ее на наш портал.</div>
            </div>

        </div>

    @else


        <div class="lk-body__row">
            <div class="container-fluid">
                <div class="trigger_company" style="display: block;">
                    <div class="row">
                        @foreach($companies as $company)

                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div >
                                <div class="search-panel__company-block">
                                    <div class="search-panel__company-block-img"
                                         style="background-image: url('{{ $company->image_url }}');">
                                             <div style="{{!$company->published ? 'opacity:.8;width: 100%;height:295px;background:#fff;' : ''}}"></div>
                                         </div>
                                    <a href="{{ route('frontend.company.show', $company) }}">
                                        <div class="events-block__empty d-flex justify-content-center align-items-center">
                                            @if (!$company->published && !$company->rejected)
                                                <span class="events-block__moderation-status">
                                            Компания находится <br>на модерации
                                            </span>
                                            @endif

                                                @if (!$company->published && $company->rejected)
                                                    <span class="events-block__moderation-status">
                                            Компания отклонена
                                            </span>
                                                @endif
                                        </div>
                                    </a>

                                    @if($company->tags->count() > 0)
                                    <div class="search-panel__company-group">{{ $company->tags[0]->name }}</div>
                                    @endif
                                    <!-- <bookmark :event="{{ json_encode($company->only('slug')) }}"
                                              :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_companies->contains('id', $company->id) : false) }}"></bookmark> -->
                                    <div class="search-panel__company-text">
                                        <div class="search-panel__company-title">{{ $company->name }}</div>
                                        <div class="search-panel__company-place">{{ $company->addresses->count() > 0 ? $company->addresses[0]->address : '' }} {{ $company->addresses->count() > 1 ? ' и еще ' . ($company->addresses->count() - 1) : '' }}
                                        </div>
                                        @if(!(boolean) request()->query('moderation'))
                                        <div class="search-panel__company-badges">
                                            <img src="/images/icons/thumb-up-black.svg"/>
                                            <span>{{ $company->rec }}</span>
                                            <img class="star" src="/images/icons/star.svg"/>
                                            <span>{{ round($company->star, 1) }}</span>
                                        </div>
                                        @endif
                                        <div class="search-panel__company-badges btns">
                                            @if (!$company->published)
                                                {{--<a title="Активировать" href="{{ route('cabinet.company.edit', $company) }}"><i class="fas fa-toggle-on"></i></a>--}}


                                                {{--<a title="Статистика" href="{{ route('cabinet.company.stat', $company) }}"><i class="fas fa-chart-line"></i></a>--}}

                                                <a title="Редактировать" href="{{ route('cabinet.company.edit', $company) }}"><i style="border-radius: 50%;
                                                        padding: 10px;
                                                        background: rgba(0,0,0,.6);" class="fas fa-pencil-alt"></i> </a>
                                            @else
                                                {{--   <a title="Снять с публикации" href="{{ route('api.cabinet.company.status', $company->id) }}"><i class="fas fa-toggle-on"></i></a>
  --}}
                                                  <a title="Редактировать" href="{{ route('cabinet.company.edit', $company) }}"><i style="border-radius: 50%;
                                                        padding: 10px;
                                                        background: rgba(0,0,0,.6);" class="fas fa-pencil-alt"></i> </a>

                                                  {{--<a title="Статистика" href="{{ route('cabinet.company.stat', $company) }}"><i class="fas fa-chart-line"></i></a>--}}

                                                {{--<a title="Увеличить просмотры" href="{{ route('cabinet.banner.index') }}"><i class="fas fa-arrow-up"></i></a>--}}

                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="pagination-panel">
                                {{ $companies->links('frontend.includes.pagination', ['paginator' => $companies]) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif



@endsection
