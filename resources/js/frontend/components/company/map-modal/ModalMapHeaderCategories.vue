<template>
	<div class="map-content__header-bottom">
        <!-- <modal-map-filter></modal-map-filter> -->
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
		// props: {
		// 	categories: {
  //               required: true,
  //               type: Array
  //           },
  //           currentCategory: {
  //           	required: false,
  //           	type: Object
  //           }
		// },
		data() {
			return {
				selectedCategory: {},
                categories: [],
                tags: [],
                selectedTag: {}
			}
		},
		mounted() {
			// this.selectedCategory = this.currentCategory
            this.$bus.$on('fetchCompaniesCategoriesList', (categories) => {
                    this.categories = categories
                });
            this.$bus.$on('fetchCompaniesTagsList', (tags) => {
                    this.tags = tags
                });
            this.$bus.$on('fetchCompaniesSelectedTag', (tag) => {
                    this.selectedTag = tag
                });
		},
		methods: {
			selectCategory(category) {
                this.selectedCategory = category
            },
            selectTag(tag) {
                let url = new URL(document.location);
                url.pathname = `/company/tag/${tag ? tag.slug : ''}`
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
                        this.$bus.$emit('fetchMapCompaniesAddresses', response.data.addresses)
                        this.$bus.$emit('fetchCompaniesList', response.data.companies)
                        if (response.data.tag) {
                            this.$bus.$emit('getSelectedTagFromCompaniesModalHeaderComponent', response.data.tag)
                        }
                        window.history.pushState({}, '', url.toString());
                    })
            },
		}
	}
</script>