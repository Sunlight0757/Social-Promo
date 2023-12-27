const form = document.querySelector('form');
let formData = null;
var submit = document.getElementById('submit');
var valid = false;
let uniqueID ='';
var  groups = [];   
let bookingdata = null;
//submit.setAttribute('class','btn btn-danger');
// slideform-btn-next
// console.log(submit);

$(document).ready(function () {
      // rewrite firebase-messaging-sw.js
      $.ajax({
        url: 'rewrite-firebase-ms-sw.php',
        success: function () {
            // console.log('firebase-messaging-sw is upadted');
        },
        error: function (xhr, status, error) {
            // errors AJAX
            console.log(xhr.responseText);
            //$('.response').text(xhr.responseText);
        }
    });
    
    var bookingsliding = false;
    /// booking data
    window.addEventListener('message', function (e) {
      if (e.source !== document.getElementById('booking-iframe').contentWindow) {
        return ;
      }
      if (typeof e.data === 'string') {
        try {
           bookingdata = JSON.parse(e.data);
          console.log('Booking form :',bookingdata);
         


          if (bookingdata) {
             groups = bookingdata.groups;
            //  console.log(groups);
            if (bookingslide < afterbookingslide)
            {
                let count = 0;
             var diff = afterbookingslide - bookingslide
             for (let index = 1; index <= diff; index++) {
             if(!bookingsliding)	{
                 $('.slideform-btn-next')[0].click(); 
                 console.log('next');  
                 count++; console.log(count,diff); 
                 }
                 }
                 bookingsliding =true;
            }  
            
            if (bookingslide > afterbookingslide)
            {
             var diff = bookingslide - afterbookingslide
             for (let index = 0; index <= diff; index++) {
             if(!bookingsliding)	{
                 $('.slideform-btn-back')[0].click();
                 console.log('back');       
         }}
                 bookingsliding =true;
            }
            var dateandtime = bookingdata.dateofbooking;
            var dateofbooking = dateandtime.split('/')[0];
            var timeofbooking = dateandtime.split('/')[1];

            // parse date
            var eventdate 	= dateofbooking.split('-');
            let month 		= eventdate[1];
            try {
                let parsed	= isNaN(parseInt(eventdate[1])) ? eventdate[1] : parseInt(eventdate[1]);
                month 		= month - 1;
            } 
            catch (error) {}
            let date 		    = new Date(eventdate[2], month, eventdate[0]);
            let options 	    = { weekday: 'long',day: 'numeric',month: 'short',year: 'numeric' };
            const dateFormatter = new Intl.DateTimeFormat('en-US', options);
            const formattedDate = dateFormatter.format(date);

           
            $('.bookingData').show();
           $('.bookingdate').text(formattedDate);
            $('.bookingtime').text(timeofbooking);
         }



       

        } catch (error) {
          console.log('Erreur de parsing JSON :', error);
        }
      }
    });

});


var numberinput = document.querySelector('input[name="number"]');
numberinput.addEventListener('input', function () {
    const value = this.value;
    const newValue = value.replace(/\s/g, '');
    this.value = newValue;
});


var apidone ='no';
 var locationUser ='';
$.ajax({
    type: 'GET',
    url: 'https://api.ipdata.co/?api-key='+api_location,
   // data: { jsonData: JSON.stringify(formData) },
    success: function (response) {
       //
        if (response.ip) {
            // console.log(response);
            locationUser = response.city+'/'+response.country_name;
            // console.log(locationUser);
        }
        else {
            // console.log(response);
            
            $.ajax({
                type: 'GET',
                url: 'http://ip-api.com/json/'+ip,
               // data: { jsonData: JSON.stringify(formData) },
                success: function (response) {
                   //
                    if (response.query) {
                        // console.log(response);
                        locationUser = response.city+'/'+response.country;
                        // console.log(locationUser);
                    }
                    else {
                        // console.log(response);
            
                        $.ajax({
                            type: 'GET',
                            url: 'https://ipapi.co/'+ip+'/json/',
                           // data: { jsonData: JSON.stringify(formData) },
                            success: function (response) {
                               //
                                if (response.ip) {
                                    // console.log(response);
                                    locationUser = response.city+'/'+response.country_name;
                                    // console.log(locationUser);
                                }
                                else {
                                    console.log(response);
                                }
                            },
                            error: function () {
                                // ajax error
                                console.log('An error is occured during email sending.');
                            }
                        });
                    }
                },
                error: function () {
                    // ajax error
                    console.log('An error is occured during email sending.');
                }
            });

        }
    },
    error: function () {
        // ajax error
        console.log('An error is occured during email sending.');
    }
});

