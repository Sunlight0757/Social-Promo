/////////// --------------------- LEADS -------------------- ///////////


var json = '';
var questions='';
var searched =false;

var seachdtbgroup = false;

$(document).ready(function() {

$.ajax({
url: domain+"getdata.php",
dataType: "json",
success: function(data) {
  json = data;
// console.log(json);
  setTimeout(function() {
  displayelemnt(json);
  }, 1000);
 
  setTimeout(function() {
    leads_stat(json);
  }, 1000);
}
});

$.ajax({
url: domain+"getquestion.php",
dataType: "json",
success: function(data) {
  questions = data;
  // console.log(data);
  setTimeout(function() {
  displayelemnt(json);
  }, 1000);

  setTimeout(function() {
    leads_stat(json);
  }, 1000);
}
});
});


function calculateAge(dateOfBirth) {
  let dateFormat = '';
  if (dateOfBirth.includes('/')) {
    dateFormat = 'mm/dd/yyyy';
  } else if (dateOfBirth.includes('-')) {
    dateFormat = 'DD-MM-YYYY';
  } else {
    // console.error('Date undefined');
    return 'null';
  }

  const today = new Date();
  const parts = dateOfBirth.split(dateFormat === 'mm/dd/yyyy' ? '/' : '-');
  const birthDate = new Date(parts[2], parts[1] - 1, parts[0]);
  
  let ageO = today.getFullYear() - birthDate.getFullYear();
  const monthDifference = today.getMonth() - birthDate.getMonth();

  if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
    ageO--;
  }

  return ageO;
}

const dateOfBirth = '15-08-2002'; 
const agetest = calculateAge(dateOfBirth);
let intervall =null;

function datajson() {
$.ajax({
url: domain+"getdata.php",
dataType: "json",
success: function(data) {
  json = data;
// console.log(json);
  setTimeout(function() {
  displayelemnt(json);
  }, 1000);

  setTimeout(function() {
    leads_stat(json);
  }, 1000);
}
});

$.ajax({
url: domain+"getquestion.php",
dataType: "json",
success: function(data) {
  questions = data;
  // console.log(data);
  setTimeout(function() {
  displayelemntb(json);
  }, 1000);

  setTimeout(function() {
    leads_stat(json);
  }, 1000);
}
});  
}

