		<!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
             
            </div>
        </div>
    </div>
    <script src="{{ asset('public/assets/vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('public/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('public/assets/vendor/bootstrap-select/dist/js/countrypicker.min.js') }}"></script>
	<script src="{{ asset('public/assets/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom.min.js') }}"></script>
	<script src="{{ asset('public/assets/js/deznav-init.js') }}"></script>
	<script src="{{ asset('public/assets/vendor/owl-carousel/owl.carousel.js') }}"></script>
	 <script src="{{ asset('public/assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
	
	<!-- Chart piety plugin files -->
    <script src="{{ asset('public/assets/vendor/peity/jquery.peity.min.js') }}"></script>
	
	<!-- Dashboard 1 -->
	<script src="{{ asset('public/assets/js/dashboard/dashboard-1.js') }}"></script>	
	<script src="{{ asset('public/assets/js/custom/common.js') }}"></script>
	
	<script>
		function carouselReview(){
			/*  testimonial one function by = owl.carousel.js */
			jQuery('.testimonial-one').owlCarousel({
				loop:true,
				autoplay:true,
				margin:15,
				nav:false,
				dots: false,
				left:true,
				navText: ['', ''],
				responsive:{
					0:{
						items:1
					},
					800:{
						items:2
					},	
					991:{
						items:2
					},			
					
					1200:{
						items:2
					},
					1600:{
						items:2
					}
				}
			})		
			jQuery('.testimonial-two').owlCarousel({
				loop:true,
				autoplay:true,
				margin:15,
				nav:false,
				dots: true,
				left:true,
				navText: ['', ''],
				responsive:{
					0:{
						items:1
					},
					600:{
						items:2
					},	
					991:{
						items:3
					},			
					
					1200:{
						items:3
					},
					1600:{
						items:4
					}
				}
			})					
		}
		jQuery(window).on('load',function(){
			setTimeout(function(){
				carouselReview();
			}, 1000); 
		});
	</script>
