		<div id="tab_0_content" class="tab_0 tab_content grid_container grid_container_mr_300" style="display:none;">
			<div class="grid_container grid_container_feed" id="grid_container_feed3">
				<!-- <div id="tabs_content">	 -->

						<?php
						$name = "'name'";
						$html = "'html'";
						for ($i=1; $i<25; $i++)
						{
						echo '
									<div class="hdiv">
										<div class="grid_container_card_large grid_container_card grid_container">
											<div class="grid_container header">
												<div class="title grid_container">Title</div>
												<div class="user grid_container">User</div>
											</div>
											<div class="pic grid_container">Pic '.$i.'
												<div id="srv_'.$i.'" class="box2 grid_container" name="srv_'.$i.'" onclick="open_service_view_tab(this.attributes['.$name.'].value, '.$html.')">0
													<div class="lng_services grid_container">
													</div>
												</div>
											</div>
											<div class="desc grid_container">Description</div>
											<div class="cat grid_container">Categorization</div>
											<div class="details1 grid_container">Details1</div>
											<div class="details2 grid_container">Details2</div>
											<div class="grid_container thumbs_read">
												<div class="thumbnails grid_container">Thumbnails</div>
												<div class="call_to_action grid_container">Read</div>
											</div>
										</div>
									</div>
						';
						}
						?>
				<!-- </div> -->
			</div>
		</div>