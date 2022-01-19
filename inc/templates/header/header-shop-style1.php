<div class="page-padding shop-header-style1">
	<div class="row row-fluid full-width-row">
		<div class="small-12 columns">
			<div class="small 12 columns" style="display: flex; justify-content: space-between">
				<h1 style="margin: 0.5rem 0 1rem 0;" class=" thb-shop-title"><?php woocommerce_page_title(); ?></h1>
				<button id="pop_up_btn_triger">
					Showing results for
					<span id="location_btnne" style="text-decoration:underline"></span>
				</button>
				<script>
					const get_user_city = sessionStorage.getItem('state-info')
					const toJSON = JSON.parse(get_user_city)
					var user_city = "";
					if (sessionStorage.getItem('state-info') != null) {
						var user_city = toJSON.suburb
						document.querySelector('#location_btnne').innerHTML = user_city;

					}
				</script>
			</div>
		</div>
	</div>
</div>