<rss xmlns:yandex="http://news.yandex.ru" xmlns:media="http://search.yahoo.com/mrss/"
     xmlns:turbo="http://turbo.yandex.ru" version="2.0">
    <channel>
        <title>Выгодные предложения, акции и скидки в вашем городе</title>
        <link>https://dailyes.ru/</link>
        <description>На нашем сайте собраны лучшие скидки, акции, специальные предложения, бесплатные купоны и промокоды
            на каждый день, от разных компаний
        </description>

        @foreach( $events as $event )

            <item turbo="true">
                <title>{{$event->name}}</title>
                <link>https://dailyes.ru/stocks/{{$event->slug}}</link>
                <turbo:content>
                    <![CDATA[
                    <header>
                        <h1>{{$event->name}}</h1>
                        <h2>{{!empty($event->company->category) ? $event->company->category->name : ''}}</h2>
                        <figure>
                            <img src="{{$event->image->url}}">
                        </figure>

                    </header>
                    <p>{!! nl2br(e($event->about)) !!}</p>
                    ]]>
                </turbo:content>
            </item>

        @endforeach


        @foreach( $companies as $company )

            <item turbo="true">
                <title>{{$company->name}}</title>
                <link>https://dailyes.ru/company/{{$company->slug}}</link>
                <turbo:content>
                    <![CDATA[
                    <header>
                        <h1>{{$company->name}}</h1>
                        <h2>{{!empty($company->category) ? $company->category->name : ''}}</h2>
                        <figure>
                            <img src="{{$company->image->url}}">
                        </figure>

                    </header>
                    <p>{!! nl2br(e($company->about)) !!}</p>
                    ]]>
                </turbo:content>
            </item>

        @endforeach

    </channel>
</rss>
