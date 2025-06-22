<?php
require_once 'vendor/autoload.php';
session_start();

$client = new Google_Client();
$client->setClientId('YOUR_CLIENT_ID');
$client->setClientSecret('YOUR_CLIENT_SECRET');
$client->setRedirectUri('https://regnumjeb.com/auth/oauth.php');
$client->addScope('email');

if (!isset($_GET['code'])) {
  $authUrl = $client->createAuthUrl();
  header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
  exit;
} else {
  $client->authenticate($_GET['code']);
  $token = $client->getAccessToken();
  $client->setAccessToken($token);

  $oauth = new Google_Service_Oauth2($client);
  $userinfo = $oauth->userinfo->get();

  // You’d now check users.json/db for that email and redirect accordingly
  // Redirect to index.php or dashboard
}
?>