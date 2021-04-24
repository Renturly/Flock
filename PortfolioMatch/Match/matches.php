
<script>
<!-
     var time = new Date().getTime();
     $(document.body).bind("mousemove keypress", function(e) {
         time = new Date().getTime();
     });

     function refresh() {
         if(new Date().getTime() - time >= 60000) 
             window.location.reload(true);
         else 
             setTimeout(refresh, 10000);
     }

     setTimeout(refresh, 10000);
->
</script>
 
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
<?php

$this->pageTitle = "Bird Cage";

		$criteria=New CDbCriteria;
		$criteria->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)';
		//$criteria->condition = 'create_time >= 2018-11-19';
		$criteria->order = 'create_time ASC';
		$matches=MatchTable::model()->findAll($criteria);

		$data = array(array('Time',"Paid Fistfuls of Cash"));
		$count = 0;
		$tire_kicker_count = 0;
		$accessed_the_flock = 0;
		$same_date = 0;
		$matches_today = array();
		foreach ($matches as $match)
		{
			
			//You have match OKBirds on your iPhone
			//if($match->path_to_seller != 92 && $match->path_to_buyer != 92 && $match->path_to_seller != 583 && $match->path_to_buyer != 583)
			//{
				//if($match->status_id == 1)
				//{
					//$today = date('Y-m-d', strtotime($match->create_time));
					$today = date('Y', strtotime($match->create_time));
					array_push($matches_today, $today);
					
				//}
			//}

			//array_push($data, array($match->id, $count));
			
		}

		$matches_today = array_count_values($matches_today);
		
		$dates = array_keys($matches_today);
		$date_count = 0;
		foreach($matches_today as $count_matches_today)
		{
			
			$count += $count_matches_today;
			$date = $dates[$date_count];
			
			//$multiple = pow($count, 2)/pow(235, 2);
			//$valuation = $multiple*115995;
			
			array_push($data, array($date, $count));
		
			$date_count += 1;
				
		}

		$access_the_flock = $count * $count;
		
		
		//Matches
		$now = new CDbCriteria;
		//$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
		//$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)';
		
		//Bird Dogs can Bird Dog Urly Birds For A Month!
		//$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)';
		//A day lower than a month increases Bird Dogging Urly Birds
		$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)';
		
		$matches = 1;
		foreach(MatchTable::model()->findAllByAttributes(array('status_id'=>1), $now) as $match)
		{
			//if($match->path_to_seller != 92 && $match->path_to_buyer != 92 && $match->path_to_seller != 583 && $match->path_to_buyer != 583)
			//{
				$matches += 1;
			//}
		}
		
		$matches = $count - $matches;
		
		if($matches == 0)
		{
			$matches = 1;
		}
		
		$access_the_flock = $count * $count;
		
		$fistfuls_of_cash = $matches * $matches;
		
		if($fistfuls_of_cash == 0)
		{
			$fistfuls_of_cash = 1;
		}
		
		$flock = number_format((($access_the_flock / $fistfuls_of_cash)), 2,'.', ',');
		
		$flock = number_format($count / $matches, 2,'.', ',');
		
		$growth_rate = $flock;
		
		$access_the_flock = $flock;
		
		$inflation = Charge::model()->findAllByPk(1)->charge;
		
		$charges = Charge::model()->findAll();
		
		foreach($charges as $charge)
		{
			$inflation += $charge->charge;
		}
		
		$flock = ceil(round(($flock * $inflation) - $inflation, 0));
		
		
		//Begin Birds of a Feather
		$charge = Charge::model()->findAll();
		
		$flock = 0;
		foreach($charge as $fistful_of_cash)
		{
			$flock += $fistful_of_cash->charge;
		}
		
		$fistfuls_of_cash = $count;
		
		
		$birds_of_a_feather = number_format($flock / $fistfuls_of_cash, 2,'.', ',');
		
		$renturly = $fistfuls_of_cash * $birds_of_a_feather;
		
		//$fistfuls_of_cash = $renturly * pow(($count / $matches), 96);
		
		$fistfuls_of_cash = ($renturly * ($count/$matches)) - $renturly;
		
		//$flock = $birds_of_a_feather * Yii::app()->user->countmatches;
		
		//echo $flock;
		
		$cash = number_format(($birds_of_a_feather * $fistfuls_of_cash) - $flock, 2,'.', ',');
		
		//echo "<p>Pay The Bird Dog Fistfuls of Cash To Access The Flock: $". $cash ."</p>";
		
		//echo $cash ."</p>";
		
		$flock = $growth_rate;
		
		//Cash
		$charge = Charge::model()->findAll();
		
		$flock = 0;
		foreach($charge as $fistful_of_cash)
		{
			$flock += $fistful_of_cash->charge;
		}
		
		$birds_of_a_feather = number_format($flock / $fistfuls_of_cash, 2,'.', ',');
		
		
		echo "<h2><center>Flock Technology</center></h2>";
		echo "<h3><center>Nov. 19, 2018 - " . date("M" . "." . " d, " . "Y") . "</center></h3>";
		
		//Buy Cheap Money; Price
		echo "<p>";

			$key="Renturly.FistfulsOfCash.Image";
			if($this->beginCache($key,array('duration'=>300)))
			{
				$baseUrl = Yii::app()->theme->baseUrl; 
				//echo CHtml::image("$baseUrl/img/the-urly-bird-holding-apple-right.png","The Urly Bird Gets The Worm!");
				echo CHtml::image("$baseUrl/img/Fistfuls of Cash.png","Fistfuls of Cash",array('width'=>20));
				$this->endCache();
			}
		
		//$fistfuls_of_cash = ($access_the_flock / 15405625) * 864.64;

		$fistfuls_of_cash = $flock;
		
		//2 Years 
		$two_years = 12*2;
		//and then just wait until I'm 92
		
		$flock = $access_the_flock;
		
		$fistfuls_of_cash = $fistfuls_of_cash*pow($flock, $two_years) * 25;
			
		//echo number_format(round($fistfuls_of_cash, -3), 0,'.', ',') . "</p>";
		$fistfuls_of_cash = $count;
		
		$criteria = New CDbCriteria;
      $criteria->condition = 'pof_amount > 98000';
      //$criteria->addCondition('create_user_id != 92');
		//$criteria->limit = 1300;
		
