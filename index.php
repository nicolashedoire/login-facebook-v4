<!--<script type="text/javascript">
    <?php if (!isset($_SESSION['username'])) { ?>
        window.location.hash = "";
        window.history.pushState("", document.title, window.location.pathname); 
     <?php } ?>
</script>-->



<?php
/*	FACEBOOK LOGIN BASIC - PHP SDK V4.0

/* INCLUSION OF LIBRARY FILEs*/
	require_once( 'lib/Facebook/FacebookSession.php');
	require_once( 'lib/Facebook/FacebookRequest.php' );
	require_once( 'lib/Facebook/FacebookResponse.php' );
	require_once( 'lib/Facebook/FacebookSDKException.php' );
	require_once( 'lib/Facebook/FacebookRequestException.php' );
	require_once( 'lib/Facebook/FacebookRedirectLoginHelper.php');
	require_once( 'lib/Facebook/FacebookAuthorizationException.php' );
	require_once( 'lib/Facebook/GraphObject.php' );
	require_once( 'lib/Facebook/GraphUser.php' );
	require_once( 'lib/Facebook/GraphSessionInfo.php' );
	require_once( 'lib/Facebook/Entities/AccessToken.php');
	require_once( 'lib/Facebook/HttpClients/FacebookCurl.php' );
	require_once( 'lib/Facebook/HttpClients/FacebookHttpable.php');
	require_once( 'lib/Facebook/HttpClients/FacebookCurlHttpClient.php');

/* USE NAMESPACES */
	
	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookRequest;
	use Facebook\FacebookResponse;
	use Facebook\FacebookSDKException;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookAuthorizationException;
	use Facebook\GraphObject;
	use Facebook\GraphUser;
	use Facebook\GraphSessionInfo;
	use Facebook\FacebookHttpable;
	use Facebook\FacebookCurlHttpClient;
	use Facebook\FacebookCurl;

/*PROCESS*/
	//1.Stat Session
	 session_start();
	if(isset($_POST['del_session'])){
		session_start();
		session_destroy();
		header('Location: index.php#');
		die();
	} 
	//2.Use app id,secret and redirect url
	 $app_id = '1820355878205588';
	 $app_secret = '52ce769abcc29da20a55badb60dac01a';
	 $redirect_url='http://localhost/facebook_login/';
	 
	 try {
	 	//3.Initialize application, create helper object and get fb sess
	 FacebookSession::setDefaultApplication($app_id,$app_secret);
	 $helper = new FacebookRedirectLoginHelper($redirect_url);
	 $sess = $helper->getSessionFromRedirect();
	//4. if fb sess exists echo name 
	if(isset($sess)){
	 	//create request object,execute and capture response
		$request = new FacebookRequest($sess, 'GET', '/me');
		// from response get graph object
		$response = $request->execute();
		$graph = $response->getGraphObject(GraphUser::className());
		// use graph object methods to get user details
		$name= $graph->getName();
		$_SESSION['username'] = $name;
		echo "Bonjour $name";
		echo '<form method="POST"><input type="submit" id="effacer" name="del_session" class="form-control" value="Deconnexion"></form>';
	}else{
		//else echo login
		echo '<a href='.$helper->getLoginUrl().'>Login with facebook</a>';
	}
} catch(\Exception $e) {
	if(isset($_SESSION['username'])){
		echo 'Bonjour '.$_SESSION['username'];
		echo '<form method="POST"><input type="submit" id="effacer" name="del_session" class="form-control" value="Deconnexion"></form>';
	}
}
	 

