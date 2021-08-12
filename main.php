<?php
// Calendar: ClickUp:~ Get Embarrassed!
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

if (true)
{

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Access The Flock',
	'theme'=>'abound',
	'defaultController' => 'site/index',

	'homeUrl'=>array('/match/search'),

	//'language' => "CHttpRequest::preferredLanguage",

	// preloading 'log' component
	'preload'=>array(
			'log',
			'bootstrap',
			'booster'
			),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.controllers.*',
		'application.vendors.*',
		'application.extensions.groupgridview.*',
		'application.extensions.EGMap.*',
		'application.extensions.httpclient',
		'application.extensions.magnific-popup.EMagnificPopup',
		'application.extensions.CAdvancedArBehavior',
		'ext.behaviors.SluggableBehavior',
		'ext.behaviors.*',
		'ext.yiibooster.*',
		'ext.clonnableFields.*',
		'application.modules.image.components.*',
		'application.modules.image.models.Image',
		'ext.yii-mail.YiiMailMessage',
		'application.modules.bum.models.*',
		'application.modules.bum.components.*',
		'ext.DbUrlManager.EDbUrlManager',
		'ext.booster.*',
		'ext.phpexcelreader.*',
		'ext.fusioncharts.*'
	),
	
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>false,
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'image'=>array(
				'createOnDemand'=>true, // requires apache mod_rewrite enabled
				'install'=>false, // allows you to run the installer
				'imagePath'=>'images/',
		),
		'MSensorarioDropdown',
		// Basic User Management module;
		'bum' => array(
				// needs yii-mail extension..

				'install'=>false, // true just for installation mode, on develop or production mode should be set to false
		),
		'blog',
		'starRank' => array(
				'class' => 'application.modules.PcStarRank.PcStarRankModule'
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class' => 'BumWebUser',//'class' => 'WebUser',
			'loginUrl' => array('//bum/users/login'), // required
			'autoUpdateFlash' => false,
		),
        'fusioncharts' => array(
	                    'class' => 'ext.fusioncharts.fusionCharts',
	            ),
		'cache'=>array(
				'class'=>'system.caching.CFileCache'
		),
		'image'=>array(
				'class'=>'ImgManager',
				'versions'=>array(
						'small'=>array('width'=>120,'height'=>120),
						'medium'=>array('width'=>320,'height'=>320),
						'large'=>array('width'=>640,'height'=>640),
				),
				'imagePath'=>'images/',
		),
		'imagemod' => array(
				//alias to dir, where you unpacked extension
				'class' => 'application.extensions.imagemodifier.CImageModifier',
		),
		
		/*
		'mail' => array(
				'class' => 'ext.yii-mail.YiiMail',
				'transportType' => 'php',
				'viewPath' => 'bum.views.mail',
				'logging' => false,
				'dryRun' => false,
		),
		*/
		/* accesstheflock.io */
		'mail' => array(
		    'class' => 'ext.yii-mail.YiiMail',
		    'transportType' => 'smtp',
		    'transportOptions' => array(
		        'host' => 'smtp.gmail.com',
		        'username' => '',
		        'password' => '', 
		        'port' => '465',
		        'encryption'=>'tls',
		    ),
		    'viewPath' => 'bum.views.mail',
		    'logging' => true,
		    'dryRun' => false
		),
		
		'authManager'=>array(
				'class'=>'CDbAuthManager',
				'connectionID'=>'db',
				'itemTable'=>'authitem',
				'itemChildTable'=>'authitemchild',
				'assignmentTable'=>'authassignment',
		),
		'session' => array (
				'class' => 'system.web.CDbHttpSession',
				'connectionID' => 'db',
				'sessionTableName' => 'tbl_session',
		),
		'bootstrap' => array(
				'class' => 'ext.booster.components.Bootstrap',
				'coreCss' => false,
		),
		'booster' => array(
				'class' => 'ext.booster.components.Bootstrap',
				'coreCss' => false,
		),
		'urlManager' => array(
			'class' => 'ext.UrlManager.UrlManager',
			'urlFormat' => 'path',

			'showScriptName'=>false,
			//'hostInfo' => 'http://www.renturly.net',
			//'secureHostInfo' => 'https://www.renturly.net',
			'hostInfo' => 'http://www.accesstheflock.io',
			'secureHostInfo' => 'https://www.accesstheflock.io',
			'secureRoutes' => array(
				'buyer/TireKicker',
				'matchTable/Deal',
				'matchTable/BirdDogging',
				'portfolio/PortfolioMatch',
				'buyer/view',
				'portfolio/view',
				'blog/content/index',
				'blog/content/view',
				'buyer/list',
				'buyer/wherelooking',
				'portfolio/list',
				'portfolio/assettype',
				'property/view',
				'site/landingpages',
				'blog/content/urlybird',
				'blog/content/admin',
				'site/index',
				'site/grow', //secure checkout
				'buyer/ApartmentBuilding',
				'property/sellhomes',
				'bum/users/login',   // site/login action
				'bum/users/googleSignup',  
				'bum/users/signUp',  // site/signup action
				'bum/users/admin',     // all actions of SettingsController
				'bum/users/update',
				'bum/users/viewProfile',
				'bum/users/rate',
				'bum/users/viewMyPrivateProfile',
				'bum/users/update',
				'match/search',
				'matchTable/search',
				'stripe/subscribe',
				'sellersDocuments/upload',
				'cashBuyersList/upload',
				'motivatedSellersList/upload',
				'matchTable/matches',
				'matchTable/paythebirddog',
				'matchTable/doggingfistfuls',
				'matchTable/bringmerenturly',
				'buyer/create',
				'buyer/matches',
				'buyer/admin',
				'buyer/togglematch',
				'portfolio/create',
				'portfolio/admin',
				'portfolio/togglematch',
				//'portfolio/view',
				//'buyer/view',
				//'portfolio/create',
				//'portfolio/update',
				//'property/create',
				//'buyer/create',
				//'buyer/update',
				'note/create',
				'note/update',
				//'stripe/subscribe',
				//'site/matching',
				//'site/matching',
				//'site/page',
				//'site/pricing',
				//'stripe/subscribe',
				//'stripe/reserve',
				//'stripe/reserved',
				//'stripe/ub4monthly',
				//'stripe/ub7monthly',
				//'stripe/ub10monthly',
				//'stripe/ub4annually',
				//'stripe/ub7annually',
				//'stripe/ub10annually'
			),
			'rules'=>array(
				'showScriptName'=>false,
				'caseSensitive'=>false,
				''=>'site/index',
				'login' => 'bum/users/login',
				'login?code' => 'bum/users/login',
				'signup' => 'bum/users/signUp',
				'googleSignup' => 'bum/users/googleSignup',
				'logout' => 'bum/users/logout',

				'the-urly-bird/page/<page:\d+>'=>'blog/content/index',
				'birddogging' => 'blog/content/urlybird',
				'marketplace/<id:\d+>' => 'property/view',
				'the-urly-bird' => 'blog/content/index',
				'sell-homes' => 'property/sellhomes',
				'gold' => 'blog/content/admin',
				'cash-buyers-landing-page' => 'site/landingpages',
			
				//'the-urly-bird' => 'blog/content/theurlybird',
				
				'buy-apartment-buildings' => 'buyer/apartmentbuilding',
			
				'the-urly-bird/<id:\d+>' => 'blog/content/view',
				'buyer/list' => 'buyer/list',
				'fistfuls-of-cash' => 'buyer/list',
				'portfolio-match' => 'portfolio/portfolioMatch',
				'sellers-list' => 'portfolio/list',
				'renturly' => 'portfolio/list',
				'match'=>'site/match',
				'boost'=>'site/boost',
				'pricing'=>'site/pricing',
				'buy'=>'site/buy',
				'sell'=>'site/sell',
				'rss'=>'site/rss',
				'packages'=>'site/packages',
				'buyers'=>'site/buyers',
				'matching'=>'site/matching',
				'social' => 'bum/users/socialUpdate',
				'portfolios' => 'portfolio/admin',
				'contact' => 'site/contact',

				'bird-feeder' => 'birdFeeder/search',
				'birds-of-a-feather' => 'matchTable/search',
				'upload-your-cash-buyers-list' => 'cashBuyersList/upload',
				'upload-your-motivated-sellers-list' => 'motivatedSellersList/upload',
				'matches' => 'matchTable/matches',
				'flock-technology' => 'matchTable/matches',

				'recoveryuser' => 'bum/users/passwordRecoveryWhatUser',
				//'askcode' => 'bum/users/passwordRecoveryAskCode',
				'reset' => 'bum/users/passwordRecoveryResetPassword',
				'resend' => 'bum/users/resendSignUpConfirmationEmail',
				'updateusers' => 'bum/users/update',
				'common-shareholders' => 'bum/users/admin',
				//'users' => 'bum/users/viewAllUsers',
				'privateprofile' => 'bum/users/viewMyPrivateProfile',
				'profile' => '/bum/users/viewProfile',
				'<view>'=>array('site/page'),




				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<pid:\d+>/commentfeed'=>array('comment/feed','urlSuffix'=>'.xml','caseSensitive'=>false),
				'commentfeed'=>array('comment/feed','urlSuffix'=>'.xml','caseSensitive'=>false),

			)
		),

		//'urlManager'=>array(
				//'urlFormat'=>'path',
				//'showScriptName'=>false,

				//'class'=>'ext.DbUrlManager.EDbUrlManager',
				//'connectionID'=>'db',
				/*
				'rules'=>array(
						'showScripName'=>false,
						'caseSensitive'=>false,
						'index'=>'site/index',
						'login' => 'bum/users/login',
						'signup' => 'bum/users/signUp',

						'the-urly-bird' => 'blog/content/index',
						'the-urly-bird/<id:\d+>' => 'blog/content/view',


						'social' => 'bum/users/socialUpdate',
						'urlybirds' => 'property/index',
						'search' => 'property/search',
						'contact' => 'site/contact',

						'recoveryuser' => 'bum/users/passwordRecoveryWhatUser',
						//'askcode' => 'bum/users/passwordRecoveryAskCode',
						'reset' => 'bum/users/passwordRecoveryResetPassword',
						'resend' => 'bum/users/resendSignUpConfirmationEmail',
						'updateusers' => 'bum/users/update',
						'users' => 'bum/users/admin',
						//'users' => 'bum/users/viewAllUsers',
						'privateprofile' => 'bum/users/viewMyPrivateProfile',
						'profile' => '/bum/users/viewProfile',
						'<view>'=>array('site/page'),




						'<controller:\w+>/<id:\d+>'=>'<controller>/view',
						'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
						'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
						'<pid:\d+>/commentfeed'=>array('comment/feed','urlSuffix'=>'.xml','caseSensitive'=>false),
						'commentfeed'=>array('comment/feed','urlSuffix'=>'.xml','caseSensitive'=>false),

				)*/

		//),
		/*
		'urlManager' => array(
		        'urlFormat' => 'path',
		        'showScriptName' => false,

		        'rules' => array(
		            '<controller:\w+>/<action:\w+>'=>'<controller>/<action>'
		        ),

		    ),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		'db'=>array(
		/*
			'connectionString' => 'mysql:host=localhost;dbname=renturly_development',
			'emulatePrepare' => true,
			'username' => '',
			'password' => '',
			'charset' => 'utf8',
		*/
			'connectionString' => 'mysql:host=localhost;dbname=renturly',
			'emulatePrepare' => true,
			'username' => '',
			'password' => '', 
			'charset' => 'utf8',
		

		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, trace, info',
					'logFile'=>'application.log',
				),
				/*
				array(
						'class'=>'CEmailLogRoute',
						'levels'=>'error, warning',
						//'emails'=>'admin@renturly.com',
						//'sentFrom'=>'admin@renturly.com',
						'emails'=>'michael.sadler@gmail.com',
						'sentFrom'=>'michael.sadler@gmail.com',
				),
				*/
				array(
						'class'=>'ext.LogDb',
						'autoCreateLogTable'=>true,
						'connectionID'=>'db',
						'enabled'=>true,
						'levels'=>'info',
				),

				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'michael.sadler@accesstheflock.io', //michael.sadler@gmail.com
	),
);
} else {
return array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name'=>'Renturly',
		'theme'=>'abound',
		'defaultController' => 'site/index',

		'homeUrl'=>array('/site/index'),

		//'language' => "CHttpRequest::preferredLanguage",

		// preloading 'log' component
		'preload'=>array('log'),

		// autoloading model and component classes
		'import'=>array(
			'application.models.*',
			'application.components.*',
			'application.controllers.*',
			'application.extensions.groupgridview.*',
			'application.extensions.EGMap.*',
			'application.extensions.httpclient',
			'application.extensions.magnific-popup.EMagnificPopup',
			'application.extensions.CAdvancedArBehavior',
			'ext.behaviors.SluggableBehavior',
			'ext.behaviors.*',
			'ext.yiibooster.*',
			'ext.clonnableFields.*',
			'application.modules.image.components.*',
			'application.modules.image.models.Image',
			'ext.yii-mail.YiiMailMessage',
			'application.modules.bum.models.*',
			'application.modules.bum.components.*',
			'ext.DbUrlManager.EDbUrlManager',
			'ext.DzRaty.*',
			'ext.xupload.*',
			'ext.phpexcelreader.*',
			'ext.fusioncharts.*',
		),
		
		'aliases' => array(
		    //If you manually installed it
		    'xupload' => 'ext.xupload',
		), 


		'modules'=>array(
				// uncomment the following to enable the Gii tool
				'gii'=>array(
				'class'=>'system.gii.GiiModule',
						'password'=>false,
						// If removed, Gii defaults to localhost only. Edit carefully to taste.
						'ipFilters'=>array('127.0.0.1','::1'),
						),
						'image'=>array(
								'createOnDemand'=>true, // requires apache mod_rewrite enabled
								'install'=>false, // allows you to run the installer
								'imagePath'=>'www/files/images/',
						),
						'MSensorarioDropdown',
						// Basic User Management module;
						'bum' => array(
								// needs yii-mail extension..

								'install'=>false, // true just for installation mode, on develop or production mode should be set to false
						),
						'blog',
				),

				// application components
				'components'=>array(
						'user'=>array(
								// enable cookie-based authentication
								'allowAutoLogin'=>true,
								'class' => 'BumWebUser',//'class' => 'WebUser',
								'loginUrl' => array('//bum/users/login'), // required
								'autoUpdateFlash' => false,
						),
				        'fusioncharts' => array(
					                    'class' => 'ext.fusioncharts.fusionCharts',
					            ),
						'cache'=>array(
								'class'=>'system.caching.CFileCache'
						),
						'image'=>array(
								'class'=>'ImgManager',
								'versions'=>array(
										'small'=>array('width'=>120,'height'=>120),
										'medium'=>array('width'=>320,'height'=>320),
										'large'=>array('width'=>640,'height'=>640),
								),
								'imagePath'=>'www/files/images/',
						),
						'imagemod' => array(
								//alias to dir, where you unpacked extension
								'class' => 'application.extensions.imagemodifier.CImageModifier',
						),
						'mail' => array(
								'class' => 'ext.yii-mail.YiiMail',
								'transportType' => 'php',
								'viewPath' => 'bum.views.mail',
								'logging' => false,
								'dryRun' => false,
						),
						'authManager'=>array(
								'class'=>'CDbAuthManager',
								'connectionID'=>'db',
						),
						'session' => array (
								'class' => 'system.web.CDbHttpSession',
								'connectionID' => 'db',
								'sessionTableName' => 'tbl_session',
						),
						'bootstrap' => array(
								'class' => 'ext.yiibooster.components.Bootstrap',
						),
						'urlManager'=>array(
								//'urlFormat'=>'path',
								'showScriptName'=>false,
				
								//'class'=>'ext.DbUrlManager.EDbUrlManager',
								//'connectionID'=>'db',
								/*
								'rules'=>array(
										'showScripName'=>false,
										'caseSensitive'=>false,
										'index'=>'site/index',
										'login' => 'bum/users/login',
										'signup' => 'bum/users/signUp',
				
										'the-urly-bird' => 'blog/content/index',
										'the-urly-bird/<id:\d+>' => 'blog/content/view',
				
				
										'social' => 'bum/users/socialUpdate',
										'urlybirds' => 'property/index',
										'search' => 'property/search',
										'contact' => 'site/contact',
				
										'recoveryuser' => 'bum/users/passwordRecoveryWhatUser',
										//'askcode' => 'bum/users/passwordRecoveryAskCode',
										'reset' => 'bum/users/passwordRecoveryResetPassword',
										'resend' => 'bum/users/resendSignUpConfirmationEmail',
										'updateusers' => 'bum/users/update',
										'users' => 'bum/users/admin',
										//'users' => 'bum/users/viewAllUsers',
										'privateprofile' => 'bum/users/viewMyPrivateProfile',
										'profile' => '/bum/users/viewProfile',
										'<view>'=>array('site/page'),
				
				
				
				
										'<controller:\w+>/<id:\d+>'=>'<controller>/view',
										'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
										'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
										'<pid:\d+>/commentfeed'=>array('comment/feed','urlSuffix'=>'.xml','caseSensitive'=>false),
										'commentfeed'=>array('comment/feed','urlSuffix'=>'.xml','caseSensitive'=>false),
				
								)*/
				
						),
						
			// uncomment the following to use a MySQL database
			'db'=>array(
					
						'connectionString' => 'mysql:host=localhost;dbname=renturly', //'mysql:host=localhost;dbname=renturly_development',
						'emulatePrepare' => true,
						'username' => '',
						'password' => '',
						'charset' => 'utf8',
					/*
						'connectionString' => 'mysql:host=localhost;dbname=renturly',
						'emulatePrepare' => true,
						'username' => '',
						'password' => '',
						'charset' => 'utf8',
					
					/*
						'connectionString' => 'mysql:host=localhost;dbname=hastenant',
						'emulatePrepare' => true,
						'username' => '',
						'password' => '',
						'charset' => 'utf8',
					*/
						
						),
						'errorHandler'=>array(
								// use 'site/error' action to display errors
								'errorAction'=>'site/error',
						),
						'log'=>array(
								'class'=>'CLogRouter',
								'routes'=>array(
										array(
												'class'=>'CFileLogRoute',
												'levels'=>'error, warning, trace, info',
												'logFile'=>'application.log',
										),
										array(
												'class'=>'CEmailLogRoute',
												'levels'=>'error, warning',
												'emails'=>'michael.sadler@gmail.com',
												'sentFrom'=>'michael.sadler@gmail.com',
										),
										array(
												'class'=>'ext.LogDb',
												'autoCreateLogTable'=>true,
												'connectionID'=>'db',
												'enabled'=>true,
												'levels'=>'info',
										),
										// uncomment the following to show log messages on web pages
										/*
array(
		'class'=>'CWebLogRoute',
),
*/
),
),
),

// application-level parameters that can be accessed
// using Yii::app()->params['paramName']
'params'=>array(
		// this is used in contact page
		'adminEmail'=>'michael.sadler@gmail.com',
								),
);
}