function validateNumber(apiKey, number) {
    return new Promise((resolve, reject) => {
      const url = `https://api.apilayer.com/number_verification/validate?apikey=${apiKey}&number=${number}&format=1`;
      $.getJSON(url, function (data) {
        if (data.valid) {
          const formattedNumber = data.international_format;
          resolve(formattedNumber);
        } else {
            const invalid=1
          reject(invalid);
        }
      }).fail(function(jqXHR, textStatus, errorThrown) {
        const invalid=0
        reject(invalid);
      });
    });
  }
  var validatenumb = 0;
  var number = "";

  numberinput.addEventListener('blur', function () {

    let apiKey = [];
    $.ajax({
        type: 'POST',
        url: 'config.php',
        data: {
          apikey: 'ask'
        },
        success: function (api) {
          apiKey=JSON.parse(api);
        //   console.log((apiKey));
          $('#spinner').show();
         
          setTimeout(() => {
             $('#spinner').hide();
          }, 5000);
         
              number = numberinput.value;
               // change number beginning from 07 to 447
             number = number.replace(/^07/, '447');
             const validateNextKey = (i) => {
               if (i >= apiKey.length) {
                 var down = '';
                 validatenumb = 1;
                 var numberError = document.getElementById('nberror');
                   numberError.style.display = 'none';
                    apidone ='yes';
                     
                 //numberError.textContent = 'All API keys failed to validate number, please try again later.';
                 //numberError.style.display = 'block';
                 return;
               }
           
               const key = apiKey[i];
               //alert(key);
               validateNumber(key, number)
                 .then(formattedNumber => {
                   validatenumb = 1;
                   apidone ='yes';
                   number = formattedNumber;
                   var numberError = document.getElementById('nberror');
                   numberError.style.display = 'none';
                 })
                 .catch(error => {
                   //console.log(error);
         
                   if(error){
                     validatenumb = 0;
                     var numberError = document.getElementById('nberror');
                     numberError.textContent = 'Mobile number is invalid, please check again';
                 numberError.style.display = 'block';
                 apidone ='yes';
                
                     // $('#spinner').hide();   
                 
                   }
                   else
                   {
                   validateNextKey(i + 1);
                 }          
                 });
             };
           
             validateNextKey(0);

        },
        error: function () {
          console.error('Error issue');
        }
      });
  });
  
var blacklist = [];

$.get('db/blacklist.txt', function (data) {
    var lines = data.split('\n');
    for (var i = 0; i < lines.length; i++) {
        var email = lines[i].trim();
        if (email.length > 0) {
            blacklist.push(email);
        }
    }
});

