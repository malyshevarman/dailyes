@push('after-scripts')
    <script src="https://yastatic.net/share2/share.js"></script>
    <script type="text/javascript">
    	function myFunction() {
		  	/* Get the text field */
		  	var copyText = window.location.href;

		  	/* Select the text field */
		  	// copyText.select();
		  	// copyText.setSelectionRange(0, 99999); /* For mobile devices */

		   	/* Copy the text inside the text field */
		  	navigator.clipboard.writeText(copyText);

		  	/* Alert the copied text */
		  	alert("Скопировано");
		  	// console.log('kshdf')
		}
    </script>
@endpush

<div class="top-block__soc">
    <ul>
        <a href="javascript://" class="ya-share2 vkclick" data-services="vkontakte"></a>
        <!-- <a href="javascript://" class="ya-share2 fbclick" data-services="facebook"><li><img src="/images/icons/fb.svg"></li></a> -->
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
