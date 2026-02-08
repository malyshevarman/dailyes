<template>
	<div class="map-content">
        <div class="map-content__header">
            <!-- <span>Компании на карте</span> -->
            <!-- <div class="map-content__header-close" data-dismiss="modal" aria-label="Close"><img
                        src="/images/icons/close.svg"/></div> -->
            <div class="map-content__header-middle-mobile">
            	<div class="logo-city-auth">
            		<div class="logo">
	                    <a href="/" style="display: flex;text-decoration: none;">
	                        <img src="/images/logo_footer.svg">
	                    </a>
	                </div>
	                <div class="select-city">
	                    <div class="top-block__city">
	                        <div @click="$bus.$emit('showCitySelectPanel')"><span class="current">{{ city.name }}</span>
	                        </div>
	                    </div>
	                </div>
	                <div class="auth-buttons">
	                	<div class="top-block__button" v-if="!user">
			                <a data="1" class="authPanel">Войти</a>
			            </div>
	                    <div class="top-block__avatar" v-else>
		                    <div class="v-align">
		                        <div class="top-block__avatar-photo">
		                            <img src="/images/avatarblack.svg"/>
		                        </div>
		                        <span class="name">{{user.name}}</span>
		                        <img src="/images/icons/arrow-down-sign-to-navigate-black.svg"/>
		                    </div>
		                    <div class="top-block__open">
		                        <div class="background">
		                            <div class="top-block__open-item" v-if="user.id == 1">
		                                <a href="/admin/dashboard">
		                                    <div class="top-block__open-img"><img src="/images/icons/user.svg"/></div>
		                                    <span>Управление</span></a>
		                            </div>
		                            <div class="top-block__open-item">
		                                <a href="cabinet/dashboard">
		                                    <div class="top-block__open-img"><img src="/images/icons/user.svg"/></div>
		                                    <span>Личный кабинет</span></a>
		                            </div>
		                            <div class="top-block__open-item">
		                                <a href="/cabinet/notification">
		                                    <div class="top-block__open-img"><img src="/images/icons/notify.svg"/></div>
		                                    <!-- <div class="top-block__open-count">{{ userUnreadNotificationsCount }}</div> -->
		                                    <span>Уведомления</span></a>
		                            </div>
		                            <div class="top-block__open-exit">
		                                <a href="/logout"
		                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
		                                    <div class="top-block__open-img"><img src="/images/icons/exit.svg"/></div>
		                                    <span>Выйти</span></a>
		                                <form id="logout-form" action="/logout" method="POST"
		                                      style="display: none;">
		                                    @csrf
		                                </form>
		                            </div>
		                        </div>
		                    </div>
		                </div>
	                </div>
            	</div>
            	<div class="search">
                    <form>
                        <input placeholder="Найти компанию" :value="requestText" name="text" type="text"/>
                        <button>
                            <img src="/images/icons/glass.svg"/>
                        </button>
                    </form>
                </div>
            </div>
            <div class="map-content__header-middle">
                <div class="logo">
                    <a href="/" style="display: flex;text-decoration: none;">
                        <img src="/images/logo_footer.svg">
                    </a>
                </div>
                <div class="select-city">
                    <div class="top-block__city">
                        <div @click="$bus.$emit('showCitySelectPanel')"><span class="current">{{ city.name }}</span>
                        </div>
                    </div>
                </div>
                <div class="search">
                    <form>
                        <input placeholder="Найти компанию" :value="requestText" name="text" type="text"/>
                        <button>
                            <img src="/images/icons/glass.svg"/>
                        </button>
                    </form>
                </div>
                <div class="auth-buttons">
                	<div class="top-block__button" v-if="!user">
		                <a data="1" class="authPanel">Войти</a>
		            </div>
                    <div class="top-block__avatar" v-else>
	                    <div class="v-align">
	                        <div class="top-block__avatar-photo">
	                            <img src="/images/avatarblack.svg"/>
	                        </div>
	                        <span class="name">{{user.name}}</span>
	                        <img src="/images/icons/arrow-down-sign-to-navigate-black.svg"/>
	                    </div>
	                    <div class="top-block__open">
	                        <div class="background">
	                            <div class="top-block__open-item" v-if="user.id == 1">
	                                <a href="/admin/dashboard">
	                                    <div class="top-block__open-img"><img src="/images/icons/user.svg"/></div>
	                                    <span>Управление</span></a>
	                            </div>
	                            <div class="top-block__open-item">
	                                <a href="cabinet/dashboard">
	                                    <div class="top-block__open-img"><img src="/images/icons/user.svg"/></div>
	                                    <span>Личный кабинет</span></a>
	                            </div>
	                            <div class="top-block__open-item">
	                                <a href="/cabinet/notification">
	                                    <div class="top-block__open-img"><img src="/images/icons/notify.svg"/></div>
	                                    <!-- <div class="top-block__open-count">{{ userUnreadNotificationsCount }}</div> -->
	                                    <span>Уведомления</span></a>
	                            </div>
	                            <div class="top-block__open-exit">
	                                <a href="/logout"
	                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
	                                    <div class="top-block__open-img"><img src="/images/icons/exit.svg"/></div>
	                                    <span>Выйти</span></a>
	                                <form id="logout-form" action="/logout" method="POST"
	                                      style="display: none;">
	                                    @csrf
	                                </form>
	                            </div>
	                        </div>
	                    </div>
	                </div>
                </div>
            </div>
            <modal-map-header-categories></modal-map-header-categories>
        </div>
        <div class="modal-body">
            <div id="map-modal-close" class="close-modal" @click="closeModal"><i class="fas fa-times"></i></div>
            <modal-map-left-side-list-items></modal-map-left-side-list-items>
            <div id="map" style="width: 100%; height: 100vh;">
                <modal-map :city="city" :balloon="true" :drag="true" :modal="true"></modal-map>
            </div>
        </div>
    </div>
