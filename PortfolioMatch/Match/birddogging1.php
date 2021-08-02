<?php /* 
*	Write the code with securing the  views for Error Handling: console.log(): limit size of process: $_POST log(1) REQUEST
*	<?php $this->renderPartial('/matchTable/birddogging'); 
?>
*	The view appears in for error handling and https: They can use it
*/
?>

<style>
/*	
*The Golden Egg Renturly
*/
#PayTheBirdDog {
	border-color: gold;
	position: fixed;
	background-color: white;
	bottom: 0;
}
.ok {
	color: pink;
}
.fistfuls {
	padding: 10px;
	margin: 5px;
	border: gold;
	color: #5dbcd2;
}
.gold {
	color: silver;
}
.Trillionaire {
	background-color: gold;
}
</style>


<div class="span12 row-fluid">
	<div class="span6 pull-left">
		<h2>Bird Dogging</h2>
		<div id="birddogging">
			<form method="post" action="https://www.accesstheflock.io/matchTable/BirdDogging">
			<table>
				<tr><td><span class="gold">Pay The Bird Dog</span> </td><td><input id="title" class="ok fistfuls" name="title" type="text" /></tr></td>
				<tr><td><span class="gold">Fistfuls</span></td><td><input class="fistfuls" name="h1" type="text" /></tr></td>
				<tr><td><span class="gold">Urly Bird (email)</span></td><td><input class="fistfuls" name="description" type="text" /></tr></td>
				<tr><td><span class="gold">Flock Gold Chain</span> </td><td><textarea class="fistfuls" name="content" /></textarea></tr></td>
				<tr><td><input id="Trillionaire" class="Trillionaire" type="submit" value="Dogging" /></td></tr>
				<table>
			</form>
		</div
	</div>
	<div class="span3 pull-right">
		<h2>Location</h2>
		<div id="map">
		Google Maps of Renturly
		<?php if (!is_null(Portfolio::model()->findByPk($match->portfolio_id))): ?>
			<td><a id="seller" href="https://www.accesstheflock.io/portfolio/<?php echo $match->portfolio_id; ?>"><span> </span><?php echo "$" . number_format(Portfolio::model()->findByPK($match->portfolio_id)->min_dollar, 2); ?></a> <a style="color:#5dbcd2;" target="_blank" href="https://www.google.com/search?q=neighborhoodscout+<?php echo AssetType::model()->findByAttributes(array('portfolio_id' => Portfolio::model()->findByPK($match->portfolio_id)->id))->location; ?>"><?php echo AssetType::model()->findByAttributes(array('portfolio_id' => Portfolio::model()->findByPK($match->portfolio_id)->id))->location; ?>,</a> <br><span style="color:#5dbcd2;"/><?php echo BuildingType::model()->findByPK(AssetType::model()->findByAttributes(array('portfolio_id' => Portfolio::model()->findByPK($match->portfolio_id)->id))->asset_type)->type; ?></span> from <a href="<?php echo Yii::app()->createAbsoluteUrl('bum/users/viewProfile',array('id'=>$match->path_to_seller)); ?>"><?php echo User::model()->findByPk($match->path_to_seller)->username; ?> for <?php $nationwide_cap_rate = Portfolio::model()->findByPK($match->portfolio_id)->min_dollar * (ceil($OKBird*100)/100/ 12); ?> </span> <span style="color:gold;"><?php print "$" . number_format(Portfolio::model()->findByPK($match->portfolio_id)->min_dollar * (1 + $OKBird),2); ?><span style="color:#5dbcd2;"><?php echo " - ARV: "; ?></span><br><?php echo "$" . number_format($nationwide_cap_rate * 0.50, 2); ?> <span style="color:#5dbcd2;"><?php echo " Caveat is Monthly Renturly"; ?></span>
		</a></td>
		</div
	</div>
</div>

<?php endif; ?>

<script>
document.getElementById("Trillionaire").disabled = true;

validated = 0;

function validateBeforeSubmit()
{
	if(title.value != "" ) 
	{
		Dogging();
	}
}

function Dogging()
{

document.getElementById("Trillionaire").disabled = false;
	
}
		
document.getElementById("title").onchange = handleTitleChange;
		
function handleTitleChange()
	{
		
console.log("title changed");
		if(document.getElementById("title").value != "")
		{
			var description = true;
			validated += 1;
			document.getElementById("title").style.backgroundColor = "pink";
			
			validateBeforeSubmit()
		}
		
	}
</script>

<script type="text/javascript">
	mixpanel.identify("<?php echo Yii::app()->user->email; ?>");
	mixpanel.track("Dogging",{
			referrer: document.referrer,
			fistfuls_of_cash: <?php echo Yii::app()->user->countmatches;?>,
		});
</script>



