<template>
	<div>
		<div :class="`filter ${activeFilter ? 'active' : ''}`" @click="filterShow=!filterShow">
	        <i class="fa fa-filter" aria-hidden="true"></i>
	    </div>
	    <div class="filter-popup" v-if="filterShow">
	        <h6>Фильтры</h6>
	        <div class="filter-item">
	            <button :class="filters.recommended ? 'active' : ''" @click="select('recommended')">Рекомендуемые</button>
	        </div>
	        <div class="filter-item">
	            <button :class="filters.new ? 'active' : ''" @click="select('new')">Акции сегодня</button>
	        </div>
	        <div class="filter-item">
	            <button :class="filters.highRating ? 'active' : ''" @click="select('highRating')">С лучшими оценками</button>
	        </div>
	        <div class="filter-item">
	            <button :class="filters.popular ? 'active' : ''" @click="select('popular')">Популярные</button>
	        </div>
	    </div>
	</div>
</template>

<script>
	const url = new URL(document.location);
    const searchParams = url.searchParams;
	export default {
		data() {
			return {
                filterShow: false,
                filters: {
                	recommended: false,
                	new: false,
                	highRating: false,
                	popular: false
                },
                activeFilter: false,
			}
		},
		mounted() {
			Object.keys(this.filters).forEach((key) => {
				if (searchParams.get(key)) {
					this.filters[key] = true
					this.activeFilter = true
				}
			});
		},
		watch: {
			url: (val) => {
				// console.log('url', url.get('recommended'))
				Object.keys(this.filters).forEach((key) => {
					if (searchParams.get(key)) {
						this.filters[key] = true
					} else {
						this.filters[key] = false
					}
				});
			}
		},
		methods: {
			select(filter) {
				Object.keys(this.filters).forEach((key) => {
					if (key !== filter) {
						this.filters[key] = false
						searchParams.delete(key);
					}
				});
				// console.log(this.filters)
				this.filters[filter] = !this.filters[filter]
				if (this.filters[filter]) {
					searchParams.set(filter, this.filters[filter])
                    this.activeFilter = true
				} else {
					// console.log('filter', filter)
					searchParams.delete(filter);
				}
				window.history.pushState({}, '', url.toString());
			}
		}
	}
</script>