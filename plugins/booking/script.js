
var booking = null;
var activeServiceinfo = null;
var service = null;
var hour = null;
var AlreadyBookedDate = [];
// var container=null;



$('.member').on('click', function (e) {
  const url = "../../db/bookings.json?timestamp=" + new Date().getTime();
  fetch(url)
      .then((response) => {
        if (!response.ok) {
          throw new Error("File detection was not ok or connecting issue");
        }
        return response.json();
      })
      .then((data) => {
        data = data.filter(item => item.status !== "Rejected");
        var count = 0;
        data.forEach((dataDate) => {
          //console.log("JSON:", dataDate.dateofbooking);
          AlreadyBookedDate[count] = dataDate.dateofbooking;
          count++;
        });
        //console.log("Gababa:", AlreadyBookedDate);
      })
      .catch((error) => {
        console.error("Error:", error);
      });

  if (!$(this).hasClass('selected')) {
    $(this).addClass('selected');
    $('.wrap').addClass('member-selected');
    var value = $(this).attr('value');
    service = $('.selected .service').text();
    //console.log(service);
    booking = bookingdata[0];
    activeServiceinfo= booking.services[value];
    // console.log(activeServiceinfo);
    if(booking.type=='booking'){
    addCalendar($(this).find('.calendar'));
    
  }
 
  else{
    var container = $(this).find('.calendar');
    var eventdate=activeServiceinfo.dateevent.split('-');
    let date = new Date(eventdate[2], eventdate[1]-1, eventdate[0]);
    var dateofbookinandtime = '';
      var dt = '<table><tbody><tr><td class=" disabled deselected"></td></tr></tbody></table>';
    //Display output
    const options = {
      weekday: 'short',
      day: 'numeric',   
      month: 'short',    
      year: 'numeric',
    };
    
    // Utilisez Intl.DateTimeFormat pour formater la date
    const dateFormatter = new Intl.DateTimeFormat('en-US', options);
    
    // Obtenez la date formatée
    const formattedDate = dateFormatter.format(date);

      dateofbookinandtime = activeServiceinfo.dateevent+'/'+activeServiceinfo.timeevent ;
      var bookingCount = 0;
      setTimeout(function (){
        //console.log("Gababa: "+AlreadyBookedDate);
        for (var j = 0; j < AlreadyBookedDate.length; j++){
          //console.log(dateofbookinandtime+' - '+AlreadyBookedDate[j]);
          if(dateofbookinandtime===AlreadyBookedDate[j]){
            bookingCount++;
          }
        }
          //console.log(dateofbookinandtime+' Gababa '+activeServiceinfo.ticketsevent);
        if (bookingCount>=activeServiceinfo.ticketsevent){
          $('.submit').val('SOLD OUT!');
          $('.submit').prop('disabled', true);
          $('.submit').css('background-color', '#dc3545');
		  $('.submit').css('font-weight', '700');
        }
      },100)

      dt+= '<label class="date eventdate" value="'+activeServiceinfo.dateevent+'">'+formattedDate+'</label></div>';
    container.html(dt);
    setTimeout(function () {
      $('.wrap').addClass('date-selected date');
    }, 10);
    var slot = $('.slots');
    service = $('.selected .service').text();
    hour=activeServiceinfo.timeevent;
    var time ='<div class="col-md-3 hours col-4 selected eventtime" value="'+activeServiceinfo.timeevent+'" style="">'+activeServiceinfo.timeevent+'</div>';
    slot.html(time);
    $('.wrap').addClass('slot-selected');      
  
  }
  }

  e.preventDefault();
  e.stopPropagation();

});

$('.deselect-member, .restart').on('click', function (e) {
  $('.member').removeClass('selected');
  $('.wrap').removeClass('member-selected date-selected slot-selected booking-complete');
  e.preventDefault();
  e.stopPropagation();
});

$('.deselect-date').on('click', function (e) {
  $('.wrap').removeClass('date-selected slot-selected');
  $('.calendar *').removeClass('selected');
  e.preventDefault();
  e.stopPropagation();
});