$criteria=New CDbCriteria;
$criteria->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)';
//$criteria->condition = 'create_time >= 2018-11-19';
//$criteria->condition = 'create_time > 2018-11-18';
$criteria->order = 'create_time ASC';
//$criteria->limit = 100;
$buyers=count(Buyer::model()->findAll($criteria));
	
		$urly_birds = Buyer::model()->findAll($criteria);
		
		$fistfuls = 0;
		$cash_buyers = 0;
		foreach($urly_birds as $urly_bird)
		{
		
			$cash_buyers += 1;

			$fistfuls += $urly_bird->pof_amount;
			
			if($cash_buyers == $buyers)
				break;
			

		}

		echo " $" . number_format($fistfuls, 0,'.', ',') . "</p>";
		
		$cash_gold_and_realestate = $fistfuls_of_cash;
		
		$criteria=New CDbCriteria;
		$criteria->order = 'create_time ASC';
		$matches = MatchTable::model()->findAll($criteria);
		
		$fistfuls_of_cash = 0;
		foreach($matches as $match)
		{
			
			//You have match OKBirds on your iPhone
			//Don't debate yourself
			//if($match->path_to_seller != 92 && $match->path_to_buyer != 92 && $match->path_to_seller != 583 && $match->path_to_buyer != 583)
			//{
				$fistfuls_of_cash += 1;
			//}

			//array_push($data, array($match->id, $count));
			
		}
		
		/*
		echo "<p>";
		
			$key="Renturly.Flock.Image";
			if($this->beginCache($key,array('duration'=>300)))
			{
				$baseUrl = Yii::app()->theme->baseUrl; 
				echo CHtml::image("$baseUrl/img/flock.png","Flock",array("width"=>"45px","class"=>"pull-left"));
				$this->endCache();
			}
	
		//Matches
		$now = new CDbCriteria;
		//$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
		//$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)';
		
		//Bird Dogs can Bird Dog Urly Birds For A Month!
		//$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)';
		//A day lower than a month increases Bird Dogging Urly Birds
		$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)';
		
		$matches = 1;
		foreach(MatchTable::model()->findAllByAttributes(array('status_id'=>1), $now) as $match)
		{
			if($match->path_to_seller != 92 && $match->path_to_buyer != 92 && $match->path_to_seller != 583 && $match->path_to_buyer != 583)
			{
				$matches += 1;
			}
		}
		
		$matches = $count - $matches;
		
		$access_the_flock = $count * $count;
		
		$fistfuls_of_cash = $matches * $matches;
		
		$flock = number_format((($access_the_flock / $fistfuls_of_cash)), 2,'.', ',');
		
		$flock = number_format($count / $matches, 2,'.', ',');
		
		$growth_rate = $flock;
		
		$access_the_flock = $flock;
		
		$inflation = Charge::model()->findAllByPk(1)->charge;
		
		$charges = Charge::model()->findAll();
		
		foreach($charges as $charge)
		{
			$inflation += $charge->charge;
		}
		
		$flock = ceil(round(($flock * $inflation) - $inflation, 0));
		
		
		//Begin Birds of a Feather
		$charge = Charge::model()->findAll();
		
		$flock = 0;
		foreach($charge as $fistful_of_cash)
		{
			$flock += $fistful_of_cash->charge;
		}
		
		$fistfuls_of_cash = $count;
		
		
		$birds_of_a_feather = number_format($flock / $fistfuls_of_cash, 6,'.', ',');
		
		$renturly = $fistfuls_of_cash * $birds_of_a_feather;
		
		//$fistfuls_of_cash = $renturly * pow(($count / $matches), 96);
		
		$fistfuls_of_cash = ($renturly * ($count/$matches)) - $renturly;
		
		//$flock = $birds_of_a_feather * Yii::app()->user->countmatches;
		
		//echo $flock;
		
		$cash = number_format(($birds_of_a_feather * $fistfuls_of_cash) - $flock, 2,'.', ',');
		
		//echo "<p>Pay The Bird Dog Fistfuls of Cash To Access The Flock: $". $cash ."</p>";
		
		//echo $cash ."</p>";
		
		$flock = $growth_rate;
		
		//Cash
		$charge = Charge::model()->findAll();
		
		$flock = 0;
		foreach($charge as $fistful_of_cash)
		{
			$flock += $fistful_of_cash->charge;
		}
		
		$birds_of_a_feather = number_format($flock / $fistfuls_of_cash, 6,'.', ',');
		
		
		
		echo "$" . round($fistfuls_of_cash, 0) . "</p>";
		
		*/
		
		if($flock > 6000)
		{
			$flock = 6000;
		}
		
		$flock = $flock - 0.01;
		
		if($flock < 1)
		{
			$flock = 1;
		}
		
		echo "</p>";
		
		//echo " " . number_format((($access_the_flock / $cash_flow)), 2,'.', ',')  . "</p>";

		
		
		//Cash
		$charge = Charge::model()->findAll();
		
		$flock = 0;
		foreach($charge as $fistful_of_cash)
		{
			$flock += $fistful_of_cash->charge;
		}
		
		$birds_of_a_feather = number_format($flock / $fistfuls_of_cash, 7,'.', ',');
		
		echo "<p>";

			$key="Renturly.Renturly.Image";
			if($this->beginCache($key,array('duration'=>300)))
			{
				$baseUrl = Yii::app()->theme->baseUrl; 
				//echo CHtml::image("$baseUrl/img/the-urly-bird-holding-apple-right.png","The Urly Bird Gets The Worm!");
				echo CHtml::image("$baseUrl/img/Renturly-logo-with-teal.png","Renturly",array('width'=>20));
				$this->endCache();
			}


