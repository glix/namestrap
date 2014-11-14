<?php get_header(); ?>
	<script>
		$(function(){
			var minRange = '<?php echo $_GET["minRange"]; ?>';
			var maxRange = '<?php echo $_GET["maxRange"]; ?>';


			$('.sl1').slider({
				tooltip: false,
				handle: 'square',
	  	    }).on('slideStop', function(ev){
	  	    	var currentVal = $('.price-slider .tooltip-inner').text();
	  	    	currentVal = currentVal.split(":");
	  	    	var min = currentVal[0].replace("$","").trim();
	  	    	var max = currentVal[1].replace("$","").trim();
	  	    	$('input[name="minRange"]').val(min);
	  	    	$('input[name="maxRange"]').val(max);
	  	    	submitForm();
			}).on('slide', function(slideEvt) {
				var currentVal = $('.price-slider .tooltip-inner').text();
	  	    	currentVal = currentVal.split(":");
	  	    	var min = currentVal[0].replace("$","").trim();
	  	    	var max = currentVal[1].replace("$","").trim();
	  	    	$('.min-val').text('$'+min);
	  	    	$('.max-val').text('$'+max);
			});

			$('.sl2').slider({
				tooltip: false,
				handle: 'square',
			}).on('slideStop', function(ev){
	  	    	var currentLength = $('.slider-by-length .tooltip-inner').text();
	  	    	$('#dLenght').val(currentLength);
	  	    	submitForm();
			}).on('slide', function(slideEvt) {
				var currentLength = $('.slider-by-length .tooltip-inner').text();
				if(currentLength == 1){
				 	currentLength = 'All';
				}
	  	    	$('.length-val').text(currentLength);
			});
			

			$("#category").select2({
				placeholder: "Filter by Category",
			});

			$("#sortBy_list").select2();

			// function toggleChevron(e) {
			//     $(e.target)
			//         .prev('.panel-heading')
			//         .find("i")
			//         .toggleClass('fa-chevron-circle-right fa-chevron-circle-down');
			// }
			// $('#accordion').on('hidden.bs.collapse', toggleChevron);
			// $('#accordion').on('shown.bs.collapse', toggleChevron);

			//$('#searchform input[name="s"]').focus();
			$('#searchform input[name="s"], #searchform #category').on('change',function(){
				submitForm();
			});

			$('.search-btn').on('click',function(){
				submitForm();
			});

			$('.sortitem').on('click',function(e){
				e.preventDefault();
				var sort_order = $(this).attr('data-sort-order');
				$('#sortby').val($(this).data('sort')+sort_order);
				
				var li = $(this);
				
				var liLeft = li.position().left;
			    var liMid = liLeft + (li.width()/2);
			    //$(".arrow_move_wrapper").css('left', liMid+"px");
			    submitForm();
			    $(".arrow_move_wrapper").animate({
				    left: liMid
			    }, 300, function() {
			    });
			    $('.sortitem i').addClass('disable-icon');
			    $(this).find('i').removeClass('disable-icon');
			    if(sort_order == "Desc"){
					$(this).attr('data-sort-order','Asc');	
					$(this).find('i').removeClass('fa-sort-asc');
					$(this).find('i').addClass('fa-sort-desc');
					
				}else{
					$(this).attr('data-sort-order','Desc');	
					$(this).find('i').removeClass('fa-sort-desc');
					$(this).find('i').addClass('fa-sort-asc');
				}
			    
			});
		});
	</script>
	<div class="container content_wrapper">
		<div class="row">
			<div class="col-xs-3 left-wrapper-width">
				<div class="left-sidebar-wrapper">
				<form id="searchform" class="form-inline">
					<input type="hidden" name="paged" id="paged" value="1"/>
					<input type="hidden" name="sortby" id="sortby" value="dateDesc"/>
					<div class="panel-group" id="accordion">
					  <div class="panel panel-default">
					   <!--  <div class="panel-heading">
					      <h4 class="panel-title">
					        <a data-parent="#accordion" href="#">
					          <i class="fa fa-chevron-circle-down"></i> Domain Name
					        </a>
					      </h4>
					    </div> -->
					    <div id="collapseOne" class="panel-collapse collapse in">
					      <div class="panel-body">
					        <div class="input-group">
							    <input type="text" class="form-control" value="<?php echo (isset($_GET['s']) && !empty($_GET['s'])) ? $_GET['s'] : ""; ?>" id="s" placeholder="Search Domain Name" name="s"/>
							    <span class="input-group-btn">
							        <input type="submit" value="Go" class="btn btn-default search-btn"/>
							    </span>
							    
							</div>
					      </div>
					    </div>
					  </div>
					  <div class="panel panel-default">
					    <div class="panel-heading">
					      <h4 class="panel-title">
					        <a data-parent="#accordion" href="#collapseTwo">
					        	Price Range
					        </a>
					        <?php 
					    		$value = "[100,900]";
					    		if(isset($_GET['minRange']) && isset($_GET['maxRange']) && !empty($_GET['minRange']) && !empty($_GET['maxRange'])){
					    			$value = "[".$_GET['minRange'].",".$_GET['maxRange']."]";
					    			$minVal = $_GET['minRange'];
					    			$maxVal = $_GET['maxRange'];
					    		}else{
					    			$minVal = 100;
					    			$maxVal = 900;
					    		}
					    	?>
							<div class="value-label pull-right">
								<span class="text-color min-val">$<?php echo $minVal; ?></span> - 
								<span class="text-color max-val">$<?php echo $maxVal; ?></span>
							</div>
					      </h4>
					    </div>
					    <div id="collapseTwo" class="panel-collapse collapse in">
					      <div class="panel-body">
					        <div class="form-group">
						    	<div class="slider-part-wrapper price-slider">
									<input type="text" class="sl1" value="" data-slider-min="100" data-slider-max="1000" data-slider-step="5" data-slider-value="<?php echo $value; ?>" id="sl1"/>
							    	<input type="hidden" name="minRange" value="<?php echo $minVal; ?>"/>
							    	<input type="hidden" name="maxRange" value="<?php echo $maxVal; ?>"/>
							    </div>
						    </div>
					      </div>
					    </div>
					  </div>
					  <div class="panel panel-default">
					    <div class="panel-heading">
					      <h4 class="panel-title">
					      	<?php
					    		$valLength = 1;
					    		if(isset($_GET['dLength']) && !empty($_GET['dLength'])){
					    			$valLength = $_GET['dLength'];
					    		}
					    	?>
					        <a data-parent="#accordion" href="#collapseThree">
					          Less than <span class="text-color length-val">All</span> characters 
					        </a>
					      </h4>
					    </div>
					    <div id="collapseThree" class="panel-collapse collapse in">
					      <div class="panel-body">
					      	<div class="form-group slider-by-length">
						        <div class="slider-part-wrapper">
							    	
							    	<input type="text" class="sl2" value="" data-slider-min="1" data-slider-max="20" data-slider-step="1" data-slider-value="<?php echo $valLength; ?>" id="sl2"/>
							    	<input type="hidden" name="dLength" id="dLenght" value="<?php echo $valLength; ?>"/>
							    </div>
							</div>
					      </div>
					    </div>
					  </div>
					  <div class="panel panel-default cat-panel">
					    <!-- <div class="panel-heading">
					      <h4 class="panel-title">
					        <a data-parent="#accordion" href="#collapseFour">
					          <i class="fa fa-chevron-circle-right"></i> Category
					        </a>
					      </h4>
					    </div> -->
					    <div id="collapseFour" class="panel-collapse collapse in">
					      <div class="panel-body">
					        <div class="form-group">
						    	<?php
									$categories = get_terms('domain-category', array(
									 	'hide_empty' => 0
									));
								?>
						        <select class="selectCategory" name="category" id="category">
						        	<option value="0">Filter by Category</option>
						        	<?php foreach ($categories as $key => $value) { ?>
						        		<?php
						        			$selectedOption = "";
						        			if(isset($_GET['category']) && !empty($_GET['category'])){
						        				if($_GET['category'] == $value->term_id){
						        					$selectedOption = "selected='selected'";
						        				}
						        			}
						        		?>
						        		<option <?php echo $selectedOption; ?> value="<?php echo $value->term_id; ?>"><?php echo $value->name; ?></option>
						        	<?php } ?>
								</select>
						    </div>
					      </div>
					    </div>
					  </div>
					</div>
				</form>
				</div>
				<div class="left-sidebar-wrapper">
					<div class="list-group">
					  <a href="#" class="list-group-item active">
					    Most Searched Domains
					  </a>
					  <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span>Colorfury.com</a>
					  <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span>Biocrime.com</a>
					  <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span>Bakeport.com</a>
					  <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span>Arcscape.com</a>
					  <a href="#" class="list-group-item"><span class="glyphicon glyphicon-hand-right"></span>Colorfury.com</a>
					</div>
				</div>

			</div>
			<div class="col-xs-9" style="padding-left:0px;">
				<div class="col-xs-12">
					<div class="form-group sortby-items">
						<label for="sortby">Sort by:</label>
						<ul class="sorting_options">
							<li>
								<a class="sortitem" data-sort-order="Desc" data-sort="date" href="#">
									<span class="glyphicon glyphicon-calendar"></span> Date
									<div class="sort-icon-wrapper">
										<i class="fa fa-sort-desc"></i>
									</div>
								</a>
							</li>
							<li>
								<a class="sortitem" data-sort-order="Desc" data-sort="title" href="#">
									Alphabetically
									<div class="sort-icon-wrapper">
										<i class="fa fa-sort-asc disable-icon"></i>
									</div>
								</a>
							</li>
							<li>
								<a class="sortitem" data-sort-order="Desc" data-sort="price" href="#">
									<span class="glyphicon glyphicon-usd"></span> Price
									<div class="sort-icon-wrapper">
										<i class="fa fa-sort-asc disable-icon"></i>
									</div>
								</a>
							</li>
						</ul>
						<div class="arrow_move_wrapper" style="left:108px;">
							<img src="<?php echo get_bloginfo('template_directory'); ?>/img/notch._V401960254_.png">
						</div>
						<!-- <select id="sortBy_list">
			        		<option value="title">Alphabetically</option>
			        		<option value="dateAsc">Date added (oldest to newest)</option>
			        		<option value="dateDesc" selected="selected">Date added (newest to oldest)</option>
			        		<option value="priceDesc">Price (highest to lowest)</option>
			        		<option value="priceAsc">Price (lowest to highest)</option>
			        	</select> -->
			        </div>
				</div>
				<div class="main-container-wrapper">
					<?php
						$curpage = get_query_var('paged') ? get_query_var('paged') : 1;
					    $args = array(
					    	'post_type' => 'domain',
					    	'paged' => $paged,
					    	'posts_per_page' => PAGINATION_LIMIT,
					    );
					    $wp_query = new WP_Query($args);
					    $page = get_page_by_path('inquire-about-a-domain');
					    $enquiry_page = $page->ID;
					    while ($wp_query->have_posts()) : $wp_query->the_post();
					    	$price = get_post_meta(get_the_ID(),'price',true);
					    	$term_list = wp_get_post_terms(get_the_ID(), 'domaintype', array("fields" => "ids"));
					?>
							<div class="col-xs-4">
								<div class="domain-section">
									<article>
										<h3><?php echo strtolower(get_the_title()); ?></h3>
										<div class="btn_section">
											<div class="left-section">
												<?php $buyButton = "Buy now"; if(!empty($price)) { $buyButton = "Buy now at $".$price; } ?>
												<a class="btn btn-default btn-xs custom-btn-style" href="#"><?php echo $buyButton; ?></a>
											</div>
											<div class="right-section">
												<a href="<?php echo home_url(); ?>?page_id=<?php echo $enquiry_page; ?>&d=<?php echo get_the_ID(); ?>" class="btn btn-default btn-xs custom-btn-style">Submit an offer</a>
											</div>
										</div>
									</article>
								</div>
							</div>
					<?php
						endwhile;
					?>
					<div class="col-xs-12 text-right pagination_wrapper no-padding">
						<?php $pagedUrl = home_url().'?paged='; ?>
		            	<div id="wp_pagination">
		            		<a class="previous page button" href="<?php echo $pagedUrl.(($curpage-1 > 0 ? $curpage-1 : 1)); ?>">&lsaquo;</a>
				            <?php for($i=1;$i<=$wp_query->max_num_pages;$i++){ ?>
				                	<a class="<?php echo ($active = $i == $curpage ? 'active ' : ''); ?>page button" href="<?php echo $pagedUrl.($i); ?>"><?php echo $i; ?></a>
				            <?php } ?>
		            		<a class="next page button" href="<?php echo $pagedUrl.(($curpage+1 <= $wp_query->max_num_pages ? $curpage+1 : $wp_query->max_num_pages)); ?>">&rsaquo;</a>
		            	</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(function(){
			$(document).on('click','.ajax_pagination a',function(e){
				e.preventDefault();
				var page = $(this).data('page');
				$('#paged').val(page);
				submitForm();
			});

			//$('.slider-track div:nth-child(2)').css('left','6%');
		})
		function submitForm(){
			//$('#searchform').submit();
			$('.ajax_load_wrapper').css('display','block');
			var url = "<?php echo home_url(); ?>"+'/wp-admin/admin-ajax.php?action=filter_domains';
			 $.ajax({
			 	type: "POST",
			 	url: url,
			 	data: $("#searchform").serialize(),
			 })
	   		.done(function( msg ) {
	     		$('.main-container-wrapper').html(msg);
	     		$('.ajax_load_wrapper').css('display','none');
	   		});
		}
	</script>
<?php get_footer(); ?>