$('.deselect-slot').on('click', function (e) {
  $('.submit').val('Confirm Booking');
  $('.submit').prop('disabled', false);
  $('.submit').css('background-color', '#0069d9');
  $('.submit').css('font-weight', '700');
  $('.wrap').removeClass('slot-selected');
  $('.slots *').removeClass('selected');
  $('.hours').show();
  e.preventDefault();
  e.stopPropagation();
});

var monthsName = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
$('.form').on('submit', function (e) {
  $('.wrap').toggleClass('booking-complete');
  e.preventDefault();
  e.stopPropagation();

})
var month = '';
var slotIndex = null;

// var locationUser = '';
// var api_location = '8705b56ff5920952268a8d4ed5ec8883ae91d185c46e685ac17e74bc';
// $.ajax({
//   type: 'GET',
//   url: 'https://api.ipdata.co/?api-key='+api_location,
//  // data: { jsonData: JSON.stringify(formData) },
//   success: function (response) {
//      //
//       if (response.ip) {
//           // console.log(response);
//           locationUser = response.city+'/'+response.country_name;
//           // console.log(locationUser);
//       }
//   },
//   error: function () {
//       // ajax error
//       console.log('An error is occured during email sending.');
//   }
// });
$('.submit').on('click', function (e) {
  //$('.wrap').toggleClass('booking-complete');
  e.preventDefault();
  var datibook = '';
  var day = $('.date').text();
  day = day.split(',')[1];
  month = $('.month').text();
  // console.log(month);
  // console.log(day);
  month = monthsName.indexOf(month) + 1;
  year = $('.year').text();
  datibook = day + '-' + month + '-' + year+'/'+hour ;
  if(booking.type=='event'){
    day = $('.eventdate').attr('value');
    datibook = day +'/'+hour ;
  }

//Checking for already taken slot
  // if(booking.type!='event') {
    const url = "../../db/bookings.json?timestamp=" + new Date().getTime();
    fetch(url)
        .then((response) => {
          if (!response.ok) {
            throw new Error("File detection was not ok or connecting issue");
          }
          return response.json();
        })
        .then((data) => {
          data = data.filter(item => item.status !== "Rejected");
          var count = 0;
          data.forEach((dataDate) => {
            //console.log("JSON:", dataDate.dateofbooking);
            AlreadyBookedDate[count] = dataDate.dateofbooking;
            count++;
          });
          var dateofbookinandtime = '';
          dateofbookinandtime = datibook;
          var bookingCount = 0;
          setTimeout(function () {
            console.log("Gababa: "+dateofbookinandtime);
            for (var j = 0; j < AlreadyBookedDate.length; j++) {
              //console.log(dateofbookinandtime+' - '+AlreadyBookedDate[j]);
              if (dateofbookinandtime === AlreadyBookedDate[j]) {
                bookingCount++;
              }
            }
            //console.log(dateofbookinandtime+' Gababa '+activeServiceinfo.ticketsevent);
            if (bookingCount >= activeServiceinfo.ticketsevent) {
              $('.submit').val('SOLD OUT!');
              $('.submit').prop('disabled', true);
              $('.submit').css('background-color', '#dc3545');
              $('.submit').css('font-weight', '700');
              $(".slots .hours").eq(slotIndex).remove();
              return;
            }else {
              const generateID = () => {
                const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                let id = "";
                for (let i = 0; i < 7; i++) {
                  id += alphabet.charAt(Math.floor(Math.random() * alphabet.length));
                }
                return id;


              };


              // var name = document.getElementById("name").value;
              // var email = document.getElementById("email").value;
              // var phone = document.getElementById("phone").value;
              var coupon = '';

              uniqueID = generateID();


              formData = {
                id: uniqueID,
                fullName: '',
                website: '',
                number: '',
                email: '',
                verified: "",
                dateofbooking: datibook,
                status: 'Pending',
                birthday: "",
                location: "",
                booking: service,
                device: "",
                groups:[service],
                // device: userToken,
                // question1Comment: question1Comment,
                // question2: question2,
                // question2Comment: question2Comment,
                // question3: question3,
                // question3Comment: question3Comment,
                // trustpilotToolsComment: trustpilotToolsComment,
                notes: coupon
              };
              console.log('Booking saved');
              window.parent.postMessage(JSON.stringify(formData), '*');
            }
          }, 100)
          //console.log("Gababa:", AlreadyBookedDate);
        })
        .catch((error) => {
          console.error("Error:", error);
        });
  // }

})