//echo " $" . number_format(count(MatchTable::model()->findAllByAttributes(array('status_id'=>1)), 0,'.', ',') . "</p>";
			

		echo " <a href='https://docs.google.com/spreadsheets/d/1qTSo-q5xiev2C7vaLHzWOKEv3rAunUGZY2fX7aH9kII/edit'>$" . number_format($fistfuls_of_cash * $birds_of_a_feather, 0,'.', ',') . "</a></p>";
		
		$renturly = $fistfuls_of_cash * $birds_of_a_feather;
		
		
		echo "<p>";

			$key="Renturly.OKBird.Image";
			if($this->beginCache($key,array('duration'=>300)))
			{
				$baseUrl = Yii::app()->theme->baseUrl; 
				//echo CHtml::image("$baseUrl/img/the-urly-bird-holding-apple-right.png","The Urly Bird Gets The Worm!");
				echo CHtml::image("$baseUrl/img/Renturly-OK-Bird.jpg","Fistfuls of Cash",array('width'=>20));
				$this->endCache();
			} 
		
		if($birds_of_a_feather < .01)
		{
			$birds_of_a_feather = 0.01;
		}

		//OKBird				
$criteria=New CDbCriteria;
		$criteria->condition = 'status_id = 1';
		//$criteria->condition = 'create_time >= 2018-11-19';
		$criteria->order = 'create_time ASC';
		$fistfuls_of_cash = count($matches=MatchTable::model()->findAll($criteria));
		
