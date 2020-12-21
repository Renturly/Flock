<?php

Yii::import('ext.httpclient.*');

require_once('adapter/EHttpClientAdapterInterface.php');
require_once('adapter/EHttpClientAdapterSocket.php');
require_once('adapter/EHttpClientException.php');

Yii::import('application.vendors.*');
require_once('LinkedIn/OAuth.php');
require_once('LinkedIn/linkedin_3.2.0.class.php');
require_once('MailChimp/MailChimp.php');

require_once('Ambassador/Ambassador.php');

			ini_set('max_execution_time', 7);
			set_time_limit(7);

class PortfolioController extends Controller
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
				'actions'=>array('view','list','assettype','api'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','dynamicprovince',
						'dynamiccity','dynamicbuilding','countries',
						'provinces','cities','admin','togglematch','search'),
				'users'=>array('@'),
			),
			array('allow',  // allow test
				'actions'=>array('testEmail'),
				'users'=>array('Michael'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
				if($model->create_user_id != Yii::app()->user->id)
					throw new CHttpException(403,'Change your own portfolios.');
			}
		}
			
	
		//complete the running of other filters and execute the requested action
		$filterChain->run();
	}
	
	public function actionSearch()
	{
		$this->layout='column1';
		
		$search = $_POST['search'];
		
		$user_id = Yii::app()->user->id;
		
		$criteria = new CDbCriteria();
		$criteria->condition = "create_user_id = $user_id";
		$criteria->addSearchCondition('seller_code', $search);
		 
		$model = Portfolio::model()->findAll($criteria);
		
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

		//ini_set("memory_limit",-1);
		
		$portfolio = Portfolio::model()->findByPk($id);

		if($portfolio->status_id == 1)
		{
			$portfolio->status_id = 2;
			$portfolio->update(false);
		} elseif($portfolio->status_id == 2)
		{
			$portfolio->status_id = 1;
			$portfolio->update(false);
		}
		
	    //Track Click Toggle Seller
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
		
		  
		  	
	       try {
	       
			$fistfuls_of_cash = 0;
	       
			$time = time(TRUE);
	       
			ini_set('max_execution_time', 7);
			set_time_limit(7);
			
	       	
	       	$FistfulsofCash = array();

		    if($portfolio->status_id == 1)
		    {    
		    	//New Algorithm
		    	$limit = 0;
		 
		    	$criteria = new CDbCriteria;
				$criteria->limit = 1090;
				//active
				$criteria->order = "create_time desc";
				
				Yii::app()->cache->set($buyer, Buyer::model()->findAll($criteria));
				
$buyers=Yii::app()->cache->get($buyer);
				
		    	foreach($buyers as $buyer)
		    	{
		    		//You can Access The Flock
		    		
    				if($limit == 100)
	    			{
	    				break;
	    			}
		    		
		    		$score = 0;
		    		
	
		    		if($portfolio->min_dollar <= $buyer->pof_amount)
		    		{
		    			
		    			//Seller Asset Types - has location
			    		$asset_type_match = false;
		    			foreach($portfolio->asset_types as $asset_type)
			    		{
			    			//Buyer Location
			    			$location_match = false;
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
					    				$location_match = true;
					    				
								    	//Buyer and Seller Asset Types
							    		foreach($buyer->types_looking as $types_looking)
							    		{
							    			if($types_looking->building_type == $asset_type->asset_type)
							    			{
							    				$score += 1;
							    				$asset_type_match = true;
							    			}
							    		}
					    			} 
					    		}
				    		}
				    		
			    		}
		    		
	    		  		//Save the match if score > 0
			    		//if($score >= 0 && $location_match == true && $asset_type_match == true && Users::model()->findByPk($buyer->create_user_id)->getVoteSum() >= 0 && Customer::model()->findByAttributes(array('create_user_id'=>$portfolio->create_user_id)) && Customer::model()->findByAttributes(array('create_user_id'=>$buyer->create_user_id)))
			    		if($score >= 1 && Users::model()->findByPk($portfolio->create_user_id)->getVoteSum() >= 0 && Users::model()->findByPk($buyer->create_user_id)->getVoteSum() >= 0 && Users::model()->findByPk($buyer->create_user_id)->id != 92)
			    		{	
			 
			    			$limit += 1;
			    			
			    			if($buyer->create_user_id != $portfolio->create_user_id)
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
						      		
									
if($fistfuls_of_cash == 100)
{
									
	$this->redirect('/matchTable/search');

}
								
									

/*					      		
									
				    		if(!Yii::app()->user->isGuest)
								{
									$UrlyBird = User::model()->findByPk($buyer->create_user_id);
									array_push($FistfulsofCash, $UrlyBird->email);
						
								}
								
*/
									
									
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
		    
//Voting
		    
       		if ($portfolio->status_id == 2)
		    {
		    	
		    	foreach(MatchTable::model()->findAllByAttributes(array('portfolio_id'=>$portfolio->id)) as $match)
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
					Yii::app()->user->setFlash('alert','Could not calculate matches. Bring Chief Bird Dog michael.sadler@accesstheflock.io. Renturly');
					
$this->redirect(array('matchTable/search'));
					
			}
		
		
		//$this->redirect(Yii::app()->createUrl('/portfolio/admin'));
		//$this->redirect(Yii::app()->createUrl('/matchTable/search'));
		
	}
	
	public function PayTheBirdDog($FistfulsofCash)
	{
		$match_users = User::model()->findAll(array('order' => 'update_time ASC','limit' => 5));
				$message = new YiiMailMessage;
				$message->view = 'newMatch';
				$message->subject = "Birds of a Feather";
				$message->setBody(array('match'=>$match), 'text/html');
			foreach($match_users as $match_user){
				
				$message->addTo($match_user->email);
				$message->from = Yii::app()->params['adminEmail'];
				Yii::app()->mail->send($message);
									
			}
		
	}
	
	public function actionMatchAll()
	{	
		
		ini_set("memory_limit",-1);
		set_time_limit(0);

		$portfolios = Portfolio::model()->findAllByAttributes(array('create_user_id'=>Yii::app()->user->id));

		foreach($portfolios as $portfolio)
		{
			$portfolio->status_id = 1;
			$portfolio->update(false);
		}
		
		$this->redirect(Yii::app()->createUrl('/portfolio/admin'));
	}
	
	public function actionTakeAllOffMarket()
	{	

		ini_set("memory_limit",-1);
		set_time_limit(0);
		
		$portfolios = Portfolio::model()->findAllByAttributes(array('create_user_id'=>Yii::app()->user->id));

		foreach($portfolios as $portfolio)
		{
			$portfolio->status_id = 2;
			$portfolio->update(false);
		}
		
		$this->redirect(Yii::app()->createUrl('/portfolio/admin'));
	}

	public function actionApi()
	{
		
		//from a POST request
		if(isset($_POST['asset_type']) && isset($_POST['location']) && isset($_POST['min_dollar']) && isset($_POST['email']))
		{
			
			$seller = new Portfolio;
		
			$transaction=$seller->dbConnection->beginTransaction();
			
			$user = User::model()->findByAttributes(array('email'=>$_POST['email']));
			$seller->create_user_id = $user->id;
			$seller->update_user_id = $user->id;
			
			
			//$seller->seller_code = $_POST['seller_code'];
			
			$seller->name = $_POST['name'];
			
			$seller->min_dollar = $_POST['min_dollar'];
			
			if(isset($_POST['cap_rate']))
			{
				$seller->cap_rate = $_POST['cap_rate'];
			}
			
			
			if(isset($_POST['discount']))
			{
				$seller->discount = $_POST['discount'];
			}
			
			
		
			$seller->status_id = 2;
			
			/*
			if ($_POST['relation_to_seller'] == 'I am the seller')
			{
				$seller->relation_to_seller = 33;
			}
			if ($_POST['relation_to_seller'] == 'I am direct to the seller')
			{
				$seller->relation_to_seller = 32;
			}
			if ($_POST['relation_to_seller'] == "I know the seller's representation")
			{
				$seller->relation_to_seller = 31;
			}
			*/
			
			$seller->commission = $_POST['commission'];
			
		
		
			//Communicate the validation
			$seller->validate(false);
			
			
			if($seller->save(false))
			{
				
								$asset_type = new AssetType;
	            				$asset_type->portfolio_id = $seller->id;
	            				$type = $_POST['asset_type'];
	            				$asset_type->asset_type = BuildingType::model()->findByAttributes(array('type'=>$type))->id;
	            				$asset_type->location = $_POST['location'];
	        


	            				$latlong = $this->get_lat_long2($asset_type->location);

								$asset_type->latitude = $latlong['lat'];
								$asset_type->longitude = $latlong['lon'];


								
								$asset_type->validate(false);
	            				$asset_type->save(false);
	            				
	            				Yii::app()->user->mp_track("Fistfuls of Cash");
				   				Yii::app()->user->mp_increment("Fistfuls of Cash");
		           
		           
			}
			
			$transaction->commit();
			
			//Track Accessed The Flock in Mixpanel when someone creates a match
			Yii::app()->user->mp_track("Bird Dog Landing Page");
			Yii::app()->user->mp_increment("Bird Dog Landing Page");
			
		
			//$this->redirect(Yii::app()->createUrl('/portfolio/admin'));
			
			//$seller->afterSave();
			
			$this->actionToggleMatch($seller->id);
						
			//$this->redirect(Yii::app()->createUrl('/buyer/admin'));
			$this->redirect(Yii::app()->createUrl('/matchTable/search'));
			
		}
		
	}
	
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->layout='//layouts/column1';
		$propertyDataProvider=new CActiveDataProvider('Property',array(
				'criteria'=>array(
						'with'=>array('portfolio'=>array(
								'on'=>'portfolio_id='.$id,
								'together'=>true,
								'joinType'=>'INNER JOIN',
						)),
						),
				'pagination'=>array(
						'pageSize'=>3,
						),
				));
				
				$model = $this->loadModel($id);
				
		$this->render('view',array(
			'portfolio'=>$model,
			
			'propertyDataProvider'=>$propertyDataProvider,
		));
		
		/*
			if(!Yii::app()->user->isGuest && Yii::app()->user->id != $model->create_user_id)
			{
			    			    //Send notification email to seller
						$message = new YiiMailMessage;
						$message->view = 'sellerView';
						$message->subject = "Your Seller Was Viewed";
						 
						//userModel is passed to the view
						$message->setBody(array('seller'=>$model), 'text/html');
						 
						$user = User::model()->findByPk($model->create_user_id);
						$message->addTo($user->email);
						$message->from = Yii::app()->params['adminEmail'];
						Yii::app()->mail->send($message);
						
						//Track Match Alert when match email is sent
						//Yii::app()->user->mp_track("Buying");
						//Yii::app()->user->mp_increment("Buying");
			}
		*/

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		//ini_set("memory_limit",-1);
		//set_time_limit(7);
		
		
		$this->layout='//layouts/column1';
		$portfolio=new Portfolio;

		if(isset($_POST['Portfolio']) || isset($_POST['AssetType']))
		{

			//$property->images=CUploadedFile::getInstancesByName('images');

			$portfolio->attributes=$_POST['Portfolio'];
			$valid=$portfolio->validate(false);
			
			if(isset($_POST['AssetType']))
				{
					$asset_types=array();
					foreach($_POST['AssetType'] as $post)
					{
						$asset_type=new AssetType;
						$asset_type->attributes=$post;
						// Create geocoded address
						if(isset($post['location']))
						{

							//echo "sssss"; exit;
							//$asset_type->location = $post['location'];
							

	            			$latlong = $this->get_lat_long2($asset_type->location);
	            			//print_r($latlong); exit;
							$asset_type->latitude = $latlong['lat'];
							$asset_type->longitude = $latlong['lon'];

							
						}

						$valid=$asset_type->validate(false) && $valid;
						array_push($asset_types,$asset_type);
					}
					$portfolio->asset_types=$asset_types;
				}
			
			if($valid)
			{
				try
				{
					$transaction=$portfolio->dbConnection->beginTransaction();
					
					$portfolio->status_id = 2;
					
					if($portfolio->save(false))
					{
						foreach($portfolio->asset_types as $asset_type)
						{
							$asset_type->portfolio_id=$portfolio->id;
							$asset_type->save(false);
						}

						//Yii::app()->user->setFlash('success',"The portfolio has been saved!");
						Yii::log('added_portfolio', 'info', 'Portfolio.add');
						$this->notificationBuyerPortfolioMatch($portfolio);
				
						
						
						
						$transaction->commit();
						
						$this->actionToggleMatch($portfolio->id);
						
						$this->redirect(Yii::app()->createUrl('/matchTable/search'));
						
						
						
						
						
						
						
						
						
						//$this->redirect(Yii::app()->createUrl('/portfolio/admin'));
						
						


						
					}
				
				}
				catch(Exception $e) // an exception is raised if a query fails
				{
					Yii::app()->user->setFlash('alert','Most likely... You need to delete any "Asset Types" rows at the bottom by clicking the "X" at the bottom-right.');
					$transaction->rollback();
				}
			}

		}
			
		
		$this->render('create', array(
				'portfolio'=>$portfolio,
		));

	}

	
/* Moved to SellersDocuments Controller
	public function actionUpload($id)
	{
		$this->layout='//layouts/column1';
		
		Yii::import("xupload.models.XUploadForm");
        
		$model = new XUploadForm;
        
        $this->render('upload', array(
			'sellers_documents' => $model
		));
	}
*/
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		
		ini_set("memory_limit",-1);
		set_time_limit(0);
		
		$this->layout='//layouts/column1';
		$portfolio=$this->loadModel($id);
		
		if(Yii::app()->user->id != 92)
		{
			if(!$portfolio->isSeller($portfolio->id))
				throw new CHttpException('403','Update a portfolio that you created.');
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Portfolio']) || isset($_POST['AssetType']))
		{
			$portfolio->attributes=$_POST['Portfolio'];
			$valid=$portfolio->validate(false);
			
			if(isset($_POST['AssetType']))
			{
				$asset_types=array();
				foreach($_POST['AssetType'] as $post)
				{
					$asset_type=new AssetType;
					$asset_type->attributes=$post;
					// Create geocoded address
					if(isset($post['location']))
					{	
						$asset_type->location = $_POST['location'];
	        


	            		$latlong = $this->get_lat_long2($asset_type->location);

						$asset_type->latitude = $latlong['lat'];
						$asset_type->longitude = $latlong['lon'];

					}
			
					$valid=$asset_type->validate(false) && $valid;
					array_push($asset_types,$asset_type);
				}
				$portfolio->asset_types=$asset_types;
			}
			
			
			if($valid)
			{

				try
				{
					$transaction=$portfolio->dbConnection->beginTransaction();
					
					$portfolio->status_id = 2;
					
					if($portfolio->save(false))
					{
						foreach(AssetType::model()->findAllByAttributes(array('portfolio_id'=>$portfolio->id)) as $saved)
							$saved->delete(false);
						foreach($portfolio->asset_types as $asset_type)
						{
							$asset_type->portfolio_id=$portfolio->id;
							$asset_type->save(false);
						}
				
						//Yii::app()->user->setFlash('success',"The portfolio has been saved!");
						Yii::log('added_portfolio', 'info', 'Portfolio.add');
						$this->notificationBuyerPortfolioMatch($portfolio);
				
						
						
						$transaction->commit();

						$this->redirect(Yii::app()->createUrl('/portfolio/admin'));
						
						/* For Sellers Documents Uploader
						if($portfolio->status_id == 1)
						{
							$this->redirect(Yii::app()->createUrl('sellersDocuments/upload', array('id'=>$portfolio->id)));
						} else {
							$this->redirect(Yii::app()->createUrl('/matchTable/search'));
						}
						*/
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
			'portfolio'=>$portfolio,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{

		$asset_types=AssetType::model()->findAll('portfolio_id='.$id);
		foreach($asset_types as $asset_type)
		{
			$asset_type->delete();
		}
		$properties=Property::model()->findAll('portfolio_id='.$id);
		foreach($properties as $property)
		{
			$unit_types=UnitType::model()->findAll('property_id='.$property->id);
			foreach($unit_types as $unit_type)
			{
				$unit_type->delete();
			}
			$property->delete();
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
		
		$this->layout='//layouts/column2';
	
		$dataProvider=new CActiveDataProvider('Portfolio', array(
				'criteria'=>array(
						'condition'=>"create_user_id=".Yii::app()->user->id,
						),
						
						
				));
	
		
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
		$model=new Portfolio('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Portfolio']))
			$model->attributes=$_GET['Portfolio'];
		*/
		
		

		$model = Portfolio::model()->findAllByAttributes(array('create_user_id'=>Yii::app()->user->id),array('order'=>'create_time DESC'));
		
		
		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Search location of Asset Type and Property
	 */
	public function actionList()
	{
		
		$this->layout='column1';
		$model=new AssetType('searchLocations');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AssetType']))
			$model->attributes=$_GET['AssetType'];

			
		$criteria = new CDbCriteria;
		//active
		$criteria->limit = 30;		
		$asset_type_markets = AssetType::model()->findAll($criteria);
   		//$property_markets = Property::model()->findAll();
			
		$this->render('list',array(
			'model'=>$model,
		    'asset_type_markets'=>$asset_type_markets,
        	//'property_markets' => $property_markets
		));
	}
	
//Portfolio Asset Type Limit is he List
	public function actionAssetType($id = 0)
	{
		//For sellers list
		if ($id == 0)
		{
			$criteria = new CDbCriteria;
			//actives
			$criteria->order = "create_time desc";
			$criteria->limit = 826;//746;
			$asset_types = AssetType::model()->findAll($criteria);
		
			$assetTypes = array();
			foreach ($asset_types as $asset_type)
			{
				$building_type = BuildingType::model()->findByPk($asset_type->asset_type);
				$portfolio = Portfolio::model()->findByPk($asset_type->portfolio_id);
				if ($portfolio->status_id == 1 && Users::model()->findByPk($portfolio->create_user_id)->getVoteSum() > 0 && $portfolio->create_user_id != 92 && $portfolio->create_user_id != 583)
				if(true)
				{
					array_push($assetTypes,array(
						'id'=>$asset_type->portfolio_id,
						'min_dollar'=>Yii::app()->format->number(CHtml::encode($portfolio->min_dollar)),
						'location'=>$asset_type->location,
						'asset_type'=>$building_type->type,
						'longitude'=>$asset_type->longitude,
						'latitude'=>$asset_type->latitude,
					));
				}

			}
			print json_encode($assetTypes);
			die();
			
		//For view seller
		} else {
			
			$asset_types = AssetType::model()->findAllByAttributes(array('portfolio_id'=>$id));
		
			$assetTypes = array();
			foreach ($asset_types as $asset_type)
			{
				$building_type = BuildingType::model()->findByPk($asset_type->asset_type);
				
				array_push($assetTypes,array(
					'id'=>$asset_type->portfolio_id,
					'location'=>$asset_type->location,
					'asset_type'=>$building_type->type,
					'longitude'=>$asset_type->longitude,
					'latitude'=>$asset_type->latitude,
				));
			}
			print json_encode($assetTypes);
			die();
		}

	}

	
	public function actionCountries()
	{
		$data=Country::model()->findAll(array(
				'order'=>'name asc',
		));
		$countries=array();
		array_push($countries, '--');
		foreach($data as $key=>$value)
		{
			array_push($countries, array($value->id=>$value->name));
		}
	
		return $countries;
	
	}
	
	public function actionProvinces()
	{
		$data=Province::model()->findAll(array(
				'order'=>'name asc',
		));
		$provinces=array();
		array_push($provinces, '--');
		foreach($data as $key=>$value)
		{
			array_push($provinces,  array($value->id=>$value->name));
		}
	
		return $provinces;
	
	}
	
	public function actionCities()
	{
		$data=City::model()->findAll(array(
				'order'=>'name asc',
		));
		$cities=array();
		array_push($cities, '--');
		foreach($data as $key=>$value)
		{
			array_push($cities,  array($value->id=>$value->name));
		}
	
		return $cities;
	
	}
	
	public function actionDynamicprovince()
	{
	    $data=Province::model()->findAll('country_id=:country_id', 
	                  array(':country_id'=>(int) $_POST['Property']['country']));

	    $data=CHtml::listData($data,'id','name');
	   // echo CHtml::tag('option',array('value'=>0),CHtml::encode("--"),true);
	    foreach($data as $value=>$name)
	    {
	    	//$value++;
	        echo CHtml::tag('option',
	                   array('value'=>$value),CHtml::encode($name),true);
	    }
	}
	
	public function actionDynamiccity()
	{
	/*
		$data=City::model()->findAll('province_id=:province_id', 
	                  array(':province_id'=>(int) $_POST['Property']['province']));
	 */
	 	$data=City::model()->findAll(array('order'=>'name', 'condition'=>'province_id=:province_id', 'params'=>array(':province_id'=>(int) $_POST['Property']['province'])));
	    $data=CHtml::listData($data,'id','name');
	    //echo CHtml::tag('option',array('value'=>0),CHtml::encode("--"),true);
	    foreach($data as $value=>$name)
	    {
	        echo CHtml::tag('option',
	                   array('value'=>$value),CHtml::encode($name),false);
	    }
	}
	
	public function actionDynamicbuilding()
	{
		if(isset($_POST['Property']['type_id']) && $_POST['Property']['type_id']==0)
		{
			$data=Property::model()->getResidentialType();
		} else if(isset($_POST['Property']['type_id']) && $_POST['Property']['type_id']==1)
		{
			$data=Property::model()->getCommercialType();
		} else {
			$data=array(0=>'--');
		}
		
		foreach($data as $value=>$name)
		{
			//$value++;
			echo CHtml::tag('option',
					array('value'=>$value),CHtml::encode($name),true);
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Listing the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Portfolio::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Listing $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='portfolio-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionTestEmail()
	{
		$email='michael@renturly.com';
		$ambassador = new Ambassador("renturly","e18b74b013dad4b82f1686ef4c3d9329");
		$params = array(
				'email' => "$email",
				'campaign_uid' => '8435',
				'auto_create' => 1,
				'uid' => Yii::app()->user->username,
				'first_name' => Yii::app()->user->firstName,
				'last_name' => Yii::app()->user->lastName,
				);
		$result = $ambassador->call("/ambassador/get",$params);

		echo $result['response']['data']['ambassador']['campaign_links']['0']['url'];
		
		return;
		$portfolio=Portfolio::model()->findByPk('1');
		return $this->notificationBuyerPortfolioMatch($portfolio);
	}
	
	/**
	 * 
	 * Called from within Portfolio.create & Portfolio.update
	 * Sends notification to matching buyers using MailChimp after portfolio save
	 * @param object $portfolio
	 */
	private function notificationBuyerPortfolioMatch($portfolio)
	{
		//Get Buyers For This Portfolio
		$buyers=Buyer::model()->findAll();
		foreach($buyers as $buyer) 
		{
			$matches=Match::model()->findAllByAttributes(array('portfolio_id'=>$portfolio->id,'buyer_id'=>$buyer->id));
		
			//Prepare Mail for MailChimp
			$isMatch = true;
			
			//buyer preferences array
			$buyer_preferences=array(
				'affordable_portfolios'=>$buyer->affordable_portfolios,
				//'affordable_properties'=>$buyer->affordable_properties,
				'assets_location'=>$buyer->assets_location,
				'asset_types'=>$buyer->asset_types,
				'cap_rate'=>$buyer->cap_rate,
				//'building_types'=>$buyer->building_types,
				//'investment_strategies'=>$buyer->investment_strategies,
				'portfolio_commission'=>$buyer->portfolio_commission,
				//'property_commission'=>$buyer->property_commission,
				//'property_location'=>$buyer->property_location,
				//'unit_types'=>$buyer->unit_types
			);
			
			//are all of the preferences matched?
			$all_matched=false;
			foreach($matches as $match)
			{
				foreach($buyer_preferences as $key => $value)
				{
					if($value == 1)
					{
						
						//Does the existing matches == 1
						if(array_key_exists($match->match_type,$buyer_preferences))
						{
							if($buyer_preferences[$match->match_type] == '0' || $buyer_preferences[$match->match_type] == 0)
							{
								
								$all_matched=true;
							}
						}

					}

				}

			}
			
			if($all_matched)
			{

				$buyers_rep=User::model()->findByPk($buyer->create_user_id);
				$seller=User::model()->findByPk($portfolio->create_user_id);
		
				$this->notifyBuyerPortfolioMatch($portfolio, $buyers_rep, $seller);
				
			} //END if $isMatch

		} //END foreach Buyers

	}
	
	private function notifyBuyerPortfolioMatch($portfolio,$buyers_rep,$seller)
	{
				$ambassador = new Ambassador("renturly","e18b74b013dad4b82f1686ef4c3d9329");
				$params = array(
						'email' => "$buyers_rep->email",
						'campaign_uid' => '8435',
						'auto_create' => 1,
						'uid' => Yii::app()->user->username,
						'first_name' => Yii::app()->user->firstName,
						'last_name' => Yii::app()->user->lastName,
						);
				$result = $ambassador->call("/ambassador/get",$params);
				$ambassador_url=$result['response']['data']['ambassador']['campaign_links']['0']['url'];

				$message       = new YiiMailMessage;
				//this points to the file test.php inside the view path
				$message->view = "buyerPortfolioMatch";

				$params = array(
					'portfolio'=>$portfolio,
					'buyers_rep'=>$buyers_rep,
					'seller'=>$seller,
					'ambassador_url'=>$ambassador_url
				);
				
				$message->subject = "Renturly - Documents!";
				$message->setBody($params, 'text/html');
				$message->from = 'michael.sadler@gmail.com';
	
				$message->addTo("$buyers_rep->email");
					Yii::app()->mail->send($message);

	}

	public function get_lat_long2($address){

	    $address = str_replace(" ", "+", $address);

	    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=".$address."&sensor=true&key=AIzaSyC52smVFMzjARDZ4kq-b1nWl5oKZdHuGYk");
	    $json = json_decode($json);

	    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
	    $lon = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
	    return array('lat' => $lat , 'lon' => $lon);
	}
}
//file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false');