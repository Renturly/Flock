<?php
/* @var $this ListingController */
/* @var $portfolio Listing */
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
	
	
    $('.btn-info').on('click', function( e ){
    

    		e.preventDefault();

			$(location).attr('href', 'https://www.accesstheflock.io/birds-of-a-feather');
		
				$('.form').hide();
				$('body').addClass('birdsOfAFeatherModal');
				$('#birdsOfAFeatherModal').show();
				$('footer').css('display','none');
				$('section#navigation-main').hide();
				$('.modal-header').hide();
				$('.modal-body').hide();
		
		});
		
		$('.btn-info').bind('touchstart click', function(e){
		
					$('.form').hide();
					$('body').addClass('birdsOfAFeatherModal');
					$('#birdsOfAFeatherModal').show();
					$('footer').css('display','none');
					$('section#navigation-main').hide();
					$('.modal-header').hide();
					$('.modal-body').hide();
					$( '#portfolio-form' ).submit();
					
		});
		
		$('.btn-info').bind( 'touchend', function(e){
		
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

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<div id="birdsOfAFeatherModal" class="birdsOfAFeatherModal">
	
		<div class="centerModal"></div>
		
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

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'portfolio-form',
    'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    'enableAjaxValidation'=>false,// This is required for file upload
    )); 
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	
?>
<?php echo CHtml::beginForm(); ?>
<?php echo CHtml::errorSummary(array($portfolio)); ?>



<!-- <h1>Access a Buyer</h1> -->

<h1>Pay The Bird Dog <a class="gold" href="http://accesstheflock.io/buyer/list">Fistfuls of Cash</a></h1>

<script>
	let listing = document.referrer;
	document.write("<br><p>If you forgot your inputs click <a href='" + listing + "'>..POF Amount</a></p>");
</script>

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


<div class="row-fluid">
	<div class="span6 well">
	<!-- <h2>Seller's Information</h2> -->
	<h2>Motivated Seller</h2>
		<p>This Fistfuls of Cash is used to match you with the highest quality cash buyers for you to <a href="https://www.facebook.com/accesstheflock">close deals</a> with. The more Fistfuls of Cash you bring me, the more of the Flock you get to Access.</p>

						<div class="pull-left">
				<div class="row">
					<?php echo $form->labelEx($portfolio,'min_dollar'); ?> 
					<div class="row input-prepend input-append"> 
						<span class="add-on" style="position: relative; top: +3px;" >$</span><?php echo $form->textField($portfolio,'min_dollar',array('size'=>18,'maxlength'=>18, 'class'=>'span7')); ?><span class="add-on" style="position: relative; top: +3px;">.00</span><?php echo $form->error($portfolio,'min_dollar'); ?>
					</div>
				</div>
			
			<div>
			
			<div class="row pull-right">
									<?php
						$key="Renturly.UrlyFlying3.Image";
						if($this->beginCache($key,array('duration'=>300)))
						{
				$baseUrl = Yii::app()->theme->baseUrl; 
				echo CHtml::image("$baseUrl/img/the-urly-bird-flying.png","The Urly Bird Gets The Worm!");
				$this->endCache();
						}
				?>
			</div>
			
				<div class="row pull-left">
					<?php echo $form->labelEx($portfolio,'cap_rate'); ?><div class="row input-prepend input-append">
					<?php echo $form->textField($portfolio,'cap_rate',array('size'=>18,'maxlength'=>2)); ?><span class="add-on" style="position: relative; top: +3px;">%</span>
					<?php echo $form->error($portfolio,'cap_rate'); ?>
				</div>
			</div>
				
			<div>
			
			<!--  
				<div class="row pull-left">
					<?php //echo $form->labelEx($portfolio,'discount'); ?><div class="row input-prepend input-append">
					<?php //echo $form->textField($portfolio,'discount',array('size'=>18,'maxlength'=>2)); ?><span class="add-on" style="position: relative; top: +3px;">%</span>
					<?php //echo $form->error($portfolio,'discount'); ?>
				</div>
			</div>
			 -->	

			</div>

		<!-- 
		<div class="row">
		
					<div class="pull-left">
				<?php //echo $form->labelEx($portfolio,'seller_code'); ?>
				<?php //echo $form->textField($portfolio,'seller_code',array('size'=>60,'maxlength'=>60,'class'=>'span6','title'=>'Keep your sellers confidential to eliminate circumvention.')); ?>
				<?php //echo $form->error($portfolio,'seller_code'); ?>
			</div>
		</div>
		 -->
		
		<!-- 
		<div class="row">
			<div class="pull-left">
				<?php //echo $form->labelEx($portfolio,'name'); ?>
				<?php //echo $form->textField($portfolio,'name',array('size'=>60,'maxlength'=>60)); ?>
				<?php //echo $form->error($portfolio,'name'); ?>
			</div>
			
			<!-- 
						<div class="pull-right">
				<?php //echo $form->labelEx($portfolio,'relation_to_seller'); ?>
				<?php //echo $form->dropDownList($portfolio,'relation_to_seller',$portfolio->getRelationToSellerOptions()); ?>
				<?php //echo $form->error($portfolio,'relation_to_seller'); ?>
			</div>
			
		</div>
		 -->

		<!-- 
		<div class="row">
		
			<!-- 
				<div class="pull-left">
				<div class="row">
					<?php //echo $form->labelEx($portfolio,'commission'); ?><div class="row input-prepend input-append">
					<?php //echo $form->textField($portfolio,'commission',array('size'=>6,'maxlength'=>6)); ?><span class="add-on">%</span>
					<?php //echo $form->error($portfolio,'commission'); ?>
				</div>
				</div>
			
			</div>
			
			
			<!-- 
			<div>
				<div class="row pull-left">
					<?php //echo $form->labelEx($portfolio,'cash_flow'); ?><div class="row input-prepend input-append">
					<span class="add-on">$</span><?php //echo $form->textField($portfolio,'cash_flow',array('size'=>5,'maxlength'=>5)); ?><span class="add-on">.00</span>
					<?php //echo $form->error($portfolio,'cash_flow'); ?>
				</div>
				</div>
			 	

			</div>
		 -->	
			<!-- Min Dollar -->

				

			<!-- </div> 
			
		
			

		</div>
		-->


	</div>
		<?php
		/*
		$key="Renturly.UrlyFlying3.Image";
		if($this->beginCache($key,array('duration'=>300)))
		{
$baseUrl = Yii::app()->theme->baseUrl; 
echo CHtml::image("$baseUrl/img/the-urly-bird-flying.png","The Urly Bird Gets The Worm!");
$this->endCache();
		}
		*/
