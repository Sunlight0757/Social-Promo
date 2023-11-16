
let points = 10;

let pointB = document.querySelectorAll('.points');

function downloadfile()
{
    document.getElementById('file').click();
    points+=download;
    pointB.forEach(element => {
        element.textContent=points;
    });  
     document.getElementById('filebtn').setAttribute('onclick', 'console.log("")');

     
}

function handleMessage(event) {
    if (event.source === document.getElementById('puzzle-iframe').contentWindow) {
      if (event.data === 'GetPuzzlePoint') {
        // console.log('puzzle prize');
        puzzlePoint();
      }
    }
  }
  
  // Add an event listener for the message
  window.addEventListener('message', handleMessage);


function puzzlePoint() {
   points+=puzzle;
   puzzle=0;
    pointB.forEach(element => {
        element.textContent=points;
    });  

}

//scratch
var cards = [];
function handleMessageScratch(e)
{
  // console.log(e);
  if (e.source === document.getElementById('scratch-iframe').contentWindow) {
    if (e.data[0] !== 'Lose') {
      // console.log('puzzle prize');
      if(!(cards.includes(e.data[1] )))
      {
      cards.push[e.data[1]];
      points+=parseInt(e.data[0]);
      pointB.forEach(element => {
      element.textContent=points;
    }); 
  }
      //puzzlePoint();
    }
  }
  //GetScratchPoint
}

 window.addEventListener('message', handleMessageScratch);


 //quiz
 var quiz = false;
function handleMessageQuiz(e)
{
  // console.log(e);
  if (e.source === document.getElementById('quiz-iframe').contentWindow) {
    if (!quiz) {
      points+=e.data;
      pointB.forEach(element => {
        element.textContent=points;
    }); quiz= true;
    }
  }

}

 window.addEventListener('message', handleMessageQuiz);

 //Memory
 var memorydone = false;
function handleMessageMemory(e)
{
  // console.log(e);
  if (e.source === document.getElementById('memory-iframe').contentWindow) {
  if (e.data == 'win'){
      if (!memorydone) {
      points+=memory;
      pointB.forEach(element => {
        element.textContent=points;
    }); memorydone= true;
    }}
  }

}

 window.addEventListener('message', handleMessageMemory);

$(document).ready(function(){
// console.log((pointB));
pointB.forEach(element => {
    element.textContent=points;


    

//game

let timeafterclick = 0;
let gametimer = null;
let gameinterval = null;
setTimeout(() => {
  var game= document.getElementById('game');
game.addEventListener('click',()=>{
  gameinterval = setInterval(gameElapsedTime, 1000);
  gametimer =  setInterval(() => {
   timeafterclick+=1;    
   }, 1000);
});

function gameElapsedTime() {
      if (timeafterclick >= gameDelay) {
    $('#game-button').show();
    clearInterval(gametimer);
    clearInterval(gameinterval);
  } 
}

}, 10000);
}); 

$('#game-button').on('click', function() {
  points+=game;
  $(this).prop('disabled',true);
   pointB.forEach(element => {
       element.textContent=points;
   }); 
    $(this).hide();

 });


//superwheel
$('.wheel-horizontal-arc').superWheel('onComplete', function (results) {

    if (results.value !== 0) {

        let v = results.text.split(' ')[0];
         points +=parseInt(v); 
         pointB.forEach(element => {
            element.textContent=points;
        });  
        document.getElementsByClassName('wheel-horizontal-arc-spin-button')[0].setAttribute('disabled', 'true') ;
    }

});

});



//match
var matchD=false;
function handleMessageMatch(e)
{
  // console.log(e);
  if (e.source === document.getElementById('match-iframe').contentWindow) {
    if (e.data !== 'Lose') {
      // console.log('puzzle prize');
      if(!matchD)
      {points+=parseInt(e.data);
      matchD=true;
      }
      pointB.forEach(element => {
        element.textContent=points;
    }); 
      //puzzlePoint();
    }
  }
  //GetScratchPoint
}

 window.addEventListener('message', handleMessageMatch);

let vid =$('iframe video');
// 2. This code loads the IFrame Player API code asynchronously.
var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  var player;
  var desiredTime = videoDelay; 

  function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
      videoId: videoid,
      events: {
        'onReady': onPlayerReady,
        'onStateChange': onPlayerStateChange
      }
    });
  }

  
  function onPlayerReady(event) {
    //event.target.playVideo();
   
  }
