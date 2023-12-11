<?php
require 'config.php';

$pushmessage = null;
if (isset($_POST['json'])) {
    $pushmessage = json_decode($_POST['json'], true);
    // var_dump($pushmessage);
    $json = $_POST['json'];
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <button style="background:#00b878;color:#fff" id="allowpushNotification" class="slideform-btn "><i class="fa-solid fa-arrow-right fa-beat-fade"></i> ALLOW PUSH NOTIFICATIONS</button>


    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <!-- Firebase-->
    <script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js"></script>
    <script>
        $(document).ready(function() {
            const iconNotification = '<?= iconNotification ?>';
            const imageNotification = '<?= imageNotification ?>';
            const domain = '<?= domain ?>';
            var uniqueID = 1;
            var confirmSlidePosition = 1;
            // rewrite firebase-messaging-sw.js
            $.ajax({
                url: 'rewrite-firebase-ms-sw.php',
                success: function() {
                    console.log('firebase-messaging-sw is upadted');
                },
                error: function(xhr, status, error) {
                    // errors AJAX
                    console.log(xhr.responseText);
                    //$('.response').text(xhr.responseText);
                }
            });


            var json = <?= $json ?>;
            let noti = null
            let buttonAllowpush = document.getElementById('allowpushNotification');

            let apiKey_pushNotification = '';
            let projectID = '';
            let messagingSenderId = '';
            let measuretId = '';
            let ServerKey = '';
            let authDomain = '';
            let storageBucket = '';
            let appId = '';
            let KeyPair = '';

            $.ajax({
                type: 'POST',
                url: 'config.php',
                data: {
                    pushdt: 'ask'
                },
                success: function(pushinfo) {

                    let push_info = JSON.parse(pushinfo);
                    apiKey_pushNotification = push_info.apiKey_pushNotification;
                    projectID = push_info.projectID;
                    messagingSenderId = push_info.messagingSenderId;
                    measuretId = push_info.measuretId;
                    ServerKey = push_info.ServerKey;
                    authDomain = push_info.authDomain;
                    storageBucket = push_info.storageBucket;
                    appId = push_info.appId;
                    KeyPair = push_info.KeyPair;
                    // console.log(push_info);
                },
                error: function() {
                    console.error('Error issue');
                }
            });

            let userToken = false;

            function requestPermission() {
                console.log('Requesting permission...');
                Notification.requestPermission().then((permission) => {
                    if (permission === 'granted') {
                        console.log('Notification permission granted.');
                    }
                });
            }

            var body = document.querySelector('body');

            buttonAllowpush.addEventListener('click', () => {
                console.log('sendpush');
                const firebaseConfig = {
                    // firebaseConfig here
                    apiKey: apiKey_pushNotification,
                    authDomain: authDomain,
                    projectId: projectID,
                    storageBucket: storageBucket,
                    messagingSenderId: messagingSenderId,
                    appId: appId,
                    measurementId: measuretId
                };
                const app = firebase.initializeApp(firebaseConfig)
                const messaging = firebase.messaging();
                navigator.serviceWorker.register('/firebase-messaging-sw.js')
                    .then(function(registration) {
                        console.log('Service Worker enregistré avec succès:', registration);
                    })
                    .catch(function(error) {
                        console.log('Échec', error);
                    });

                messaging.getToken({
                    vapidKey: KeyPair
                }).then((currentToken) => {
                    if (currentToken) {
                        console.log('Registration token:', currentToken);
                        // Send the token to your server and update the UI if necessary
                        // document.querySelector('body').append(currentToken);
                        sendTokenToServer(currentToken)

                        userToken = currentToken;
                        //body.innerHTML =  '<button style="background:#00b878;color:#fff" id="allowpushNotification" class="slideform-btn "><i class="fa-solid fa-arrow-right fa-beat-fade"></i> ALLOW PUSH NOTIFICATIONS</button><br><br>'+body+'<br><br>'+currentToken;


                        //send push notification
                        messaging.onMessage((payload) => {
                            // notification data receive here, use it however you want
                            // keep in mind if message receive here, it will not notify in background
                            console.log('Message received. ', payload);
                        });


                    } else {
                        requestPermission();
                        console.log('No registration token available. Request permission to generate one.');
                        setTokenSentToServer(false);
                    }
                }).catch((err) => {
                    console.log('An error occurred while retrieving token.', err);

                    setTimeout(() => {
                        buttonAllowpush.click();
                    }, 7000);
                    setTokenSentToServer(false);
                });

                console.log(noti, 'okff');
            });
            // setTimeout(buttonAllowpush.click(), 7000);
            // setTimeout(function() {
            //   buttonAllowpush.click();
            // }, 8000);
            json.forEach((element, index) => {
                let time = 15000;
                if (index == 0) {
                    time = 2000;
                }

                setTimeout(function() {
                    noti = {
                        title: element.title,
                        body: element.content,
                        icon: iconNotification,
                        image: element.image,
                        click_action: element.url,
                        device: element.device,
                    };

                    $.ajax({
                        url: 'rewrite-firebase-ms-sw.php',
                        type: 'POST',
                        data: {
                            notiData: JSON.stringify(noti)
                        },
                        success: function() {
                            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                                .then(function(registration) {
                                    console.log('Service Worker enregistré avec succès:', registration);
                                })
                                .catch(function(error) {
                                    console.log('Échec', error);
                                });

                            navigator.serviceWorker.getRegistration('/firebase-messaging-sw.js').then(function(registration) {
                                if (registration) {
                                    registration.update().then(function() {
                                        console.log('Service Worker updated');
                                    });
                                }
                            });

                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }, (index + 1) * time);

                setTimeout(() => {
                    buttonAllowpush.click();
                }, (index + 1) * time + 4000);
               
                setTimeout(() => {
                    $.ajax({
                                type: 'POST',
                                url: 'notification.php',
                                data: { token: noti.device },
                                success: function(respon) {
                                    console.log(respon);
                                },
                                error: function() {
                                    console.error('Error issue ');
                                }
                            });
                }, (index + 1) * time + 6000);


            });


        });



        //setTimeout(sendpush, 7000);

        function sendTokenToServer(currentToken) {
            if (!isTokenSentToServer()) {
                console.log('Sending token to server...');
                // TODO(developer): Send the current token to your server.
                setTokenSentToServer(true);
            } else {
                console.log('Token already available in the server');
            }
        }

        function isTokenSentToServer() {
            return window.localStorage.getItem('sentToServer') === '1';
        }

        function setTokenSentToServer(sent) {
            window.localStorage.setItem('sentToServer', sent ? '1' : '0');
        }
    </script>


</body>

</html>