function displayelemntb(json) {

//var data = JSON.parse(json);
var tbody = document.querySelector('tbody');
var tr = '';
json.forEach((Element, index) => {
const age = calculateAge(Element.birthday);
  let existe= 0;
if (index == 0) {
  tr += '<tr data-widget="expandable-table" class="'+(index + 1)+'" aria-expanded="true">';
} else {
  tr += ' <tr data-widget="expandable-table" class="'+(index + 1)+'" aria-expanded="false">';
}
tr += '<td><input type="checkbox" name="delete-lead" id="" value="' + index +' " class="delete-lead" /></td><td>' + (index + 1) + '</td> <td><p style="width:90px;">' + Element.fullName + '</p></td>';
tr += '<td><p style="width:30px;">' + age + '</p></td>';
tr += '<td><p style="width:90px;"><a href="' + Element.website + '" target="_blank"onclick="openWebsitePopup(event)">' + Element.website + ' </a></p></td><td><p style="width:110px;">' + Element.number + '<br>';
var cleanNumber = Element.number.replace("+", "");
 // change number beginning from 07 to 447
var qrNumber = cleanNumber.replace(/^447/, '07');
tr += '<p><img src="https://chart.googleapis.com/chart?cht=qr&chs=100x100&chl=tel:+'+qrNumber+'"></p><p><a aria-label="Chat on WhatsApp" class="btn btn-sm btn-success" href="https://wa.me/'+cleanNumber+'"onclick="openWhatsAppPopup(event)" ><i class="fa-brands fa-whatsapp"></i></i> WhatsApp<a/></p></td><td><p style="width:90px;">'+ Element.email + '</p></td>';
tr += '<td><p style="width:90px;">'+ Element.location + '</p></td><td><p style="width:75px;">' + Element.date + '</p></td>'; 
if (Element.verified == 'true') {tr += '<td><span style="cursor:pointer;" class="badge bg-secondary ">Confirmed</span></td>';
} else { tr += '<td><b>Pending</b></td>';}

if(Element.unsubscribed == 'true' )
{
  tr += '<td><span style="cursor:pointer;"  st' + (index + 1)+ '" class="badge bg-info">Unsubscribed</span></td>';
  existe++;
}
else
{
  for (let i = 0; i < sts.length; i++) {
    const statusObj = sts[i];
    const statusKey = Object.keys(statusObj)[0];
    const statusValue = statusObj[statusKey];

    if (Element.status === statusKey) {
        tr += '<td><span style="cursor:pointer;" onclick="togglestatut(' + index + ')" class="badge bg-' + statusValue + ' st' + (index + 1)+ '">' + Element.status + '</span></td>';
        existe++;
        break;
    }
}

}
if (existe == 0) {
  const firstStatus = sts[0];
  const firstStatusKey = Object.keys(firstStatus)[0]; 
  const firstStatusValue = firstStatus[firstStatusKey]; 

  tr += '<td><span style="cursor:pointer;" onclick="togglestatut(' + index + ')" class="badge bg-' + firstStatusValue + ' st' + (index + 1)+ '">' + firstStatusKey + '</span></td>';
}

tr += '<td> <button class="m-1 btn btn btn-info btn-sm" onclick="edit(' + index + ')" data-toggle="modal" data-target="#edit"><i class="fas fa-pencil-alt"></i> Edit</button><button onclick="deleteit(' + index + ')" class="m-1 btn btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button></td>';
tr += '</tr>';
tr += '<tr class="expandable-body '+(index + 1)+'"><td style = "padding:12px !important" colspan = "12"> ';
tr += '<span>';

Element.question.forEach((quest, position) => {
  tr += ' <h5>'+quest.question+'</h5><p class="text-muted">';

 quest.answers.forEach((answer)=>{
   tr += answer + '<br>';
 });
  tr += quest.comment;    tr += '</p>';
});
tr += '<h5>Notes:</h5><p class="text-muted">' + Element.notes + '</p> ';
tr += '<h5>Groups:</h5><p class="text-muted">';
Element.groups.forEach((group)=>{
  tr += '<small class="badge badge-primary"> '+group+'  </small>  ';
});
tr+= '</p> ';
tr += ' </span>';
tr += '</td></tr> ';

});
tbody.innerHTML = tr;

}



function downloadCSV(data) {

const csv = Papa.unparse(data);


const blob = new Blob([csv], {
type: 'text/csv'
});
const url = ('csv-down.php');
const link = document.createElement('a');
link.href = url;


document.body.appendChild(link);
link.click();


URL.revokeObjectURL(url);
document.body.removeChild(link);
}

const downloadBtn = document.getElementById('csv');
downloadBtn.addEventListener('click', () => {
downloadCSV(json);
});


function deleteit(id) {
json.splice(id, 1);
deleted=json;

Swal.fire({
title: 'Are you sure?',
text: "You won't be able to revert this!",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes, delete it!'
}).then((result) => {
if (result.isConfirmed) {

  const delay = 3;
  setTimeout(function() {
  Swal.close();
  }, 3 * 1000);
 
  //json = data;
  data = deleted;
  $.ajax({
    type: 'POST',
    url: 'save.php',
    data: {
    jsonDatAdmin: JSON.stringify(data)
    },
    success: function() {
    // console.log('Data saved');
    setTimeout(displayelemnt(json), 1000);
    if(searched == true){
      // console.log(searched);
      var keyword = document.getElementById('keyword').value;
      // intervall = setInterval(datajson, 30000);
        search(keyword);
        if(seachdtbgroup == true){
          var filterselect = document.getElementById('filtergroup');
          searchDtByGroup(filterselect.value);
      }}

    setTimeout(function() {
      leads_stat(json);
    }, 1000);

    },
    error: function() {
    console.error('Error issue');
    }
  });

  Swal.fire(
  'Deleted!',
  'Your survey has been deleted.',
  'success'
  )
}
})

}

