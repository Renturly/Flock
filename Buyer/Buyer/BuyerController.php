<?php

//Yii::import('application.vendors.Mixpanel.*');

Yii::import('application.vendors.mandrill.*');
require_once 'src/Mandrill.php';


			ini_set('max_execution_time', 7);
			set_time_limit(7);

class BuyerController extends Controller
{
	/**
	 * @var string the default layout for the viewsp. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			
			'postOnly + delete', // we only allow deletion via POST request
			//'listingPropertyContext +update',
			'updateDeleteContext +update, delete',
			
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
		/*
			array('deny', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create'),
				'users'=>array('MichaelDSadler','matches'),
				),
		*/
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view','list','wherelooking','apartmentbuilding','api'),
				'users'=>array('*'),
			),
			array('allow',  // allow all users
				'actions'=>array('interview','letterofintent', 'buyerwidget','matches'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view','create','update','admin','interview','togglematch','search'),
					'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete','admin'),
				'users'=>array('michael.sadler@gmail.com'),
					),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionSearch()
	{
		$this->layout='column1';
		
		$search = $_POST['search'];
		
		$user_id = Yii::app()->user->id;
		
		$criteria = new CDbCriteria();
		$criteria->condition = "create_user_id = $user_id";
		$criteria->addSearchCondition('buyer_code', $search);
		 
		$model = Buyer::model()->findAll($criteria);
		
		$this->render('admin',array(
			'model'=>$model,
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
	
	
	/*
	 * Bird Dog Matching Algorithm
	 */
	public function actionToggleMatch($id)
	{	

		
		$buyer = Buyer::model()->findByPk($id);

		if($buyer->status_id == 1)
		{
			$buyer->status_id = 2;
			$buyer->update(false);
		} elseif($buyer->status_id == 2)
		{
			$buyer->status_id = 1;
			$buyer->update(false);
		}
		
		if(Yii::app()->user->id != 92)
		{
			//Track Click Toggle Buyer
			Yii::app()->user->mp_track("Bird Dog");
			Yii::app()->user->mp_increment("Bird Dog");
		}
		
		if(Yii::app()->user->id == 92)
		{
			//Track Click Toggle Buyer
			Yii::app()->user->mp_track("Pay The Bird Dog");
			Yii::app()->user->mp_increment("Pay The Bird Dog");
		}

		
		

	  //Begin Matching Algorithm
       try {
       
       
			$seconds = time(TRUE);
       
			ini_set('max_execution_time', 7);
			set_time_limit(7);
		
 			$FistfulsofCash = array();
	        
		    if($buyer->status_id == 1)
		    {    
		    	//New Algorithm
		    	$limit = 0;
		    	
				
		    	
		    	$criteria = new CDbCriteria;
		    	//the limit is what makes Buyers load quickly
				$criteria->limit = 200;
				$criteria->order = "create_time desc";
				//active
				
Yii::app()->cache->set($portfolio, Portfolio::model()->findAll($criteria));
				
$portfolios=Yii::app()->cache->get($portfolio);
				
		    	foreach($portfolios as $portfolio)
		    	{
		    	
			
		    		
		    		//You can Access The Flock
		    		
		    		
		    	   	if($limit == 100)
	    			{
	    				break;
	    			}
		    		
		    		$score = 0;
		    		
					//Enough Money
		    		if($portfolio->min_dollar <= $buyer->pof_amount)
		    		{
						//Seller Asset Types
			    		$asset_type_match = 0;
			    		foreach($portfolio->asset_types as $asset_type)
			    		{
			    			
			    			//Location
			    			$location_match = 0;
			    			foreach($buyer->where_looking as $where_looking)
				    		{
				    			if(empty($where_looking->radius) || $where_looking->radius == 0)
					    		{
					    			$radius = 100000;
					    		} else {
					    			$radius = $where_looking->radius * 1609.34;
					    		}
					    		
					    		if($this::earth_distance($asset_type->latitude, $asset_type->longitude, $where_looking->latitude, $where_looking->longitude) < $radius)
					    		{
					    			if(!empty($asset_type->latitude) && !empty($asset_type->longitude) && !empty($where_looking->latitude) && !empty($where_looking->longitude))
					    			{
					    				$location_match = 1;
					    				
					    				//Buyer & Seller Asset Type in Location
							    		
							    		foreach($buyer->types_looking as $types_looking)
							    		{
							    			if($types_looking->building_type == $asset_type->asset_type)
							    			{
							    				$score += 1;
							    				$asset_type_match = 1;
							    			}
							    		}
							    		
					    			} 
					    		} 
				    		}
				    		
			    		}
			    		
	    		  		//Save the match if score > 0
			    		//if($score >= 0 && $location_match == true && $asset_type_match == true && Users::model()->findByPk($portfolio->create_user_id)->getVoteSum() >= 0 && Customer::model()->findByAttributes(array('create_user_id'=>$portfolio->create_user_id)) && Customer::model()->findByAttributes(array('create_user_id'=>$buyer->create_user_id)))
			    		
//throw new Exception("Not a Match"); 
			    		
//Doesn't pass this condition
//Users::model()->findByPk($portfolio->create_user_id)->getVoteSum() >= 0 && Users::model()->findByPk($buyer->create_user_id)->getVoteSum() >= 0 && Users::model()->findByPk($portfolio->create_user_id)->id != 92
$votes_for_renturly = Users::model()->findByPk($portfolio->create_user_id)->getVoteSum();
$votes_for_fistfuls = Users::model()->findByPk($buyer->create_user_id)->getVoteSum();
$I_just_sent_the_first_email = Users::model()->findByPk($portfolio->create_user_id)->id;

if($asset_type_match > 0 && $location_match > 0)
			    		{	
			
			    			$limit += 1;
			    			
			if(Users::model()->findByPk($portfolio->create_user_id)->id != 1722)
			    			{
			    			
			    			$match = MatchTable::model()->findByAttributes(array('buyer_id'=>$buyer->id,'portfolio_id'=>$portfolio->id));
			    			if(count($match) > 0)
			    			{
			    				//update score
			    				$match->score = $score;
			    				$match->status_id = 1;
			    				
	      		//Track Matches
					      		
									Yii::app()->user->mp_track("Fistfuls of Cash");
									Yii::app()->user->mp_increment("Fistfuls of Cash");
																
			    				$match->update();
			    				
			    			} else {
			    				//save new match
			    				$match = new MatchTable;
					      		$match->buyer_id = $buyer->id;
					      		$match->portfolio_id = $portfolio->id;
					      		$match->path_to_buyer = $buyer->create_user_id;
					      		$match->path_to_seller = $portfolio->create_user_id;
					      		$match->score = $score;
					      		$match->status_id = 1;
					      		
	      		//Track Matches
					      		
								
									Yii::app()->user->mp_track("Fistfuls of Cash");
									Yii::app()->user->mp_increment("Fistfuls of Cash");
																
					      		$match->save(false);
					      		
				
								
if(!Yii::app()->user->isGuest)
								{
									$UrlyBird = User::model()->findByPk($portfolio->create_user_id);
									array_push($FistfulsofCash, $UrlyBird->email);
						
								}
												
								
			    				}
			    			}
			    			
			    			
			    			
			    		} else {
			    			//change status to not quality any more
			    			//Add binary dropped threshold attribute to tbl_match
			    		    $match = MatchTable::model()->findByAttributes(array('buyer_id'=>$buyer->id,'portfolio_id'=>$portfolio->id));
			    			if(count($match) > 0)
			    			{
			    				//update score
			    				$match->score = $score;
			    				$match->status_id = 2;
			    				$match->update();
			    			}
			    		}
			    		

			    	}
		    	}
		    	
		    }    	
		    
		    
		    
		    
            if ($buyer->status_id == 2)
		    {
		    	
		    	foreach(MatchTable::model()->findAllByAttributes(array('buyer_id'=>$buyer->id)) as $match)
		    	{
	
		    			$match->status_id = 2;
		    			$match->update();

		    	}
		    }
		    
		    //$this->PayTheBirdDog(array_unique($FistfulsofCash));
		    
/*		    
		    foreach($PayTheBirdDog as $FistfulsofCash)
		    {
		    				    			    //Send notification email to seller
									$message = new YiiMailMessage;
									$message->view = 'newMatch';
									$message->subject = "Birds of a Feather";
									 
									//userModel is passed to the view
									$message->setBody(array('match'=>$match), 'text/html');
									 
									$message->addTo($FistfulsofCash);
									$message->from = Yii::app()->params['adminEmail'];
									Yii::app()->mail->send($message);
		    }
*/		    
	       	} catch(Exception $e) {
					//print_r($e->getMessage());
					//Yii::app()->end();
					Yii::app()->user->setFlash('alert','Could not calculate matches. Email Chief Bird Dog michael.sadler@accesstheflock.io.');
					
$this->redirect(array('matchTable/search'));
					
			}
			
		
	}
	
	public function PayTheBirdDog($FistfulsofCash)
	{
		$match_users = User::model()->findAll(array('order' => 'update_time ASC','limit' => 5));
				$message = new YiiMailMessage;
				$message->view = 'newMatch';
				$message->subject = "Birds of a Feather";
				$message->setBody(array('match'=>$match), 'text/html');	
			foreach($match_users as $match_user)
			{	
								 
				$message->addTo($match_user->email);
				$message->from = Yii::app()->params['adminEmail'];							
				Yii::app()->mail->send($message);
	
			}

		
	}
	
	public function actionApartmentBuilding()
	{
		$this->pageTitle = 'Dogging: Buy Apartment Buildings';
		
		//SQL
		$criteria = new CDbCriteria;
		//$criteria->select = "create_user_id";
		$criteria->condition = 'building_type = 8';
		$criteria->order = "create_time desc";
		$criteria->limit = 1;
		
		$cash_buyers = TypesLooking::model()->findAll($criteria);
		
		
		$pofs=array();
		foreach($cash_buyers as $pof)
		{
			$criteria = new CDbCriteria;
			$criteria->select = 'pof_amount';
			$criteria->condition = 'id = ' .$pof->id;
			$pof_amount = Buyer::model()->find($criteria);
			array_push($pofs, $pof_amount);
		}
		
//print_r($cash_buyers);

		$this->render('ApartmentBuilding',array(
			'cash_buyers' => $cash_buyers,
			'pofs' => $pofs,
		));
	}
	
	
	public function actionMatchAll()
	{	
		
		ini_set("memory_limit",-1);
		set_time_limit(0);

		$buyers = Buyer::model()->findAllByAttributes(array('create_user_id'=>Yii::app()->user->id));

		foreach($buyers as $buyer)
		{
			$buyer->status_id = 1;
			$buyer->update(false);
		}
		
		$this->redirect(Yii::app()->createUrl('/buyer/admin'));
	}
	
	public function actionTakeAllOffMarket()
	{	

		ini_set("memory_limit",-1);
		set_time_limit(0);
		
		$buyers = Buyer::model()->findAllByAttributes(array('create_user_id'=>Yii::app()->user->id));

		foreach($buyers as $buyer)
		{
			$buyer->status_id = 2;
			$buyer->update(false);
		}
		
		$this->redirect(Yii::app()->createUrl('/buyer/admin'));
	}
	
	public function actionApi()
	{
		
		//from a POST request
		if(isset($_POST['asset_type']) && isset($_POST['location']) && isset($_POST['radius']) && isset($_POST['email']) && isset($_POST['pof_amount']))
		{
			
			$buyer = new Buyer;
		
			$transaction=$buyer->dbConnection->beginTransaction();
			
			$user = User::model()->findByAttributes(array('email'=>$_POST['email']));
			$buyer->create_user_id = $user->id;
			$buyer->update_user_id = $user->id;
			
			
			//$buyer->buyer_code = $_POST['buyer_code'];
			
			$buyer->pof_amount = $_POST['pof_amount'];
			

			$buyer->status_id = 2;
			
			/*
			if ($_POST['relation_to_buyer'] == 'I am the buyer')
			{
				$buyer->relation_to_buyer = 3;
			}
			if ($_POST['relation_to_buyer'] == 'I am direct to the buyer')
			{
				$buyer->relation_to_buyer = 2;
			}
			if ($_POST['relation_to_buyer'] == "I know the buyer's representation")
			{
				$buyer->relation_to_buyer = 1;
			}
			*/
			
			$buyer->allowed_commission = $_POST['allowed_commission'];
			
		
		
			//Communicate the validation
			$buyer->validate(false);
			
			
			if($buyer->save(false))
			{
				
				
			       $types_looking = new TypesLooking;
	               $types_looking->id = $buyer->id;
	           	   $type = $_POST['asset_type'];
	               $types_looking->building_type = BuildingType::model()->findByAttributes(array('type'=>$type))->id;
	               $types_looking->validate(false);
	            				
	               $types_looking->save(false);
	               
	               
	               $where_looking = new WhereLooking;
		           $where_looking->id = $buyer->id;
		           $where_looking->location = $_POST['location'];
		           $where_looking->radius = $_POST['radius'];
		           $gMap = new EGMap();
				   $geocoded_address = new EGMapGeocodedAddress($where_looking->location);
				   $geocoded_address->geocode($gMap->getGMapClient());
				   $where_looking->latitude=$geocoded_address->getLat();
				   $where_looking->longitude=$geocoded_address->getLng();
				   $where_looking->validate(false);
									
		           $where_looking->save(false);
		           
		           Yii::app()->user->mp_track("Fistfuls of Cash");
				   Yii::app()->user->mp_increment("Fistfuls of Cash");
		           
		           
			}
			
			$transaction->commit();
			
			//Track Accessed The Flock in Mixpanel when someone creates a match
			Yii::app()->user->mp_track("Cash Buyer Landing Page");
			Yii::app()->user->mp_increment("Cash Buyer Landing Page");
			
			
			$this->actionToggleMatch($buyer->id);
						
			//$this->redirect(Yii::app()->createUrl('/buyer/admin'));
			$this->redirect(Yii::app()->createUrl('/matchTable/search'));
		
			//$this->redirect(Yii::app()->createUrl('/buyer/admin'));
			
			//$buyer->afterSave();
			
		}
		
	}
	
	public function actionMatches()
	{
			$matches = MatchTable::model()->findAll();
		
			$where_lookings = array();
			foreach($matches as $match)
			{
				$buyer = Buyer::model()->findByPK($match->buyer_id);
				foreach($buyer->where_looking as $where_looking)
				{
					array_push($where_lookings, array(
						'location'=>$where_looking->location,
						'radius'=>$where_looking->radius,
						'longitude'=>$where_looking->longitude,
						'latitude'=>$where_looking->latitude,
						'pof_amount'=>$buyer->pof_amount,
					));
				}

			}
			
		
			print json_encode($where_lookings);
			die();
	}
	
	/*
	*Cash Buyers List
	*
	*
	*
	*
	*
	*
	*
	*
	*/
	public function actionWhereLooking($id = 0)
	{
		header('Content-Type: application/json;charset=UTF-8');
		
		//for buyers list
		if($id == 0)
		{
			
			$criteria = new CDbCriteria;
			//active
			$criteria->condition = "create_user_id != 92";
			$criteria->order = "create_time desc";
			$criteria->limit = 80;//1300;
			$where_lookings = WhereLooking::model()->findAll($criteria);
		
			$whereLookings = array();
			foreach ($where_lookings as $where_looking)
			{
				$buyer = Buyer::model()->findByPk($where_looking->id);
				foreach($buyer->types_looking as $type_looking)
				{
					if($buyer->status_id == 1 && $buyer->create_user_id != 92 && $buyer->create_user_id != 583)
					if(true)
					{
						array_push($whereLookings,array(
							'id'=>$where_looking->id,
							'location'=>$where_looking->location,
							'type'=>$type_looking->type->type,
							'radius'=>$where_looking->radius,
							'longitude'=>$where_looking->longitude,
							'latitude'=>$where_looking->latitude,
							'pof_amount' => Yii::app()->format->number(CHtml::encode($buyer->pof_amount)),
						));
					}
				}
					

			}
			print json_encode($whereLookings);
			die();
			
		//For view buyer	
		} else {
			
			$id = (int) $id;
			
			$where_lookings = WhereLooking::model()->findAllByAttributes(array('id'=>$id));

			
			$whereLookings = array();
			foreach ($where_lookings as $where_looking)
			{
				$buyer = Buyer::model()->findByPk($id);
				array_push($whereLookings,array(
					'id'=>$where_looking->id,
					'location'=>$where_looking->location,
					'radius'=>$where_looking->radius,
					'longitude'=>$where_looking->longitude,
					'latitude'=>$where_looking->latitude,
					'pof_amount' => $buyer->pof_amount,
				));
			}
			print json_encode($whereLookings);
			die();
		}

	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model=$this->loadModel($id);
		
		$this->render('view',array(
				'model'=>$model,

		));
		
		/*
		if(!Yii::app()->user->isGuest && Yii::app()->user->id != $model->create_user_id)
		{
			
    			    //Send notification email to seller
					$message = new YiiMailMessage;
					$message->view = 'buyerView';
					$message->subject = "Your Buyer Was Viewed";
					 
					//userModel is passed to the view
					$message->setBody(array('buyer'=>$model), 'text/html');
					 
					$user = User::model()->findByPk($model->create_user_id);
					$message->addTo($user->email);
					$message->from = Yii::app()->params['adminEmail'];
					Yii::app()->mail->send($message);
					
					//Track Match Alert when match email is sent
					//Yii::app()->user->mp_track("Selling");
					//Yii::app()->user->mp_increment("Selling");

		}
		*/

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
 
		header('Access-Control-Allow-Origin: http://www.accesstheflock.io');
		
		ini_set("memory_limit",-1);
		set_time_limit(30);
		
		$model=new Buyer;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Buyer']) || isset($_POST['BuyFromType']) || isset($_POST['TypesLooking']) || isset($_POST['TypesPurchased']) || isset($_POST['WhereLooking']) || isset($_POST['WherePurchased']))
		{
		
			
			//Validate Buyer
			$model->attributes=$_POST['Buyer'];
			$valid=$model->validate(false);


			//Validate BuyFromTypes
			if(isset($_POST['BuyFromType']))
			{
				$buy_from_types=array();
				$repeat=array();
				foreach($_POST['BuyFromType'] as $post)
				{
					if(!empty($post['organization_type']) && !in_array($post['organization_type'],$repeat))
					{
						array_push($repeat,$post['organization_type']);
						$buy_from_type=new BuyFromType;
						$buy_from_type->attributes=$post;
						$valid=$buy_from_type->validate(false) && $valid;
						array_push($buy_from_types,$buy_from_type);
					}
				}
				$model->buy_from_types=$buy_from_types;
			}
	
			//Validate TypesLooking
			if(isset($_POST['TypesLooking']))
			{
				$types_looking=array();
				$repeat=array();
				foreach($_POST['TypesLooking'] as $post)
				{
					if(!empty($post['building_type']) && !in_array($post['building_type'],$repeat))
					{
						array_push($repeat,$post['building_type']);
						$type_looking=new TypesLooking;
						$type_looking->attributes=$post;
						$valid=$type_looking->validate(false) && $valid;
						array_push($types_looking,$type_looking);
					}
				
				}
				$model->types_looking=$types_looking;
			} 

			
			//Validate TypesPurchased
			if(isset($_POST['TypesPurchased']))
			{
				$types_purchased=array();
				$repeat=array();
				foreach($_POST['TypesPurchased'] as $post)
				{
					if(!empty($post['building_type']) && !in_array($post['building_type'],$repeat))
					{
						array_push($repeat,$post['building_type']);
						$type_purchased=new TypesPurchased;
						$type_purchased->attributes=$post;
						$valid=$type_purchased->validate(false) && $valid;
						array_push($types_purchased,$type_purchased);
					}
				
				}
				$model->types_purchased=$types_purchased;
			}

			
			//Validate WhereLooking
			if(isset($_POST['WhereLooking']))
			{
				$where_lookings=array();
				$repeat=array();
				foreach($_POST['WhereLooking'] as $post)
				{	
					$where_looking=new WhereLooking;
					$where_looking->attributes=$post;
					
					if($where_looking['location'] != '' && !in_array($post['location'],$repeat))
					{
						array_push($repeat,$post['location']);

				        $latlong = $this->get_lat_long($where_looking->location);

						$where_looking->latitude = $latlong['lat'];
						$where_looking->longitude = $latlong['lon'];
						$valid=$where_looking->validate(false) && $valid;
						array_push($where_lookings,$where_looking);
					}
				}

				$model->where_looking=$where_lookings;
			}

			
			//Validate WherePurchased
			if(isset($_POST['WherePurchased']))
			{
				$where_purchaseds=array();
				$repeat=array();
				foreach($_POST['WherePurchased'] as $post)
				{
					$where_purchased=new WherePurchased;
					$where_purchased->attributes=$post;
					
					if($where_purchased['location'] != '' && !in_array($post['location'],$repeat))
					{
						array_push($repeat,$post['location']);
						$gMap = new EGMap();
						$geocoded_address = new EGMapGeocodedAddress($where_purchased->location);
						$geocoded_address->geocode($gMap->getGMapClient());
						$where_purchased->latitude=$geocoded_address->getLat();
						$where_purchased->longitude=$geocoded_address->getLng();
						$valid=$where_purchased->validate(false) && $valid;
						array_push($where_purchaseds,$where_purchased);
					}
				}
				$model->where_purchased=$where_purchaseds;
			}

			if ($valid)
			{

				try
				{
					//Save as not matching. Needs Toggle Match Matching
					$model->status_id = 2;
					
					$transaction=$model->dbConnection->beginTransaction();
					if($model->save(false))
					{
						foreach($model->buy_from_types as $buy_from_type)
						{
							$buy_from_type->id=$model->id;
							$buy_from_type->save(false);
						}
						foreach($model->types_looking as $type_looking)
						{
							$type_looking->id=$model->id;
							$type_looking->save(false);
						}
						foreach($model->types_purchased as $type_purchased)
						{
							$type_purchased->id=$model->id;
							$type_purchased->save(false);
						}
						foreach($model->where_looking as $where_looking)
						{
							$where_looking->id=$model->id;
							$where_looking->save(false);
						}
						foreach($model->where_purchased as $where_purchased)
						{
							$where_purchased->id=$model->id;
							$where_purchased->save(false);
						}
						//Yii::app()->user->setFlash('success',"The buyer has been saved!");
						Yii::log('added_buy', 'info', 'Buyer.add');
						
						
						
						$transaction->commit();

						$this->actionToggleMatch($model->id);
						
						//$this->redirect(Yii::app()->createUrl('/buyer/admin'));
						$this->redirect(Yii::app()->createUrl('/matchTable/search'));
						
					}

				}
				catch(Exception $e) // an exception is raised if a query fails
				{
					Yii::app()->user->setFlash('alert','Contact us for help.');
					$transaction->rollback();
				}
			}

		}



		$this->render('create',array(
				'model'=>$model,
		));

	




		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		/*
		if(isset($_POST['Buyer']))
		{
			$model->attributes=$_POST['Buyer'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
		*/
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionBuyerWidget()
	{
		
		
		$model=new Buyer;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Buyer']) || isset($_POST['BuyFromType']) || isset($_POST['TypesLooking']) || isset($_POST['TypesPurchased']) || isset($_POST['WhereLooking']) || isset($_POST['WherePurchased']))
		{
		
			//Find the user id from the website
			if(isset($_POST['site']))
			{
				$site = $_POST['site'];
				$user_id = UsersData::model()->findByAttributes(array('site'=>$site))->id;
				
			}
			
			
			//Validate Buyer
			$model->attributes=$_POST['Buyer'];
			
			//Set to matching;
			$model->status_id = 1;
			
			$model->buyer_name = $_POST['Buyer']['buyer_name'];
			$model->buyer_telephone = $_POST['Buyer']['buyer_telephone'];
			$model->buyer_email = $_POST['Buyer']['buyer_email'];
			
			$valid=$model->validate(false);

			
			//Validate BuyFromTypes
			if(isset($_POST['BuyFromType']))
			{
				$buy_from_types=array();
				$repeat=array();
				foreach($_POST['BuyFromType'] as $post)
				{
					if(!empty($post['organization_type']) && !in_array($post['organization_type'],$repeat))
					{
						array_push($repeat,$post['organization_type']);
						$buy_from_type=new BuyFromType;
						$buy_from_type->attributes=$post;
						$valid=$buy_from_type->validate(false) && $valid;
						array_push($buy_from_types,$buy_from_type);
					}
				}
				$model->buy_from_types=$buy_from_types;
			}

			//Validate TypesLooking
			if(isset($_POST['TypesLooking']))
			{
				$types_looking=array();
				$repeat=array();
				foreach($_POST['TypesLooking'] as $post)
				{
					if(!empty($post['building_type']) && !in_array($post['building_type'],$repeat))
					{
						array_push($repeat,$post['building_type']);
						$type_looking=new TypesLooking;
						$type_looking->attributes=$post;
						$valid=$type_looking->validate(false) && $valid;
						array_push($types_looking,$type_looking);
					}
				
				}
				$model->types_looking=$types_looking;
			} 

			
			//Validate TypesPurchased
			if(isset($_POST['TypesPurchased']))
			{
				$types_purchased=array();
				$repeat=array();
				foreach($_POST['TypesPurchased'] as $post)
				{
					if(!empty($post['building_type']) && !in_array($post['building_type'],$repeat))
					{
						array_push($repeat,$post['building_type']);
						$type_purchased=new TypesPurchased;
						$type_purchased->attributes=$post;
						$valid=$type_purchased->validate(false) && $valid;
						array_push($types_purchased,$type_purchased);
					}
				
				}
				$model->types_purchased=$types_purchased;
			}

			
			//Validate WhereLooking
			if(isset($_POST['WhereLooking']))
			{
				$where_lookings=array();
				$repeat=array();
				foreach($_POST['WhereLooking'] as $post)
				{
					$where_looking=new WhereLooking;
					$where_looking->attributes=$post;
					
					
					if($where_looking['location'] != '' && !in_array($post['location'],$repeat))
					{
						array_push($repeat,$post['location']);
						$gMap = new EGMap();
						$geocoded_address = new EGMapGeocodedAddress($where_looking->location);
						$geocoded_address->geocode($gMap->getGMapClient());
						$where_looking->latitude=$geocoded_address->getLat();
						$where_looking->longitude=$geocoded_address->getLng();
						$valid=$where_looking->validate(false) && $valid;
						array_push($where_lookings,$where_looking);
					}
				}
				$model->where_looking=$where_lookings;
			}

			
			//Validate WherePurchased
			if(isset($_POST['WherePurchased']))
			{
				$where_purchaseds=array();
				$repeat=array();
				foreach($_POST['WherePurchased'] as $post)
				{
					$where_purchased=new WherePurchased;
					$where_purchased->attributes=$post;
					
					
					if($where_purchased['location'] != '' && !in_array($post['location'],$repeat))
					{
						array_push($repeat,$post['location']);
						$gMap = new EGMap();
						$geocoded_address = new EGMapGeocodedAddress($where_purchased->location);
						$geocoded_address->geocode($gMap->getGMapClient());
						$where_purchased->latitude=$geocoded_address->getLat();
						$where_purchased->longitude=$geocoded_address->getLng();
						$valid=$where_purchased->validate(false) && $valid;
						array_push($where_purchaseds,$where_purchased);
					}
				}
				$model->where_purchased=$where_purchaseds;
			}

			if ($valid)
			{

				try
				{
					$transaction=$model->dbConnection->beginTransaction();
					
					if($model->save(false))
						foreach($model->buy_from_types as $buy_from_type)
						{
							$buy_from_type->id=$model->id;
							$buy_from_type->save(false);
						}
						foreach($model->types_looking as $type_looking)
						{
							$type_looking->id=$model->id;
							$type_looking->save(false);
						}
						foreach($model->types_purchased as $type_purchased)
						{
							$type_purchased->id=$model->id;
							$type_purchased->save(false);
						}
						foreach($model->where_looking as $where_looking)
						{
							$where_looking->id=$model->id;
							$where_looking->save(false);
						}
						foreach($model->where_purchased as $where_purchased)
						{
							$where_purchased->id=$model->id;
							$where_purchased->save(false);
						}
					
						
						
						Yii::app()->user->setFlash('success',"The buyer has been saved! You can save more buyers on Renturly.net to access even more sellers. You will never be able to circumvent your original seller if it's the same buyer that you are posting. You can get a buyers widget for your website on Renturly.net. Your seller has been notified of your buyer, has matches, and may contact you to close the deal.");
						Yii::log('added_buy', 'info', 'Buyer.add');
						$transaction->commit();
						
						//Buyer change create_user_id
						$buyer=Buyer::model()->findByPk($model->id);
						$buyer->create_user_id=$user_id;
						$buyer->validate(false);
						$buyer->save(false);
						//BuyFromType change create_user_id
						//BuyFromType::model()->updateAll(array('create_user_id'=>$user_id),array('id'=>"'. $model->id.'", 'organization_type' => '*'));
						// Update tbl_buy_from_type set create_user_id = 92 where id = 78
						//Yii::app()->db->createCommand("Update tbl_buy_from_type set create_user_id = $user_id where id = $model->id")->queryAll();
						$command = Yii::app()->db->createCommand("Update tbl_buy_from_type set create_user_id = $user_id where id = $model->id");
						$command->execute();
						$command = false;
						//TypesLooking
						$command = Yii::app()->db->createCommand("Update tbl_types_looking set create_user_id = $user_id where id = $model->id");
						$command->execute();
						$command = false;
						//TypesPurchased
						$command = Yii::app()->db->createCommand("Update tbl_types_purchased set create_user_id = $user_id where id = $model->id");
						$command->execute();
						$command = false;
						//WhereLooking
						$command = Yii::app()->db->createCommand("Update tbl_where_looking set create_user_id = $user_id where id = $model->id");
						$command->execute();
						$command = false;
						//WherePurchased
						$command = Yii::app()->db->createCommand("Update tbl_where_purchased set create_user_id = $user_id where id = $model->id");
						$command->execute();
						$command = false;
						

						//Send Email to Account 
						//BEGIN MANDRILL
							// If are not using environment variables to specific your API key, use:
							$mandrill = new Mandrill('L7Qw8N-hVHM7Q8ZxHe97mw');
							
							$message = array(
							    'subject' => "Renturly - You've got new matches!",
							    'from_email' => 'michael.sadler@renturly.net',
							    'html' => "<h1><font color='#008080'>Your new buyer $buyer->buyer_name is matched with sellers on Renturly.net</font><br />
											<span style='color:rgb(80, 80, 80); font-family:helvetica; font-size:20px; line-height:20px'>Contact them to close the deal!</span></h1>
											Buyer&#39;s Name: $buyer->buyer_name<br />
											Buyer&#39;s Telephone: $buyer->buyer_telephone<br />
											Buyer&#39;s Email: $buyer->buyer_email<br />
											<br />
											<a href='http://www.renturly.net/birds-of-a-feather' target='_blank'>View All Matches!</a>
											&nbsp;",
							    'to' => array(array('email' => 'michael.sadler@renturly.net', 'name' => 'Michael Sadler')),
							);
							$mandrill->messages->send($message);
					    //END MANDRILL//
		

						//Send Email to Lead
							//BEGIN MANDRILL
							// If are not using environment variables to specific your API key, use:
							$mandrill = new Mandrill('L7Qw8N-hVHM7Q8ZxHe97mw');
							
							$message = array(
							    'subject' => "Renturly - Your seller has your information and may contact you",
							    'from_email' => 'michael.sadler@renturly.net',
							    'html' => "<h1><font color='#008080'>Your seller has your information and may contact you</font><br />
											<span style='color:rgb(80, 80, 80); font-family:helvetica; font-size:20px; line-height:20px'>There is no circumvention on Renturly.net</span></h1>
											<p>If you have more buyers and sellers you may want to create an account and promote them on Renturly.net, 
											as well as get a buyer's or seller widget for your website; The more you vet the more leads you get.</p>
											<br />
											&nbsp;",
							    'to' => array(array('email' => $buyer->buyer_email, 'name' => $buyer->buyer_name)),
							);
							$mandrill->messages->send($message);
					    //END MANDRILL//
						
						$this->redirect(Yii::app()->createUrl('/bum/users/signUp'));
					}
				catch(Exception $e) // an exception is raised if a query fails
				{
					print_r($e->getMessage());
					Yii::app()->end();
					Yii::app()->user->setFlash('alert','Contact us for help.');
					$transaction->rollback();
				}
			}

		}
		
		//$this->redirect(Yii::app()->request->urlReferrer);


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		/*
		if(isset($_POST['Buyer']))
		{
			$model->attributes=$_POST['Buyer'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
		*/
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionLoadBuyerWidget()
	{
		//load the buyers widget from Users Data for Ajax copy & paste;
		echo UsersData::model()->findByAttributes(array('site'=>$_POST['site']))->buyers_widget;

	}

	/**
	 * Search location of Asset Type and Property
	 */
	public function actionList()
	{
		
			
			
			
		
		//$this->layout='column1';
		$model=new WhereLooking('searchLocations');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['WhereLooking']))
			$model->attributes=$_GET['WhereLooking'];

		$criteria = new CDbCriteria;
		//active
		$criteria->limit = 1090;//1300;	
		$buyers_markets = WhereLooking::model()->findAll($criteria);
			
		$this->render('list',array(
			'model'=>$model,
			'buyers_markets'=>$buyers_markets,
		));
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		
		ini_set("memory_limit",-1);
		set_time_limit(0);
		
		$model=$this->loadModel($id);
			
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Buyer']) || isset($_POST['BuyFromType']) || isset($_POST['TypesLooking']) || isset($_POST['TypesPurchased']) || isset($_POST['WhereLooking']) || isset($_POST['WherePurchased']))
		{
		
			//Validate Buyer
			$model->attributes=$_POST['Buyer'];
			$valid=$model->validate(false);
		
			//Validate BuyFromTypes
			if(isset($_POST['BuyFromType']))
			{
				$buy_from_types=array();
				$repeat=array();
				foreach($_POST['BuyFromType'] as $post)
				{
		
					if(!empty($post['organization_type']) && !in_array($post['organization_type'],$repeat))
					{
						array_push($repeat,$post['organization_type']);
						$buy_from_type=new BuyFromType;
						$buy_from_type->attributes=$post;
						$valid=$buy_from_type->validate(false) && $valid;
						array_push($buy_from_types,$buy_from_type);
					}
		
				}
				$model->buy_from_types=$buy_from_types;
			}
		
			//Validate TypesLooking
			if(isset($_POST['TypesLooking']))
			{
				$types_looking=array();
				$repeat=array();
				foreach($_POST['TypesLooking'] as $post)
				{
					if(!empty($post['building_type']) && !in_array($post['building_type'],$repeat))
					{
						array_push($repeat,$post['building_type']);
						$type_looking=new TypesLooking;
						$type_looking->attributes=$post;
						$valid=$type_looking->validate(false) && $valid;
						array_push($types_looking,$type_looking);
					}
		
				}
				$model->types_looking=$types_looking;
			}
		
				
			//Validate TypesPurchased
			if(isset($_POST['TypesPurchased']))
			{
				$types_purchased=array();
				$repeat=array();
				foreach($_POST['TypesPurchased'] as $post)
				{
					if(!empty($post['building_type']) && !in_array($post['building_type'],$repeat))
					{
						array_push($repeat,$post['building_type']);
						$type_purchased=new TypesPurchased;
						$type_purchased->attributes=$post;
						$valid=$type_purchased->validate(false) && $valid;
						array_push($types_purchased,$type_purchased);
					}
		
				}
				$model->types_purchased=$types_purchased;
			}
		
				
			//Validate WhereLooking
			if(isset($_POST['WhereLooking']))
			{
				$where_lookings=array();
				$repeat=array();
				foreach($_POST['WhereLooking'] as $post)
				{
					$where_looking=new WhereLooking;
					$where_looking->attributes=$post;
						
					if($where_looking['location'] != '' && !in_array($post['location'],$repeat))
					{
						array_push($repeat,$post['location']);
						$gMap = new EGMap();
						$geocoded_address = new EGMapGeocodedAddress($where_looking->location);
						$geocoded_address->geocode($gMap->getGMapClient());
						$where_looking->latitude=$geocoded_address->getLat();
						$where_looking->longitude=$geocoded_address->getLng();
						$valid=$where_looking->validate(false) && $valid;
						array_push($where_lookings,$where_looking);
					}
				}
				$model->where_looking=$where_lookings;
			}
		
				
			//Validate WherePurchased
			if(isset($_POST['WherePurchased']))
			{
				$where_purchaseds=array();
				$repeat=array();
				foreach($_POST['WherePurchased'] as $post)
				{
					$where_purchased=new WherePurchased;
					$where_purchased->attributes=$post;
						
					if($where_purchased['location'] != '' && !in_array($post['location'],$repeat))
					{
						array_push($repeat,$post['location']);
						$gMap = new EGMap();
						$geocoded_address = new EGMapGeocodedAddress($where_purchased->location);
						$geocoded_address->geocode($gMap->getGMapClient());
						$where_purchased->latitude=$geocoded_address->getLat();
						$where_purchased->longitude=$geocoded_address->getLng();
						$valid=$where_purchased->validate(false) && $valid;
						array_push($where_purchaseds,$where_purchased);
					}
				}
				$model->where_purchased=$where_purchaseds;
			}
		
		
		
			if ($valid)
			{
		
				try
				{
					$transaction=$model->dbConnection->beginTransaction();
					
					
					//Save as not matching. Needs Toggle Match Matching
					$model->status_id = 2;
					
					if($model->save(false))
					{
						foreach(BuyFromType::model()->findAllByAttributes(array('id'=>$model->id)) as $saved)
							$saved->delete(false);
						foreach($model->buy_from_types as $buy_from_type)
						{
							$buy_from_type->id=$model->id;
							$buy_from_type->save(false);
						}
						
						foreach(TypesLooking::model()->findAllByAttributes(array('id'=>$model->id)) as $saved)
							$saved->delete(false);
						foreach($model->types_looking as $type_looking)
						{
							$type_looking->id=$model->id;
							$type_looking->save(false);
						}
						
						foreach(TypesPurchased::model()->findAllByAttributes(array('id'=>$model->id)) as $saved)
							$saved->delete(false);
						foreach($model->types_purchased as $type_purchased)
						{
							$type_purchased->id=$model->id;
							$type_purchased->save(false);
						}
						
						foreach(WhereLooking::model()->findAllByAttributes(array('id'=>$model->id)) as $saved)
							$saved->delete(false);
						foreach($model->where_looking as $where_looking)
						{
							$where_looking->id=$model->id;
							$where_looking->save(false);
						}
						
						foreach(WherePurchased::model()->findAllByAttributes(array('id'=>$model->id)) as $saved)
							$saved->delete(false);
						foreach($model->where_purchased as $where_purchased)
						{
							$where_purchased->id=$model->id;
							$where_purchased->save(false);
						}
						
						//Yii::app()->user->setFlash('success',"The buyer has been saved!");
						Yii::log('updated_buy', 'info', 'Buyer.update');
		
		
						
						
						
						$transaction->commit();
	
						$this->redirect(Yii::app()->createUrl('/buyer/admin'));
					}
					
		
				}
				catch(Exception $e) // an exception is raised if a query fails
				{
					Yii::app()->user->setFlash('alert','Contact us for help.');
					$transaction->rollback();
				}
			}
		
		}
		
		
		
		$this->render('update',array(
				'model'=>$model,
				'id'=>$id,

		));
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		/*
		if(isset($_POST['Buyer']))
		{
			$model->attributes=$_POST['Buyer'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
		*/
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		
		$where_lookings=WhereLooking::model()->findAll('id='.$id);
		foreach($where_lookings as $where_looking)
		{
			$where_looking->delete();
		}
		$types_lookings=TypesLooking::model()->findAll('id='.$id);
		foreach($types_lookings as $types_looking)
		{
			$types_looking->delete();
		}
		$where_purchaseds=WherePurchased::model()->findAll('id='.$id);
		foreach($where_purchaseds as $where_purchased)
		{
			$where_purchased->delete();
		}
		$types_purchaseds=TypesPurchased::model()->findAll('id='.$id);
		foreach($types_purchaseds as $types_purchased)
		{
			$types_purchased->delete();
		}
		$this->loadModel($id)->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Buyer');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout='column1';
		
		/*
		$model=new Buyer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Buyer']))
			$model->attributes=$_GET['Buyer'];
		*/	
		
		
		$model = Buyer::model()->findAllByAttributes(array('create_user_id'=>Yii::app()->user->id),array('order'=>'create_time DESC'));
		
		

		$this->render('admin',array(
			'model'=>$model,
		));
	}

   public function actionInterview() {
   	$model=new Buyer;
    $this->renderPartial("interview",array('model'=>$model));
  }
  
   public function actionLetterOfIntent() {
   	$model=new Buyer;
    $this->renderPartial("letter_of_intent",array('model'=>$model));
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Buyer the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Buyer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Buyer $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='buyer-survey-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function filterIsCustomer($filterChain)
	{
	
		if(!Yii::app()->user->isCustomer())
			$this->redirect(Yii::app()->createUrl('/site/pricing'));
		$filterChain->run();
	}
	
	/**
	 * In-class defined filter method, configured for use in the above filters() method.
	 * It is called before the actionCreate() action method is run in order to ensure a proper listing context
	 */
	public function filterListingPropertyContext($filterChain)
	{
		//set the listing identifier based on GET input request variables
		if(!isset($_GET['id']) || !isset($_GET['listing_id']))
			throw new CHttpException(403,'Propose a deal for a listed property.');
	
		//complete the running of other filters and execute the requested action
		$filterChain->run();
	}
	
	/**
	 * In-class defined filter method, configured for use in the above filters() method.
	 * It is called before the actionCreate() action method is run in order to ensure a proper listing context
	 */
	public function filterUpdateDeleteContext($filterChain)
	{
		//set the listing identifier based on GET input request variables
		if(isset($_GET['id']))
		{
			$id=$_GET['id'];
		}
		if(isset($_POST['id']))
		{
			$id=$_POST['id'];
		}
		if(isset($id))
		{
			$model=$this->loadModel($id);
			if(Yii::app()->user->id != 92)
			{
				if($model->create_user_id!=Yii::app()->user->id)
					throw new CHttpException(403,'Change your own buyer profiles.');
			}
		}
			
	
		//complete the running of other filters and execute the requested action
		$filterChain->run();
	}

	public function get_lat_long($address){

	    $address = str_replace(" ", "+", $address);

	    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyC52smVFMzjARDZ4kq-b1nWl5oKZdHuGYk");
	    $json = json_decode($json);

	    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
	    $lon = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	    return array('lat' => $lat , 'lon' => $lon);
	}
	
}