let timer =null;
let timeuser =0;
let checkinterval = null;
  function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING) {
    checkinterval = setInterval(checkElapsedTime, 1000);
       timer =  setInterval(() => {
        timeuser+=1;    
        }, 1000);
    }
    // else{
    //     let timerN =  setInterval(() => {
    //         timeuser-=1;    
    //         }, 1000);
    // }
  }

  function checkElapsedTime() {
    var currentTime = player.getCurrentTime();
    if (currentTime >= desiredTime) {
        if (timeuser >= desiredTime) {
      $('#verification-button').show();
      clearInterval(timer);
      clearInterval(checkinterval);
    } 
}
  }

  $('#verification-button').on('click', function() {
   points+=video;
   $(this).prop('disabled',true);
    pointB.forEach(element => {
        element.textContent=points;
    }); 
     $(this).hide();

  });

//html video
$diviVideo = $(".html-video video");
$diviVideo.on("play", function () {
$diviVideo.on("timeupdate", function (e) {
  if (e.target.currentTime >= videoDelay) {
    $('#verification-button').show();
  }
});
});

  //checkbox point

    $('.myCheckbox').on('change', function() {
        var isChecked = $(this).is(':checked');
        var isAnyOtherChecked = $('.myCheckbox:checked').not(this).length > 0;
      
        if (isChecked && !isAnyOtherChecked) {
          points += survey; // Incrémenter les points si la case est cochée et aucune autre case n'est cochée
        } else if (!isChecked && !isAnyOtherChecked) {
          points -= survey; // Décrémenter les points si la case est décochée et aucune autre case n'est cochée
        }
      
        pointB.forEach(function(element) {
          element.textContent = points;
        });
      
        // console.log('Points:', points);
      });

      // share popup 

      var popupCheck, popuptimer;


      let linkpoint = document.getElementsByClassName('linkpoint');
      let linkpA= Array.from(linkpoint);
      linkpA.forEach(element => {
        element.addEventListener('click', function (e) {
         e.preventDefault();
        })
      });

letshareorfollow = null;
      function popup(id,type,t=false) {
        let link =document.getElementById(id);
        let url = link.href;
        // console.log(url);
       link.setAttribute('href', '#done');
          var w = 1024;
          var h = 768;
          var title = 'Share/follow link ';
          var left = (screen.width / 2) - (w / 2);
          var top = (screen.height / 2) - (h / 2);
          var win = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
  letshareorfollow = type;
          popuptimer = 0;
          popupCheck = setInterval(function() {
            popuptimer++;
            
            if(t){
 setTimeout(() => {
              Swal.fire({
                title: alerttitle,
                text: alerttext,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes I shared!',
                cancelButtonText:'No I did not'
                }).then((result) => {
                if (result.isConfirmed) {
                  shared();
                  let a= document.getElementById(id);
                  a.setAttribute('href', '#done');
                   a.setAttribute('onclick', '');
                   
                  Swal.fire(
                  'Congrat',
                  'Point added!',
                  'success'
                  )
                }
                else{
                  let a= document.getElementById(id);
                  a.setAttribute('href', url);
                }
                }); 
              }, delay2*1000);

                clearInterval(popupCheck)
            }else{ if (win.closed) {
                  checkCheat(url,id);
              }}
             
          }, 1000);
  
  
          return false
      }
  
      function checkCheat(url,id) {
          clearInterval(popupCheck);
          popupCheck = '';
          if (popuptimer < delay) {
            let text = "";
            if(letshareorfollow === 's'){text='Share not detected! Please share to earn points. Thanks.';}else{text ='Follow not detected! Please follow to earn points. Thanks.';}
              console.log('Error');
              Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: text,
              });

              let a= document.getElementById(id);
              a.setAttribute('href', url);
          }
          if (popuptimer >= delay) {
  
              shared();

            let a= document.getElementById(id);
            a.setAttribute('href', '#done');
             a.setAttribute('onclick', '');
  
          }
      }


      function shared()
      {

        points+=share;
         pointB.forEach(function(element) {
          element.textContent = points;
        });
 
        //alert('10')
      }




