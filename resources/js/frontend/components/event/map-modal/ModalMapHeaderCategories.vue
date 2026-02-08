<template>
	<div class="map-content__header-bottom">
        <event-modal-map-filter :newTab="newTab" :endTab="endTab"></event-modal-map-filter>
        <div class="categories">
            <ul v-if="JSON.stringify(selectedCategory) === JSON.stringify({})">
                <li v-for="category in categories">
                    <button :class="selectedCategory ? (selectedCategory.id == category.id ? 'active' : '') : ''" @click="selectCategory(category)">
                        {{category.name}}
                    </button>
                </li>
            </ul>
            <ul v-else>
                <li>
                    <button :class="selectedCategory ? 'active' : ''" @click="selectedCategory = {}">
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </button>
                </li>
                <li v-for="tag in tags.filter(tag => tag.category_id == selectedCategory.id)">
                    <button :class="selectedTag ? (selectedTag.id == tag.id ? 'active' : '') : ''" @click="selectTag(tag)">
                        {{tag.name}}
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
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
				selectedCategory: {},
                categories: [],
                tags: [],
                selectedTag: {}
			}
		},
		mounted() {
            this.$bus.$on('fetchEventsCategoriesList', (categories) => {
                    this.categories = categories
                });
            this.$bus.$on('fetchEventsTagsList', (tags) => {
                    this.tags = tags
                });
            this.$bus.$on('fetchEventsSelectedTag', (tag) => {
                    this.selectedTag = tag
                });
		},
		methods: {
            selectCategory(category) {
                this.selectedCategory = category
            },
			selectTag(tag) {
                let url = new URL(document.location);
                url.pathname = `/stocks/tag/${tag ? tag.slug : ''}`
                if (url.searchParams.get('balloonid')) {
                    url.searchParams.delete('balloonid');
                }
				axios.get(`${url}`)
                    .then(response => {
                        this.selectedTag = tag
                        // this.categories = response.data.categories
                        // this.categories.forEach(cat => {
                        //     cat.tags.forEach(tag => {
                        //         this.tags.push(tag)
                        //     })
                        // })
                        // this.tags = response.data.tags
						this.$bus.$emit('fetchMapEventsAddresses', response.data.addresses)
						this.$bus.$emit('fetchEventsList', response.data.events)
                        if (response.data.tag) {
                            this.$bus.$emit('getSelectedTagFromEventsModalHeaderComponent', response.data.tag)
                        }
                        window.history.pushState({}, '', url.toString());
                    })
			},
		}
	}
</script>