var surveyedit = null;
var editid = '';

function editbooking(id) {
editid = id;
surveyedit = json[id];
// var InputTitle = document.getElementById('InputName');
var InputWebsite = document.getElementById('InputWebsite');
var InputEmail = document.getElementById('InputEmail');
var InputPhone = document.getElementById('InputPhone');
var InputBirthday = document.getElementById('InputBirthday'); 
var InputLocation = document.getElementById('InputLocation');
var InputNote = document.getElementById('InputNote');
var InputName = document.getElementById('InputName_fck');

const selectElement = document.getElementById('editgroup');
// options selected
for (var i = 0; i < selectElement.options.length; i++) {
  var option = selectElement.options[i];
  option.selected = false; 
}

$(selectElement).trigger('change');

for (var i = 0; i < selectElement.options.length; i++) {
  var option = selectElement.options[i];
  
  
  if (surveyedit.groups.includes(option.value)) {
    option.selected = true; // Sélectionner l'option
  }
}
$(selectElement).trigger('change');
var question_input=document.getElementById('question');
var line='';
line+='<h2>Questions</h2>';

surveyedit.question.forEach((element,id) => {
//question
line+='<label for="InputQuestions'+(id+1)+'">'+element.question+'</label>';

// console.log(typeof(element),element);
line+='<textarea id="InputQuestions'+(id+1)+'" name="question'+(id+1)+'" class="form-control form-control-lg form-control-border" rows="4" placeholder="Enter questions">';
element.answers.forEach((answer,key) => {
 line+=answer;
 if((element.answers.length > (key +1)) )
 {
  line+="\n"
 }else if((element.answers.length == (key +1))&&element.comment )
 {
   line+="\n"
 }

 
})
if(element.comment){
line+=element.comment;
}
line+='</textarea>';


});

question_input.innerHTML=line;

// InputTitle.value = surveyedit.fullName;
InputWebsite.value = surveyedit.website;
InputEmail.value = surveyedit.email;
InputPhone.value = surveyedit.number;
InputBirthday.value = surveyedit.birthday;
InputLocation.value = surveyedit.location;
var noteEdit = document.querySelector('.note-group .note-editable');
noteEdit.innerHTML = surveyedit.notes;
InputName.value = surveyedit.fullName;

}

// console.log(statut);
function togglestatut2(id) {
let st= '';
var surveyt = json[id];
let lastst =surveyt.status;

var btnstatu = document.querySelector('.st'+(id + 1));
const secondStatus = sts[1];
const secondStatusKey = Object.keys(secondStatus)[0]; 
let existt=0;
for (let index = 0; index < sts.length; index++) {
  const statusKey = Object.keys(sts[index])[0]; 

  if (surveyt.status === statusKey) {
    const nextIndex = (index + 1) % sts.length;
    st = Object.keys(sts[nextIndex])[0];     
    existt++
    break;
  }
}
if (existt==0) {
  st = secondStatusKey;
  }

  for (let i = 0; i < sts.length; i++) {
    const statusObj = sts[i];
    const statusKey = Object.keys(statusObj)[0];
    const statusValue = statusObj[statusKey];

if(lastst === statusKey)    {
  btnstatu.classList.remove("bg-"+statusValue);
  btnstatu.innerText = statusKey;
  break
}

}
for (let i = 0; i < sts.length; i++) {
    const statusObj = sts[i];
    const statusKey = Object.keys(statusObj)[0];
    const statusValue = statusObj[statusKey];

if(st === statusKey)    {
    btnstatu.classList.add("bg-"+statusValue);
    btnstatu.innerText = statusKey;
  break
}

}

surveyt.status = st;
json[id] = surveyt;
$.getJSON(datafile, function(data) {
data = json;
$.ajax({
  type: 'POST',
  url: 'save.php',
  data: {
  jsonDatAdmin: JSON.stringify(data)
  },
  success: function() {

  if(searched == false){
    // console.log(searched);
    // intervall = setInterval(datajson, 30000);
    setTimeout(displayelemnt(json), 1000);
    }
  setTimeout(function() {
    leads_stat(json);
  }, 1000);

  },
  error: function() {
  console.error('Error issue');
  }
});
});

}

