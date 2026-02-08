<template>
	<div>
		<div :class="`filter ${activeFilter || filterShow ? 'active' : ''}`" @click="filterShow=!filterShow">
	        <i class="fa fa-filter" aria-hidden="true"></i>
	    </div>
	    <div class="filter-popup" v-if="filterShow">
	        <h6>Фильтры</h6>
	        <div class="filter-item" v-for="(filter, index) in filters.filter(item => item.show == true)" :key="index">
	            <button :class="{'active': filter.status}" @click="select(filter.name, filter.value)">{{filter.label}}<i class="clear_filter" v-if="filter.status">&times;</i></button>
	        </div>
	    </div>
	    <div v-if="filterShow" style="position: absolute;left: 0;right: 0;top: 0;bottom: 0;z-index: 16;cursor: pointer;" @click="filterShow=false">
	        	
	    </div>
	</div>
</template>

<script>
	// const url = new URL(document.location);
 //    const searchParams = url.searchParams;
	export default {
		props: {
            newTab: {
                required: true,
                type: Boolean
            },
            endTab: {
                required: true,
                type: Boolean
            },
		},
		data() {
			return {
                filterShow: false,
                filters: [
                	{
                		status: false,
                		name: 'label_id',
                		value: 2,
                		label: 'Успейте воспользоваться',
                		show: true
                	},
                	{
                		status: false,
                		name: 'label_id',
                		value: 1,
                		label: 'Новые акции',
                		show: true
                	},
                	{
                		status: false,
                		name: 'sort-raiting',
                		value: 'desc',
                		label: 'С лучшими оценками',
                		show: true
                	},
                	{
                		status: false,
                		name: 'sort-views',
                		value: 'desc',
                		label: 'Популярные',
                		show: true
                	},
                	{
                		status: false,
                		name: 'favorite',
                		value: 1,
                		label: 'Рекомендуемые',
                		show: true
                	}
                ],
                activeFilter: false,
			}
		},
		mounted() {
			let url = new URL(document.location);
    		let searchParams = url.searchParams;
    		// console.log('asdasd', url)
			this.filters.forEach((filter) => {
				if (searchParams.get(filter.name) && searchParams.get(filter.name) == filter.value) {
					filter.status = true
					this.activeFilter = true
				}
				if (filter.name == 'label_id' && filter.value == 1) {
					// console.log('aaaaaaaaaaaa')
					filter.show = this.newTab
				}
				if (filter.name == 'label_id' && filter.value == 2) {
					filter.show = this.endTab
				}
			});
		},
		// watch: {
		// 	url: (val) => {
		// 		console.log('url', url.get('recommended'))
		// 		Object.keys(this.filters).forEach((key) => {
		// 			if (searchParams.get(key)) {
		// 				this.filters[key] = true
		// 			} else {
		// 				this.filters[key] = false
		// 			}
		// 		});
		// 	}
		// },
		methods: {
			select(filterName, filterValue) {
				let url = new URL(document.location);
    			let searchParams = url.searchParams;
    			if (searchParams.get('balloonid')) {
                    searchParams.delete('balloonid');
                }
				this.filters.forEach((f) => {
					if (f.name !== filterName || f.name == filterName && f.value != filterValue) {
						f.status = false
						searchParams.delete(f.name);
					}
				});
				// console.log(this.filters)
				let selectedFilter = this.filters.find(item => item.name == filterName && item.value == filterValue)
				selectedFilter.status = !selectedFilter.status
				if (selectedFilter.status) {
					searchParams.set(selectedFilter.name, selectedFilter.value)
                    this.activeFilter = true
				} else {
					// console.log('filter', filter)
					searchParams.delete(selectedFilter.name);
					this.activeFilter = false
				}
				axios.get(`${url}`)
					.then((response) => {
						// console.log('response' ,response)
						this.$bus.$emit('fetchEventsCategoriesList', response.data.categories)
						this.$bus.$emit('fetchEventsTagsList', response.data.tags)
						this.$bus.$emit('fetchMapEventsAddresses', response.data.addresses)
						this.$bus.$emit('fetchEventsList', response.data.events)
						window.history.pushState({}, '', url.toString());
					})
			},
		}
	}
</script>