<?php /* 
*	fetch json
*	<?php $this->renderPartial('/matchTable/motivated_sellers'); 
?>
*	Create secure path for error handling and https: They can use it
*/
?>

<!--
<div class="span12 row-fluid">
	<div class="span3 pull-right">
		<h2>Location</h2>
		<div id="map">
		Google Maps of Renturly
		</div
	</div>
</div>
-->

<script type="text/javascript">
	mixpanel.identify("<?php echo Yii::app()->user->email; ?>");
	mixpanel.track("Dogging Near Me",{
			referrer: document.referrer,
			fistfuls_of_cash: <?php echo Yii::app()->user->countmatches;?>,
		});
</script>