//search

// var searchBtn = document.getElementById('search');
// var input = document.getElementById('keyword');
// // console.log(searchBtn);

// input.addEventListener('input', function (e) {

// e.preventDefault();
// // alert('done');
// var keyword = document.getElementById('keyword').value;
// search(keyword);

// });

// function search(keyword)
// {

// //get element searched

// var jsons =  filterData(keyword, json);

// json.forEach((element,index) => {

// let exist = 0;
// for (let i = 0; i < jsons.length; i++) {
//   if(jsons[i].id == element.id )
//   {
//     // console.log(index);
//     // console.log(element.id,jsons[i].id);
//     exist += 1;
//     break;
//   }
// }

// //console.log(exist);

// if(exist==0)
//  {
//    $('.'+(index+1)).hide();

//   // console.log(index);
//  }
//  else
//  {
//    $('.'+(index+1)).show();

//   // console.log(index);
//  }

// });
// searched= true;
// clearInterval(intervall);
// intervall = null ;
// //after display none element  not considered


// }

// // Function to filter data by name and return a new JSON containing the results
// function filterData(query, data) {
// var filteredData = data.filter(function (entry) {
//   var fullNameMatch = entry.fullName.toLowerCase().includes(query.toLowerCase());
//   var websiteMatch = entry.website.toLowerCase().includes(query.toLowerCase());
//   var phoneMatch = entry.number.toLowerCase().includes(query.toLowerCase());
//   var groupMatch = entry.groups.includes(query);
//   return fullNameMatch || websiteMatch || phoneMatch || groupMatch;
// });

// return filteredData;

// }


// $(document).ready(function() {
//   $('#filtergroup').on("change", function(e) { 
//     // what you would like to happen
//     // var selectElement = document.getElementById("filtergroup");
// var filterselect = document.getElementById('filtergroup');
// if(filterselect.value != '')
// {
//   searched= true;
//   seachdtbgroup = true;
//  searchDtByGroup(filterselect.value);
  
//   clearInterval(intervall);
// }else
// {
//   searched= false;
//    seachdtbgroup = false;
//   setTimeout( datajson, 1000);
//   intervall = setInterval(datajson, 40000);
// }
   
//  });

// });

// ///filter by group
// var filterselect = document.getElementById('filtergroup');
// // console.log(filterselect);
// filterselect.addEventListener('change', ()=>
// {
//   if(filterselect.value != '')
//   {
//     searched= true;
//     seachdtbgroup = true;
//     alert(filterselect.value);
//    searchDtByGroup(filterselect.value);
    
//     clearInterval(intervall);
//   }else
//   {
//     searched= false;
//      seachdtbgroup = false;
//     setTimeout( datajson, 1000);
//     intervall = setInterval(datajson, 40000);
//   }
// })

// //function filter lead by group 

// function searchDtByGroup(groupname) {
//   for (let i = 0; i < json.length; i++) {

//   let exist = 0;
//   if(json[i].groups.includes(groupname))
//   {
//     $('.'+(i+1)).show();
//   }
//   else{
//     $('.'+(i+1)).hide();
//   }
  
// }}

//save booking

var submitbook = document.querySelector("#btnBooking")

// var templateEmail = document.getElementById('templateEmail');
var templateGroup = document.getElementById('templateGroup');
var templateImage = document.getElementById('templateImage');
var templateTitle = document.getElementById('templateTitle');
var summernote = document.getElementById('summernote');
var templateLink = document.getElementById('templateLink');
// console.log(templateLink);