//Cash
		$charge = Charge::model()->findAll();
		
		$flock = 0;
		foreach($charge as $fistful_of_cash)
		{
			$flock += $fistful_of_cash->charge;
		}
		
//print number_format($flock, 0,'.', ',');
		
$birds_of_a_feather = number_format($flock / $fistfuls_of_cash, 7,'.', ',');
			
		echo "<a href='https://facebook.com'>$" . number_format($birds_of_a_feather, 7,'.', ',') ."</a></p>";
		
		
		echo "<p>";
		
			$key="Renturly.Flock.Image";
			if($this->beginCache($key,array('duration'=>300)))
			{
				$baseUrl = Yii::app()->theme->baseUrl; 
				echo CHtml::image("$baseUrl/img/flock.png","Flock",array("width"=>"45px","class"=>"pull-left"));
				$this->endCache();
			}
	
		//Matches
		$now = new CDbCriteria;
		//$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
		//$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)';
		
		//Bird Dogs can Bird Dog Urly Birds For A Month!
		//$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)';
		//A day lower than a month increases Bird Dogging Urly Birds
		$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)';
		
		$matches = 1;
		foreach(MatchTable::model()->findAllByAttributes(array('status_id'=>1), $now) as $match)
		{
			//if($match->path_to_seller != 92 && $match->path_to_buyer != 92 && $match->path_to_seller != 583 && $match->path_to_buyer != 583)
			//{
				$matches += 1;
			//}
		}
		
		
		$matches = $count - $matches;
		
		/*
		$access_the_flock = $count * $count;
		
		$fistfuls_of_cash = $matches * $matches;
		
		$flock = number_format((($access_the_flock / $fistfuls_of_cash)), 2,'.', ',');
		
		$flock = number_format($count / $matches, 2,'.', ',');
		
		$growth_rate = $flock;
		
		$access_the_flock = $flock;
		
		
		$inflation = Charge::model()->findAllByPk(1)->charge;
		
		$charges = Charge::model()->findAll();
		
		foreach($charges as $charge)
		{
			$inflation += $charge->charge;
		}
		
		
		$flock = ceil(round(($flock * $inflation) - $inflation, 0));
		*/
		
		//Begin Birds of a Feather
		
		//1 Month
		$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)';
		$charge = Charge::model()->findAll($now);
		
		$gold = 0;
		foreach($charge as $fistful_of_cash)
		{
			$gold += $fistful_of_cash->charge;
		}
		
		
		$fistfuls_of_cash = $count - $matches;
		
		$birds_of_a_feather = number_format($gold / $fistfuls_of_cash, 2,'.', ',');
		
		//$renturly = $fistfuls_of_cash * $birds_of_a_feather;
		
		//$fistfuls_of_cash = $renturly * pow(($count / $matches), 96);
		
		$flock = $gold / 3;
		
		//$flock = $birds_of_a_feather * Yii::app()->user->countmatches;
		
		//echo $flock;
		
		//$cash = number_format(($birds_of_a_feather * $fistfuls_of_cash) - $gold, 2,'.', ',');
		
		//echo "<p>Pay The Bird Dog Fistfuls of Cash To Access The Flock: $". $cash ."</p>";
		
		//echo $cash ."</p>";
		
		/*
		$flock = $growth_rate;
		
		//Cash
		$charge = Charge::model()->findAll();
		
		$flock = 0;
		foreach($charge as $fistful_of_cash)
		{
			$gold += $fistful_of_cash->charge;
		}
		
		
		$birds_of_a_feather = number_format($gold / $fistfuls_of_cash, 6,'.', ',');
		*/
		
		
		echo "$" . round($flock, 0) . "</p>";
		
		
		
		//echo "<p>The Mating Dance: Pay The Bird Dog Fistfuls of Cash To Access The Flock, Renturly.</p>";
		
		//$fistfuls_of_cash = ($count * (1 + number_format($birds_of_a_feather, 2,'.', ','))) * pow(($count / $matches), 24);
		
		/*
		$criteria=New CDbCriteria;
		$criteria->select = 'sum(charge) as charge';
		$criteria->condition = 'create_time >= 2018-11-19';
		//$criteria->order = 'create_time ASC';
		$fistfuls_of_cash = Charge::model()->findAll($criteria);
		
		$fistfuls_of_cash = $fistfuls_of_cash[0]['charge'] - 1033.81;
		
		$criteria=New CDbCriteria;
		$criteria->select = 'sum(charge) as charge';
		$criteria->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)';
		//$criteria->order = 'create_time ASC';
		$flock = Charge::model()->findAll($criteria);
		
		$flock = $flock[0]['charge'];
		
		$growth_rate = 1 + ((($fistfuls_of_cash - $flock) / $fistfuls_of_cash) * .67);
		
		$fistfuls_of_cash = $flock * pow(round($growth_rate, 2), 24);
		*/
		
		/*
		$fistfuls_of_cash = $renturly * pow(($count / $matches), 96);
		
		$fistfuls_of_cash = ($renturly * ($count/$matches)) - $renturly;
		
		$fistfuls_of_cash = $fistfuls_of_cash + ($fistfuls_of_cash * ($count/$matches));
		$fistfuls_of_cash += ($fistfuls_of_cash * ($count/$matches));
		$fistfuls_of_cash += ($fistfuls_of_cash * ($count/$matches));
		$fistfuls_of_cash += ($fistfuls_of_cash * ($count/$matches));
		$fistfuls_of_cash += ($fistfuls_of_cash * ($count/$matches));
		$fistfuls_of_cash += ($fistfuls_of_cash * ($count/$matches));
		$fistfuls_of_cash += ($fistfuls_of_cash * ($count/$matches));
		$fistfuls_of_cash += ($fistfuls_of_cash * ($count/$matches));
		$fistfuls_of_cash += ($fistfuls_of_cash * ($count/$matches));
		$fistfuls_of_cash += ($fistfuls_of_cash * ($count/$matches));
		$fistfuls_of_cash += ($fistfuls_of_cash * ($count/$matches));
		$fistfuls_of_cash += ($fistfuls_of_cash * ($count/$matches));
		*/
		
		echo "<p>";

			$key="Renturly.GoldenEgg.Image";
			if($this->beginCache($key,array('duration'=>300)))
			{
				$baseUrl = Yii::app()->theme->baseUrl; 
				//echo CHtml::image("$baseUrl/img/the-urly-bird-holding-apple-right.png","The Urly Bird Gets The Worm!");
				echo CHtml::image("$baseUrl/img/Golden Egg.jpg","Golden Egg",array('width'=>20));
				$this->endCache();
			}
			
		$fistfuls_of_cash = $cash_gold_and_realestate;
			
		//fistfuls of cash * renturly
		echo " $" . number_format($gold * $renturly * 1.37, 0,'.', ',') . "</p>";
		
