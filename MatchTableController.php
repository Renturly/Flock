<?php

		ini_set("memory_limit",-1);
		set_time_limit(0);
		
		use PredictionBuilder\PredictionBuilder;
		
Yii::import('application.vendors.*');

//require Yii::app()->basePath . '/vendors/vendor/autoload.php';

class MatchTableController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('matches','doggingfistfuls','bringmerenturly','paythebirddog','birddog','vettingfee','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update','search','relationtoseller','relationtobuyer','proofoffunds'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('admin'),
			),
			/*
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('updateallmatches'),
				'users'=>array('MichaelDSadler'),
			),
			*/
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionMatches()
	{
		//if(Yii::app()->user->id == 92)
		//{
			
			$this->layout='//layouts/column1';
		
			$this->render('matches');
		//}

		
		/*
		//Yii::app()->fusioncharts->setChartOptions( array( 'caption'=>'Matches', 'xAxisName'=>'Date', 'yAxisName'=>'Matches' ) );
		
		$criteria=New CDbCriteria;
		$criteria->condition = 'status_id = 1 AND score > 0';
		$match_models = Match::model()->findAllByAttributes(array(), $criteria);
		
		$matches = array();
		foreach ($match_models as $match)
		{
			array_push($matches, array('time' => $match->id));
		}
		
		print json_encode($matches);
		die();
		
		
		//Yii::app()->fusioncharts->addTrendLine(array('startValue'=>'1', 'color'=>'black', 'displayvalue'=>'Target'));
		*/
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MatchTable']))
		{
			$model->attributes=$_POST['MatchTable'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->portfolio_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	
	//HTTPS
	//Flock Pricing is for Usability
	//echoes json
	public function actionBringMeRenturly()
	{
	
		header('Content-Type: application/json');
		//Title & Escrow
		//autoload.php
		try {
			
			//test code
			//Loads Composer
			//I need composer.json for more complicated Files
			require_once(dirname(__DIR__) . "/vendors/prediction-builder/src/PredictionBuilder.php");
			//'/vendor/autoload.php');
			//I can get my Data Science Certificate: I can get Composer autoload.php to work
			//Linear Regression: Spend Credit on Making Money
//$data = [[1,20],[2,70],[2,45],[3,81],[5,73],[6,80],[7,110]];

		$criteria=new CDbCriteria;
		$criteria->addCondition('create_time >= :create_time');
$criteria->params[':create_time'] = date('Y-m-d h:i:s', strtotime('-1 year'));
		$criteria->order = "create_time desc";

$data = Yii::app()->db->createCommand()
    ->select('charge')
    ->from('tbl_flock')
    ->queryAll($criteria);
    

$flock = array();
$pay_the_bird_dog = 0;
foreach($data as $pay)
{
	$pay_the_bird_dog += 1;
	array_push($flock, array($pay_the_bird_dog, $pay[charge]));
	

}
		//What I Got $0.15
		$x = 0.15;

		$prediction = new PredictionBuilder($x, $flock);
		//Bring a Smile to the Bank
    	$result = $prediction->build();
    	
		//p-value
    	$result->cor;
print json_encode(array("flock_pricing"=>"$" . round($result->y, 2))); //Wire Transfer: Float
		die();
   
		} catch (Exception $e) {
  			
			echo 'Message: ' . $e->getMessage();
			
		}
		
		//Pay The Bird Dog
		/*
		header('Content-Type: application/json');
		
		//buyer_id and portfolio_id
		//update status
		$cash_buyers_list = Yii::app()->db->createCommand()
    ->select('buyer_id, portfolio_id')
    ->from('tbl_match fistfuls_of_cash')
	->limit(1)
	->where('status_id = :status_id AND create_user_id = :create_user_id', array(':create_user_id'=>Yii::app()->user->id,':status_id'=>1))
    ->queryRow();

    //Linear Regression
$data = [[1,20],[2,70],[2,45],[3,81],[5,73],[6,80],[7,110]];
$x = 4.5;



//What is the expected y value for a given x value?
try {
		//Use  composer autoload in vendors
		$prediction = new PredictionBuilder($x, $data);
    $result = $prediction->build(); // y = 76.65
} catch (\Exception $e) {
    echo $e->getMessage(), "\n";
}

		//Gradient Descent Recommend Fistfuls of Cash with Minimum Loss
	
		print json_encode(array("buyer_id"=>$cash_buyers_list['buyer_id'],"portfolio_id"=>$result));
		//Vote
		die();
		*/

	}
	
	//HTTPS
	//Flock Pricing is for Usability
	//echoes json
	public function actionVettingFee()
	{
	
		header('Content-Type: application/json');
		//Title & Escrow
		//autoload.php
		try {
			
			//test code
			//Loads Composer
			//I need composer.json for more complicated Files
			require_once(dirname(__DIR__) . "/vendors/prediction-builder/src/PredictionBuilder.php");
			//'/vendor/autoload.php');
			//I can get my Data Science Certificate: I can get Composer autoload.php to work
			//Linear Regression: Spend Credit on Making Money
//$data = [[1,20],[2,70],[2,45],[3,81],[5,73],[6,80],[7,110]];

		$criteria=new CDbCriteria;
		$criteria->addCondition('create_time >= :create_time');
$criteria->params[':create_time'] = date('Y-m-d h:i:s', strtotime('-1 year'));
		$criteria->order = "create_time desc";

$data = Yii::app()->db->createCommand()
    ->select('charge')
    ->from('tbl_flock')
    ->queryAll($criteria);
    

$flock = array();
$pay_the_bird_dog = 0;
foreach($data as $pay)
{
	$pay_the_bird_dog += 1;
	array_push($flock, array($pay_the_bird_dog, $pay[charge]));
	

}
		//What I Got $0.15
		$x = 0.15;

		$prediction = new PredictionBuilder($x, $flock);
		//Bring a Smile to the Bank
    	$result = $prediction->build();
    	

    	//p-value < 0.05: Common Sense
print json_encode(array("vetting_fee"=>round($result->cor, 2))); //Wire Transfer: Float
		die();
   
		} catch (Exception $e) {
  			
			echo 'Message: ' . $e->getMessage();
			
		}
		
		//Pay The Bird Dog
		/*
		header('Content-Type: application/json');
		
		//buyer_id and portfolio_id
		//update status
		$cash_buyers_list = Yii::app()->db->createCommand()
    ->select('buyer_id, portfolio_id')
    ->from('tbl_match fistfuls_of_cash')
	->limit(1)
	->where('status_id = :status_id AND create_user_id = :create_user_id', array(':create_user_id'=>Yii::app()->user->id,':status_id'=>1))
    ->queryRow();

    //Linear Regression
$data = [[1,20],[2,70],[2,45],[3,81],[5,73],[6,80],[7,110]];
$x = 4.5;



//What is the expected y value for a given x value?
try {
		//Use  composer autoload in vendors
		$prediction = new PredictionBuilder($x, $data);
    $result = $prediction->build(); // y = 76.65
} catch (\Exception $e) {
    echo $e->getMessage(), "\n";
}

		//Gradient Descent Recommend Fistfuls of Cash with Minimum Loss
	
		print json_encode(array("buyer_id"=>$cash_buyers_list['buyer_id'],"portfolio_id"=>$result));
		//Vote
		die();
		*/

	}
	
	public function actionPOFAmount()
	{
		//on-Click Fistfuls async
		//return It Multiplies
		//Binary Search Tree
		//to get Randy Ford a referral
		header('Content-Type: application/json');
		
		//return Fistfuls:
		print json_encode(array('match'=>$match->id));
		//Get him a refferal
		die();
	}
	
	//echoes json
	public function actionDoggingFistfuls()
	{
		header('Content-Type: application/json');
		
		//on-Click Dogging Fistfuls async
		//return OKBird Matches
		//Binary Search Tree to get Randy Ford a referral
		//Use Model: for $111K, matchTable $pof_amounts sorted by $trillionaire to $minimum_purchase_price: 3 Months Fistfuls
		$criteria=new CDbCriteria;
		$criteria->addCondition('create_time >= :create_time');
$criteria->params[':create_time'] = date('Y-m-d h:i:s', strtotime('-3 month'));
		$criteria->select = "pof_amount";
		$criteria->order = "pof_amount desc";
		$cash_buyer = Buyer::model()->findAll($criteria);
		
		$cash_buyers_list = array();
		//$limit = 0;
		foreach($cash_buyer as $fistfuls)
		{
			//$limit += 1;
			//if ($limit < 1090)
			//{
			  array_push($cash_buyers_list, $fistfuls->pof_amount);
			//}

		}
		
		//sorted Trillionaire to Minimum Purchase Price
		//print_r($cash_buyers_list);
		$flock = 111000;
		$right = max($cash_buyers_list);
		$left = min($cash_buyers_list);
		$motivated_sellers_list = array();
		
		
		while ($left < $right)
		{
				$mid = ($left + $right)/2;
				
				if($flock < $mid)	{
				$right = $mid;
					array_push($motivated_sellers_list, $right);
				//set mid == to left
				} elseif ($mid < $flock) {
					$left = $mid;
					array_push($motivated_sellers_list, $left);
				} else {
				//return json
				//return $fistfuls + $flock
		
		//fistfuls_of_cash are Credit
		$criteria=new CDbCriteria;
		$criteria->condition= "status_id != 2 AND score >= 0";
			$fistfuls_of_cash = count(MatchTable::model()->findAll($criteria));

			foreach($motivated_sellers_list as $bring_me_fistfuls)
				{
				
					//{"fistfuls":"$3025"}{"fistfuls":"$1538"}{"fistfuls":"$794"}{"fistfuls":"$422"}{"fistfuls":"$236"}{"fistfuls":"$143"}{"fistfuls":"$96"}
					//Cum on The Golden Egg
$golden_egg == false;					
if (($flock  -$fistfuls_of_cash) >  $bring_me_fistfuls)
					{
						$golden_egg = true;
						print json_encode(array("fistfuls"=>"$" . round($bring_me_fistfuls/1000)));
						break;
					}

				} 
				
				//the blondes tell me what Love is
				if($golden_egg == false)
				{
						print json_encode(array("fistfuls"=>"$" . round($flock/1000)));
				}
					
				

				//print json_encode(array("fistfuls"=>$motivated_sellers_list));
				//$100K is a Lot of Money
				die();
				
				}
		

		}
				
		
		//Yii::app()->user->setFlash('success', "The Bird Dog just got you a Minimum Purchase Price.");
		
		//print json_encode(array("buyer_id"=>$cash_buyers_list['buyer_id'],"portfolio_id"=>$result));
		//Vote
		//die();

		//print json_encode(array('match'=>$match->id));
		//Vote
		//die();

	}

	/**
	*OKBird
	*/
	public function actionBirdDog()
	{
	
		$criteria=new CDbCriteria;
		$criteria->condition= "status_id = 1";
		$criteria->limit = 1;
		$criteria->order = "create_time desc";
		$match = MatchTable::model()->find($criteria);
		
		$match->create_time = date("y:F:d",strtotime("-3 Months"));
		
		$match->update();
		
		Yii::app()->user->setFlash('success', "You will Follow-Up in 3 Months.");
		
		$this->redirect("https://www.accesstheflock.io/birds-of-a-feather");
		
	}

	/**
	 * Lists all models.
	 */
	public function actionPayTheBirdDog()
	{
	
		//header('Access-Control-Allow-Origin: https://www.accesstheflock.io/matchTable/PayTheBirdDog'); 
		
		//If OKBird print Fistfuls of Cash
		//Insert into bottom of MatchTable
		//Load recent create_time 
		
		//buyer_id and portfolio_id
		$affordability = Yii::app()->db->createCommand()
    ->select('cash_buyer.id as buyer_id, portfolio.id as portfolio_id, min_dollar')
    ->from('tbl_buyer cash_buyer')
    ->join('tbl_portfolio portfolio', 'cash_buyer.status_id=portfolio.status_id')
	->limit(1)
	->where('(pof_amount >= min_dollar AND (cash_buyer.create_user_id=:create_user_id OR portfolio.create_user_id=:create_user_id) AND (cash_buyer.status_id=:status_id OR portfolio.status_id=:status_id))', array(':create_user_id'=>Yii::app()->user->id,':status_id'=>1))
    ->queryAll();
		
		$this->render('gold',array(
			'affordability'=>$affordability,
		));
	}



	
	/**
	 * Manages all models.
	 */
	public function actionSearch()
	{
		
	  	ini_set("memory_limit",-1);
		set_time_limit(0);
	
		$this->layout='//layouts/column1';
	
		$user_id = Yii::app()->user->id;
		
		if(Yii::app()->user->id == 92)
		{
			$criteria=New CDbCriteria;
			$criteria->condition= "status_id != 2 AND score >= 0";
			$criteria->order = 'update_time DESC, score DESC';
			$criteria->limit = 1;
			$model=MatchTable::model()->findAll($criteria);
		} else {
			$criteria=New CDbCriteria;
			$criteria->condition="(path_to_seller = $user_id OR path_to_buyer = $user_id) AND status_id != 2 AND score >= 0";
			$criteria->order = 'update_time DESC, score DESC';
			$criteria->limit = 1;
			$model=MatchTable::model()->findAll($criteria);
		 } 
	
		 if(isset($_GET['Match']))
		{
			Yii::app()->user->mp_increment("Filtered Matches");
			$model->attributes=$_GET['Match'];
			
		}
		
   		$buyers_markets = WhereLooking::model()->findAll();
		
   		
   		$asset_type_markets = AssetType::model()->findAll();
   		$property_markets = Property::model()->findAll();
   		//count
		$criteria=New CDbCriteria;
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


	//Matches
		$now = new CDbCriteria;
		//$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)';
		//$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)';
		$now->condition = 'create_time >= DATE_SUB(CURDATE(), INTERVAL 1 DAY)';
		
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
		
		$inflation = Charge::model()->findAllByPk(1)->charge;
		
		$charges = Charge::model()->findAll();
		
		foreach($charges as $charge)
		{
			$inflation += $charge->charge;
		}
		
		$flock = floor(round(($flock * $inflation) - $inflation, 0));
		
		//Begin Birds of a Feather
		$charge = Charge::model()->findAll();
		
		$flock = 0;
		foreach($charge as $fistful_of_cash)
		{
			$flock += $fistful_of_cash->charge;
		}
		
		$fistfuls_of_cash = $count;
		$birds_of_a_feather = number_format($flock / $fistfuls_of_cash, 2,'.', ',');
		
		$OKBird = $birds_of_a_feather;
		
		if($birds_of_a_feather < .01)
		{
			$birds_of_a_feather = 0.01;
		}
		
		$flock = $birds_of_a_feather * Yii::app()->user->countmatches;
		
		if($flock > 6000)
		{
			$flock = 6000;
		}
		
		$flock = $flock - 0.01;
		
		//Currency Manipulator
		if($flock < 1)
		{
			$flock = 1;
		}
		
		$this->render('search',array(
				'model'=>$model,
				'count' => count($model),
				'buyers_markets'=>$buyers_markets,
        		'asset_type_markets'=>$asset_type_markets,
        		'property_markets' => $property_markets,
        		'OKBird' => $OKBird,
				'flock' => $flock
		));
	}
	
	/**
	 * Calculates the earth distance between two latitude-longitude points
	 * @param float $latitudeFrom Latitude of start point in [deg decimal]
	 * @param float $longitudeFrom Longitude of start point in [deg decimal]
	 * @param float $latitudeTo Latitude of target point in [deg decimal]
	 * @param float $longitudeTo Longitude of target point in [deg decimal]
	 * @param float $earthRadius Mean earth radius in [m]
	 * @return float Distance between points in [m] (same as earthRadius)
	 */
	function earth_distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
	{
	  // convert from degrees to radians
	  $latFrom = deg2rad($latitudeFrom);
	  $lonFrom = deg2rad($longitudeFrom);
	  $latTo = deg2rad($latitudeTo);
	  $lonTo = deg2rad($longitudeTo);
	
	  $latDelta = $latTo - $latFrom;
	  $lonDelta = $lonTo - $lonFrom;
	
	  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
	    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	  return $angle * $earthRadius;
	}
	
	
	
	
	
	/**
	 * Manages all models.
	 */
	public function actionRelationToSeller()
	{

		
	
		$this->layout='//layouts/match';
		
		if(isset($_POST['portfolioId']))
		{
			$username= User::model()->findByPk(Portfolio::model()->findByPk($_POST['portfolioId'])->create_user_id)->username;
			
			switch (Portfolio::model()->findByPk($_POST['portfolioId'])->relation_to_seller) 
			{
			    case "33":
			     	echo $username . " is the seller";
			        break;
			    case "32":
			    	echo $username . " is direct to the seller";
			        break;
			    case "31":
			    	echo $username . " knows the seller's representation";
			        break;
			    default:
			    	echo $username;
			}
			
		}
	}
	
	/**
	 * Manages all models.
	 */
	public function actionRelationToBuyer()
	{

	
		$this->layout='//layouts/match';
		
		if(isset($_POST['buyerId']))
		{
			$username= User::model()->findByPk(Buyer::model()->findByPk($_POST['buyerId'])->create_user_id)->username;
			
			switch (Buyer::model()->findByPk($_POST['buyerId'])->relation_to_buyer) 
			{
			    case "3":
			     	echo $username . " is the buyer";
			        break;
			    case "2":
			    	echo $username . " is direct to the buyer";
			        break;
			    case "1":
			    	echo $username . " knows the buyer's representation";
			        break;
			    default:
			    	echo $username;
			}
			
		}
	}
	
	/**
	 * Manages all models.
	 */
	public function actionProofOfFunds()
	{

	
		$this->layout='//layouts/match';
		
		
		if(isset($_POST['buyerId']))
		{
			echo 'This buyer has ' . '$'.Yii::app()->format->number(Buyer::model()->findByPk($_POST['buyerId'])->pof_amount) . ' to close on ';
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MatchTable the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MatchTable::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MatchTable $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='match-table-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
