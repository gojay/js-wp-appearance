<div id="<?php echo $widget['id']; ?>" class="span4 portlet">
	<div class="portlet-header">
		<h4><?php echo $widget['title']; ?>
			<span class="widget-name"><?php if(isset($widget_value['title'])) echo ':'.$widget_value['title']; ?></span>
		</h4>
	</div>
	<div class="portlet-description" style="height:50px"><?php echo $widget['description']; ?></div>
	<div class="portlet-inside hide">
		<div class="portlet-form">
			<form action="#">
				<div class="control-group">
					<label for="title">Title</label>
					<input type="text" name="title" id="title" class="span12" value="<?php if(isset($widget_value['title'])) echo $widget_value['value'] ?>" />
				</div>

				<?php 
				if( $attrbs = $widget['attrbs'] ) : ?>
				<div class="control-group">	
					<?php
					$type = $attrbs['type'];
					switch ($attrbs['element']) {
						// attribut input text	
 						case 'text': 
							$label = ( $type == 'count' ) ? 'Number of '.$widget['title'].' to show : ' : $attrbs['label']; ?>
							<label for="value"><?php echo $label ?></label>
							<input type="text" name="value" id="value" class="span12" value="<?php if(isset($widget_value['title'])) echo $widget_value['value'] ?>" />
							<?php 
							break;
						// attribut input textarea				
						case 'textarea': ?>
							<textarea name="value" id="value" class="span12" rows="5"><?php if(isset($widget_value['title'])) echo $widget_value['value'] ?></textarea>
							<?php
							break;
					} 
					?>
				</div>
				<?php endif; ?>

				<div class="control-group">
					<div class="alignleft" style="padding:0.5em">
						<a class="widget-control-remove" href="#remove">Delete</a> |
						<a class="widget-control-close" href="#close">Close</a>
					</div>
					<div class="alignright">
						<img class="ajax-loader-widget" src="images/ajax_spin.gif"/>
						<input type="submit" class="widget-control-save ui-button ui-widget ui-state-default ui-corner-all" value="Save" />
					</div>
				</div>
				<?php 
				/**
				 * 
				 * available widgets
				 * untuk multi widget
				 * set value $multiCount pada input tipe hidden class multi
				*/
				if( $multiCount ) : ?>
				<!-- [IMPORTANT] multi widget, set value count widget value -->
				<input type="hidden" class="multi" name="multi" value="<?php echo $multiCount; ?>" />
				<!-- [IMPORTANT] add widget, input hidden class add value TRUE -->
				<input type="hidden" class="add" name="add" value="true" />
				<?php endif; ?>
			</form>
		</div>
		<div class="clearfix"></div>
	</div>
</div>