<?php
//Dogging dynamically generates Apartment Buildings I pay for: OKBird
?>

<h1>Apartment Buildings we're Buying</h1>


<style>
/*	
*The Golden Egg Renturly
*/
input {
	border: 1px solid gold;
}
#Chinese {
	margin-left: 21%;
}
#PayTheBirdDog {
	border-color: gold;
	position: fixed;
	background-color: white;
	bottom: 0;
}
.fistfuls {
	padding: 10px;
	margin: 5px;
	border: gold;
	color: #5dbcd2;
}
td {
	//width: 20%;
	//height: 21px;
	padding: 3%;
	float: left;
	font-size: 21px;
	line-height: 1.6;
	//margin: 10px;
	//background-color: gold;
}
.gold {
	color: silver;
}
.Trillionaire {
	background-color: gold;
}
.fistfuls_of_cash {
	border-radius: 13px;
	padding: 10px;
}
a.gold:active, a.gold:hover {
	color: #5dbcd2;
}
#Chinese-Cash-Buyers {
	margin-left: 21%;
	display: inline;
}
</style>



<p id="PayTheBirdDog">Bird Dogs made so much value that you can buy multiple Apartment Buildings <a id="blog-post" href="http://www.accesstheflock.io/the-urly-bird/160"></a></p>


<?php
//row id is buyer id			
function buyer($types_looking_id)
{
			$criteria = new CDbCriteria;
			$criteria->select = 'id, pof_amount';
			$criteria->condition = 'id = ' . $types_looking_id;
			$pof = Buyer::model()->find($criteria);
			if($pof->pof_amount <= 5500000)
			{
				return $pof->pof_amount;	
			}	else {
				return "Minimizing the Value of Real Estate";
			}
}
?>

<table id="Chinese">
	<?php //each Apartment Building Urly Bird 
	foreach($cash_buyers as $apartment_building)
	{
		//if($apartment_building->pof_amount >= 5500000)
		//{
?>
	<tr class="Trillionaire" id="<?php echo $apartment_building->id; ?>">
		<td style="color: #5dbcd2;" ><a class="fistfuls" href="https://www.accesstheflock.io/birds-of-a-feather">Dogging <span class="pof"><?php if(buyer($apartment_building->id) != "Minimizing the Value of Real Estate") { print "$". number_format(buyer($apartment_building->id), 0, ".", ","); } else { print "Bankruptcy"; } ?></span></a><td>
		<td id="apartment-building-buyer"><a class="gold" href="https://www.accesstheflock.io/buyer/<?php print $apartment_building->id; ?>">Urly Bird</a><span id="next"></span></td>
		<td><a href="https://www.accesstheflock.io/portfolio/create" class="fistfuls_of_cash btn-info">Bring Me Renturly</a></td>
	</tr>
	<form method="post" id="unit_type" name="sell-home" enctype="multipart/form-data" action="https://www.accesstheflock.io/sell-homes">
	<tr>
		<td><input id="photo" name="Renturly" type="file" value="Unboarded-Up Houses" /></td>
		<td><input id="bedrooms" name="bedrooms" placeholder="Beds" /></td>
		<td><input id="bathrooms" name="bathrooms" placeholder="Bath" /></td>
		<td><select id="unit_types" name="unit_types">
		<option value="">Select Unit Type</option>
    <option value="Apartment">Apartment</option>
    <option value="House">House</option>
  </select>
		</td>
		<td><input id="location" name="Location" placeholder="Address" value="NY" /></td>
		<td><input name="username" value="<?= Yii::app()->user->id;?>" type="hidden" /></td>
		<td class="underline"><input id="Renturly" type="submit" value="Sell House" /></td>
	</tr>
	</form>
	<?php 
		//}
	} ?>
<table>

<?php if(Yii::app()->user->id != 92): ?>
	<script>
	mixpanel.track("Bird Dogging", {
		    "referrer": document.referrer
		});
	</script>
<?php endif; ?>


<script>

document.getElementById("Renturly").disabled = true;

validated = 0;

function Renturly()
{

document.getElementById("Renturly").disabled = false;


//document.getElementById("Renturly").value = "Submitted";

//document.getElementById("unit_type").submit();
	
}

document.getElementById("Renturly"). addEventListener("click", getLocationWhenSubmit);