?>
<br>
					<?php
						$key="Renturly.TheWorm.Image";
						if($this->beginCache($key,array('duration'=>300)))
						{
							$baseUrl = Yii::app()->theme->baseUrl; 
							echo CHtml::image("$baseUrl/img/the-worm.png","The Urly Bird Gets The Worm!");
							$this->endCache();
						}
					?>
</div>
	




<?php Yii::app()->clientScript->registerScript('geo1Complete', "$('.location').geocomplete()");

?>

<div class="row-fluid">
	<div class="span12 well">
	<h5>Asset Types</h5>
		<?php
		$this->widget (
      'ext.clonnableFields.ClonnableFields',
      array (
          'models'=>$portfolio->asset_types, //required, one to many model relation or array

          'rowGroupName'=>'AssetType', //required, all fields will be with this key number
          'startRows'=>1, //optional, default: 1 - The number of rows at widget start
          'labelsMode'=>1, //optional, default: 1 - (0 - never, 1 - always, 2 - only if rows exist)
		  'addButtonLabel' => '<i class="icon-plus"></i> Add a type of asset to this portfolio', //optionall, default: "Add"
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
								'htmlOptions'=>array('class'=>'span12 location'),
                    //),//array('class'=>'span12 location'),
						),
						'fieldHtmlOptions' => array('class'=>'span4'),
				), 
      
      			array
	              (
	                  'label'=>array(
	                      'title'=>'Asset Type',
	                  ),
						'field'=>array( //required
								'class'=>'TemplateSelectField', //required.
								'attribute'=>'asset_type', //required, model attribute or field name
								'htmlOptions'=>array('class'=>'span12', 'maxlength'=>'128'), //optional
								'data'=>CHtml::listData(BuildingType::model()->findAll(), 'id', 'type'),
								'params'=>array( //optional
										'asDropDownList'=>true,
								),
						),
					  'fieldHtmlOptions' => array('class'=>'span4'),
	              ),
	              
          ),
      )
  ); ?>
	</div>
</div>



	<div class="row">    	   	 <?php
	//echo CHtml::submitButton('Save!', array('class'=>'btn btn-warning'));
	echo CHtml::submitButton('Renturly', array("class"=>"btn btn-info", "id"=>"payment-button"));

		?>
	</div>
	<div class="row"><br></div>
</div>
</div>

	




<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>
</div><!-- form -->




	<script src='http://maps.googleapis.com/maps/api/js?v=3&amp;libraries=places&key=AIzaSyC52smVFMzjARDZ4kq-b1nWl5oKZdHuGYk'></script>

	<script type="text/javascript">

	//$("#yw0_AssetType_0_location").removeAttr("required");
	
	$("#Portfolio_seller_code").tooltip();
	// $('input.location').appear();
	// $( "input.location" ).on( "appear", function(event, inputs) {

	// 	inputs.each(function() {

	// 		$(this).geocomplete();
	// 		$(this).attr("required","required");
			
	// 	 });
	// });

	
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



 
