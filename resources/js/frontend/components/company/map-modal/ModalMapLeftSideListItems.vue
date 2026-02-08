<template>
	<div class="map-list">
        <!-- <div v-if="address != ''"  class="map-list-mobile-block">
            <div class="col-lg-12 col-md-12 col-sm-12 event-item bootfix-col">
                <div class="map-list-mobile-block-content">
                    <div class="map-list-mobile-block-label">
                        Вы выбрали адрес:
                    </div>
                    <div class="map-list-mobile-block-address">
                        {{address}}
                    </div>
                    <div class="map-list-close" @click="closeMapList()">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="map-list-mobile-block">
            <div class="col-lg-12 col-md-12 col-sm-12 event-item bootfix-col">
                <div class="main-page-map-button-block">
                    <div class="main-page-map-button">
                        <a href="javascript:void(0);" @click.prevent="closeMapList()">
                            <div class="label">
                                <svg width="20" height="25" viewBox="0 0 17 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.12534 10.6221C7.54271 10.9003 8.03357 11.0489 8.5359 11.0491L7.12534 10.6221ZM7.12534 10.6221C6.70778 10.3438 6.38263 9.9485 6.1907 9.48634M7.12534 10.6221L6.1907 9.48634M6.1907 9.48634C5.99878 9.0242 5.94859 8.51578 6.0464 8.02531M6.1907 9.48634L6.0464 8.02531M6.0464 8.02531C6.14422 7.53483 6.38572 7.08402 6.74065 6.73M6.0464 8.02531L6.74065 6.73M6.74065 6.73C7.09561 6.37597 7.54809 6.13464 8.04097 6.03686M6.74065 6.73L8.04097 6.03686M8.04097 6.03686C8.53386 5.93907 9.04474 5.98928 9.50892 6.18105M8.04097 6.03686L9.50892 6.18105M9.50892 6.18105C9.97308 6.37281 10.3695 6.69741 10.6482 7.11352M9.50892 6.18105L10.6482 7.11352M10.6482 7.11352C10.9268 7.52939 11.0755 8.01807 11.0756 8.51785L10.6482 7.11352ZM9.28666 1.28936V1.24923L8.5359 1.25C6.60501 1.25197 4.75335 2.0178 3.3873 3.38008C2.02118 4.74243 1.25231 6.59006 1.25 8.51772V8.51861C1.25 9.78359 1.66062 11.14 2.23223 12.4292C2.80797 13.7278 3.57173 15.0125 4.3327 16.1484C5.8547 18.4205 7.40592 20.157 7.54016 20.3065L7.54133 20.3078C7.667 20.4471 7.82053 20.5584 7.99191 20.6346C8.16326 20.7107 8.34867 20.75 8.53611 20.75C8.72356 20.75 8.90896 20.7107 9.0803 20.6346C9.25168 20.5584 9.40521 20.4471 9.53088 20.3078L9.53205 20.3065C9.66629 20.157 11.2175 18.4205 12.7395 16.1484C13.5005 15.0125 14.2642 13.7278 14.84 12.4292C15.4116 11.14 15.8222 9.78359 15.8222 8.51861L15.8222 8.51772C15.8199 6.59027 15.0512 4.74283 13.6853 3.38052C12.4974 2.19561 10.942 1.46184 9.28666 1.28936ZM11.0756 8.51794C11.0749 9.18839 10.8076 9.83157 10.3317 10.3062C9.85572 10.781 9.20995 11.0484 8.53599 11.0491L11.0756 8.51794Z" stroke="#fff" stroke-width="1.5"/>
                                </svg>
                                Смотреть на карте 
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12.154" height="21.322" viewBox="0 0 12.154 21.322">
                              <path id="Path_174" data-name="Path 174" d="M10.662,109.294a1.489,1.489,0,0,1-1.056-.437L.438,99.689A1.493,1.493,0,0,1,2.55,97.578l8.112,8.112,8.112-8.112a1.493,1.493,0,0,1,2.111,2.112l-9.168,9.168A1.489,1.489,0,0,1,10.662,109.294Z" transform="translate(-97.141 21.322) rotate(-90)" fill="#fff"/>
                            </svg>
                        </a>
                        <span>Для быстрого и удобного поиска акций</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="map-list-items">
            <div class="col-lg-12 col-md-12 col-sm-12 company-item bootfix-col" v-for="company in companies" :key="company.id">
            	<div class="search-panel__company-block">
                    <img :src="company.image_url"/>
                    <a :href="`/company/${company.slug}`">
                        <div class="events-block__empty" style="z-index: unset;"></div>
                        <div class="animation-block"></div>
                    </a>

                    <a v-if="company.tags && company.tags.length > 0" :href="`/company/category/${company.tags[0].slug}`">
                        <div class="search-panel__company-group">
                            {{company.tags[0].name}}
                        </div>
                    </a>
                    <company-bookmark :company="{slug: company.slug}"
                                      :status="company.status"></company-bookmark>
                    <div class="search-panel__company-text">
                        <div class="search-panel__company-title">{{company.name}}</div>
                        <div class="search-panel__company-place">{{ company.addressString1}}<span>{{company.addressString2}}</span></div>
                        <div class="search-panel__company-badges">
                            <img src="/images/icons/thumb-up-black.svg"/>
                            <span>{{company.rec}}</span>
                            <img class="star" src="/images/icons/star.svg"/>
                            <span>{{Math.round(company.star, 1)}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
		// props: {
		// 	currentCompanies: {
  //               required: true,
  //               type: Array
  //           }
		// },
		data() {
			return {
				companies: [],
                address: ''
			}
		},
		mounted() {
            // if ((new URL(document.location)).searchParams.get('balloonid') == null) {
            //     this.companies = this.currentCompanies
            // }
			
			this.$bus.$on('fetchCompaniesList', (companies) => {
                    this.fetchCompaniesList(companies)
                    if (screen.width <= "768") {
                        // this.closeMapList()
                    }
                });
            this.$bus.$on('fetchPlacemarkCompanies', (companies, address) => {
                    this.fetchPlacemarkCompanies(companies, address)
                });
		},
		methods: {
			fetchCompaniesList(companies) {
                this.address = ''
                // if ((new URL(document.location)).searchParams.get('balloonid') == null) {
                this.companies = companies
                // }
			},
            fetchPlacemarkCompanies(companies, address) {
                this.companies = companies
                this.address = address
                $('.map-list').css({
                    display: 'block',
                })
            },
            closeMapList() {
                $('.map-list').css({
                    display: 'none',
                })
            }
		}
	}
</script>