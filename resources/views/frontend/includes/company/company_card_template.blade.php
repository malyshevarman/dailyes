<div class="search-panel__company-block">
    <img src="{{ $company->image_url }}" alt="{{$company->name}}"/>
    <a href="{{ route('frontend.company.show', $company) }}">
        <div class="events-block__empty" style="z-index: unset;"></div>
        <div class="animation-block"></div>
    </a>


    @if (!is_null(Request::input('categories')) && Request::input('categories') !== [])
    @php
    foreach ($company->categories as $company_category)
        if (in_array($company_category->id, Request::input('categories'))) {
            $req_cat = $company_category;
        } else {
            $req_cat = $company->categories[0];
        }
    @endphp
    <a href="{{ route('frontend.city.company.category.show', $req_cat) }}">
        <div class="search-panel__company-group">
            {{ $req_cat->name }}
        </div>
    </a>
    @else
    <a href="{{ route('frontend.city.company.category.show', empty($category) ? (empty($company->categories[0]) ? null : $company->categories[0]) : $category) }}">
        <div class="search-panel__company-group">
            {{empty($category) ? (empty($company->categories[0]) ? null : $company->categories[0]->name) : $category->name}}
        </div>
    </a>
    @endif

    <company-bookmark :company="{{ json_encode($company->only('slug')) }}"
                      :status="{{ json_encode(Auth()->user() ? Auth()->user()->favorite_companies->contains('id', $company->id) : false) }}"></company-bookmark>
    
    <div class="search-panel__company-text">
        <div class="search-panel__company-title">{{ $company->name }}</div>
        <div class="search-panel__company-place">{{ $company->addresses->count() > 0 ? (isset($current_address) ? $current_address : $company->addresses[0]->address) : '' }}{{ $company->addresses->count() > 1 ? ' и еще ' : ''}} <span>{{ $company->addresses->count() > 1 ? ($company->addresses->count() - 1). ' ' . pular(($company->addresses->count() - 1), ['адрес', 'адреса', 'адресов']) : '' }}</span></div>
        <div class="search-panel__company-badges">
            <img src="/images/icons/thumb-up-black.svg"/>
            <span>{{ $company->rec }}</span>
            <img class="star" src="/images/icons/star.svg"/>
            <span>{{ round($company->star, 1) }}</span>
        </div>
    </div>
</div>