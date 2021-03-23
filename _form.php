<?php
/* @var $this buyerController */
/* @var $model buyer */
/* @var $form CActiveForm */

if (!function_exists('array_replace'))
{
	function array_replace( $array, $array1 )
	{
		$args = func_get_args();
		$count = func_num_args();

		for ($i = 0; $i < $count; ++$i) {
			if (is_array($args[$i])) {
				foreach ($args[$i] as $key => $val) {
					$array[$key] = $val;
				}
			}
			else {
				trigger_error(
				__FUNCTION__ . '(): Argument #' . ($i+1) . ' is not an array',
				E_USER_WARNING
				);
				return NULL;
			}
		}

		return $array;
	}
}

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/themes/abound/css/birds-of-a-feather-modal.css');

	//put a spinning load wheel until page loads
	Yii::app()->clientScript->registerScript('loader1',"

		//$( window ).unload(function() {
		
		//$('.btn-warning').click(function() {
		
//When clicking on a button, it shows the loader

    $('.btn-warning').on('click', function(){

					$('.form').hide();
					$('body').addClass('birdsOfAFeatherModal');
					$('#birdsOfAFeatherModal').show();
					$('footer').css('display','none');
					$('section#navigation-main').hide();
					$('.modal-header').hide();
					$('.modal-body').hide();
				
		});
		

		
		$('.btn btn-warning').bind('touchstart click', function(e){
			
					$('.form').hide();
					$('body').addClass('birdsOfAFeatherModal');
					$('#birdsOfAFeatherModal').show();
					$('footer').css('display','none');
					$('section#navigation-main').hide();
					$('.modal-header').hide();
					$('.modal-body').hide();
					$( '#buyer-survey-form' ).submit();
			
		});
		
		$('.btn-warning').bind( 'touchend', function(e){
			
			//setTimeout(function () {

				//window.location.href= 'https://www.accesstheflock.io/birds-of-a-feather'; // the redirect goes here
				   	
			//}, 3000); //29 //13 seconds
		
				$('.form').show();
				$('section#navigation-main').css('display','unset');
				$('footer').css('display','unset');
				$('.modal-header').show();
				$('#birdsOfAFeatherModal').hide();
				//$('#birdsOfAFeatherModal').css('display','unset');;
				$('body').removeClass('birdsOfAFeatherModal');
				
		});
		
		
		$(window).load(function() {
		
				$('section#navigation-main').css('display','unset');
				$('footer').css('display','unset');
				$('.modal-header').show();
				$('#birdsOfAFeatherModal').hide();
				//$('#birdsOfAFeatherModal').css('display','unset');;
				$('body').removeClass('birdsOfAFeatherModal');
				
		});
			
	");

?> 	
		
<style>
.centerModal {
  border: 16px solid gold;
  border-radius: 50%;
  border-top: 16px solid black;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<style>
 .renturly {
   color: #5dbcd2;
   background-color: transparent;
}

.gold {
	color: gold;
}

a:active, a:hover {
	color: gold;
}

</style>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<div id="birdsOfAFeatherModal" class="birdsOfAFeatherModal">
	
		<div class="centerModal"></div>
		<br>
		<br>
		<?php
			//$key="Renturly.AccessTheFlockLoading.Image";
			//if($this->beginCache($key,array('duration'=>300)))
			//{
				$baseUrl = Yii::app()->theme->baseUrl; 
				echo CHtml::image("$baseUrl/img/Access The Flock Loading.jpg","Loading Access to the Flock...",array("width"=>"","class"=>"upperModal"));
				
				//$this->endCache();
			//}
		?>
	
		

	</div><!-- End BirdsOfAFeatherModal -->
		

<!--  <h1>Access a Seller</h1> -->
<h1>Pay The Bird Dog <a class="renturly" href="http://accesstheflock.io/sellers-list">Renturly</a></h1>

<script>
	let listing = document.referrer;
	document.write("<br><p>If you forgot your inputs click <a href='" + listing + "'>..POF Amount</a></p>");
</script>

	
	<div class="form span12 well row-fluid">

	
	
	<?php if($this->action->id == 'update'): ?>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'buyer-survey-form',
		'action'=>Yii::app()->createAbsoluteUrl('/buyer/update',array('id'=>$id)),
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>
	<?php endif; ?>
	
	<?php if($this->action->id == 'create' || $this->action->id == 'interview'): ?>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'buyer-survey-form',
			
		'action'=>Yii::app()->createAbsoluteUrl('/buyer/create'),
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>

	<?php endif; ?>
	
	<!-- <h2><span class="badge">1</span> Buyer's Information</h2> -->	
	<h2><span class="badge">1</span> Cash Buyer</h2>
	<p>This Fistfuls of Cash is used to match you with the highest quality motivated sellers for you to <a href="https://www.facebook.com/accesstheflock">close deals</a> with. The more Fistfuls of Cash you bring me, the more of the Flock you get to Access.</p>	
	
	<?php echo $form->errorSummary(array($model)); ?>
		
		
	<p class="note">Fields with <span class="required">*</span> are required.</p>	
	<div class="row-fluid">
	<div class="span12 well">
		
		<!--  
		<div class="span4">

			
			<?php //echo $form->labelEx($model,'allowed_commission'); ?>
					<?php //echo $form->error($model,'allowed_commission'); ?>
					<div class="row input-prepend input-append">
					<?php //echo $form->textField($model,'allowed_commission',array('size'=>6,'maxlength'=>6)); ?><span class="add-on">%</span>
			
		</div>
		</div>
		 -->
		
		<div class="span4">		

		
			<?php echo $form->labelEx($model,'pof_amount'); ?>
			<?php echo $form->error($model,'pof_amount'); ?>
			<div class="row input-prepend input-append">	
				<span class="add-on" style="position: relative; top: +3px;">$</span><?php echo $form->textField($model,'pof_amount',array('size'=>16,'maxlength'=>16)); ?><span class="add-on" style="position: relative; top: +3px;">.00</span>
				
			</div>
			
		</div>
		
		<div class="span4"></div>
	</div>

		</div>
	
	<h2>What is the buyer's order?</h2>	

	<div class="row-fluid">
	<div class="span8 well">
	<h5><span class="badge">2</span> Asset types that this buyer is ordering</h5>
		<?php
		$this->widget (
      'ext.clonnableFields.ClonnableFields',
      array (
          'models'=>$model->types_looking, //required, one to many model relation or array

          'rowGroupName'=>'TypesLooking', //required, all fields will be with this key number
          'startRows'=>1, //optional, default: 1 - The number of rows at widget start
          'labelsMode'=>1, //optional, default: 1 - (0 - never, 1 - always, 2 - only if rows exist)
		  'addButtonLabel' => "<i class='icon-plus'></i> Add a type of asset to this buyer's order", //optionall, default: "Add"
		  'removeButtonLabel' => '<i class="icon-remove"></i>', //optional, default: "Remove"
		  'removeButtonHtmlOptions' => array('class'=>'pull-right'), //optional
          'fields'=>array( //required
              array
              (
                  'label'=>array(
                      'title'=>'Asset Type',
                  ),
					'field'=>array( //required
							'class'=>'TemplateSelectField', //required.
							'attribute'=> 'building_type', //required, model attribute or field name
							'htmlOptions'=>array('class'=>'span12', 'maxlength'=>'128'), //optional
							'data'=>array_replace(CHtml::listData(BuildingType::model()->findAll(), 'id', 'type')),
							'params'=>array( //optional
									'asDropDownList'=>true,
							),
							'emptytext'=>'Yes',
					),
				  'fieldHtmlOptions' => array('class'=>'span3'),
              ),
              
		),
	)
  ); ?>
  
 	</div>
 	
 	<div class="span4 well">
		<h5><span class="badge">3</span> Locations this buyer is ordering</h5>
		<?php
		$this->widget (
				'ext.clonnableFields.ClonnableFields',
				array (
						'models'=>$model->where_looking, //required, one to many model relation or array
		
						'rowGroupName'=>'WhereLooking', //required, all fields will be with this key number
						'startRows'=>1, //optional, default: 1 - The number of rows at widget start
						'labelsMode'=>1, //optional, default: 1 - (0 - never, 1 - always, 2 - only if rows exist)
				  'addButtonLabel' => "<i class='icon-plus'></i> Add a location to this buyer's order", //optionall, default: "Add"
				  'removeButtonLabel' => '<i class="icon-remove"></i>', //optional, default: "Remove"
				  'removeButtonHtmlOptions' => array('class'=>'pull-right'), //optional
						'fields'=>array( //required
								array
								(
										'label'=>array(
												'title'=>'Location (Country Name For Nationwide)',
										),
										'field'=>array(
												'class'=>'TemplateTextField',
												'attribute'=>'location',
												'htmlOptions'=>array('id'=>'location','class'=>'span12 location'),
										),
										'fieldHtmlOptions' => array('class'=>'span7'),
								),
								array
								(
										'label'=>array(
												'title'=>'Radius (in miles)',
										),
										'field'=>array(
												'class'=>'TemplateNumberField',
												'attribute'=>'radius',
												'htmlOptions'=>array('class'=>'span12'),
										),
										'fieldHtmlOptions' => array('class'=>'span3'),
								),
						),
				)
		  ); ?>
	</div>
 	
	</div>
	
	
	
			
			

	
	
 	

<!-- 
	<div class="well">
		<h5><span class="badge">9</span> Notify me when all of these are matched: </h5>
		<div class="row-fluid">
			<div class="span12">
			<h6> Portfolio & Asset Attributes: </h6>
				<div class="row span2">
			        <?php echo $form->labelEx($model,'affordable_portfolios'); ?>
			        <?php echo $form->checkBox($model,'affordable_portfolios'); ?>
			        <?php echo $form->error($model,'affordable_portfolios'); ?>
			    </div>
			

			
			    <div class="row span2">
			        <?php echo $form->labelEx($model,'assets_location'); ?>
			        <?php echo $form->checkBox($model,'assets_location'); ?>
			        <?php echo $form->error($model,'assets_location'); ?>
			    </div>
			
			    <div class="row span2">
			        <?php echo $form->labelEx($model,'asset_types'); ?>
			        <?php echo $form->checkBox($model,'asset_types'); ?>
			        <?php echo $form->error($model,'asset_types'); ?>
			    </div>
			    
			    <div class="row span2">
			        <?php echo $form->labelEx($model,'cap_rate'); ?>
			        <?php echo $form->checkBox($model,'cap_rate'); ?>
			        <?php echo $form->error($model,'cap_rate'); ?>
			    </div>
			
				    <div class="row span2">
			        <?php echo $form->labelEx($model,'portfolio_commission'); ?>
			        <?php echo $form->checkBox($model,'portfolio_commission'); ?>
			        <?php echo $form->error($model,'portfolio_commission'); ?>
			    </div>
			    
			

			</div>
		</div>
	
		<div class="row-fluid">
			<div class="span12">
			<h6> Property & Unit Type Attributes: </h6>
						    <div class="row span2">
			        <?php echo $form->labelEx($model,'investment_strategies'); ?>
			        <?php echo $form->checkBox($model,'investment_strategies'); ?>
			        <?php echo $form->error($model,'investment_strategies'); ?>
			    </div>
			    
						    <div class="row span2">
			        <?php echo $form->labelEx($model,'building_types'); ?>
			        <?php echo $form->checkBox($model,'building_types'); ?>
			        <?php echo $form->error($model,'building_types'); ?>
			    </div>
			
						    <div class="row span2">
			        <?php echo $form->labelEx($model,'affordable_properties'); ?>
			        <?php echo $form->checkBox($model,'affordable_properties'); ?>
			        <?php echo $form->error($model,'affordable_properties'); ?>
			    </div>
			

			
			    <div class="row span2">
			        <?php echo $form->labelEx($model,'property_commission'); ?>
			        <?php echo $form->checkBox($model,'property_commission'); ?>
			        <?php echo $form->error($model,'property_commission'); ?>
			    </div>
			
			    <div class="row span2">
			        <?php echo $form->labelEx($model,'property_location'); ?>
			        <?php echo $form->checkBox($model,'property_location'); ?>
			        <?php echo $form->error($model,'property_location'); ?>
			    </div>
			    
			    <div class="row span2">
			        <?php echo $form->labelEx($model,'unit_types'); ?>
			        <?php echo $form->checkBox($model,'unit_types'); ?>
			        <?php echo $form->error($model,'unit_types'); ?>
			    </div>
			</div>
		</div>
	</div>
	 -->		
	<div class="row">    	   	 <?php
	//echo CHtml::submitButton('Save!', array('class'=>'btn btn-warning'));
	echo CHtml::submitButton('Fistfuls of Cash', array('class'=>'btn btn-warning'));

		?>
	</div>
		</div><!-- form -->
	<?php $this->endWidget(); ?>
	<script src='http://maps.googleapis.com/maps/api/js?v=3&amp;libraries=places&key=AIzaSyC52smVFMzjARDZ4kq-b1nWl5oKZdHuGYk'></script>
	<script type="text/javascript">
	$("#Buyer_buyer_code").tooltip();
	// $('input.location').appear();
	$( "body" ).on( "keyup", "input.location",  function(event, inputs) {
		// inputs.each(function() {
			$(this).geocomplete();

			if($(this).attr('id').indexOf("WhereLooking") >= 0)
			{
				$(this).attr("required","required");
			}

	    // });
	});
	</script>
	
	<script>
		//fixed javascript geocomplete()
		const location = document.getElementById("location");
		
		location.keyup = javascript;
		function javascript()
		{
			location.geocomplete();
		}
	</script>
</div>