submit.addEventListener('click', function (event) {
    event.preventDefault();

//    console.log(number);

    $('#spinner').show();

    // console.log(apidone);
    setTimeout(function(){
        if( apidone == 'no'){
            validatenumb=1;
        }
    }, 5000);


    var questions = [];
    var libelle = '';
    const questclass = document.getElementsByClassName('question');
    const nbquestion = questclass.length;

    for (let index = 0; index < nbquestion; index++) {
      
        //question
    libelle = document.querySelector('.question'+(index+1)).textContent;
    const question = [];
    const questionInputs = document.querySelectorAll('input[name="group'+(index+1)+'"]');
    questionInputs.forEach(input => {
        if (input.checked) {
           question.push(input.nextElementSibling.querySelector('.option').textContent);

        //    var options=  input.nextElementSibling;

           var group = input.nextElementSibling.querySelector('.group').textContent;
          // console.log(group);
         if(group !== 'null' && !groups.includes(group))
           { 
            groups.push( group);
           }

        }
    });
    const questionComment = document.getElementById('comment'+(index+1)).value;
// console.log(groups);
    var questionData = {
        question: libelle,
        answers: question,
        comment: questionComment,
    };

    questions.push(
        questionData
    );

    }

 

    //personnal information
    var fullName = document.querySelector('input[name="fullname"]').value;
    var website = document.querySelector('input[name="website"]').value;
    var userName='';

    const email = document.querySelector('input[name="email"]').value;

    const fn = fullName.split(' ');
    userName = fn[0];
    var fullnamep = document.getElementById('fullname');
    var validate = 0;

    if (fn.length >= 2) {
        if (fn[1] != '') {
            validate += 1;
        }
        else {
            var fullnameError = document.getElementById('fullname-error');
            if (!fullnameError) {
                fullnamep.innerHTML = fullnamep.innerHTML + '<label id="fullname-error" class="error" for="fullname"style="color: red;">Please enter a valid fullname.</label>';
            }
            else {
                fullnameError.style.display = "block"; fullnameError.textContent = 'Please enter a valid fullname .'
            }
        }
    } else {
        var fullnameError = document.getElementById('fullname-error');

        if (!fullnameError) {
            fullnamep.innerHTML = fullnamep.innerHTML + '<label id="fullname-error" class="error" for="fullname" style="color: red;">Please enter a valid fullname.</label>';
        }
        else {
            fullnameError.style.display = "block"; fullnameError.textContent = 'Please enter a valid fullname .'
            //console.log(fullnameError);
        }
    }

    var correctEmail = '';
    for (let i = 0; i < blacklist.length; i++) {
        if (email.includes(blacklist[i]) || email == '') {
            correctEmail = false;
            break;
        }
        else {
            correctEmail = true;
        }
    }
    if (correctEmail) {
        validate += 1;
    } else {

        var emailp = document.getElementById('email');
        var down = '';
        var emailError = document.getElementById('email-error');
        if (!emailError) {
            down = emailp.innerHTML + '<label id="email-error" class="error" for="email">Email not supported, please enter business email with your name.</label>'
            emailp.innerHTML = down;
        } else { emailError.textContent = 'Email not supported, please enter business email with your name.'; emailError.style.display = 'block'; }
    }


    if (website) {
        validate += 1;
    } else {

        var websitep = document.getElementById('website');
        var down = '';
        var websiteError = document.getElementById('website-error');
        if (!websiteError) {
            down = websitep.innerHTML + '<label id="website-error" class="error" for="website">Please enter a valid website link.</label>'
            websitep.innerHTML = down;
        } else { websiteError.textContent = 'Please enter a valid website link.'; websiteError.style.display = 'block'; }
    }
    var numberwherSubmited = document.querySelector('input[name="number"]').value;
    // console.log(validate); console.log(number);

    // if (validatenumb == 0) {

    // }

    if (numberwherSubmited) {
        validate += 1;
    } else {

        var numberp = document.getElementById('number');
        var numberError = document.getElementById('nberror');
        numberError.textContent = 'Mobile number is invalid, please check again';
        numberError.style.display = 'block';
    }

    validate = validate + validatenumb;
    if (validate >= 5) {


        //uniq id : 

        const generateID = () => {
            const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            let id = "";
            for (let i = 0; i < 7; i++) {
              id += alphabet.charAt(Math.floor(Math.random() * alphabet.length));
            }
            return id;
          };

           uniqueID = generateID();
           //   
//console.log(uniqueID); 

if(number[0]!='+')
{
    number='+'+number;
}

        const date = new Date();
        const formattedDate = date.toLocaleDateString()+' / '+date.getHours()+':'+date.getMinutes();
         formData = {
            id : uniqueID,
            fullName: fullName,
            website: website,
            number: number,
            email: email,
            verified: "",
            date: formattedDate,
            status: stDefaut,
            question: questions,
            birthday : "",
            location:locationUser,
            groups:groups,
            device : "",
            notes: ""
        };
        var update = '';
        var next = document.getElementsByClassName('slideform-btn-next')[0];
        // $.getJSON('db/data.json', function (data) {
            //data[data.length] = formData;
            $.ajax({
                type: 'POST',
                url: 'save.php',
                data: { jsonData: JSON.stringify(formData) },
                success: function (response) {
                  //  console.log('Data saved');
                    valid = true
                    update = response
                    $('#spinner').hide();
                    $('#end').show();
                    $('#username').text(userName);
                    var giftLinks = document.querySelectorAll(".gift");
                    var giftUrl = domain+'gifter='+uniqueID+'&id='+giftslide;
                    if (giftLinks) {
                        giftUrl = domain+'gifter='+uniqueID+'&id='+giftslide;
                        
                        giftLinks.forEach(function(link) {
                            var href = link.getAttribute("href");
                            href = href.replace("{LINK}", giftUrl);
                            link.setAttribute("href", href);
                    console.log(uniqueID);     });
                
                    }

                          //booking
                          if(bookingdata)
                          {
                            var booking = bookingdata;
                              booking.fullName= fullName;
                              booking.website= website;
                              booking.number= number;
                              booking.email= email;
                              booking.date= formattedDate;
                              booking.question= questions;
                              booking.location=locationUser;
                              booking.id=uniqueID;
                              console.log(booking);
                              $.ajax({
                                type: 'POST',
                                url: 'save.php',
                                data: { userbook: JSON.stringify(booking) },
                                success: function (response) {

                                },
                                error: function () {
                                  console.log('Error issue');
                                }
                              });
                           }
              

                    let noti = {
                        title :'Social promo',
          body: bodyNotification,
          icon: iconNotification,
          image : imageNotification,
          click_action : domain+''+confirmFile+'?index='+uniqueID+'&id='+confirmSlidePosition
                      }

                       navigator.serviceWorker.getRegistrations().then(function(registrations) {
                                  registrations.forEach(function(registration) {
                                    registration.unregister();
                                    console.log('reinitialisation...');
                                  });
                                });
                    $.ajax({
                        url: 'rewrite-firebase-ms-sw.php',
                        type: 'POST',
                        data: { notiData: JSON.stringify(noti) },
                        success: function () {
                            // console.log('firebase-messaging-sw is upadted2');
                                navigator.serviceWorker.register('/firebase-messaging-sw.js')
                                  .then(function(registration) {
                                    console.log('Service Worker enregistré avec succès:', registration);
                                  })
                                  .catch(function(error) {
                                    console.log('Échec', error);
                                  });
                        },
                        error: function (xhr, status, error) {
                            // errors AJAX
                            console.log(xhr.responseText);
                            //$('.response').text(xhr.responseText);
                        }
                    });
                    //email

                 if (send_email_verification) 
                 {   $.ajax({
                        type: 'POST',
                        url: sendemailFile,
                        data: { jsonData: JSON.stringify(formData) },
                        success: function (response) {
                           //
                            if (response == 'success') {
                               // console.log('Email envoyé avec succès!');
                            }
                            else {
                                console.log(response);
                            }
                        },
                        error: function () {
                            // ajax error
                            console.log('An error is occured during email sending.');
                        }
                    });
}
                    //admin alert
                    if (send_email_alert) 
                 {   $.ajax({
                        type: 'POST',
                        url: sendemailFile,
                        data: { name: fullName, alert:true},
                        success: function (response) {
                           //
                            if (response == 'success') {
                               // console.log('Email envoyé avec succès!');
                            }
                            else {
                                console.log(response);
                            }
                        },
                        error: function () {
                            // ajax error
                            console.log('An error is occured during email sending.');
                        }
                    });
                }
                //sms

                $.ajax({
                        type: 'POST',
                        url: 'config.php',
                        data: {
                          twillodt: 'ask'
                        },
                        success: function (twilloinfo) {
                            
                            let twillo_info = JSON.parse(twilloinfo);
                            const twillo_ssid = twillo_info.twilo_ssid;
                            const twillo_token = twillo_info.twilo_token;
                            const twillo_phonenumber = twillo_info.twilo_phoneNumber;
                            const twilo_whatsapp_sender = twillo_info.twilo_whatsapp_sender;
                            // console.log(twillo_ssid, twillo_token);
                            if(send_sms && update !=='update')
                            {
                                if(smsMessage!=='') { //Here is message content goes from confirm file if smsMessage is not null
                                    console.log('Gababa SMS ONLY:'+smsMessage);
                              var link= domain+''+confirmFile+'?index='+uniqueID+'&id='+confirmSlidePosition;
                                $(document).ready(function () {
                                    $.ajax({
                                        url: 'https://api.twilio.com/2010-04-01/Accounts/'+twillo_ssid+'/Messages.json',
                                        type: 'POST',
                                        data: {
                                            To: number,
                                            From: twillo_phonenumber,
                                            Body: smsMessage+': '+link
                                        },
                                        beforeSend: function (xhr) {
                                            xhr.setRequestHeader('Authorization', 'Basic ' + btoa(twillo_ssid+':'+twillo_token));
                                        },
                                        success: function (response) {
                                            console.log(response);
                                        },
                                        error: function (xhr, status, error) {
                                            // errors AJAX
                                            console.log(xhr.responseText);
                                            //$('.response').text(xhr.responseText);
                                        }
                                    });
                                    
                                    
                                });
                                }


                            }
            
                            //send whatsapp
            
                            if(send_sms && update !=='update')
                            {
            
                               var link= domain+''+confirmFile+'?index='+uniqueID+'&id='+confirmSlidePosition;
                                $(document).ready(function () {
            
                                    $.ajax({
                                        url: 'https://api.twilio.com/2010-04-01/Accounts/'+twillo_ssid+'/Messages.json',
                                        type: 'POST',
                                        data: {
                                            To: number,
                                            From:'whatsapp:'+ twilo_whatsapp_sender,
                                            Body: smsMessage+': '+link
                                        },
                                        beforeSend: function (xhr) {
                                            xhr.setRequestHeader('Authorization', 'Basic ' + btoa(twillo_ssid+':'+twillo_token));
                                        },
                                        success: function (response) {
                                            console.log(response);
                                        },
                                        error: function (xhr, status, error) {
                                            // errors AJAX
                                            console.log(xhr.responseText);
                                            //$('.response').text(xhr.responseText);
                                        }
                                    });
                                });
                            }
            
            
                                //admin alert
                                if(send_sms_alert)
                                        {
                                            $.each(sms_phoneNumber, function(index, adminNumber) {
                                          var link= domain+'admin.php';
                                            $(document).ready(function () {
            
                                                $.ajax({
                                                    url: 'https://api.twilio.com/2010-04-01/Accounts/'+twillo_ssid+'/Messages.json',
                                                    type: 'POST',
                                                    data: {
                                                        To: adminNumber,
                                                        From: twillo_phonenumber,
                                                        Body: fullName +' '+adminalert+link
                                                    },
                                                    beforeSend: function (xhr) {
                                                        xhr.setRequestHeader('Authorization', 'Basic ' + btoa(twillo_ssid+':'+twillo_token));
                                                    },
                                                    success: function (response) {
                                                        console.log(response);
                                                    },
                                                    error: function (xhr, status, error) {
                                                        // errors AJAX
                                                        console.log(xhr.responseText);
                                                        //$('.response').text(xhr.responseText);
                                                    }
                                                });
                                            });
                                        });
                                        }

                        },
                        error: function () {
                          console.error('Error issue');
                        }
                      });
                },
                error: function () {
                    console.error('Error issue');
                }
            });
        // 

        $('#end').show;
        $('#spinner').hide();
        next.click();

    }
    else {
        $('#spinner').hide();
        valid = false
    }

});
	
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
    success: function (pushinfo) {
        
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
    error: function () {
      console.error('Error issue');
    }
  });