submitTemp.addEventListener('click', function (e) {
  e.preventDefault();
  noteEditor = document.querySelector(".note-editor")

  if (templateGroup.value == '' || templateImage.value == '' || templateTitle.value == '' || summernote.value == '' || templateLink.value == '') {
    if (templateGroup.value == '') {
      templateGroup.style.borderColor = 'red'
    } else { templateGroup.style.borderColor = 'green' }
    if (templateImage.value == '') {
      templateImage.style.borderColor = 'red'
    } else { templateImage.style.borderColor = 'green' }
    if (templateTitle.value == '') {
      templateTitle.style.borderColor = 'red'
    } else { templateTitle.style.borderColor = 'green' }
    if (summernote.value == '') {
      noteEditor.style.borderColor = 'red'
    } else { noteEditor.style.borderColor = 'green' }
      if (templateLink.value == '') {
      templateLink.style.borderColor = 'red'
    } else { templateLink.style.borderColor = 'green' }
 }
  else {
    const date = new Date();
    const formattedDate = date.toLocaleDateString() + ' / ' + date.getHours() + ':' + date.getMinutes();
    const formData = {
      id: templates.length + 1,
      group: templateGroup.value,
      image: templateImage.value,
      title: templateTitle.value,
      content: summernote.value,
      //emailsignature: templateEmail.value,
      url:templateLink.value,
      sendemail:false,
      sendsms:false,
      sendpush:false,
      date: formattedDate
    };

    $.ajax({
      type: 'POST',
      url: 'save.php',
      data: { template: JSON.stringify(formData) },
      success: function (response) {
        // console.log(response);
        updateTempate();
        Swal.fire({
          icon: 'success',
          title: 'Congratulation',
          text: 'Template added',
        });

          // Call the function 
          updateSelectOptions();
          
      },
      error: function () {
        console.error('Error issue');
      }
    });


  }

});

//edit

var editsubmit = document.getElementById('editsubmit');
editsubmit.addEventListener('click', function(event) {

event.preventDefault();
var questions = [];
var name = document.getElementById('InputName_fck').value;
var website = document.getElementById('InputWebsite').value;
var email = document.getElementById('InputEmail').value;
 var phone = document.getElementById('InputPhone').value;
var birthday = document.getElementById('InputBirthday').value;
 var location = document.getElementById('InputLocation').value;
var note = document.getElementById('InputNote').value;

var selectedValues = $('#editgroup').val();

var groups=selectedValues;
for (let index = 0; index < surveyedit.question.length; index++) {
//question
var question = [];
const questionInput = document.getElementById('InputQuestions'+(index+1));
var forAttribute = 'InputQuestions'+(index+1);
const libelle =document.querySelector("label[for='" + forAttribute + "']").textContent;

question = questionInput.value.split('\n');


var questionData = {
    question : libelle,
    answers: question,
    comment: '',
};

questions.push(
    questionData
);
  
}
//save
if (surveyedit) {
surveyedit.fullName = name;
surveyedit.website = website;
surveyedit.number = phone;
surveyedit.email = email;
surveyedit.birthday = birthday;
surveyedit.location = location;
surveyedit.notes = note;
surveyedit.question = questions;
surveyedit.groups = groups;  
//surveyedit.date = 
json[editid] = surveyedit;
$.getJSON(datafile, function(data) {
  data = json;
  $.ajax({
  type: 'POST',
  url: 'save.php',
  data: {
    jsonDatAdmin: JSON.stringify(data)
  },
  success: function() {
    // console.log('Data saved');
    setTimeout(displayelemnt(json), 1000);

    if(searched == true){
      // console.log(searched);
      var keyword = document.getElementById('keyword').value;
      search(keyword);
      // intervall = setInterval(datajson, 30000);
        if(seachdtbgroup == true){
          var filterselect = document.getElementById('filtergroup');
          searchDtByGroup(filterselect.value);
      }}

    $('#spinner').hide()

    editsubmit.innerHTML = '<i class="fas fa-check"></i> Saved';
    editsubmit.classList.remove("btn-primary");
    editsubmit.classList.add("btn-success");

    setTimeout(function() {
      editsubmit.innerText = 'Save changes';
      editsubmit.classList.remove("btn-success");
      editsubmit.classList.add("btn-primary");
    }, 3000); 

    // setTimeout(function() {
    //   $('#closemodale1').click();
    // }, 3000); 


  },
  error: function() {
    console.error('Error issue');
  }
  });
});

}

});


    if(searched == false){
     console.log(searched);
    intervall = setInterval(datajson, 30000);
    }
    else{
     console.log(searched);
    clearInterval(intervall);
    } 
 

    setTimeout(() => {

$('.delete-lead').on('change', function() {
  var isChecked = $(this).is(':checked');
  var isAnyOtherChecked = $('.delete-lead:checked').not(this).length > 0;

  if (isChecked && !isAnyOtherChecked) {
    clearInterval(intervall);
  //  console.log('1');
  } else if (!isChecked && !isAnyOtherChecked) {
   searched = false;
   setTimeout( datajson, 1000);

  }

  // console.log('Points:', points);
});
    }, 4000);



