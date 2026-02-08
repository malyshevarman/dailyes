@extends('frontend.layouts.app')

@section('header')
    @include('frontend.includes.headers.article-page')
@endsection

@section('content')
	<div class="container-fluid search-panel oh text-page">
        <div class="container minus-15">
            <div class="row">
                <div class="col-md-12">
                	<div class="news-block">
                		<div class="row news-container bootfix-row">
                			<div class="col-md-12 bootfix-col">
								{!! $article->text !!}
							</div>
							<div class="col-md-12 bootfix-col article-sign">
								{{--<div style="float: left;
											font-family: Monsterrat-bold;
											font-size: 18px;
											line-height: 27px;
											color: #161C2C;">
									{{ $article->user->name . ' ' . $article->user->last_name }}
								</div>--}}
								<div style="float: right;">
									<div class="article-block__soc d-flex justify-content-around">
										<span style="font-family: Monsterrat-medium;
													font-size: 16px;
													line-height: 27px;
													color: #637F99;">
											Поделиться статьей
										</span>
								        <ul>
				                            <a href="javascript://" class="ya-share2" data-services="vkontakte"></a>
				                            <!-- <a href="javascript://" class="ya-share2" data-services="facebook"><li><img src="/images/icons/fb.svg"></li></a> -->
				                            <a href="javascript://" class="ya-share2" data-services="odnoklassniki"></a>
				                            <a href="javascript://" class="ya-share2" data-services="telegram"></a>
				                            <div onclick="myFunction()" class="ya-share2__container ya-share2__container_size_m ya-share2__container_color-scheme_normal ya-share2__container_shape_normal">
									    		<ul class="ya-share2__list ya-share2__list_direction_horizontal">
									    			<li class="ya-share2__item ya-share2__item_service_link">
									    				<a class="ya-share2__link" href="javascript://" rel="nofollow noopener" title="CopyLink">
									    					<span class="ya-share2__badge"><span class="ya-share2__icon"></span></span><span class="ya-share2__title"></span>
									    				</a>
									    			</li>
									    		</ul>
									    	</div>
				                        </ul>
									</div>
								</div>
							</div>
                            @if ($article->related_articles->count() > 0)
                            <div class="col-md-12 bootfix-col">
				                <div class="similar-title">
				                    Читайте также:
				                </div>
				                <div class="owl-carousel events-block gallery_owl">
				                    @foreach($article->related_articles as $related_article)
				                        <div>
		                                    <div class="news-item_preview">
		                                        <div class="news-item_tags-block">
		                                            @foreach ($related_article->tags as $key => $tag)
		                                            @if($key < 2)
		                                            <span class="news-item_tag">
		                                                {{$tag->name}}
		                                            </span>
		                                            @endif
		                                            @endforeach
		                                        </div>

                                                <a href="{{'/blog/' . $related_article->slug}}"><img src="{{'/storage/'.$related_article->preview->path}}" alt="{{$related_article->title}}">
                                                </a>
		                                    </div>
		                                    <div class="news-item_title">
		                                        <a href="{{'/blog/' . $related_article->slug}}">{{$related_article->title}}</a>
		                                    </div>
		                                    <div class="news-item_description">
		                                        {{$related_article->description}}
		                                    </div>
		                                    <div class="news-item_date">
		                                        {{$related_article->created_at->locale('ru')->isoFormat('D MMMM YYYY') . ' г.'}}
		                                    </div>
		                                </div>
				                    @endforeach
				                </div>
				            </div>
				            @endif
				            <!-- <blogform></blogform> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('after-scripts')
@endpush