var vpopupCheck, vpopuptimer;
var visited =false;
      function visit(url)
{
var w = 1024;
var h = 768;
var title = 'Social Ad';
var left = (screen.width / 2) - (w / 2);
var top = (screen.height / 2) - (h / 2);
windo = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

vpopuptimer = 0;
         vpopupCheck = setInterval(function() {
           vpopuptimer++;
           if (windo.closed) {
                 checkvCheat();
             }
            
         }, 1000);
return false
     }

     function checkvCheat() {
      clearInterval(vpopupCheck);
      vpopupCheck = '';
      if (vpopuptimer < visitDelay) {
        let text = "";
       text ='Visit not detected!';
          console.log('Error');
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: text,
          });

      }
      if (vpopuptimer >= visitDelay) {


        Swal.fire({
          icon: 'success',
          title: 'Congratulation',
          text: 'Visit points added',
      });
        if(!visited){setTimeout(() => {
          points+=visitpoint;
        pointB.forEach(function(element) {
          element.textContent = points;
          visited=true;
        });
        }, 1000);}
      }
  }

  let aftervisit = null;

aftervisit =  setInterval(()=>{

	if(visited)
	{
		$('.visited').show()
		clearInterval(aftervisit);
	}
	else{
	$('.visited').hide()
}
},1000)

      

let reachCent = false; 
      let checkpoints = null;
      function checkpointIntervall() {
     
      checkpoints = setInterval(() => {

        if(points >= 100)
     {
      reachCent =true
      clearInterval(checkpoints);
     }
      // console.log(reachCent,points);
      }, 1000);
    }

//badges
      let checkbadges = null;
      let badge1check =false;
      let badge2check =false;
      let badge3check =false;
      let badge4check =false;
           
      function startInterval() { 
      checkbadges = setInterval(() => {

        //badge1;
        if(points >= badge1)
     {          
        const element1 = document.getElementById('badge1');
        if (element1) {
          element1.style.opacity = '1';
    if(!badge1check)        
     {
      var elementbadge='';
        elementbadge+='  <div class="'+element1.getAttribute('class')+'" > ';
        elementbadge+=element1.innerHTML;
        elementbadge+='</div>';

      var title = 'Great!\n\r';
      title +='You earned a badge';
      Swal.fire({
          html: elementbadge,
          title: title,
          // text: 
      });
      badge1check = true;
    }
        }
      
     }  else{
      const element1 = document.getElementById('badge1');

      element1.style.opacity ='0.2';
    }

//badge 2

         if(points >= badge2)
     {
            
        var element = document.getElementById('badge2');

        if (element) {
          element.style.opacity = '1';
    if(!badge2check)        
    { 
      var elementbadge='';
        elementbadge+='  <div class="'+element.getAttribute('class')+'" > ';
        elementbadge+=element.innerHTML;
        elementbadge+='</div>';
      
      Swal.fire({
          html: elementbadge,
          title: 'Good job!\n\rYou earned a badge',
      });
      badge2check = true;
    }
        }

     } else{
      const element = document.getElementById('badge2');

      element.style.opacity ='0.2';
    }
    
    //badge3
     if(points >= badge3)
     {
            
        const element = document.getElementById('badge3');

        // 
        if (element) {
          element.style.opacity = '1';
    if(!badge3check)       
     { 
      var elementbadge='';
        elementbadge+='  <div class="'+element.getAttribute('class')+'" > ';
        elementbadge+=element.innerHTML;
        elementbadge+='</div>';
      
      Swal.fire({
          html: elementbadge,
          title: 'Fantastic!\n\rYou earned a badge',
      });
      badge3check = true;
    }
        }

     }
     else{
      const element = document.getElementById('badge3');

      element.style.opacity ='0.2';
    }
     
    //badge4
     if(points >= badge4)
     {
              
        const element = document.getElementById('badge4');

        // 
        if (element) {
          element.style.opacity = '1';
      if(!badge4check) {   

      var elementbadge='';
        elementbadge+='  <div class="'+element.getAttribute('class')+'" > ';
        elementbadge+=element.innerHTML;
        elementbadge+='</div>';
      
      Swal.fire({
          html: elementbadge,
            title: 'Congrats!\n\rYou earned a badge',
        });
        badge4check = true;
      }
        }
       
     }
     else{
      const element = document.getElementById('badge4');

      element.style.opacity ='0.2';
    }
      }, 2000);
    }

    function stopInterval() {
      clearInterval(checkbadges);
      clearInterval(checkpoints);
    }
    
    // Démarrer l'intervalle lorsque la page a le focus
    window.addEventListener('focus', ()=>{
      startInterval();
      checkpointIntervall();
    });
    
    // Arrêter l'intervalle lorsque la page perd le focus
    window.addEventListener('blur', stopInterval);

