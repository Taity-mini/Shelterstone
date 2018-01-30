<?php
// Include FB config file && User class
require_once('/inc/config.php');
require_once('./inc/fbConfig.php');
require_once('./models/users.php');


$helper = $fb->getRedirectLoginHelper();
try {
    $accessToken = $helper->getAccessToken();
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (isset($accessToken)) {
    $helper = $fb->getRedirectLoginHelper();
    if (isset($_SESSION['facebook_access_token'])) {
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    } else {
        // Put short-lived access token in session
        $_SESSION['facebook_access_token'] = (string)$accessToken;

        // OAuth 2.0 client handler helps to manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string)$longLivedAccessToken;

        // Set default access token to be used in script
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }

    // Getting user facebook profile info
    try {
        $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture.width(160).height(160)');
        $fbUserProfile = $profileRequest->getGraphNode()->asArray();
    } catch (FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        session_destroy();
        // Redirect user back to app login page
        header("Location: ./login");
        exit;
    } catch (FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }


//Check if user is in the club! (Bouncer function)
    try {
        // Returns a `FacebookFacebookResponse` object
        $response = $fb->get(
            '/146226435444638/members/?fields=id,administrator&limit=500',
            '' .  $_SESSION['facebook_access_token'] . ''
        );
    } catch (FacebookExceptionsFacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch (FacebookExceptionsFacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
    $graphNode = $response->getGraphList()->asArray();
    $inClub = false;
    $committeMember = false;
    foreach ($graphNode as $key => $value) { // This will search in the 2 jsons
        if ($fbUserProfile['id'] == $value["id"]) {
            $inClub = true;
            //if admin of Facebook group then automatically added to the committee user group on site
            if ($value['administrator'] == 1) {
                $committeMember = true;
            }
        }
    }

    if ($inClub) {
        // Initialize User class
        $user = new users();

        //get user data from Facebook profile
        $conn = dbConnect();
        $user->setUserName($fbUserProfile['id']);
        $user->setOAuthUID($fbUserProfile['id']);
        $user->setFirstName($fbUserProfile['first_name']);
        $user->setLastName($fbUserProfile['last_name']);
        $user->setEmail($fbUserProfile['email']);
        $user->setPicture($fbUserProfile['picture']['url']);
        $user->setLink($fbUserProfile['link']);

        //User groups
        if($committeMember){
            $user->setGroupID(2);
            $user->setApproved(1);
        } else{
            $user->setGroupID(3);
            $user->setApproved(0);
        }

        $userData = $user->checkUser($conn);

        if ($userData) {
            $user->getUserIDFromUsername($conn);
            $_SESSION['userID'] = $user->getUserID();
            header("Location: " . $_SESSION['domain'] . "");

        } else {
            $_SESSION['fb_error'] = true;
            header("Location: ./login");
        }
    } else {
        $_SESSION['not_in_club'] = true;
        header("Location: ./login");
    }
} else {
    header("Location: ./login");
    exit;
}
?>
