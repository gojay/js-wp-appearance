<?php include 'header.php'; ?>

<?php include 'includes/functions.php'; ?>

<?php $availablewidgets = getAvailableWidgets(); ?>

	<div class="row-fluid">
		<!-- sidebar -->
		<?php include 'sidebar.php' ?>
		<!-- sidebar -->

		<!-- content -->
		<div class="span10">
			<div id="widgets" class="row-fluid">
				<!-- Available Widget -->
				<div id="widgets-left" class="span9 portlet widgets-column">
					<div class="portlet-header">
						<h3>Available Widgets
							<span id="removing-widget" style="display: none;">
								Deactivate
								<span></span>
							</span>
						</h3>
					</div>
					<div class="spn12 portlet-inside" style="display: block;">
						<div id="available-widget" class="widget-holder">	
							<div class="info">
								<p>Drag widgets from here to a sidebar on the right to activate them.<br/> 
								Drag widgets back here to deactivate them and delete their settings</p>
							</div>
							<!-- =================
								AVAILABLE SIDEBAR
							====================== -->
						
							<?php 
							if( $availablewidgets ) : 
								/**
								 * looping available sidebar
								 */
								foreach($availablewidgets as $widget) 
								{
									/**
									 * variabel count : jumlah widget value + 1
									 * untuk multi widget
									 * set value $count pada input tipe hidden class multi
									 */
									$data = isset($widget['data']) ? count($widget['data']) : 0 ;
									$multiCount = $data + 1; 
									include 'partials/loop-widget.php';
								} 
							
							else :
								echo 'empty';
							endif; ?>

						</div>
					</div>	
				</div>
				<!-- /available widget -->

				<!-- Register Widget -->
				<div id="widgets-right" class="span3 widgets-column">
					
					<?php foreach( getWidgets() as $widget_title => $widget_data ) : ?>
						<div class="widget-holder-wrap portlet">
							<div class="portlet-header">
								<h3>
									<?php 
									// buat title header
									list( $w, $n ) = explode('_', $widget_title, 2);
									$title = str_replace('_', ' ', $n);
									echo ucwords($title); 						
									?>
									<span>
										<img class="ajax-loader-widget" src="images/ajax_spin.gif"/>
									</span>
								</h3>
							</div>
							<div class="widget-content portlet-inside" style="display: block;">
								<div id="<?php echo $widget_title ?>" class="widgets-sortables">
								<?php 
								if( $widget_data ) :
									foreach( $widget_data as $register_widget ) 
									{ 
										/**
										 * pisahkan value "-" : [nama_widget]-[posisi_widget]
										 * partial widget : [nama_widget] sbg ARRAY KEY dari widgets
										 * partial pos : [posisi_widget]
										 */
										list($widget_name, $widget_position) = explode('-', $register_widget);
										/**
										 * widget id : preffix.id-pos
										 * example : widget_1-1	
										 */
										$widget_id = sprintf('widget_%d-%d', $widget['id'], $this->widget_position); 
										// widget
										$widget = $availablewidgets[$widget_name];
										// widget value = widget data index position
										$widget_value = $availablewidgets[$widget_name]['data'][$widget_position]; 
										echo $this->partial('partials/loop-widget.phtml', array(
													'widget' => $widget,
													'widget_id' => $widget_id,
													'widget_value' => $widget_value,
										)); 
									} 
								endif;
								?>
								</div>
							</div>	
						</div>	
					<?php endforeach; ?>
					
				</div>
				<!-- /Register Widget -->
		  </div>
		</div>
		<!-- /content -->

	</div><!--/row-->

<?php include 'footer.php' ?>