</template>

<script>
	const requestText = (new URL(document.location)).searchParams.get("text");

	export default {
		props: {
			// categories: {
   //              required: true,
   //              type: Array
   //          },
            currentTag: {
            	required: false,
            	type: Object,
            	default: null
            },
   //          addresses: {
   //              required: true,
   //              type: Array
   //          },
   //          currentCompanies: {
   //              required: true,
   //              type: Array
   //          },
   //          userUnreadNotificationsCount: {
   //          	required: false,
   //          	type: Number,
   //          	default: null
   //          },
            city: {
            	required: true,
            	type: Object
            },
		},
		data() {
			return {
				user: Laravel.user,
				requestText: requestText,
				selectedTag: {},
				// currentCategory: {}
			}
		},
		mounted() {
			let params = (new URL(document.location)).searchParams;
		    // console.log('df')
		    if (params.get("map")) {
		        $('#map-modal').modal('show')
		        this.fetch()
		    }
			this.$bus.$on('getSelectedTagFromCompaniesModalHeaderComponent', (tag) => {
                    this.selectedTag = tag
                    // if (this.currentCategory !== null && Object.keys(this.currentCategory).length == 0) {
                    	// this.currentCategory = category
                    // }
                });
			this.$bus.$on('showCompaniesMap', () => {
					this.show()
                });
		},
		methods: {
			show() {
				$('#map-modal').modal('show')
				history.pushState(null, null, (window.location.protocol + '//' + window.location.host + window.location.pathname + '?map=1'));
				this.fetch()
			},
			closeModal() {
				if (this.selectedTag == null && this.currentTag == null || this.selectedTag !== null && JSON.stringify(this.selectedTag) === JSON.stringify({}) || this.currentTag !== null && this.selectedTag !== null && this.selectedTag.id == this.currentTag.id) {
					let url = new URL(document.location);
					let searchParams = url.searchParams;
					// console.log('searchParams', searchParams.keys())
					// for(let key of searchParams.keys()) {
						// console.log('key', key)
					  searchParams.delete('map');
					  searchParams.delete('balloonid');
					// }
					window.history.pushState({}, '', url.toString());
					$('#map-modal').modal('hide');
				} else {
					if (this.selectedTag == null || JSON.stringify(this.selectedTag) === JSON.stringify({})) {
						location.href = `/company`
					} else {
						location.href = `/company/tag/${this.selectedTag.slug}`
					}
				}
			},
			fetch() {
				axios.get(`${new URL(document.location)}`)
					.then(response => {
						this.$bus.$emit('fetchMapAddresses', response.data.addresses)
						if ((new URL(document.location)).searchParams.get('balloonid') == null) {
							this.$bus.$emit('fetchCompaniesList', response.data.companies)
						}
						this.$bus.$emit('fetchCompaniesCategoriesList', response.data.categories)
						// this.$bus.$emit('fetchCompaniesSelectedCategory', response.data.category)
						this.$bus.$emit('fetchCompaniesTagsList', response.data.tags)
						if (response.data.tag) {
							this.$bus.$emit('fetchEventsSelectedTag', response.data.tag)
						}
					})
			}
		}
	}
</script>