//delete multiple leads

$('#allleads').on('click', function(e) {
  clearInterval(intervall);
	if($(this).is(':checked',true))  
	{
		$(".delete-lead").prop('checked', true);  
	}  
	else  
	{  
		$(".delete-lead").prop('checked',false);  
	}  
});


var deleted
var deleteLeadbtn = document.getElementById('deleteLead');

deleteLeadbtn.addEventListener('click',function (event) {

var leadChecked = document.querySelectorAll('input[name="delete-lead"]');
  event.preventDefault();

  var todelete = [];
  leadChecked = document.querySelectorAll('input[name="delete-lead"]');
  leadChecked.forEach(input => {
    // array.includes(item, fromIndex)
    if(input.checked){
     todelete.push(input.value);
      }
  
});
todelete.reverse();
  todelete.forEach(del => {
    // array.includes(item, fromIndex)
    deleted = json;
    deleted.splice(del,1);
});
Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
  if ( result.isConfirmed) {
  
    const delay = 3;
    setTimeout(function() {
    Swal.close();
    }, 3 * 1000);
   
    //json = data;
    data = deleted;
    $.ajax({
      type: 'POST',
      url: 'save.php',
      data: {
      jsonDatAdmin: JSON.stringify(data)
      },
      success: function() {
      //console.log('Data saved');
       json= deleted;
      setTimeout(displayelemnt(json), 1000);

      setTimeout(function() {
        leads_stat(json);
      }, 1000);

      if(searched == true){
        // console.log(searched);
        var keyword = document.getElementById('keyword').value;
        // intervall = setInterval(datajson, 30000);
          search(keyword);
          if(seachdtbgroup == true){
            var filterselect = document.getElementById('filtergroup');
            searchDtByGroup(filterselect.value);
        }}
  
      },
      error: function() {
      console.error('Error issue');
      }
    });
  
    Swal.fire(
    'Deleted!',
    'Your survey has been deleted.',
    'success'
    )
  }
  })

// console.log(templates, deleted);
})

///Whatsapppopup
function openWhatsAppPopup(event) {
  event.preventDefault();
  const link = event.target;
  const url = link.getAttribute("href");
  const cleanNumber = url.replace("https://wa.me/", "").replace("+", "");
  const whatsappLink = `https://wa.me/${cleanNumber}`;
  // Open the WhatsApp link in a popup window
  var w = 1024;
  var h = 768;
  var title = 'Chat on whatsapp';
  var left = (screen.width / 2) - (w / 2);
  var top = (screen.height / 2) - (h / 2);
  var win = window.open(whatsappLink, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
}

///openWebsitePopup
function openWebsitePopup(event) {
  event.preventDefault();
  const link = event.target;
  let url = link.getAttribute("href");
  // Open the WhatsApp link in a popup window
  url = (formatUrl(url));
  var w = 1024;
  var h = 768;
  var title = 'Website';
  var left = (screen.width / 2) - (w / 2);
  var top = (screen.height / 2) - (h / 2);
  var win = window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
}
function formatUrl(url) {
  if (!url.startsWith('http://') && !url.startsWith('https://')) {
    url = 'http://' + url;
  }
  return url;
}