let userToken =false;
function requestPermission() {
  console.log('Requesting permission...');
  Notification.requestPermission().then((permission) => {
    if (permission === 'granted') {
      console.log('Notification permission granted.');
    }
  });
}

   
buttonAllowpush.addEventListener('click', ()=>{

 const firebaseConfig = {
            // firebaseConfig here
            apiKey: apiKey_pushNotification,
            authDomain: authDomain ,
            projectId: projectID,
            storageBucket: storageBucket ,
            messagingSenderId: messagingSenderId ,
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

if(allow_push ){ messaging.getToken({ vapidKey:KeyPair }).then((currentToken) => {
  if (currentToken) {
    console.log('Registration token:', currentToken);
    // Send the token to your server and update the UI if necessary
	// document.querySelector('body').append(currentToken);
	sendTokenToServer(currentToken)

	userToken = currentToken;
    formData.device = currentToken;
// save data in device json
$.ajax({
                type: 'POST',
                url: 'save.php',
                data: { token: JSON.stringify(formData)},
                success: function (respon) {
                  console.log(respon);
               
  },
                error: function () {
                    console.error('Error issue ');
                }
            });

//send push notification
messaging.onMessage((payload) => {
    // notification data receive here, use it however you want
    // keep in mind if message receive here, it will not notify in background
    console.log('Message received. ', payload);
});

if(uniqueID != '')
    {
        $.ajax({
                type: 'POST',
                url: 'notification.php',
                data: { token: currentToken, userId: uniqueID },
                success: function (respon) {
                 // console.log(respon);
                 },
                error: function () {
                    console.error('Error issue ');
                }
            });
    }

    // ...
  } else {
    requestPermission();
    console.log('No registration token available. Request permission to generate one.');
	setTokenSentToServer(false);
}
}).catch((err) => {
  console.log('An error occurred while retrieving token.', err);

  setTimeout(() => {
  buttonAllowpush.click();
  }, 3000);
  setTokenSentToServer(false);
});}
	
})

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
///---------Birthday---------------///

$(document).ready(function () {

});

 
//  var birthdatep = document.getElementById('date');
//  birthdatep.addEventListener('blur', function () {
//     console.log(birthdatep.value);
//    var datep = birthdatep.value;
// var dateps = datep.split('/');
// var dayp = (dateps[0]);
// var monthp = (dateps[1]);
// var yearp = (dateps[2]);

//  var birthdatep1 = monthp + "/" +dayp  + "/" + yearp;
//  $(birthdatep).val(birthdatep1);

//  })

 
 let submitBirthday = document.getElementById('submitBirthday');
 submitBirthday.addEventListener('click', function (e) {
    e.preventDefault();
    $('#spinner').show();
    var birth = document.querySelector('input[name="birthdate"]');
    //var selectedDate = $(birth).datepicker("getDate");
 var birthdate =birth.value;
    // if (selectedDate) {
    //     var day = ("0" + selectedDate.getDate()).slice(-2);
    //     var month = ("0" + (selectedDate.getMonth() + 1)).slice(-2);
    //     var year = selectedDate.getFullYear();

    //      birthdate = day + "-" + month + "-" + year;
    //     console.log(birthdate);
    //     $(birth).val(birthdate);
    // }
    if (birthdate) {
       
var dateps = birthdate.split('-');
var dayp = (dateps[2]);
var monthp = (dateps[1]);
var yearp = (dateps[0]);

 var birthdate = dayp + "-" +monthp  + "-" + yearp;
        console.log(birthdate);
        formData.birthday = birthdate;
        $.ajax({
            type: 'POST',
            url: 'save.php',
            data: {
              birth: JSON.stringify(formData)
            },
            success: function () {   
                  $('#spinner').hide(); 
                var next = document.getElementsByClassName('slideform-btn-next')[0];
                next.click();
        
                           
            },
            error: function () {
              console.error('Error issue');
            }
        });

    } else {

        var birthdatep = document.getElementById('txtDOB');
        var down = '';
        var birthdateError = document.getElementById('txtDOB-error');
        if (!birthdateError) {
            down = birthdatep.innerHTML + '<label id="txtDOB-error" class="error" for="txtDOB">Please enter a valid birthdate link.</label>'
            birthdatep.innerHTML = down;
        }
       
        // lblAgeValue.textContent = 'Please enter a date';
        // lblAgeValue.style.display = 'block';
        // lblAgeValue.style.color = 'red';
    }
 })