function getLocationWhenSubmit()
{
	
document.getElementById("location").value = document.getElementById("location").value;
	console.log(document.getElementById("location").value);
}
		document.getElementById("photo").onchange = handlePhotoChange;
		
function handlePhotoChange()
	{
		if(document.getElementById("photo").value != "")
		{
			var photo = true;
			validated += 1;
			console.log(photo);
			document.getElementById("photo").style.backgroundColor = "pink";
		}
		
	}
document.getElementById("bedrooms").onchange = handleBedroomsChange;
		
function handleBedroomsChange()
	{
		if(document.getElementById("bedrooms").value != "" && document.getElementById("bedrooms").value > 0 && !Number.isNaN(document.getElementById("bedrooms").value))
		{
			var bedrooms = true;
			validated += 1;
			console.log(bedrooms);
			console.log(this.value);
			document.getElementById("bedrooms").style.backgroundColor = "pink";
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


	
		console.log("Submit Renturly");
	
		Renturly();

		mixpanel.track("Unit Type", {
		    "referrer": document.referrer
		});
		
}
		}
		
	}
</script>

<script>
//Inlining

function greaterThan()
{
	

	Fistfuls = document.getElementById('blog-post').innerHTML;
	//.forEach(Trillionaire as flock)
	return Fistfuls;
}

		
//var Trillionaire = 1;
	//Sir Li Ka Ching
	bankruptcies = 0;
	while (bankruptcies < 170)
	{
	
		//if(Fistfuls >= 
//document.getElementById("Chinese").rows[bankruptcies].style.display = "block";
		//bankruptcies.push(Trillionaire);
						//if(document.getElementById("Chinese").rows[bankruptcies].querySelector("span").innerHTML <= greaterThan())
{
						//console.log(document.getElementById("Chinese").rows[bankruptcies].querySelector("span").innerHTML + greaterThan());
						
//document.getElementById("Chinese").rows[bankruptcies].style.display = "block";
}
						
		bankruptcies += 1;
	}
</script>

<script>

function craftBeer() {

//document.getElementById("next").closest(".Gold");

}

//document.getElementById("next").onclick = craftBeer;

//<tr>
let gold = document.getElementsByClassName("Trillionaire");
var list = Array.from(gold);

//Trillionaire.style.display = "none";

//console.log(list);

apartment_buildings = [];
list.forEach(gold => {
	//console.log(gold.id);
	apartment_buildings.push(gold.id);
	
});

console.log(apartment_buildings);

//console.log(list);
//apartment_buildings.shift();


</script>

<script>

  const goldenEgg = async () => {
	const buyer = await fetch("https://www.accesstheflock.io/matchTable/DoggingFistfuls");
    
	const buyerJSON = await buyer.json();
	
	console.log(buyerJSON.fistfuls);
	
	let pof_amount = buyerJSON.fistfuls;
	document.getElementById('blog-post').innerHTML = pof_amount;
	
	return pof_amount;

}

goldenEgg();

//console.log(Trillionaire);

//let Gold = document.getElementsByClassName("Gold");

//console.log(Gold);
	

//const Gold = ["gold1", "gold2"];

//let cash_buyers = document.getElementById("Chinese").rows[0].cells[0].style.display = "none";

//console.log(cash_buyers);


function greaterThan()
{
	

	Fistfuls = document.getElementById('blog-post').innerHTML;
	//.forEach(Trillionaire as flock)
	return Fistfuls;
}

</script>

<script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC52smVFMzjARDZ4kq-b1nWl5oKZdHuGYk&libraries=places&callback=initMap">
</script>
<script>
//Inspect: https://developers.google.com/maps/documentation/places/web-service/autocomplete?hl=id


function initMap()
{
		console.log("youtube");
		
		const center = { lat: 37.0902, lng: 95.7129 };
// Create a bounding box with sides ~10km away from the center point
const defaultBounds = {
  north: center.lat + 0.1,
  south: center.lat - 0.1,
  east: center.lng + 0.1,
  west: center.lng - 0.1,
};
const input = document.getElementById("location");
const options = {
  bounds: defaultBounds,
  componentRestrictions: { country: ["us", "ca"] },
  fields: ["address_components", "geometry", "icon", "name"],
  origin: center,
  strictBounds: false,
  //types: ["establishment"],
};
		
		const autocomplete = new google.maps.places.Autocomplete(input, options);
		
}
</script>