$criteria=New CDbCriteria;
$criteria->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
//$criteria->condition = 'create_time >= 2018-11-19';
//$criteria->condition = 'create_time > 2018-11-18';
$criteria->order = 'create_time ASC';
//$criteria->limit = 100;
$buyers=Buyer::model()->findAll($criteria);
		


		$data = array(array('Time','Renturly'));
		$count = 0;
		$buyers_today = array();
		foreach ($buyers as $buyer)
		{
			
			//if($buyer->create_user_id != 92 && $buyer->create_user_id != 583)
			//{
				if($buyer->status_id == 1)
				{
					//$today = date('Y-m-d', strtotime($buyer->create_time));
					$today = date('Y-M-d', strtotime($buyer->create_time));
					array_push($buyers_today, $today);
				}
			//}
			
			
			
			//array_push($data, array($match->id, $count));
		}


		$buyers_today = array_count_values($buyers_today);
		
		$dates = array_keys($buyers_today);
		$date_count = 0;
		foreach($buyers_today as $count_buyers_today)
		{
			
			$count += $count_buyers_today;

			$date = $dates[$date_count];
			
			array_push($data, array($date, $count));
		
			$date_count += 1;
				
		}
		
		/*  
		if ($count == 0)
		{
			$count = 1;
		}
		*/