function invokeCalendarListener() {
  $('.calendar td:not(.disabled)').on('click', function (e) {
    var value = $(this).attr('value');
    day = booking.days[value];
    //console.log(day);
    var days = $(this).html();
    month = $('.member.selected .month').text();
    month = monthsName.indexOf(month) + 1;
    year = $('.member.selected .year').text();
    var dateofbooking = '';
    dateofbooking = days + '-' + month + '-' + year;
    console.log("Gababa: "+dateofbooking);
    addSlots(dateofbooking,day.times, booking.slot);
    var date = $(this).html();
    var day = $(this).data('day');
    $('.date').html(day + ',' + date);
    $(this).addClass('selected');
    setTimeout(function () {
      $('.wrap').addClass('date-selected');
    }, 10);
    e.preventDefault();
    e.stopPropagation();
  });
}


function invokeSlotsListener() {
  $('.slots .hours').on('click', function (e) {
    slotIndex = $(this).index();
    $(this).addClass('selected');
    $('.wrap').addClass('slot-selected');
    hour =  $(this).text();
    setTimeout(function () {
      $('.selected.member input[name="name"]').focus();
    }, 700);
    $('.hours').hide();
     $('.selected').show();
    e.preventDefault();
    e.stopPropagation();
  });
}



// function addSlots(container){

//   var number = Math.ceil(Math.random()*5 + 1);
//   var time = 7;
//   var endings = [':00', ':15', ':30', ':45'];
//   var timeDisplay = '';
//   var slots = ''
//   for(var i = 0; i < number; i++){
//     time += Math.ceil(Math.random()*3);
//     timeDisplay = time + endings[Math.floor(Math.random()*4)];
//     slots += '<li>'+timeDisplay+'</li>';
//   }

//   $('.selected .slots').html(slots);

//   invokeSlotsListener();

// }
// function addSlots(timeData, slot) {
//   console.log(timeData);
//   var timeDisplay = '';
//   var slots = '';

//   var startTime = parseInt(timeData.times[0]) * 60;
//   var endTime = (parseInt(timeData.times[1])) * 60;
//   console.log(startTime, endTime);

//   // Convertissez l'heure du créneau en minutes.
//   var slotTime = parseInt(slot.split(':')[0]) * 60 + parseInt(slot.split(':')[1]);
//   console.log(slotTime);
//   // Générez les créneaux horaires en fonction des intervalles.
//   for (var time = startTime; time < endTime; time += slotTime) {
//     var hours = Math.floor(time / 60);
//     var minutes = time % 60;
//     timeDisplay = (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;
//     console.log(time, endTime); if (time > endTime) {
//       break;
//     }

//     slots += '<li value="' + timeDisplay + '">' + timeDisplay + '</li>';

//   }
//   $('.selected .slots .slots-container').html(slots);
//   invokeSlotsListener();

// }

