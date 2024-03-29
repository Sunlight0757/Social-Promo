<?php

require 'search/getSearchParams.php';
require 'search/getSearchData.php';

header('Access-Control-Allow-Origin: *');

// Domain
define("domain", 'https://socialpromo.biz/demo/sunlight/');
//define("domain", 'https://socialpromo.biz/test/');
define("SEARCH_BASE_URL", 'https://suite.social/search/');

// Max Search URL's
define("MAX_SEARCH_KEYWORD", 3);

// Product Type Phrases 
define('phrase1', 'I want a');
define('phrase2', 'Recommend a');
define('phrase3', 'Hunting for a');
define('phrase4', 'Looking for a');
define('phrase5', 'Searching for a');
define('phrase6', 'Seeking a');
define('phrase7', 'Trying to find a');

// HOW TO ADD MORE NETWORKS?
// Just add new option in admin page with same name as search
// <option>Tiktok</option>

// Search API Key
define("SEARCH_API_KEY", 'DfbocUOh1x76d9Lt1hfLf5ia1Ugs6Zqu');

// location API Key  https://api.ipdata
define("api_location", '');

// Numbervalidte api
define('api_key', ['', '', '']);

//Weather 
//api used: https://api.api-ninjas.com
define('locationapi', '');

//weather info by cities
define('weatherapi', '');

// Email verification // Gmail lets you send up to 500 emails per day.
define('send_email_verification', true);
define('address', 'no-reply@socialpromo.biz');
define('name', 'Social Promo');
define('subject', 'Social Promo');
define('username', 'test@socialpromo.biz');
define('password', 'testing@123');
define('host','mail.socialpromo.biz');
define('SMTPAuth', true);
define('SMTPSecure', 'ssl');
define('port', '465'); // OR TRY 587

// Booking settings
//define('adminbookingalert', 'has just completed your promotion, visit to view: ');
define('send_email_booking_reminder', true);
define('send_sms_booking_reminder', true);
define('send_email_booking_reminder_admin', true);
define('send_sms_booking_reminder_admin', true);
define('adminbookingreminder', 'Booking Reminder for ');
define('bookingslide', '1');
define('afterbookingslide', '2');
define('bookingstatus', '[{"Pending":"warning"},{"Attended":"primary"},{"Rejected": "danger"}]');
define('bookingdatafile', 'db/bookings.json');
define('sendemailBookingFile', 'send-email_booking.php');

// Twilio verification and whatsapp
define('send_sms', true);
define('twilo_ssid', '');
define('twilo_token', '');
define('twilo_phoneNumber', '');
define('twilo_whatsapp_sender', '');
define('smsMessage', 'Thanks for taking part! Confirm your answers here');

// Admin alert
define('send_email_alert', true);
define('send_sms_alert', true);
define('email_address', ['message.uk@gmail.com','socialsuite.uk@gmail.com']); //you can add more email
define('sms_phoneNumber', ['+447305800400','',]); // you can add more number
define('adminalert', 'has just completed your promotion, visit to view: ');

// Firebase push notifications
define('allow_push', true);
define('apiKey_pushNotification', '');
define('authDomain', '');
define('projectID', '');
define('storageBucket', '');
define('messagingSenderId', '');
define('appId', '');
define('measuretId', '');
define('ServerKey', '');
define('KeyPair', '');

//Google calendar https://www.googleapis.com/calendar
define('calendar_api_key', '');
define('country', 'uk');  // country sigle.

// Push settings
define('titleNotification', 'Social Promo');
define('bodyNotification', 'Thanks for taking part! Confirm your answers here');
define('iconNotification', domain . '/src/img/logo.png');
define('imageNotification', domain . 'src/img/banner.jpg');
define('click_action', 'https://example.com');

// Points
define('download', 10);
define('visit', 10);
define('puzzle', 10);
define('video', 10);
define('survey', 10);
define('share', 5);
define('memory', 10);
define('game', 10);

// Delays
define('shareDelay', 20);
define('shareDelay2', 5);
define('visitDelay', 10);
define('videoDelay', 10);
define('gameDelay', 10);

// Video 
define('videoid', '');
define('htmlVideo', '');

// Confirm
define('confirmSlide', '15');

// Gift
define('giftslide', '20');

// Badges
define('badge1', 25);
define('badge2', 50);
define('badge3', 75);
define('badge4', 100);

// Status (Leads)
define('status', '[
{"Warm":"primary"},
{"Rejected": "warning"},
{"Hot": "danger"}, 
{"Contacted":"success"},
{"Attended":"success"}
]');

//Status (Search)
define('searchstatus', '[
{"Pending":"primary"},
{"Contacted":"secondary"},
{"Replied": "success"},
{"Rejected": "warning"}
]');

// Status (Template)
define('templatestatus', '[
{"Pending":"warning"},
{"Approved":"primary"},
{"Rejected": "danger"},
{"Published": "success"}
]');

// Share alert
define('alerttitle','Confirm you shared to add points!');
define('alerttext','Did you share it? We check so no cheating please.');

// Files (Email)
define('sendemailFile', 'send-email.php');
define('emailFile', 'email.php');
define('confirmFile', 'confirm.php');
define('datafile', 'db/data.json');

//Files (Support)
/*
define('supportdatafile', 'db/support.json');
define('sendemailSupportFile', 'send-email_support.php');
define('emailSupportFile', 'email_support.php');
define('confirmBSupportFile', 'confirm_support.php');
*/

//Files (Admin)
define('adminTemplatesFile', 'db/templates.json');
define('adminQuestionsFile', 'db/questions.json');
define('adminServicesFile', 'db/services.json');
define('adminSearchCategoriesFile', 'db/search_categories.json');
define('adminClientLinksFile', 'db/client_links.json');

// Post request;

if (isset($_POST['apikey'])) {
    echo json_encode(api_key);
}

if (isset($_POST['twillodt'])) {
    $twillodata = [];
    $twillodata['twilo_ssid'] = twilo_ssid;
    $twillodata['twilo_token'] = twilo_token;
    $twillodata['twilo_phoneNumber'] = twilo_phoneNumber;
    $twillodata['twilo_whatsapp_sender'] = twilo_whatsapp_sender;
    echo json_encode($twillodata);
}

if (isset($_POST['pushdt'])) {
    $pushdata = [];
    $pushdata['apiKey_pushNotification'] = apiKey_pushNotification;
    $pushdata['projectID'] = projectID;
    $pushdata['messagingSenderId'] = messagingSenderId;
    $pushdata['measuretId'] = measuretId;
    $pushdata['ServerKey'] = ServerKey;
    $pushdata['authDomain'] = authDomain;
    $pushdata['storageBucket'] = storageBucket;
    $pushdata['appId'] = appId;
    $pushdata['KeyPair'] = KeyPair;
    echo json_encode($pushdata);
}