?>

<br>
<br>
<br>

<div class="well span12">
<h3 style="text-align:center;"><a class="renturly" href="https://www.accesstheflock.io/birds-of-a-feather">Birds of a Feather</a></h3>

<style>
.renturly {
   color: #5dbcd2;
   background-color: transparent;
}

a:active, a:hover {
	color: gold;
}

.gold {
	color: gold;
}
</style>

<?php 		


$gold = $count;
		
$this->widget('ext.Hzl.google.HzlVisualizationChart', array('visualization' => 'LineChart',
            'data' => $data,
            'options' => array(
                'title' => 'Fistfuls',
                'titleTextStyle' => array('color' => 'black'),
                'vAxis' => array(
                    'title' => 'Chief Bird Dog',
                    'gridlines' => array(
                        'color' => 'transparent'  //set grid line transparent
                    )),
               // 'hAxis' => array('title' => 'Renturly'),
                'curveType' => 'function', //smooth curve or not
                //'legend' => array('position' => 'bottom'),
        )));
        
echo "<small><center><a class='renturly' href='http://www.accesstheflock.io/buyer/create'>Renturly</a></center></small>";
        
        /*
         * Cash
         */
/*
        $criteria=New CDbCriteria;
        $criteria->select = array('create_time','charge');
		$criteria->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)';
		$criteria->order = 'create_time ASC';
		$flock=Charge::model()->findAll($criteria);
		
		

		$data = array(array('Time','Flock'));
		$bank = array();
		foreach ($flock as $fistfuls_of_cash)
		{
			//date('Y-M-d', strtotime($fistfuls_of_cash->create_time))
			array_push($bank, $fistfuls_of_cash->charge);
			
		}
		?><pre><?php 
	print_r($bank);
		?></pre><?php 
		
$this->widget('ext.Hzl.google.HzlVisualizationChart', array('visualization' => 'LineChart',
            'data' => $bank,
            'options' => array(
                'title' => 'Flock',
                'titleTextStyle' => array('color' => 'black'),
                'vAxis' => array(
                    'title' => 'Bird Dogging',
                    'gridlines' => array(
                        'color' => 'transparent'  //set grid line transparent
                    )),
                'hAxis' => array('title' => 'Time'),
                'curveType' => 'function', //smooth curve or not
                'legend' => array('position' => 'right'),
        )));
        
  */      
  


Yii::app()->user->mp_increment("Fistfuls");

