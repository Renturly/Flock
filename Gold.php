<?php
/* @var $this MatchTableController */
/* @var $dataProvider CActiveDataProvider */

?>

<h1>OKBird</h1>

<div id="Pay" class="span12 well row-fluid">

<script>
/*
*Droplet puts out the Hot Stuff..
*Pay The Bird Dog Renturly
*Cash Buyer is Indexed By Google
*On Keyup fetch("https://maps.googleapis.com/maps/api/place/autocomplete/json?parameters")
*.filter() json object
*
*
*/
function pillage(renturly)	{

	

	return new Promise(resolve => {
	
	document.getElementById("Pay").innerHTML = renturly;

	/*
	 *Origin Access Error
	 *.fetch is recommended by Google:
	 * fetch supports CORS
	 * fetch requires HTTPS
		fetch(renturly).then(
			response => {
				//alert(response);
				document.getElementById("Pay").innerHTML = response.json();
				
			},
			rejection => {
			
				//alert(rejection.message);
				
document.getElementById("Pay").innerHTML = rejection.message;
				
			});
	*/
	
});
	
	fetch(url, {
		method: 'GET',
		headers: {
			'Content-type': 'application/json',
			'api-key': apiKey,
		},
		body: data,
	}).then(response => {
		if (response.ok) {
			return response.json();
		}
		throw new Error('Request failed!');
	}, networkError => {
		console.log(networkError.message)
	})
	
	//Close the Deal
}

const pay = async (location) => {

 pillage('https://maps.googleapis.com/maps/api/place/autocomplete/json?input=Edmonton&key=AIzaSyC52smVFMzjARDZ4kq-b1nWl5oKZdHuGYk');

}

function keyUp()
{
	try {
	
		var location = 'Edmonton';

		pay(location);
	
		} catch (e) {
	
		//alerts it to the DOM
		alert(e);
	
	}
}

keyUp();

</script>

</div>
