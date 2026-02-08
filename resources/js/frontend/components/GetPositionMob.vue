<template>
	<div style="display: inline-block;">
		<div style="display: inline-block;width: 100%;position: relative;">
            <div class="mobfilter_3-title">Введите адрес, где вы находитесь</div>
            <input type="text" name="location[name]" id="address" placeholder="Адрес"
               :value="locationName ? locationName : string"/>
               <span v-if="locationName || string" class="clear_address_filter_geo_input" @click="clearLocation()">&times;</span>
        </div>
		<input type="hidden" name="location[coords]" :value="coords">
		<!-- <div @click="getPosition()"> Определить</div> -->
		<button @click.prevent="getPosition()" style="background: #137CD6;
												    color: #FFF;
												    border-radius: 3px;
												    padding: 17px 60px;
												    font-size: 14px;
												    cursor: pointer;
												    outline: none;
												    border: none;width: 100%;font-family: 'Monsterrat-medium';">Определить</button>
		<div v-if="show" style="margin-top: 5px;">
			<yandex-map
				style="width: 100%;height: 200px;"
	            :coords="coords"
	            :zoom="16"
	            class="map"
	            @map-was-initialized="initMapHandler"
	            :controls="['zoomControl']"
	        >
	            <ymap-marker
	                :coords="coords"
	                marker-id="1"
	                :icon="markerIcon"
	            />
	        </yandex-map>
		</div>
	</div>
</template>

<script>
	import yandexMap from 'vue-yandex-maps';
	export default {
		components: {
            yandexMap
        },
        props: {
        	'locationName': String
        },
		data() {
			return {
				coords: [],
				navigator: navigator,
				markerIcon: {
	              layout: 'default#imageWithContent',
	              imageHref: '/images/pages/contacts/placemark.png',
	              imageSize: [43, 43],
	              imageOffset: [-24, -24],
	              content: '',
	              contentOffset: [],
	              contentLayout: ''
	            },
	            show: false,
	            string: ''
			}
		},
		methods: {
			clearLocation() {
				this.show = false
				this.coords = []
				$('.rangeBlock').hide()
				this.string = ''
			},
			getPosition() {
				// this.show = true
				// $('#address').hide()
				// this.string = ''
				$('.rangeBlock').show()
	            if ("geolocation" in this.navigator) {
	                new Promise((resolve, reject) => {
	                	this.navigator.geolocation.getCurrentPosition((position) => {
	                    	// console.log(position);
	                		// this.lat = position.coords.latitude
	                		// this.long = position.coords.longitude
	                		this.coords.push(position.coords.latitude)
	                		this.coords.push(position.coords.longitude)
	                		resolve()
	                	})
	                }).then(() => {
	                	this.show = true
	                	axios.get(`https://geocode-maps.yandex.ru/1.x/?apikey=f679a5dd-9081-411e-abf2-ac4a32c74e0c&format=json&geocode=${this.coords[1]},${this.coords[0]}`)
	                	.then(response => {
	                		this.string = response.data.response.GeoObjectCollection.featureMember[0].GeoObject.name
	                		console.log(response, 'hi')
	                	})
	                })
	            } else {
	              /* местоположение НЕ доступно */
	            }
	        },
	        initMapHandler(map) {
                this.map = map
            }
		}
	}
</script>