?>

	
<script type="text/javascript">
	mixpanel.identify("<?php echo Yii::app()->user->email; ?>");
	mixpanel.track("Fistfuls",{
			referrer: document.referrer,
		});
	//mixpanel.track_forms("#payment-form","Saved Revenue",{
	//	referrer: document.referrer
	//});
</script>
		 
<?php
  


		$criteria=New CDbCriteria;
		//$criteria->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 2 MONTH)';
		$criteria->condition = 'create_time >= 2018-11-19';
		$criteria->order = 'create_time ASC';
		//$matches=MatchTable::model()->findAll($criteria);
		$matches=Charge::model()->findAll($criteria);

		
		$data = array(array('Time', "Flock"));
		/*
		$count = 0;
		$tire_kicker_count = 0;
		$accessed_the_flock = 0;
		$same_date = 0;
		$matches_today = array();
		foreach ($matches as $match)
		{
			
			//You have match OKBirds on your iPhone
			//if($match->path_to_seller != 92 && $match->path_to_buyer != 92 && $match->path_to_seller != 583 && $match->path_to_buyer != 583)
			//{
				//if($match->status_id == 1)
				//{
					//$today = date('Y-m-d', strtotime($match->create_time));
					$today = date('Y-M-d', strtotime($match->create_time));
					//$today = date('Y', strtotime($match->create_time));
					array_push($matches_today, $today);
					
				//}
			//}

			//array_push($data, array($match->id, $count));
			
		}

		$matches_today = array_count_values($matches_today);
		
		$dates = array_keys($matches_today);
		$date_count = 0;
		foreach($matches_today as $count_matches_today)
		{
			
			$count += $count_matches_today;
			$date = $dates[$date_count];
			
			//$multiple = pow($count, 2)/pow(235, 2);
			//$valuation = $multiple*115995;
			
			array_push($data, array($date, $count));
		
			$date_count += 1;
				
		}
		*/
		
		$flock = 0;
		foreach($matches as $fistfuls_of_cash)
		{
			//Renturly
			if($fistfuls_of_cash->charge == 1465)
			{
				$flock = 0;
			} else {
				$flock += $fistfuls_of_cash->charge;
			}
			
			array_push($data, array(date('Y-M-d', strtotime($fistfuls_of_cash->create_time)), $flock));
		}
		

		//$access_the_flock = $count * $count;
		
		/*
		echo "<p>";
		
			$key="Renturly.Flock.Image";
			if($this->beginCache($key,array('duration'=>300)))
			{
				$baseUrl = Yii::app()->theme->baseUrl; 
				echo CHtml::image("$baseUrl/img/flock.png","Flock",array("width"=>"45px","class"=>"pull-left"));
				$this->endCache();
			}
	
		//Matches
		$matches = 0;
		
		$now = new CDbCriteria;
		$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
		
		$matches = 0;
		foreach(MatchTable::model()->findAllByAttributes(array(), $now) as $match)
		{
			if($match->path_to_seller != 92 && $match->path_to_buyer != 92 && $match->path_to_seller != 583 && $match->path_to_buyer != 583)
			{
				$matches += 1;
			}
		}
		
		
		$matches = $count - $matches;
		
		$access_the_flock = $count * $count;
		
		$cash_flow = $matches * $matches;
		

		echo " " . number_format((($access_the_flock / $cash_flow)), 2,'.', ',')  . "</p>";
		
		*/
		
		/*
		echo "<p>";

			$key="Renturly.FistfulsofCash.Image";
			if($this->beginCache($key,array('duration'=>300)))
			{
				$baseUrl = Yii::app()->theme->baseUrl; 
				//echo CHtml::image("$baseUrl/img/the-urly-bird-holding-apple-right.png","The Urly Bird Gets The Worm!");
				echo CHtml::image("$baseUrl/img/FistfulsOfCash.jpg","Fistfuls of Cash",array('width'=>20));
				$this->endCache();
			}
		
		echo number_format($access_the_flock, 0,'.', ',') . "</p>";
		*/
		
		//echo "<p>Weekly Cash Flow Growth Rate: " .  number_format((($access_the_flock / ($access_the_flock - pow($matches, 2)) - 1) * 100), 2,'.', ',')   ." Times</p>" ;
		//echo "<p>Flock: " .  number_format(((($matches * $matches) / $access_the_flock) * 100), 2,'.', ',')   ."%</p>" ;

		
		
		

		

  		$fistfuls_of_cash = $count;

		$fistfuls_of_cash = round($fistfuls_of_cash/$gold, 0);     
        

        

