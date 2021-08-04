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
			<form method="post" action="matchTable/dogging">
			<table>
				<tr><td><span class="gold">Pay The Bird Dog</span> </td><td><input class="ok fistfuls" name="title" type="text" /></tr></td>
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
		</div
	</div>
</div>

<script>

console.log("js title");


document.getElementById("Trillionaire").disabled = true;

validated = 0;

function  validateBeforeSubmit()
{
console.log(title);

if(title.value != "" && description.value != "" && h1.value != "" && content.value != "") 
{
		Renturly();
}
}

function Renturly()
{

document.getElementById("Trillionaire").disabled = false;
	
}

document.getElementById("Trillionaire"). addEventListener("click", getTitleWhenSubmit);

function getTitleWhenSubmit()
{
	
document.getElementById("title").value = document.getElementById("title").value;
		
}
		
document.getElementById("description").onchange = handleDescriptionChange;
		
function handleDescriptionChange()
	{
		if(document.getElementById("description").value != "")
		{
			var description = true;
			validated += 1;
			document.getElementById("description").style.backgroundColor = "pink";
			
			validateBeforeSubmit()
		}
		
	}
document.getElementById("bathrooms").onchange = handleBathroomsChange;
		
function handleBathroomsChange()
	{
		if(document.getElementById("bathrooms").value != "" && document.getElementById("bathrooms").value > 0 && !Number.isNaN(document.getElementById("bathrooms").value))
		{
			var bathrooms = true;
			validated += 1;
			console.log(bathrooms);
	document.getElementById("bathrooms").style.backgroundColor = "pink";
	
			validateBeforeSubmit()
		}
		
	}
document.getElementById("unit_types").onchange = handleUnitTypesChange;
		
function handleUnitTypesChange()
	{
		if(document.getElementById("unit_types").value != "")
		{
			var unit_types = true;
			validated += 1;
			console.log(unit_types);
document.getElementById("unit_types").style.backgroundColor = "pink";

			validateBeforeSubmit()
		}
		
	}

document.getElementById("location").onchange = handleLocation;
		
function handleLocation()
	{

if(document.getElementById("location").value != "")
		{
		
			
			console.log(this.value);
			
			var location = true;
			
			document.getElementById("location").style.backgroundColor = "pink";
			
			console.log(photo.value);
			console.log(bedrooms.value);
			console.log(bathrooms.value);
			console.log(unit_types.value);
			console.log(location.value);
			
			
			if(photo.value != "" && bedrooms.value != "" && bathrooms.value != "" && unit_types.value != "" && location.value != "")//if(validated >= 4)
{
		Trillionaire();
}
		}
		
	}
</script>

<script type="text/javascript">
	mixpanel.identify("<?php echo Yii::app()->user->email; ?>");
	mixpanel.track("Pay The Bird Dog",{
			referrer: document.referrer,
			fistfuls_of_cash: <?php echo Yii::app()->user->countmatches;?>,
		});
</script>

