<?php

class MatchController extends Controller
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
			//'isCustomer +search',
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('search','view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('updateallmatches'),
				'users'=>array('michael.sadler@gmail.com'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function filterIsCustomer($filterChain)
	{
	
		if(!Yii::app()->user->isCustomer())
			$this->redirect(Yii::app()->createUrl('/matchTable/search'));
		$filterChain->run();
	}
	
	/**
	 * Manages all models.
	 */
	public function actionSearch()
	{

		
		$this->redirect(Yii::app()->createUrl('/matchTable/search'));
		
		/*
		$this->layout='//layouts/match';
	
		$model=new MatchTable('search');
		$model->unsetAttributes();  // clear any default values
	
	
		if(isset($_GET['Match']))
		{
			Yii::app()->user->mp_increment("Filtered Matches");
			$model->attributes=$_GET['Match'];
		}
		

	
		$this->render('search',array(
				'model'=>$model,
		));
		
		*/
		
	}
	
	/**
	 * Updates scores on all models automatically.
	 */
	public function actionUpdateAllMatches()
	{
		/*
		$this->layout='//layouts/match';
	
		//Begin Algorithm
		
		
		try {
			//Delete all matches
			MatchTable::model()->deleteAll();
			
			
			foreach (Buyer::model()->findAllByAttributes(array('status_id'=>1)) as $buyer)
			{
				foreach(Portfolio::model()->findAllByAttributes(array('status_id'=>1)) as $portfolio)
				{
					$score = 0;
	
		    		if(empty($buyer->allowed_commission) || $buyer->allowed_commission == 0)
		    		{
		    			$allowed_commission = 3;
		    		} else {
		    			$allowed_commission = $this->allowed_commission;
		    		}
		    		
					if(empty($portfolio->commission) || $portfolio->commission == 0)
		    		{
		    			$commission = 3;
		    		} else {
		    			$commission = $portfolio->commission;
		    		}
		    		
		    		if($portfolio->min_dollar <= $buyer->pof_amount && $commission <= $allowed_commission)
		    		{
		    			//Score 100 for being principal
			    		if($portfolio->relation_to_seller == 33 || $buyer->relation_to_buyer == 3)
			    		{
			    			$score += 100;
			    		}
			    		
			    		//Score Urly Bird Grade Weighted By Quality

		    			$sellers_grade = Users::model()->findByPk($portfolio->create_user_id)->getGrade();
			    		$buyers_grade = Users::model()->findByPk($buyer->create_user_id)->getGrade();
			    		
			    		if($sellers_grade <= $buyers_grade)
			    		{
			    			$grade = $sellers_grade;
			    		} else {
			    			$grade = $buyers_grade;
			    		}
			    		
			    		if ($grade == 10) 
						{
						    $score += $grade * 100;
						} elseif ($grade == 9) {
							$score += $grade * 50;
						} elseif ($grade == 8) {
							$score += $grade * 40;
						} elseif ($grade == 7) {
							$score += $grade * 30;
						} elseif ($grade == 6) {
							$score += $grade * 20;
						} elseif ($grade == 5) {
							$score += $grade * 10;
						} elseif ($grade >= 3) {
						    $score -= 300;
						} elseif ($grade == 2) {
						    $score -= 400;
						} elseif ($grade == 1) {
						    $score -= 500;
						} 
			    		
						foreach($portfolio->asset_types as $asset_type)
			    		{
			    			//Score 70 for being great location
				    		if($asset_type->great_location == 1)
				    		{
				    			$score += 70;
				    		}
		    		
		    				//Score -70 for being in war zone
			    			if($asset_type->war_zone == 1)
				    		{
				    			$score -= 70;
				    		}
			    			
			    			//Score 70 for being located where the buyer is looking
			    			foreach($buyer->where_looking as $where_looking)
				    		{
					    		if(empty($where_looking->radius))
					    		{
					    			$radius = 50;
					    		} else {
					    			$radius = $where_looking->radius;
					    		}
					    		if(Buyer::earth_distance($asset_type->latitude, $asset_type->longitude, $where_looking->latitude, $where_looking->longitude) < $radius)
					    		{
					    			if(!empty($asset_type->latitude) && !empty($asset_type->longitude) && !empty($where_looking->latitude) && !empty($where_looking->longitude))
					    			{
					    				$score += 70;
					    				
								    	//Score 360 for being the right asset types in the right locations
							    		foreach($this->types_looking as $types_looking)
							    		{
							    			if($types_looking->building_type == $asset_type->asset_type)
							    			{
							    				$score += 360;
							    			}
							    		}
					    			} 
					    		}
				    		}
    						
				    		//Score 70 for being the right asset types 
				    		foreach($buyer->types_looking as $types_looking)
				    		{
				    			if($types_looking->building_type == $asset_type->asset_type)
				    			{
				    				$score += 70;
				    			}
				    		}
			    			
			    		}
			    		
			    		foreach($portfolio->properties as $property)
				    	{
				    		if(empty($property->commission) || $portfolio->commission == 0)
				    		{
				    			$commission = 3;
				    		} else {
				    			$commission = $property->commission;
				    		}
				    		
				    		//What properties don't have high comissions
				    		if($commission <= $allowed_commission)
				    		{
				    			//Properties match investment criterias
					    		if($buyer->fix_flip == 1 && $property->fix_flip == 1)
					    		{
					    			$score += 10;
					    		}
					    		if($buyer->fix_hold == 1 && $property->fix_hold == 1)
					    		{
					    			$score += 10;
					    		}
					    		if($buyer->buy_hold == 1 && $property->buy_hold == 1)
					    		{
					    			$score += 10;
					    		}
					    		if($buyer->rent_to_own == 1 && $property->rent_to_own == 1)
					    		{
					    			$score += 10;
					    		}
					    		if($buyer->vendor_take_back == 1 && $property->vendor_take_back == 1)
					    		{
					    			$score += 10;
					    		}
					    		if($buyer->rebuild == 1 && $property->rebuild == 1)
					    		{
					    			$score += 10;
					    		}
					    		
				    			//Score 50 Unit types match unit type specifications
					    		foreach($property->unit_types as $unit_type)
					    		{
					    			if($buyer->min_square_feet != 0 && $buyer->min_bedrooms != 0 && $buyer->min_bathrooms != 0)
					    			{
						    			if(($unit_type->square_feet >= !empty($buyer->min_square_feet)) && ($unit_type->bedrooms >= !empty($buyer->min_bedrooms)) && ($unit_type->bathrooms >= !empty($buyer->min_bathrooms)))
						    			{
						    				$score += 20;	
						    			}
					    			}
					    			if($buyer->min_square_feet != 0)
					    			{
					    				if($unit_type->square_feet >= !empty($buyer->min_square_feet))
						    			{
						    				$score += 10;
						    			}
					    			}
									if($buyer->min_bedrooms != 0)
									{
						    			if($unit_type->bedrooms >= !empty($buyer->min_bedrooms))
						    			{
						    				$score += 10;
						    			}
									}
									if($buyer->min_bathrooms != 0)
									{
										if($unit_type->bathrooms >= !empty($buyer->min_bathrooms))
						    			{
						    				$score += 10;
						    			}		
									}
									
					    			//Score 10 for year built being new enough
						    		if($property->year_built >= $buyer->min_year_built)
						    		{
						    			$score += 10;
						    		}
						    		
					    			//Score 70 for being in a great location    				
						    		if($property->great_location == 1)
						    		{
						    			$score += 70;
						    		}
									
						    		//Score 70 for being located where the buyer is looking
					    			foreach($buyer->where_looking as $where_looking)
						    		{
							    		if(empty($where_looking->radius))
							    		{
							    			$radius = 50;
							    		} else {
							    			$radius = $where_looking->radius;
							    		}
							    		if(Buyer::earth_distance($property->latitude, $property->longitude, $where_looking->latitude, $where_looking->longitude) < $radius)
							    		{
							    			if(!empty($property->latitude) && !empty($property->longitude) && !empty($where_looking->latitude) && !empty($where_looking->longitude))
							    			{
							    				$score += 70;
							    				
										    	//Score 360 for being the right asset types in the right locations
									    		foreach($this->types_looking as $types_looking)
									    		{
									    			if($types_looking->building_type == $property->building_type)
									    			{
									    				$score += 360;
									    			}
									    		}
							    			} 
							    		}
						    		}
		    						
						    		//Score 70 for being the right asset types 
						    		foreach($buyer->types_looking as $types_looking)
						    		{
						    			if($types_looking->building_type == $property->building_type)
						    			{
						    				$score += 70;
						    			}
						    		}
									
					    		}
				    		}
				    		
				    	
					    	//Score 10 times for each match with this user
					    	//The more they are matched the more likely the possibility of having a deal together
					    	$count = MatchTable::model()->countByAttributes(array('path_to_seller'=>$portfolio->create_user_id,'path_to_buyer'=>$this->create_user_id));
					    	$score += $count * 10;
					    	
				    		//Save the match if score > 0
				    		if($score > 0)
				    		{	
					    		$match = new MatchTable;
					      		$match->buyer_id = $buyer->id;
					      		$match->portfolio_id = $portfolio->id;
					      		$match->path_to_buyer = $buyer->create_user_id;
					      		$match->path_to_seller = $portfolio->create_user_id;
					      		$match->score = $score;
					      		$match->save(false);
					      		
				    		}
				    		
				    		
				    	}
			    		
		    		}
		    		
		    		
		    		
		    		
		    		
				}
			}
			
		} catch (Exception $e) {
			
		}
		
		
		
		
		
		
		//End Algorithm
		
		$model=new MatchTable('search');
		$model->unsetAttributes();  // clear any default values
	
	
		if(isset($_GET['Match']))
		{
			$model->attributes=$_GET['Match'];
		}
		

	
		$this->render('search',array(
				'model'=>$model,
		));
		
		*/
	}
	
	public function actionView()
	{
		ini_set('memory_limit', '-1');
		
		//Get The Users Buyers
		$buyers=Buyer::model()->findAllByAttributes(array('create_user_id' => Yii::app()->user->id));
		foreach($buyers as $buyer) 
		{
			
			//Buyer Preferences Array
			$buyer_preferences=array(
				'affordable_portfolios'=>$buyer->affordable_portfolios,
				'affordable_properties'=>$buyer->affordable_properties,
				'assets_location'=>$buyer->assets_location,
				'asset_types'=>$buyer->asset_types,
				'cap_rate'=>$buyer->cap_rate,
				'building_types'=>$buyer->building_types,
				'investment_strategies'=>$buyer->investment_strategies,
				'portfolio_commission'=>$buyer->portfolio_commission,
				'property_commission'=>$buyer->property_commission,
				'property_location'=>$buyer->property_location,
				'unit_types'=>$buyer->unit_types
			);
			
			//Get the Users Matches that are Either Path to Seller or Path to Buyer
			$user_id = Yii::app()->user->id;
			$criteria=new CDbCriteria;
			$criteria->condition="path_to_seller = $user_id OR path_to_buyer = $user_id";
			$matches=Match::model()->findAll($criteria);
								
			//are all of the preferences matched?
			foreach($matches as $match)
			{
				//Does the existing matches == 1
				if(array_key_exists($match->match_type,$buyer_preferences))
				{
					foreach($buyer_preferences as $key => $value)
					{
						if($value == 0)
						{
							if($buyer_preferences[$match->match_type] == '1' || $buyer_preferences[$match->match_type] == 1)
							{
								$matches=$this->unsetValue($matches, $match);
										CVarDumper::dump(count($matches));
		
							}
						}
	
					}
				}
			}
			
			/*
			if(count($matches_array) > 0)
			{
				$this->render('view',array(
						'model'=>$matches_array,
				));
			} //END if $isMatch
			*/
		} //END foreach Buyers
		

		
	}
	
	function unsetValue(array $array, $value, $strict = TRUE)
	{
	    if(($key = array_search($value, $array, $strict)) !== FALSE) {
	        unset($array[$key]);
	    }
	    return $array;
	}

	
}