$criteria=New CDbCriteria;
$criteria->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)';
//$criteria->condition = 'create_time >= 2018-11-19';
//$criteria->condition = 'create_time > 2018-11-18';
$criteria->order = 'create_time ASC';
$renturly=count(Portfolio::model()->findAll($criteria));

$criteria=New CDbCriteria;
$criteria->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)';
//$criteria->condition = 'create_time >= 2018-11-19';
//$criteria->condition = 'create_time > 2018-11-18';
$criteria->order = 'create_time ASC';
$fistfuls=count(Buyer::model()->findAll($criteria)); 

if(($fistfuls/$renturly) <= 3)
{
	$strategy = "Dogging Fistfuls";
} else {
	$strategy = "Bring Me Renturly";
}
        
        $this->widget('ext.Hzl.google.HzlVisualizationChart', array('visualization' => 'LineChart',
            'data' => $data,
            'options' => array(
                'title' => "Pay The Bird Dog: " . $strategy,
                'titleTextStyle' => array('color' => 'black'),
                'vAxis' => array(
                    'title' => "Fistfuls of Cash",
                    'gridlines' => array(
                        'color' => 'transparent'  //set grid line transparent
                    )),
                'hAxis' => array('title' => 'Time'),
                'curveType' => 'function', //smooth curve or not
                'legend' => array('position' => 'right'),
        )));
        
        
        
$criteria=New CDbCriteria;
$criteria->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
//$criteria->condition = 'create_time >= 2018-11-19';
//$criteria->condition = 'create_time > 2018-11-18';
$criteria->order = 'create_time ASC';
//$criteria->limit = 300;
$sellers=Portfolio::model()->findAll($criteria);
		


		$data = array(array('Time','Fistfuls of Cash'));
		$count = 0;
		$sellers_today = array();
		foreach ($sellers as $seller)
		{
			
			//if($seller->create_user_id != 92 && $seller->create_user_id != 583)
			//{
				if($seller->status_id == 1)
				{
					//$today = date('Y-m-d', strtotime($seller->create_time));
					$today = date('Y-M-d', strtotime($seller->create_time));
					array_push($sellers_today, $today);
					
					
				}
			//}
			
			
			
			//array_push($data, array($match->id, $count));
		}


		$sellers_today = array_count_values($sellers_today);
		
		$dates = array_keys($sellers_today);
		$date_count = 0;
		foreach($sellers_today as $count_sellers_today)
		{
			
			$count += $count_sellers_today;
			$date = $dates[$date_count];
			
			array_push($data, array($date, $count));
		
			$date_count += 1;
				
		}
		
		$real_estate = $count;

		$real_estate = round($real_estate/$gold, 0);

$this->widget('ext.Hzl.google.HzlVisualizationChart', array('visualization' => 'LineChart',
            'data' => $data,
            'options' => array(
                'title' => "Real Estate",
                'titleTextStyle' => array('color' => 'black'),
                'vAxis' => array(
                    'title' => 'Bring Me Renturly',
                    'gridlines' => array(
                        'color' => 'transparent'  //set grid line transparent
                    )),
                //'hAxis' => array('title' => 'Fistfuls of Cash'),
                'curveType' => 'function', //smooth curve or not
                //'legend' => array('position' => 'bottom'),
        )));
        echo "<small><center><a class='gold' href='http://www.accesstheflock.io/portfolio/create'>Fistfuls of Cash</a></center></small>";

?>
</div>
<br>
<br>
<br>