function addSlots(dateofbooking,timeData, slot) {
  //console.log(dateofbooking);
  var dateofbookinandtime = '';
  var timeDisplay = '';
  var slots = '';

  var availableTimes = [];
  for (var i = 0; i < timeData.length; i++) {
    var parts = timeData[i].split('-');
    if (parts.length == 1) {
      var startTime = parseInt(parts[0]) * 60;
     var endTime = (parseInt(parts[0])+1) * 60;

      availableTimes.push([startTime,endTime]);
      
    } else if (parts.length == 2) {
      var startTime = parseInt(parts[0]) * 60;
     var endTime = (parseInt(parts[1])+1) * 60;
      availableTimes.push([startTime,endTime]);
    }
  }
  // console.log(availableTimes);

  var slotTime = parseInt(slot.split(':')[0]) * 60 + parseInt(slot.split(':')[1]);

  // console.log(slotTime);
  for (var i = 0; i < availableTimes.length; i++) {
    startTime = availableTimes[i][0];
    endTime = availableTimes[i][1];
    
  for (var time = startTime; time <= endTime; time += slotTime) {
    var hours = Math.floor(time / 60);
    var minutes = time % 60;
    timeDisplay = (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;
    //console.log(time, endTime);
     if (time >= endTime) {
      break;
    }
    dateofbookinandtime = dateofbooking+'/'+timeDisplay ;
    var bookingCount = 0;
    for (var j = 0; j < AlreadyBookedDate.length; j++){
      if(dateofbookinandtime===AlreadyBookedDate[j]){
        bookingCount++;
      }
    }
    if (bookingCount>=booking.users){
      //console.log(dateofbookinandtime+'Gababa'+booking.users);
      continue;
    }
    slots += '<div class="col-md-3 hours col-4" value="' + timeDisplay + '">' + timeDisplay + '</div>';
  }
  }
  // $('.selected .slots .slots-container').html(slots);
 $('.selected .slots').html(slots);
// console.log(slots);
  invokeSlotsListener();
}

function addCalendar(container) {
  //get dates
  var today = new Date();
  var day = today.getDay()
  var date = today.getDate();
  var month = today.getMonth();
  var year = today.getFullYear();
  var first = new Date();
  first.setDate(1);
  var startDay = first.getDay();
  var dayLabels = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
  var monthLengths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
  var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  var dayNames =['SAT', 'SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI'];


  var current = 1 - startDay;

  var today = new Date();
  var currentDay = today.getDate();
  var currentMonth = today.getMonth();

  var specifiedDays = [];
  if (booking.days) {
    booking.days.forEach(function (day) {
      if (day.day) {
        specifiedDays.push(day.day[0] + day.day[1] + day.day[2]);
       
      }
    });
  }
  //assemble calendar
  var calendar = '<label class="date"></label><label class="month">' + monthNames[month] + '</label> <label class="year">' + year + '</label>';

  calendar += '<table><tr>';
  dayLabels.forEach(function (label) {
    calendar += '<th>' + label + '</th>';
  });
  calendar += '</tr><tr>';
  var dayClasses = '';
  while (current <= 31) {
    if (current > 0) {
      dayClasses = '';
      today.setDate(current);
      var dayName = dayNames[(current + startDay) % 7];
      // console.log(specifiedDays);
      // alert(dayName);
      if (specifiedDays.indexOf(dayName) === -1) {
        dayClasses += ' disabled deselected';
      } else {
        // if (today.getDay() == 0 || today.getDay() == 6) {
        //   dayClasses += ' disabled';
        // }
        if (current < date) {
          dayClasses += ' disabled';
        }
        if (current == date) {
          dayClasses += ' today';
        }
      }

      if (currentMonth === month && currentDay === current) {
        dayClasses += ' today';
      }

      if (specifiedDays.indexOf(dayName) !== -1) {
        dayClasses += ' active';
        var dayIndex = specifiedDays.indexOf(dayName);
        calendar += '<td class="' + dayClasses + '" data-day="' + dayName + '" value="' + dayIndex + '">' + current + '</td>';
      } else {
        calendar += '<td class="' + dayClasses + '" data-day="' + dayName + '">' + current + '</td>';
      }
    } else {
      calendar += '<td></td>';
    }

    if ((current + startDay) % 7 == 0) {
      calendar += '</tr><tr>';
    }

    current++;
  }

  calendar += '</tr></table>';
  container.html(calendar);

  invokeCalendarListener();
}