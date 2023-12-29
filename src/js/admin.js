/////////// --------------------- LEADS -------------------- ///////////


var json = '';
var questions = '';
var userbookings='';
var searchjson = '';
var templates = '';
var searched = false;

var seachdtbgroup = false;

$(document).ready(function () {

  $.ajax({
    url: domain + "getdata.php",
    dataType: "json",
    success: function (data) {
      // console.log(json);
      setTimeout(function () {
        json = [];
        if(dataID.length!=0) {
          for(var i=0;i<data.length;i++){
            if(data[i]['groups'].includes(current_group))
              json.push(data[i]);
          }
        } else {
          json = data;
        }
        displayelemnt(json);
        leads_stat(json);
      }, 1000);
    }
  });

  $.ajax({
    url: domain + "getbooking.php",
    dataType: "json",
    success: function (data) {
      setTimeout(function () {
        userbookings = [];
        if(dataID.length!=0) {
          for(var i=0;i<data.length;i++){
            if(data[i]['groups'].includes(current_group))
              userbookings.push(data[i]);
          }
        } else {
          userbookings = data;
        }
        displayBooking(userbookings);
        booking_stat(userbookings);
      }, 1000);
  
    }
  });

  setTimeout(function () {
    searchjson = [];
    if(dataID.length!=0) {
      for(var i=0;i<search_data.length;i++){
        if(search_data[i]['category']==current_group)
          searchjson.push(search_data[i]);
      }
    } else {
      searchjson = search_data;
    }
    displaySearch(searchjson);
    search_stat(searchjson);
  }, 1000);
  
  $.ajax({
    url: domain + "gettemplate.php",
    dataType: "json",
    success: function (data) {
      templates = [];
      if(dataID.length!=0) {
        for(var i=0;i<data.length;i++){
          if(data[i]['group']==current_group)
            templates.push(data[i]);
        }
      } else {
        templates = data;
      }
      setTimeout(function () {
        displayTemplate(templates);
        message_stats();
      }, 1000);

    }
  });

  $.ajax({
    url: domain + "getquestion.php",
    dataType: "json",
    success: function (data) {
      questions = data;
      // console.log(data);
      setTimeout(function () {
        displayelemnt(json);
      }, 1000);

      setTimeout(function () {
        leads_stat(json);
      }, 1000);
    }
  });

  setInterval(updateTemplate, 6000)
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
let intervall = null;

function datajson() {
  $.ajax({
    url: domain + "getdata.php",
    dataType: "json",
    success: function (data) {
      json = [];
      if(dataID.length!=0) {
        for(var i=0;i<data.length;i++){
          if(data[i]['groups'].includes(current_group))
            json.push(data[i]);
        }
      } else {
        json = data;
      }
      // console.log(json);
      setTimeout(function () {
        displayelemnt(json);
      }, 1000);

      setTimeout(function () {
        leads_stat(json);
      }, 1000);
    }
  });

  $.ajax({
    url: domain + "getquestion.php",
    dataType: "json",
    success: function (data) {
      questions = data;
      // console.log(data);
      setTimeout(function () {
        displayelemnt(json);
      }, 1000);

      setTimeout(function () {
        leads_stat(json);
      }, 1000);
    }
  });
}

function displayelemnt(json) {
  //var data = JSON.parse(json);
  var thead = document.querySelector('#leadth');
  var tbody = document.querySelector('#leadtab');
  var tr = '';
  var StatusBtnVal = '';
  json.forEach((Element, index) => {
    var a = '';
    var StatusArr = [];
    const age = calculateAge(Element.birthday);
    let existe = 0;
    if (index == 0) {
      tr += '<tr data-widget="expandable-table" class="' + (index + 1) + '" aria-expanded="true">';
    } else {
      tr += ' <tr data-widget="expandable-table" class="' + (index + 1) + '" aria-expanded="false">';
    }
    if(dataID.length==0) tr += '<td><input type="checkbox" name="delete-lead" id="" value="' + index + ' " class="delete-lead" /></td>';
    tr += '<td>' + (index + 1) + '</td>';
    if(dataID.length==0||dataID.includes('0')) tr += '<td><p style="width:90px;">' + Element.fullName + '</p></td>';
    if(dataID.length==0||dataID.includes('1')) tr += '<td><p style="width:30px;">' + age + '</p></td>';
    if(dataID.length==0||dataID.includes('2')) tr += '<td><p style="width:90px;"><a href="' + Element.website + '" target="_blank"onclick="openWebsitePopup(event)">' + Element.website + ' </a></p></td>';
    if(dataID.length==0||dataID.includes('3')) {
      tr += '<td><p style="width:110px;">' + Element.number + '<br>';
      var cleanNumber = Element.number.replace("+", "");
      // change number beginning from 07 to 447
      var qrNumber = cleanNumber.replace(/^447/, '07');
      tr += '<p><img src="https://chart.googleapis.com/chart?cht=qr&chs=100x100&chl=tel:+' + qrNumber + '"></p><p><a aria-label="Chat on WhatsApp" class="btn btn-sm btn-success" href="https://wa.me/' + cleanNumber + '"onclick="openWhatsAppPopup(event)" ><i class="fa-brands fa-whatsapp"></i></i> WhatsApp<a/></p></td>';
    }
    if(dataID.length==0||dataID.includes('4')) tr += '<td><p style="width:90px;">' + Element.email + '</p></td>';
    if(dataID.length==0||dataID.includes('5')) tr += '<td><p style="width:90px;">' + Element.location + '</p></td>';
    if(dataID.length==0||dataID.includes('6')) tr += '<td><p style="width:75px;">' + Element.date + '</p></td>';
    if(dataID.length==0||dataID.includes('7')) {
      if (Element.verified == 'true') {
        tr += '<td><span style="cursor:pointer;" class="badge bg-secondary ">Confirmed</span></td>';
      } else { tr += '<td><b>Pending</b></td>'; }
    }

    if(dataID.length==0||dataID.includes('8')) {
      if (Element.unsubscribed == 'true') {
        tr += '<td><span style="cursor:pointer;"  st' + (index + 1) + '" class="badge bg-info">Unsubscribed</span></td>';
        existe++;
      }
      else {
        for (let i = 0; i < sts.length; i++) {
          const statusObj = sts[i];
          const statusKey = Object.keys(statusObj)[0];
          const statusValue = statusObj[statusKey];
          StatusArr[statusKey] = statusValue;
          a += '<a class="dropdown-item bg-' + statusValue + '" onclick="togglestatut(' + index + ', \'' + statusKey + '\')">'+statusKey+'</a>';
          //if (Element.status === statusKey) {
            //tr += '<td><span style="cursor:pointer;" onclick="togglestatut(' + index + ')" class="badge bg-' + statusValue + ' st' + (index + 1) + '">' + Element.status + '</span></td>';
            //existe++;
            //break;
          //}
        }
  
        StatusBtnVal = StatusArr[Element.status];
        tr += '<td>' +
              '<div class="btn-group">' +
                '<button type="button" class="btn btn-'+StatusBtnVal+'">'+Element.status+'</button><button type="button" class="btn btn-'+StatusBtnVal+' dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>' +
                '<div class="dropdown-menu" role="menu" style="">' +
                  a +
                '</div>' +
              '</div>' +
            '</td>';
      }
    }
/*
    if (existe == 0) {
      const firstStatus = sts[0];
      const firstStatusKey = Object.keys(firstStatus)[0];
      const firstStatusValue = firstStatus[firstStatusKey];

      tr += '<td><span style="cursor:pointer;" onclick="togglestatut(' + index + ')" class="badge bg-' + firstStatusValue + ' st' + (index + 1) + '">' + firstStatusKey + '</span></td>';
    }
*/

    if(dataID.length==0||dataID.includes('9')) tr += '<td> <button class="m-1 btn btn-block btn-info btn-sm" onclick="edit(' + index + ')" data-toggle="modal" data-target="#edit"><i class="fas fa-pencil-alt"></i> Edit</button><button onclick="deleteit(' + index + ')" class="m-1 btn btn-block btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button> <button data-toggle="modal" data-target="#message" class="m-1 btn btn-block btn-success btn-sm"><i class="fas fa-envelope"></i> Message</button></td>';
    tr += '</tr>';
    tr += '<tr class="expandable-body ' + (index + 1) + '"><td style = "padding:12px !important" colspan = "12"> ';
    tr += '<span>';

    Element.question.forEach((quest, position) => {
      tr += ' <h5>' + quest.question + '</h5><p class="text-muted">';

      quest.answers.forEach((answer) => {
        tr += answer + '<br>';
      });
      tr += quest.comment; tr += '</p>';
    });
    tr += '<h5>Notes:</h5><p class="text-muted">' + Element.notes + '</p> ';
    tr += '<h5>Groups:</h5><p class="text-muted">';
    Element.groups.forEach((group) => {
      tr += '<small class="badge badge-primary"> ' + group + '  </small>  ';
    });
    tr += '</p> ';
    tr += ' </span>';
    tr += '</td></tr> ';

  });
  tbody.innerHTML = tr;
  var thr = '<tr>';
  if(dataID.length==0) thr += '<th><input type="checkbox" id="allleads" name="delete-all" value="lead" title="select all"></th>';
  thr += '<th>#</th>';
  if(dataID.length==0||dataID.includes('0')) thr += '<td>Name</td>';
  if(dataID.length==0||dataID.includes('1')) thr += '<td>Age</td>';
  if(dataID.length==0||dataID.includes('2')) thr += '<td>Website</td>';
  if(dataID.length==0||dataID.includes('3')) thr += '<td>Phone (+Area Code)</td>';
  if(dataID.length==0||dataID.includes('4')) thr += '<td>Email</td>';
  if(dataID.length==0||dataID.includes('5')) thr += '<td>Location</td>';
  if(dataID.length==0||dataID.includes('6')) thr += '<td>Date</td>';
  if(dataID.length==0||dataID.includes('7')) thr += '<td>Confirmed</td>';
  if(dataID.length==0||dataID.includes('8')) thr += '<td>Status</td>';
  if(dataID.length==0||dataID.includes('9')) thr += '<td>Actions</td>';
  thr += '</tr>';
  thead.innerHTML = thr;
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
const bookingdownloadBtn = document.getElementById('booking_csv');
bookingdownloadBtn.addEventListener('click', () => {
  downloadCSV(json);
});


function deleteit(id) {
  var groups = json[id]['groups'];
  json.splice(id, 1);
  deleted = json;

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
      setTimeout(function () {
        Swal.close();
      }, 3 * 1000);

      //json = data;
      if(deleted===null){
        deleted = [];
      }
      data = deleted;
      $.ajax({
        type: 'POST',
        url: 'save.php',
        data: {
          jsonDatAdmin: JSON.stringify(data)
        },
        success: function () {
          // console.log('Data saved');
          setTimeout(displayelemnt(json), 1000);
          if (searched == true) {
            // console.log(searched);
            var keyword = document.getElementById('keyword').value;
            // intervall = setInterval(datajson, 30000);
            search(keyword);
            if (seachdtbgroup == true) {
              var filterselect = document.getElementById('filtergroup');
              searchDtByGroup(filterselect.value);
            }
          }

          setTimeout(function () {
            leads_stat(json);
          }, 1000);
          
          var flag = false;
          for(var i=0; i<json.length; i++){
            flag = json[i]['groups'].some(element => {
              return groups.includes(element)
            })
            if(flag) break;
          }
          if(!flag) {
            groups.forEach(group=>deleteClientLink(group))
          }

        },
        error: function () {
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

function edit(id) {
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
  var question_input = document.getElementById('question');
  var line = '';
  line += '<h2>Questions</h2>';

  surveyedit.question.forEach((element, id) => {
    //question
    line += '<label for="InputQuestions' + (id + 1) + '">' + element.question + '</label>';

    // console.log(typeof(element),element);
    line += '<textarea id="InputQuestions' + (id + 1) + '" name="question' + (id + 1) + '" class="form-control form-control-lg form-control-border" rows="4" placeholder="Enter questions">';
    element.answers.forEach((answer, key) => {
      line += answer;
      if ((element.answers.length > (key + 1))) {
        line += "\n"
      } else if ((element.answers.length == (key + 1)) && element.comment) {
        line += "\n"
      }


    })
    if (element.comment) {
      line += element.comment;
    }
    line += '</textarea>';


  });

  question_input.innerHTML = line;

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
function togglestatut(id,st) {
  //let st = '';
  var surveyt = json[id];
/*
  let lastst = surveyt.status;

  var btnstatu = document.querySelector('.st' + (id + 1));
  const secondStatus = sts[1];
  const secondStatusKey = Object.keys(secondStatus)[0];
  let existt = 0;
  for (let index = 0; index < sts.length; index++) {
    const statusKey = Object.keys(sts[index])[0];

    if (surveyt.status === statusKey) {
      const nextIndex = (index + 1) % sts.length;
      st = Object.keys(sts[nextIndex])[0];
      existt++
      break;
    }
  }
  if (existt == 0) {
    st = secondStatusKey;
  }

  for (let i = 0; i < sts.length; i++) {
    const statusObj = sts[i];
    const statusKey = Object.keys(statusObj)[0];
    const statusValue = statusObj[statusKey];

    if (lastst === statusKey) {
      btnstatu.classList.remove("bg-" + statusValue);
      btnstatu.innerText = statusKey;
      break
    }

  }
  for (let i = 0; i < sts.length; i++) {
    const statusObj = sts[i];
    const statusKey = Object.keys(statusObj)[0];
    const statusValue = statusObj[statusKey];

    if (st === statusKey) {
      btnstatu.classList.add("bg-" + statusValue);
      btnstatu.innerText = statusKey;
      break
    }

  }
*/

  surveyt.status = st;
  json[id] = surveyt;
  $.getJSON(datafile, function (data) {
    data = json;
    $.ajax({
      type: 'POST',
      url: 'save.php',
      data: {
        jsonDatAdmin: JSON.stringify(data)
      },
      success: function () {

        if (searched == false) {
          // console.log(searched);
          // intervall = setInterval(datajson, 30000);
          setTimeout(displayelemnt(json), 1000);
        }
        setTimeout(function () {
          leads_stat(json);
        }, 1000);

      },
      error: function () {
        console.error('Error issue');
      }
    });
  });

}

//search

var searchBtn = document.getElementById('search');
var input = document.getElementById('keyword');
// console.log(searchBtn);

input.addEventListener('input', function (e) {

  e.preventDefault();
  // alert('done');
  var keyword = document.getElementById('keyword').value;
  // console.log(keyword);
  search(keyword);

});

function search(keyword) {

  //get element searched

  var jsons = filterData(keyword, json);

  json.forEach((element, index) => {

    let exist = 0;
    for (let i = 0; i < jsons.length; i++) {
      if (jsons[i].id == element.id) {
        // console.log(index);
        // console.log(element.id,jsons[i].id);
        exist += 1;
        break;
      }
    }

    //console.log(exist);

    if (exist == 0) {
      $('.' + (index + 1)).hide();

      // console.log(index);
    }
    else {
      $('.' + (index + 1)).show();

      // console.log(index);
    }

  });
  searched = true;
  clearInterval(intervall);
  intervall = null;
  //after display none element  not considered


}

// Function to filter data by name and return a new JSON containing the results
function filterData(query, data) {
  var filteredData = data.filter(function (entry) {
    var fullNameMatch = entry.fullName.toLowerCase().includes(query.toLowerCase());
    var websiteMatch = entry.website.toLowerCase().includes(query.toLowerCase());
    var phoneMatch = entry.number.toLowerCase().includes(query.toLowerCase());
    var groupMatch = entry.groups.includes(query);
    return fullNameMatch || websiteMatch || phoneMatch || groupMatch;
  });

  return filteredData;

}


$(document).ready(function () {
  $('#filtergroup').on("change", function (e) {
    // what you would like to happen
    // var selectElement = document.getElementById("filtergroup");
    var filterselect = document.getElementById('filtergroup');
    if (filterselect.value != '') {
      searched = true;
      seachdtbgroup = true;
      searchDtByGroup(filterselect.value);

      clearInterval(intervall);
    } else {
      searched = false;
      seachdtbgroup = false;
      setTimeout(datajson, 1000);
      intervall = setInterval(datajson, 6000);
    }

  });

});

///filter by group
var filterselect = document.getElementById('filtergroup');
// console.log(filterselect);
filterselect.addEventListener('change', () => {
  if (filterselect.value != '') {
    searched = true;
    seachdtbgroup = true;
   // alert(filterselect.value);
    searchDtByGroup(filterselect.value);

    clearInterval(intervall);
  } else {
    searched = false;
    seachdtbgroup = false;
    setTimeout(datajson, 1000);
    intervall = setInterval(datajson, 40000);
  }
})

//function filter lead by group 

function searchDtByGroup(groupname) {
  for (let i = 0; i < json.length; i++) {

    let exist = 0;
    if (json[i].groups.includes(groupname)) {
      $('.' + (i + 1)).show();
    }
    else {
      $('.' + (i + 1)).hide();
    }

  }
}

//edit

var editsubmit = document.getElementById('editsubmit');
editsubmit.addEventListener('click', function (event) {

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

  var groups = selectedValues;
  for (let index = 0; index < surveyedit.question.length; index++) {
    //question
    var question = [];
    const questionInput = document.getElementById('InputQuestions' + (index + 1));
    var forAttribute = 'InputQuestions' + (index + 1);
    const libelle = document.querySelector("label[for='" + forAttribute + "']").textContent;

    question = questionInput.value.split('\n');


    var questionData = {
      question: libelle,
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
    $.getJSON(datafile, function (data) {
      data = json;
      $.ajax({
        type: 'POST',
        url: 'save.php',
        data: {
          jsonDatAdmin: JSON.stringify(data)
        },
        success: function () {
          // console.log('Data saved');

          if (searched == true) {
            // console.log(searched);
            var keyword = document.getElementById('keyword').value;
            search(keyword);
            // intervall = setInterval(datajson, 30000);
            if (seachdtbgroup == true) {
              var filterselect = document.getElementById('filtergroup');
              searchDtByGroup(filterselect.value);
            }
          }

          $('#spinner').hide()

          editsubmit.innerHTML = '<i class="fas fa-check"></i> Saved';
          editsubmit.classList.remove("btn-primary");
          editsubmit.classList.add("btn-success");
          
          setTimeout(displayelemnt(json), 1000);

          setTimeout(function () {
            editsubmit.innerText = 'Save changes';
            editsubmit.classList.remove("btn-success");
            editsubmit.classList.add("btn-primary");
          }, 3000);

          // setTimeout(function() {
          //   $('#closemodale1').click();
          // }, 3000); 


        },
        error: function () {
          console.error('Error issue');
        }
      });
    });

  }

});


if (searched == false) {
  console.log(searched);
  intervall = setInterval(datajson, 6000);
}
else {
  console.log(searched);
  clearInterval(intervall);
}


setTimeout(() => {
  //       var leadnChecked = document.querySelectorAll('input[name="delete-lead"]');
  // console.log(leadnChecked);
  // leadnChecked.addEventListener('change',function (e) {
  //   var cheked= 0;
  // leadnChecked.forEach(input => {
  //   console.log(input.checked);
  //     if(input.checked == true ){
  //       cheked++;
  //       console.log(cheked);

  // }

  // });if(cheked>0)
  // clearInterval(intervall);
  // console.log(intervall);
  // });
  $('.delete-lead').on('change', function () {
    var isChecked = $(this).is(':checked');
    var isAnyOtherChecked = $('.delete-lead:checked').not(this).length > 0;

    if (isChecked && !isAnyOtherChecked) {
      clearInterval(intervall);
      //  console.log('1');
    } else if (!isChecked && !isAnyOtherChecked) {
      searched = false;
      setTimeout(datajson, 1000);

    }

    // console.log('Points:', points);
  });
}, 4000);



//delete multiple leads

$('#allleads').on('click', function (e) {
  clearInterval(intervall);
  if ($(this).is(':checked', true)) {
    $(".delete-lead").prop('checked', true);
  }
  else {
    $(".delete-lead").prop('checked', false);
  }
});


var deleted
var deleteLeadbtn = document.getElementById('deleteLead');

deleteLeadbtn.addEventListener('click', function (event) {

  var leadChecked = document.querySelectorAll('input[name="delete-lead"]');
  event.preventDefault();

  var todelete = [];
  leadChecked = document.querySelectorAll('input[name="delete-lead"]');
  leadChecked.forEach(input => {
    // array.includes(item, fromIndex)
    if (input.checked) {
      todelete.push(input.value);
    }

  });
  todelete.reverse();
  todelete.forEach(del => {
    // array.includes(item, fromIndex)
    deleted = json;
    var groups = deleted[del]['groups'];
    deleted.splice(del, 1);
          
    var flag = false;
    for(var i=0; i<deleted.length; i++){
      flag = deleted[i]['groups'].some(element => {
        return groups.includes(element)
      })
      if(flag) break;
    }
    if(!flag) {
      groups.forEach(group=>deleteClientLink(group))
    }
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
    if (result.isConfirmed) {

      const delay = 3;
      setTimeout(function () {
        Swal.close();
      }, 3 * 1000);

      //json = data;
      if(deleted===null){
        deleted = [];
      }
      data = deleted;
      $.ajax({
        type: 'POST',
        url: 'save.php',
        data: {
          jsonDatAdmin: JSON.stringify(data)
        },
        success: function () {
          //console.log('Data saved');
          json = deleted;
          setTimeout(displayelemnt(json), 1000);

          setTimeout(function () {
            leads_stat(json);
          }, 1000);

          if (searched == true) {
            // console.log(searched);
            var keyword = document.getElementById('keyword').value;
            // intervall = setInterval(datajson, 30000);
            search(keyword);
            if (seachdtbgroup == true) {
              var filterselect = document.getElementById('filtergroup');
              searchDtByGroup(filterselect.value);
            }
          }

        },
        error: function () {
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


/////////// --------------------- TEMPLATES -------------------- ///////////

function updateTemplate() {
  $.ajax({
    url: domain + "gettemplate.php",
    dataType: "json",
    success: function (data) {
      templates = [];
      if(dataID.length!=0) {
        for(var i=0;i<data.length;i++){
          if(data[i]['group']==current_group)
            templates.push(data[i]);
        }
      } else {
        templates = data;
      }
      setTimeout(function () {
        displayTemplate(templates);
        message_stats();
      }, 1000);
    }
  });
}

setInterval(updateTemplate, 6000)


//uniq id : 

const generateID = () => {
  const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  let id = "";
  for (let i = 0; i < 7; i++) {
    id += alphabet.charAt(Math.floor(Math.random() * alphabet.length));
  }
  return id;
};




function displayTemplate(templates) {

  //var data = JSON.parse(json);
  var thead = document.querySelector('#templateth');
  var tbody = document.querySelector('#templateBody');
  var tr = '';
  var StatusBtnVal = '';
  templates.forEach((Element, index) => {
    var a = '';
    var StatusArr = [];

    tr += '<tr class="template' + (index + 1) + '">';
    if(dataID.length==0) tr += '<td><input type="checkbox" name="delete-template" value="' + index + ' " class="delete-template" /></td>';
    tr += '<td>' + (index + 1) + ' </td>';
    tr += '<td>' + Element.group + '</td>';
    if(dataID.length==0||dataID.includes('0')) tr += '<td><img width="100%" src = "' + Element.image + '"/></td>';
    if(dataID.length==0||dataID.includes('1')) tr += '<td><a href="//' + Element.url + '" target="_blank">' + Element.url + '</a></td>';
    if(dataID.length==0||dataID.includes('2')) tr += '<td>' + Element.title + '</td>';
    if(dataID.length==0||dataID.includes('3')) tr += '<td>' + Element.content + '</td>';
    if(dataID.length==0||dataID.includes('4')) {
      for (let i = 0; i < templatests.length; i++) {
        const statusObj = templatests[i];
        const statusKey = Object.keys(statusObj)[0];
        const statusValue = statusObj[statusKey];
        StatusArr[statusKey] = statusValue;
        a += '<a class="dropdown-item bg-' + statusValue + '" onclick="toggletemplatestatut(' + index + ', \'' + statusKey + '\')" style="cursor: pointer;">'+statusKey+'</a>';
      }

      StatusBtnVal = StatusArr[Element.status];
      if(Element.status == 'Published'&&dataID.length>0)
        tr += '<td><span class=" badge badge-success">Published</span></td>'
      else
        tr += '<td>' +
          '<div class="btn-group">' +
            '<button type="button" class="btn btn-'+StatusBtnVal+'">'+Element.status+'</button><button type="button" class="btn btn-'+StatusBtnVal+' dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>' +
            '<div class="dropdown-menu" role="menu" style="">' +
              a +
            '</div>' +
          '</div>' +
        '</td>';
    }
    if(dataID.length==0||dataID.includes('5')) {
      tr += '<td><a href="view.php?index=' + Element.id + '" class="m-1 btn btn-block btn-primary btn-sm"><i class="fas fa-eye"></i> View</a>';
      tr += '<button class="m-1 btn btn-block btn-success btn-sm" onclick="postTemplate(' + index + ')"  data-toggle="modal" data-target="#post"><i class="fas fa-share-alt"></i> Post</button>';
      tr += '<button class="m-1 btn btn-block btn btn-info btn-sm" onclick="editTemplate(' + index + ')" data-toggle="modal" data-target="#edit-template"><i class="fas fa-pencil-alt"></i> Edit</button>';
      tr += '<button class="m-1 btn btn-block btn btn-danger btn-sm" onclick="deleteTemplate(' + index + ')" ><i class="fas fa-trash"></i> Delete</button></td>';
    }
    tr += '</tr>';

  });
  tbody.innerHTML = tr;
  var thr = '<tr>';
  if(dataID.length==0) thr += '<th><input type="checkbox" id="alltemplate" name="delete-all" value="template" title="select all"></th>';
  thr += '<th>No</th><td>Group</td>';
  if(dataID.length==0||dataID.includes('0')) thr += '<td>Image</td>';
  if(dataID.length==0||dataID.includes('1')) thr += '<td>Link</td>';
  if(dataID.length==0||dataID.includes('2')) thr += '<td>Title</td>';
  if(dataID.length==0||dataID.includes('3')) thr += '<td>Content</td>';
  if(dataID.length==0||dataID.includes('4')) thr += '<td>Status</td>';
  if(dataID.length==0||dataID.includes('5')) thr += '<td>Actions</td>';
  thr += '</tr>';
  thead.innerHTML = thr;

}

function toggletemplatestatut(id,st) {
  var surveyt = templates[id];

  surveyt.status = st;
  templates[id] = surveyt;
  data = templates;
  $.ajax({
    type: 'POST',
    url: 'save.php',
    data: {
      editTemplate: JSON.stringify(data)
    },
    success: function () {
      updateTemplate();
    },
    error: function () {
      console.error('Error issue');
    }
  });

}

//delete template

function deleteTemplate(id) {
  templates.splice(id, 1);
  deleted = templates;

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

      data = deleted;
      $.ajax({
        type: 'POST',
        url: 'save.php',
        data: {
          deleteTemplate: JSON.stringify(data)
        },
        success: function () {

          setTimeout(displayTemplate(templates), 1000);
          
          setTimeout(function () {
            message_stats();
          }, 1000);
              
          updateSelectOptions();


        },
        error: function () {
          console.error('Error issue');
        }
      });

      Swal.fire(
        'Deleted!',
        'Your template has been deleted.',
        'success'

      )
      setTimeout(function () {
        Swal.close();
      }, 1 * 1000);
    }
  })

}


//post template

var templateEdit = null;
var templateid = '';

var fb = document.getElementById('fb');
var blogger = document.getElementById('blogger');
var insta = document.getElementById('insta');
var linkedin = document.getElementById('linkedin');
var messenger = document.getElementById('messenger');
var pinterest = document.getElementById('pinterest');
var reddit = document.getElementById('reddit');
var telegram = document.getElementById('telegram');
var twitter = document.getElementById('twitter');
var tumblr = document.getElementById('tumblr');
var whatsapp = document.getElementById('whatsapp');


function postTemplate(id) {
  templateid = id;
  templateEdit = templates[id];
  // console.log('edit');
  url = domain + 'view.php?index=' + templateEdit.id;

  seturl(fb, 'u', url);
  seturl(blogger, 'u', url);
  seturl(insta, 'url', url);
  seturl(linkedin, 'url', url);
  seturl(messenger, 'link', url);
  seturl(pinterest, 'url', url);
  seturl(reddit, 'url', url);
  seturl(telegram, 'url', url);
  seturl(twitter, 'text', url);
  seturl(tumblr, 'canonicalUrl', url);
  seturl(whatsapp, 'text', url);

}

function seturl(link, attr, value) {

  let href = new URL(link.getAttribute('href'), window.location.href);
  href.searchParams.set(attr, value);
  link.setAttribute('href', href.toString());
  // console.log('seturl');
}

//edit template

var templateEdit = null;
var templateid = '';


var editTitle = document.getElementById('editTemplateTitle');
var editGroup = document.getElementById('editTemplateGroup');
var editImage = document.getElementById('editTemplateImage');
var editContent = document.getElementById('editTemplateContent');
var editTemplateLink = document.getElementById('editTemplateLink');

function editTemplate(id) {
  templateid = id;
  templateEdit = templates[id];

  editTitle.value = templateEdit.title;
  editGroup.value = templateEdit.group;
  editImage.value = templateEdit.image;
  editContent.value = templateEdit.content;
  editTemplateLink.value = templateEdit.url;
}

// console.log( $('#closemodale_temp'));
var editTemplatesubmit = document.getElementById('btnEditTemp');
editTemplatesubmit.addEventListener('click', function (event) {

  event.preventDefault();
  //$('#spinner').show();


  //save
  if (templateEdit) {
    templateEdit.title = editTitle.value;
    templateEdit.group = editGroup.value;
    templateEdit.image = editImage.value;
    templateEdit.content = editContent.value;
    templateEdit.url = editTemplateLink.value;

    templates[templateid] = templateEdit;
    $.ajax({
      type: 'POST',
      url: 'save.php',
      data: {
        deleteTemplate: JSON.stringify(templates)
      },
      success: function () {
        // console.log('Data saved');
        setTimeout(displayTemplate(templates), 1000);
        updateSelectOptions();

        setTimeout(function () {
          message_stats();
        }, 1000);
        Swal.fire({
          icon: 'success',
          title: 'Congratulation',
          text: 'Template edited',
        });

        // console.log( $('#closemodale_temp'));
        editTemplatesubmit.innerHTML = '<i class="fas fa-check"></i> Saved';
        editTemplatesubmit.classList.remove("btn-primary");
        editTemplatesubmit.classList.add("btn-success");



        setTimeout(function () {
          editTemplatesubmit.innerText = 'Save changes';
          editTemplatesubmit.classList.remove("btn-success");
          editTemplatesubmit.classList.add("btn-primary");
        }, 3000);

      },
      error: function () {
        console.error('Error issue');
      }
    });

  }

});

var submitTemp = document.querySelector("#btnTemplate")

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

  if (templateGroup.value == '' ||  templateTitle.value == '' || summernote.value == '' || templateLink.value == '') {
    if (templateGroup.value == '') {
      templateGroup.style.borderColor = 'red'
    } else { templateGroup.style.borderColor = 'green' }
    templateImage.style.borderColor = 'green'
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
      url: templateLink.value,
      sendemail: false,
      sendsms: false,
      sendpush: false,
      date: formattedDate
    };

    $.ajax({
      type: 'POST',
      url: 'save.php',
      data: { template: JSON.stringify(formData) },
      success: function (response) {
        // console.log(response);
        Swal.fire({
          icon: 'success',
          title: 'Congratulation',
          text: 'Template added',
        });
        
        updateTemplate();
        // Call the function 
        updateSelectOptions();

      },
      error: function () {
        console.error('Error issue');
      }
    });


  }

});


//delete multiple Template

$('#alltemplate').on('click', function (e) {
  if ($(this).is(':checked', true)) {
    $(".delete-template").prop('checked', true);
  }
  else {
    $(".delete-template").prop('checked', false);
  }
});


var deleted = null;
var deleteTemplatebtn = document.getElementById('deleteTemplate');
var templateChecked = document.querySelectorAll('input[name="delete-template"]');
deleteTemplatebtn.addEventListener('click', function (event) {
  event.preventDefault();
  var todelete = [];
  templateChecked = document.querySelectorAll('input[name="delete-template"]');
  console.log(templateChecked);
  templateChecked.forEach(input => {
    if (input.checked) {
      todelete.push(input.value);
    }
  });
  var inv = todelete.reverse();
  todelete.forEach(del => {
    deleted = templates;
    deleted.splice(del, 1);
  });
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete all!'
  }).then((result) => {
    if (result.isConfirmed) {


      data = deleted;
      $.ajax({
        type: 'POST',
        url: 'save.php',
        data: {
          deleteTemplate: JSON.stringify(data)
        },
        success: function () {
          templates = deleted;
          setTimeout(displayTemplate(templates), 1000);
          updateSelectOptions();

          setTimeout(function () {
            message_stats();
          }, 1000);

        },
        error: function () {
          console.error('Error issue');
        }
      });

      Swal.fire(
        'Deleted!',
        'Your templates have been deleted.',
        'success'

      )
      setTimeout(function () {
        Swal.close();
      }, 1 * 1000);
    }
  })

  // console.log(templates, deleted);
})



///filter by group


$(document).ready(function () {
  $('#filtertemplategroup').on("change", function (e) {
    // what you would like to happen
    // var selectElement = document.getElementById("filtergroup");
    var filterselectT = document.getElementById('filtertemplategroup');
    if (filterselectT.value != '') {
      for (let i = 0; i < templates.length; i++) {

        let exist = 0;
        if (templates[i].group == filterselectT.value) {
          $('.template' + (i + 1)).show();
        }
        else {
          $('.template' + (i + 1)).hide();
        }

      }


    } else {
      setTimeout(displayTemplate(templates), 1000);
    }

  });
});
var filterselectT = document.getElementById('filtertemplategroup');
filterselectT.addEventListener('change', () => {
  if (filterselectT.value != '') {
    for (let i = 0; i < templates.length; i++) {

      let exist = 0;
      if (templates[i].group == filterselectT.value) {
        $('.template' + (i + 1)).show();
      }
      else {
        $('.template' + (i + 1)).hide();
      }

    }


  } else {
    setTimeout(displayTemplate(templates), 1000);
  }
})



//search

function search2(keyword2) {

  //get element searched

  var seached2 = filterData2(keyword2, searchjson);
  searchjson.forEach((element, index) => {

    let exist = 0;
    for (let i = 0; i < seached2.length; i++) {
      if (seached2[i].id == element.id) {
        exist += 1;
        break;
      }
    }
    if (exist == 0) {
      $('.search' + (index + 1)).hide();
    }
    else {
      $('.search' + (index + 1)).show();
    }

  });
  searched = true;
}

// Function to filter data by name and return a new JSON containing the results
function filterData2(query, data) {
  var filteredData = data.filter(function (entry) {
    var TitleMatch = entry.title.toLowerCase().includes(query.toLowerCase());
    return TitleMatch;
  });

  return filteredData;

}

function temp_search(temp_keyword) {

  //get element searched

  var tempseached = temp_filterData(temp_keyword, templates);
  console.log(tempseached, temp_keyword);
  templates.forEach((element, index) => {

    let exist = 0;
    for (let i = 0; i < tempseached.length; i++) {
      //console.log(tempseached[i],element);
      if (tempseached[i].id == element.id) {
        // console.log(index);
        // console.log(element.id,jsons[i].id);
        exist += 1;
        break;
      }
    }
    if (exist == 0) {
      $('.template' + (index + 1)).hide();

      // console.log(index);
    }
    else {
      $('.template' + (index + 1)).show();
    }

  });
  searched = true;
}

// Function to filter data by name and return a new JSON containing the results
function temp_filterData(query, data) {
  var filteredData = data.filter(function (entry) {
    var contentMatch = entry.content.toLowerCase().includes(query.toLowerCase());
    var TitleMatch = entry.title.toLowerCase().includes(query.toLowerCase());
    var groupMatch = entry.group.includes(query);
    return contentMatch || TitleMatch || groupMatch;
  });

  return filteredData;

}




/////////// --------------------- CAMPAIGN -------------------- ///////////

var campaigns = '';
$.ajax({
  url: domain + "getcampaign.php",
  dataType: "json",
  success: function (data) {
    campaigns = data;
    setTimeout(function () {
      displayCampaign(campaigns);
    }, 2000);

    setTimeout(function () {
      message_stats();
    }, 1000);
  }
});

function updateCampaign() {
  $.ajax({
    url: domain + "getcampaign.php",
    dataType: "json",
    success: function (data) {
      campaigns = data;
      // console.log(data);
      setTimeout(function () {
        displayCampaign(campaigns);
      }, 1000);

      setTimeout(function () {
        message_stats();
      }, 1000);
    }
  });
}



function displayCampaign(campaigns) {

  //var data = JSON.parse(json);
  var tbody = document.querySelector('#campaignBody');
  var tr = '';
  campaigns.forEach((Element, index) => {

    tr += '<tr><td><input type="checkbox" name="delete-campaign" id="" value="' + index + ' " class="delete-campaign" /></td><td>' + (index + 1) + ' </td>';

    tr += '<td>' + Element.type;
    if (Element.forecast) {
      tr += '(Weather)';
    }
    if (Element.holiday) {
      tr += ' (' + Element.holiday + ')';
    }
    tr += '</td>';
    if (Element.forecast) {
      tr += '<td>' + Element.forecast;
      if (Element.days == 'same') {
        tr += '(Same day)';
      }
      else { tr += '(Day before)'; }

      tr += '</td><td>' + Element.time + '</td>';

    }
    else if (Element.holiday) {
      tr += '<td>' + Element.holiday;
      if (Element.moment == 'day_before') {
        tr += '(Day before)';
      }
      else if (Element.moment == 'same_day') { tr += '(Same day)'; }

      else { tr += '(Week before)'; }
      tr += '</td><td>' + Element.time + '</td>';

    }

    else {
      if(Element.days.toString() == 'Bookings'){
        if(Element.time<60){
          tr += '<td>' + Element.days.toString() + '</td><td>' + Element.time + ' mins Before</td>';
        }else {
          tr += '<td>' + Element.days.toString() + '</td><td>' + Element.time/60 + ' hours Before</td>';
        }
      }else {
        tr += '<td>' + Element.days.toString() + '</td><td>' + Element.time + '</td>';
      }
    }
    tr += '<td>' + Element.group + '</td>';

    tr += '<td><button class="m-1 btn btn btn-info btn-sm" data-toggle="modal" data-target="#edit-campaign" onclick="editCampaign(' + index + ')"><i class="fas fa-pencil-alt"></i> Edit</button>';
    tr += '<button class="m-1 btn btn btn-danger btn-sm" onclick="deleteCampaign(' + index + ')" ><i class="fas fa-trash"></i> Delete</button>';
    tr += '<button class="m-1 btn btn btn-success btn-sm" data-toggle="modal" data-target="#status-campaign" onclick="statusCampaign(' + index + ')" ><i class="fas fa-chart-line"></i> Status</button>';
    if(Element.type=='RSS') tr += '<a class="m-1 btn btn btn-warning btn-sm" href="rss/' + Element.group + '.xml" target="_blank"><i class="fa-solid fa-rss"></i> RSS</a>';
    tr += '</td>';
    tr += '</tr>';

  });
  tbody.innerHTML = tr;

}


//groups

function updateSelectOptions() {
  7

  // Make an Ajax request
  $.ajax({
    url: domain + 'getGroups.php',
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      // Clear the select options
      // $('#bootstrap-duallistbox-nonselected-list_').empty();
      $('#selectContainer').empty();
      $('#editgroup').empty();
      $('#birth-selectContainer').empty();
      $('#birth-selectContainer #editgroup').empty();
      $('#filtertemplategroup').empty();
      $('#linkfiltergroup').html('<option value="">- SELECT GROUP OR RESET-</option>');
      $('#filtergroup').empty();
      $('#holidaygroup').empty();
      $('#weatherGroup').empty();
      // Loop through the response data and add new options

      var selectContainer = document.getElementById('selectContainer');
      selectContainer.innerHTML = '  <label for="InputGroup">Select Group</label> <select class="duallistbox" multiple="multiple">'
      var duallistbox = document.querySelector('#selectContainer .duallistbox'); var options = '';
      var birthSelectContainer = document.getElementById('birth-selectContainer');
      birthSelectContainer.innerHTML = '  <label for="InputGroup">Select Group</label> <select class="duallistbox" multiple="multiple">'
      var duallistbox1 = document.querySelector('#birth-selectContainer .duallistbox'); var options = '';
      var Booking_selectContainer = document.getElementById('Booking_selectContainer');
      Booking_selectContainer.innerHTML = '  <label for="InputGroup">Select Group</label> <select class="duallistbox" multiple="multiple">'
      var duallistbox3 = document.querySelector('#Booking_selectContainer .duallistbox'); var options = '';
      template_groups = response;
      response.forEach(function (group) {
        $('#selectContainer .duallistbox').append('<option>' + group + '</option>');
        $('#filtertemplategroup').append('<option value="' + group + '">' + group + '</option>');
        $('#linkfiltergroup').append('<option value="' + group + '">' + group + '</option>');
        $('#filtergroup').append('<option value="' + group + '">' + group + '</option>');
        options += '<option>' + group + '</option>';
        $('#editgroup').append('<option value = "' + group + '">' + group + '</option>');
        $('#holidaygroup').append('<option value = "' + group + '">' + group + '</option>');
        $('#weatherGroup').append('<option value = "' + group + '">' + group + '</option>');
      });
      duallistbox.innerHTML = options;
      duallistbox1.innerHTML = options;
      duallistbox3.innerHTML = options;
      $('#selectContainer .duallistbox').bootstrapDualListbox({
        // selectorMinimalHeight: 160
      });
      $('#birth-selectContainer .duallistbox').bootstrapDualListbox({
        // selectorMinimalHeight: 160
      });
      $('#Booking_selectContainer .duallistbox').bootstrapDualListbox({
        // selectorMinimalHeight: 160
      });
      console.log($('#editgroup'));
    },
    error: function (xhr, status, error) {
      console.log('Ajax request error:', error);
    }
  });



}



//delete campaign

function deleteCampaign(id) {
  campaigns.splice(id, 1);
  deleted = campaigns;
  // console.log(id);

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
      setTimeout(function () {
        Swal.close();
      }, 1 * 1000);

      //json = data;
      data = deleted;
      $.ajax({
        type: 'POST',
        url: 'save.php',
        data: {
          deleteCampaign: JSON.stringify(data)
        },
        success: function () {

          setTimeout(displayCampaign(campaigns), 1000);

          setTimeout(function () {
            message_stats();
          }, 1000);

        },
        error: function () {
          console.error('Error issue');
        }
      });

      Swal.fire(
        'Deleted!',
        'Your campaign has been deleted.',
        'success'
      )
    }
  })

}

//edit campaingn

var campaignEdit = null;
var campaignid = '';



var editcampaignType = document.getElementById('edit-type');
var editcampaignTime = document.getElementById('edit-time');
var editcampaignGroup = document.getElementById('edit-group');
var editdaysInputs = document.querySelectorAll('input[name="editdays"]');

function editCampaign(id) {
  campaignid = id;

  editcampaignType = document.getElementById('edit-type');
  editcampaignTime = document.getElementById('edit-time');
  editcampaignGroup = document.getElementById('edit-group');
  //days

  editdaysInputs = document.querySelectorAll('input[name="editdays"]');
  //  console.log(editdaysInputs);


  campaignEdit = campaigns[id];
  editcampaignType.value = campaignEdit.type;
  editcampaignTime.value = campaignEdit.time;
  editcampaignGroup.value = campaignEdit.group;
  var editdays = campaignEdit.days;


  editdaysInputs.forEach(input => {
    // array.includes(item, fromIndex)
    if (editdays.includes(input.value)) { input.click(); }

  });
}

function statusCampaign(id) {
  // console.log('ok');

  campaignid = id;
  var currentcampaign = campaigns[id];
  //var data = JSON.parse(json);
  var tbody = document.querySelector('#status_table');
  var tr = '';

  json.forEach((Element, index) => {
    var exist = null;
    var p = 0;
    currentcampaign.status.forEach((user, index) => {
      if (Element.id == user.id) {
        exist = user;
        var position = p;
      }
      p++
    });

    if (Element.groups.includes(currentcampaign.group)) {

      tr += '<tr><td>' + Element.fullName + ' </td>';

      tr += '<td>' + Element.email + '</td>';
      if (exist) {
        tr += '<td>' + exist.date + '</td>';
      }
      else {
        tr += '<td></td>';
      }
      if (exist) {
        if (exist.state == "Success") {
          tr += '<td><small class="badge badge-success"><i class="fas fa-check"></i> Submitted</small></td>';
          tr += '<td><button class="btn btn btn-light btn-sm"><i class="fas fa-rotate"></i> Resend</button></td>';
        }
        else {
          tr += '<td><small class="badge badge-danger"><i class="fas fa-xmark"></i> Failure</small></td>';
          tr += '<td><button class="btn btn btn-primary btn-sm"><i class="fas fa-rotate"></i> Resend</button></td>';
        }
      }
      else {
        tr += '<td><small class="badge badge-warning"><i class="fas fa-clock"></i> Pending</small></td>';
        tr += '<td><button class="btn btn btn-light btn-sm"><i class="fas fa-rotate"></i> Resend</button></td>';
      }
      tr += '</tr>';
    }

  });
  tbody.innerHTML = tr;
  // statusCamp = document.getElementById('status-camp');
  //    statusCamp.textContent = currentcampaign.status;
}
var editCampaignsubmit = document.getElementById('editCampaignsubmit');
editCampaignsubmit.addEventListener('click', function (event) {

  event.preventDefault();

  //save
  if (campaignEdit) {
    campaignEdit.type = editcampaignType.value;
    campaignEdit.time = editcampaignTime.value;
    campaignEdit.group = editcampaignGroup.value;
    editdays = [];
    editdaysInputs = document.querySelectorAll('input[name="editdays"]');
    editdaysInputs.forEach(input => {
      if (input.checked) {
        editdays.push(input.value);
      }
    });
    if (campaignEdit.days != 'Birthdays' && campaignEdit.holiday == 'undefined') {
      campaignEdit.days = editdays;
    }

    campaigns[campaignid] = campaignEdit;
    $.ajax({
      type: 'POST',
      url: 'save.php',
      data: {
        deleteCampaign: JSON.stringify(campaigns)
      },
      success: function () {
        // console.log('Data saved');
        setTimeout(displayCampaign(campaigns), 1000);

        setTimeout(function () {
          message_stats();
        }, 1000);
        Swal.fire({
          icon: 'success',
          title: 'Congratulation',
          text: 'Campaign edited',
        });

        // console.log( $('#closemodale_temp'));
        editCampaignsubmit.innerHTML = '<i class="fas fa-check"></i> Saved';
        editCampaignsubmit.classList.remove("btn-primary");
        editCampaignsubmit.classList.add("btn-success");



        setTimeout(function () {
          editCampaignsubmit.innerText = 'Save changes';
          editCampaignsubmit.classList.remove("btn-success");
          editCampaignsubmit.classList.add("btn-primary");
        }, 3000);

      },
      error: function () {
        console.error('Error issue');
      }
    });

  }

});


var selectContainer = document.getElementById('selectContainer');

var selectElement = selectContainer.querySelector('select[name="_helper1"]');
var selectElement2 = selectContainer.querySelector('select[name="_helper2"]');

var moveall = selectContainer.querySelector('.moveall');
var removeall = selectContainer.querySelector('.removeall');
var groups = [];

// console.log(selectElement);
var options = selectElement.querySelectorAll('option');
// console.log(options);

selectElement.addEventListener('change', function (e) {
  e.preventDefault();
  var selectElement = selectContainer.querySelector('select[name="_helper1"]');
  var options2 = selectElement2.querySelectorAll('option');
  groups = [];
  $.each(options2, function (index, option) {
    groups.push(option.value);
  })
  console.log(groups)
});

selectElement2.addEventListener('change', function (e) {
  e.preventDefault();
  var options2 = selectElement2.querySelectorAll('option');
  groups = [];
  $.each(options2, function (index, option) {
    groups.push(option.value);
  })
  // console.log(groups)

});

moveall.addEventListener('click', function (e) {
  e.preventDefault();
  var options2 = selectElement2.querySelectorAll('option');
  groups = [];
  $.each(options2, function (index, option) {
    groups.push(option.value);
  })
  // console.log(groups)

});

removeall.addEventListener('click', function (e) {
  e.preventDefault();
  var options2 = selectElement2.querySelectorAll('option');
  groups = [];
  $.each(options2, function (index, option) {
    groups.push(option.value);
  })
  // console.log(groups)

});


var submitCamp = document.querySelector("#btnCampaign")


// Retrieve form values
var type = document.getElementById('type').value;
var time = document.getElementById('time').value;

$('.custom-tabs-one-campaigns-tab').click();
submitCamp.addEventListener('click', function (e) {

  e.preventDefault();
  // console.log(groups);
  type = document.getElementById('type').value;
  time = document.getElementById('time').value;

  //days
  var days = [];
  const daysInputs = document.querySelectorAll('input[name="days"]');
  //  console.log(daysInputs);
  daysInputs.forEach(input => {

    if (input.checked) {
      days.push(input.value);
    }
  });




  if (type != '' && days.length > 0 && time != '' && groups.length > 0) {
    const date = new Date();
    const formattedDate = date.toLocaleDateString() + ' / ' + date.getHours() + ':' + date.getMinutes();
    const formData = {
      id: 1,
      type: type,
      days: days,
      time: time,
      group: groups,
      status: [],
      // emailsignature: templateEmail.value,
      date: formattedDate
    };
    // console.log(formData);

    $.ajax({
      type: 'POST',
      url: 'save.php',
      data: { campaign: JSON.stringify(formData) },
      success: function (response) {
        // console.log(response);
        updateCampaign();
        Swal.fire({
          icon: 'success',
          title: 'Congratulation',
          text: 'Campaign added',
        });
      },
      error: function () {
        console.error('Error issue');
      }
    });


  }

});



//delete multiple Campaign

$('#allcampaign').on('click', function (e) {
  if ($(this).is(':checked', true)) {
    $(".delete-campaign").prop('checked', true);
  }
  else {
    $(".delete-campaign").prop('checked', false);
  }
});


var deleted
var deleteCampaignbtn = document.getElementById('deleteCampaign');
var campaignChecked = document.querySelectorAll('input[name="delete-campaign"]');
deleteCampaignbtn.addEventListener('click', function (event) {

  event.preventDefault();
  var todelete = [];
  campaignChecked = document.querySelectorAll('input[name="delete-campaign"]');
  campaignChecked.forEach(input => {
    if (input.checked) {
      todelete.push(input.value);
    }
  });
  todelete.reverse();
  todelete.forEach(del => {
    deleted = campaigns;
    deleted.splice(del, 1);
  });
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete all!'
  }).then((result) => {
    if (result.isConfirmed) {


      data = deleted;
      $.ajax({
        type: 'POST',
        url: 'save.php',
        data: {
          deleteCampaign: JSON.stringify(data)
        },
        success: function () {

          campaigns = deleted;
          setTimeout(displayCampaign(campaigns), 1000);

          setTimeout(function () {
            message_stats();
          }, 1000);

        },
        error: function () {
          console.error('Error issue');
        }
      });

      Swal.fire(
        'Deleted!',
        'Your campaigns have been deleted.',
        'success'

      )
      setTimeout(function () {
        Swal.close();
      }, 1 * 1000);
    }
  })

  // console.log(templates, deleted);
})


/////////////////////////// Bookings campaign

var btnBookingCampaign = document.querySelector("#btnBookingCampaign")

btnBookingCampaign.addEventListener('click', function (e) {

  e.preventDefault();

  var Booking_selectContainer = document.querySelector('#Booking_selectContainer select[name="_helper2"]');
  var groups = [];
  var Booking_selectContainer2nd = Booking_selectContainer.querySelectorAll('option');
  $.each(Booking_selectContainer2nd, function (index, option) {
    groups.push(option.value);
  })
  // alert(groups);
  // return;

// Retrieve form values
  var BookingRtype = document.getElementById('BookingRtype').value;
  var BookingRTime = document.getElementById('BookingRTime').value;

  if (BookingRtype !== '' && BookingRTime !== '' && groups.length > 0) {
    const date = new Date();
    const formattedDate = date.toLocaleDateString() + ' / ' + date.getHours() + ':' + date.getMinutes();
    const formData = {
      id: 1,
      type: BookingRtype,
      days: 'Bookings',
      time: BookingRTime,
      group: groups[0],
      status: [],
      // emailsignature: templateEmail.value,
      date: formattedDate
    };
    console.log(formData);

    $.ajax({
      type: 'POST',
      url: 'save.php',
      data: { campaign: JSON.stringify(formData) },
      success: function (response) {
         console.log(response);
        updateCampaign();
        Swal.fire({
          icon: 'success',
          title: 'Congratulation',
          text: 'Booking campaign added',
        });
      },
      error: function () {
        console.error('Error issue');
      }
    });

  }

});



////////////////////////////Birthday campaign

var selectElementbirth = document.querySelector('#birth-selectContainer select[name="_helper1"]');
var selectElementbirth2 = document.querySelector('#birth-selectContainer select[name="_helper2"]');

var moveallbirth = document.querySelector('#birth-selectContainer .moveall');
var removeallbirth = document.querySelector('#birth-selectContainer .removeall');
var groups = [];

// console.log(selectElement);
var options = selectElementbirth.querySelectorAll('option');
// console.log(options);

selectElementbirth.addEventListener('change', function (e) {
  e.preventDefault();
  var selectElementbirth = document.querySelector('#birth-selectContainer select[name="_helper1"]');
  var options2birth = selectElementbirth2.querySelectorAll('option');
  groups = [];
  $.each(options2birth, function (index, option) {
    groups.push(option.value);
  })
  // console.log(groups)
});

selectElementbirth2.addEventListener('change', function (e) {
  e.preventDefault();
  var options2 = selectElementbirth2.querySelectorAll('option');
  groups = [];
  $.each(options2, function (index, option) {
    groups.push(option.value);
  })
  // console.log(groups)

});

moveallbirth.addEventListener('click', function (e) {
  e.preventDefault();
  var options2 = selectElementbirth2.querySelectorAll('option');
  groups = [];
  $.each(options2, function (index, option) {
    groups.push(option.value);
  })
  // console.log(groups)

});

removeallbirth.addEventListener('click', function (e) {
  e.preventDefault();
  var options2 = selectElementbirth2.querySelectorAll('option');
  groups = [];
  $.each(options2, function (index, option) {
    groups.push(option.value);
  })
  // console.log(groups)

});



var submitBirth = document.querySelector("#birtbtnCampaign")


// Retrieve form values
var type = document.getElementById('type').value;
var time = document.getElementById('time').value;

submitBirth.addEventListener('click', function (e) {

  e.preventDefault();


  birthtype = document.getElementById('birthtype').value;
  birthtime = document.getElementById('birthtime').value;


  if (birthtype != '' && birthtime != '' && groups.length > 0) {
    const date = new Date();
    const formattedDate = date.toLocaleDateString() + ' / ' + date.getHours() + ':' + date.getMinutes();
    const formData = {
      id: 1,
      type: birthtype,
      days: 'Birthdays',
      time: birthtime,
      group: groups[0],
      status: [],
      // emailsignature: templateEmail.value,
      date: formattedDate
    };
    // console.log(formData);

    $.ajax({
      type: 'POST',
      url: 'save.php',
      data: { campaign: JSON.stringify(formData) },
      success: function (response) {
        // console.log(response);
        updateCampaign();
        Swal.fire({
          icon: 'success',
          title: 'Congratulation',
          text: 'Campaign added',
        });
      },
      error: function () {
        console.error('Error issue');
      }
    });

  }

});


/////////////////////////// Weather campaign

var groups = [];

// console.log(options);
var submitWeather = document.querySelector("#weatherSubmit")

// Retrieve form values
var weatherType = document.getElementById('weatherType').value;
var weatherTime = document.getElementById('weatherTime').value;
var weatherForecast = document.getElementById('weatherForecast').value;
var weatherday = document.getElementById('weatherday').value;
var weatherGroup = document.getElementById('weatherGroup').value;
submitWeather.addEventListener('click', function (e) {

  e.preventDefault();


  weatherType = document.getElementById('weatherType').value;
  weatherTime = document.getElementById('weatherTime').value;
  weatherForecast = document.getElementById('weatherForecast').value;
  weatherday = document.getElementById('weatherday').value;
  weatherGroup = document.getElementById('weatherGroup').value;

  if (weatherType != '' && weatherTime != '' && weatherForecast != '' && weatherday != '' && weatherGroup != '') {
    const date = new Date();
    const formattedDate = date.toLocaleDateString() + ' / ' + date.getHours() + ':' + date.getMinutes();
    const formData = {
      id: 1,
      type: weatherType,
      time: weatherTime,
      forecast: weatherForecast,
      days: weatherday,
      group: weatherGroup,
      status: [],
      // emailsignature: templateEmail.value,
      date: formattedDate
    };
    // console.log(formData);

    $.ajax({
      type: 'POST',
      url: 'save.php',
      data: { campaign: JSON.stringify(formData) },
      success: function (response) {
        // console.log(response);
        updateCampaign();
        Swal.fire({
          icon: 'success',
          title: 'Congratulation',
          text: 'Weather campaign added',
        });
      },
      error: function () {
        console.error('Error issue');
      }
    });

  }

});




/////////////////////////// Holiday campaign
//charge holidays <option>2nd January (substitute day) (Scotland) - 2023-01-03</option>

$("document").ready(function (e) {
  $("#holidaySelect").html("<option>Loading...</option>");
  var calendarUrl = 'https://www.googleapis.com/calendar/v3/calendars/en.' + country
    + '%23holiday%40group.v.calendar.google.com/events?key=' + calendar_api_key;


  $.getJSON(calendarUrl, function (data) {

    // console.log(data);
    $("#holidaySelect").empty();
    for (item in data.items) {

      let partiesDate1 = '';
      partiesDate1 = data.items[item].start.date.split('-'); // Diviser la date en parties : année, mois, jour
      var dateFormatee1 = partiesDate1[2] + '-' + partiesDate1[1] + '-' + partiesDate1[0];
      let partiesDate2 = '';
      partiesDate2 = data.items[item].end.date.split('-'); // Diviser la date en parties : année, mois, jour
      var dateFormatee2 = partiesDate2[2] + '-' + partiesDate2[1] + '-' + partiesDate2[0];
      $("#holidaySelect").append(
        "<option value=" + dateFormatee1 + "@" + dateFormatee2 + ">" + data.items[item].summary + ' [' + dateFormatee1 + ']' + "</option>"
      );
    }
  }).fail(function () {
    $("#holidaySelect").html("An error occurred.");
    console.log('An error occurred.');
  });
});
$("#selectCountry").trigger("change");



var groups = [];

// console.log(options);
var holidaysubmit = document.querySelector("#holidaysubmit")

// Retrieve form values
var holidayType = document.getElementById('holidaytype').value;
var holidaySelect = document.getElementById('holidaySelect').value;
var holidaytime = document.getElementById('holidaytime').value;
var holidaymoment = document.getElementById('holidaymoment').value;
var holidaygroup = document.getElementById('holidaygroup').value;
holidaysubmit.addEventListener('click', function (e) {

  e.preventDefault();


  holidayType = document.getElementById('holidaytype').value;
  holidaySelect = document.getElementById('holidaySelect').value;
  holiday = document.querySelector('#select2-holidaySelect-container').textContent;
  holidaytime = document.getElementById('holidaytime').value;
  holidaymoment = document.getElementById('holidaymoment').value;
  holidaygroup = document.getElementById('holidaygroup').value;

  if (holidayType != '' && holidaySelect != '' && holidaytime != '' && holidaymoment != '' && holidaygroup != '') {
    const date = new Date();
    const formattedDate = date.toLocaleDateString() + ' / ' + date.getHours() + ':' + date.getMinutes();
    let days = holidaySelect.split('@');
    const formData = {
      id: 1,
      type: holidayType,
      time: holidaytime,
      moment: holidaymoment,
      days: [days[0], days[1]],
      holiday: holiday,
      group: holidaygroup,
      status: [],
      // emailsignature: templateEmail.value,
      date: formattedDate
    };
    console.log(formData);

    $.ajax({
      type: 'POST',
      url: 'save.php',
      data: { campaign: JSON.stringify(formData) },
      success: function (response) {
        // console.log(response);
        updateCampaign();
        Swal.fire({
          icon: 'success',
          title: 'Congratulation',
          text: 'Holiday campaign added',
        });
      },
      error: function () {
        console.error('Error issue');
      }
    });

  }

});

//////////////------------------------------------- Admin stat ---------------------------------------------------//

$(document).ready(function () {

});
function total_contact(json) {

}

function leads_stat(json) {
  var total_contact = json.length;
  // var total_stat = document.getElementById('total_stat');
  // total_stat.textContent = total_contact;

  const firstStatusg = sts[0];
  const secondStatusg = sts[1];
  const thirdStatusg = sts[2];
  const forthStatusg = sts[3];

  const firstStatusKey = Object.keys(firstStatusg)[0];
  const secondStatusKey = Object.keys(secondStatusg)[0];
  const thirdStatusKey = Object.keys(thirdStatusg)[0];
  const forthStatusKey = Object.keys(forthStatusg)[0];

  var total_first = 0; var total_second = 0; var total_third = 0; var total_forth = 0;
  var total_pending = 0;
  var total_confirmed = 0;
  // var total_hot = 0;
  json.forEach(element => {
    if (element.status == firstStatusKey) {
      total_first++;
    }

    if (element.status == secondStatusKey) {
      total_second++;
    }

    if (element.status == thirdStatusKey) {
      total_third++;
    }

    if (element.status == forthStatusKey) {
      total_forth++;
    }

    if (element.verified == 'true') {
      total_confirmed++;
    }
    else {
      total_pending++;
    }


  })

  $("#lead_warm_stat").text(total_first);
  $("#lead_rejected_stat").text(total_second);
  $("#lead_hot_stat").text(total_third);
  $("#lead_contacted_stat").text(total_forth);

  var leads_stat = document.getElementById('leads_stats');

  var li = '';
  li += '<li class="list-group-item">Total <span class="float-right badge bg-info" id="total_stat">' + total_contact + '</span></li>'

  li += '<li class="list-group-item">' + firstStatusKey + ' <span class="float-right badge bg-info" id="warm_stat">' + total_first + '</span></li>';

  li += ' <li class="list-group-item">' + secondStatusKey + ' <span class="float-right badge bg-info" id="hot_stat">' + total_second + '</span></li>';
  var pending_stat = document.getElementById('pending_stat');
  pending_stat.textContent = total_pending;

  var confirmed_stat = document.getElementById('confirmed_stat');
  confirmed_stat.textContent = total_confirmed;
  leads_stat.innerHTML = li;
}

function message_stats() {
  const firstStatusg = templatests[0];
  const secondStatusg = templatests[1];
  const thirdStatusg = templatests[2];
  const forthStatusg = templatests[3];

  const firstStatusKey = Object.keys(firstStatusg)[0];
  const secondStatusKey = Object.keys(secondStatusg)[0];
  const thirdStatusKey = Object.keys(thirdStatusg)[0];
  const forthStatusKey = Object.keys(forthStatusg)[0];

  var total_first = 0; var total_second = 0; var total_third = 0; var total_forth = 0;

  templates.forEach(element => {
    if (element.status == firstStatusKey) {
      total_first++;
    }

    if (element.status == secondStatusKey) {
      total_second++;
    }

    if (element.status == thirdStatusKey) {
      total_third++;
    }

    if (element.status == forthStatusKey) {
      total_forth++;
    }
  })

  $("#template_pending_stat").text(total_first);
  $("#template_approved_stat").text(total_second);
  $("#template_rejected_stat").text(total_third);
  $("#template_published_stat").text(total_forth);

  $("#templates_approved").text(total_second);
  $("#templates_rejected").text(total_third);
  $("#templates_published").text(total_forth);
  
  var templates_stat = document.getElementById('templates_stat');
  templates_stat.textContent = templates.length;

  var campaigns_stat = document.getElementById('campaigns_stat');
  campaigns_stat.textContent = campaigns.length;
  var messages_total = 0;
  // campaigns.forEach(element => {
    //var sent = element.status.split('Success');  

    //if(sent.length>1){messages_total+=(sent.length/2);}

  // })

  var sent_stat = document.getElementById('sent_stat');
  sent_stat.textContent = messages_total;

}


function booking_stat(booking) {
  var total_contact = booking.length;
  // var total_stat = document.getElementById('total_stat');
  // total_stat.textContent = total_contact;

  const firstStatusg = bookingsts[0];
  const secondStatusg = bookingsts[1];
  const thirdStatusg = bookingsts[2];

  const firstStatusKey = Object.keys(firstStatusg)[0];
  const secondStatusKey = Object.keys(secondStatusg)[0];
  const thirdStatusKey = Object.keys(thirdStatusg)[0];

  var total_first = 0; var total_second = 0; var total_third = 0;
  var total_pending = 0;
  var total_confirmed = 0;
  // var total_hot = 0;
  booking.forEach(element => {
    if (element.status == firstStatusKey) {
      total_first++;
    }

    if (element.status == secondStatusKey) {
      total_second++;
    }

    if (element.status == thirdStatusKey) {
      total_third++;
    }

    if (element.verified == 'true') {
      total_confirmed++;
    }
    else {
      total_pending++;
    }


  })

  $("#booking_pending_stat").text(total_first);
  $("#booking_attended_stat").text(total_second);
  $("#booking_rejected_stat").text(total_third);

  var booking_stats = document.getElementById('booking_stats');

  var li = '';
  li += ' <li class="list-group-item">Total <span class="float-right badge bg-info" id="total_booking_status">' + total_contact + '</span></li>'

  li += '<li class="list-group-item">' + firstStatusKey + ' <span class="float-right badge bg-info" id="warm_stat">' + total_first + '</span></li>';

  li += ' <li class="list-group-item">' + secondStatusKey + ' <span class="float-right badge bg-info" id="hot_stat">' + total_second + '</span></li>';
  
  booking_stats.innerHTML = li;
}

function search_stat(json) {
  var total_contact = json.length;
  // var total_stat = document.getElementById('total_stat');
  // total_stat.textContent = total_contact;

  const firstStatusg = searchsts[0];
  const secondStatusg = searchsts[1];
  const thirdStatusg = searchsts[2];
  const forthStatusg = searchsts[3];

  const firstStatusKey = Object.keys(firstStatusg)[0];
  const secondStatusKey = Object.keys(secondStatusg)[0];
  const thirdStatusKey = Object.keys(thirdStatusg)[0];
  const forthStatusKey = Object.keys(forthStatusg)[0];

  var total_first = 0; var total_second = 0; var total_third = 0; var total_forth = 0;
  // var total_hot = 0;
  json.forEach(element => {
    if (element.status == firstStatusKey) {
      total_first++;
    }

    if (element.status == secondStatusKey) {
      total_second++;
    }

    if (element.status == thirdStatusKey) {
      total_third++;
    }

    if (element.status == forthStatusKey) {
      total_forth++;
    }
  })

  $("#search_pending_stat").text(total_first);
  $("#search_contacted_stat").text(total_second);
  $("#search_replied_stat").text(total_third);
  $("#search_rejected_stat").text(total_forth);

  var search_stat = document.getElementById('search_stats');

  var li = '';
  li += '<li class="list-group-item">Total <span class="float-right badge bg-info" id="total_search_status">' + total_contact + '</span></li>'

  li += '<li class="list-group-item">' + secondStatusKey + ' <span class="float-right badge bg-info" id="total_search_contacted_status">' + total_first + '</span></li>';

  li += ' <li class="list-group-item">' + thirdStatusKey + ' <span class="float-right badge bg-info" id="total_search_replied_status">' + total_second + '</span></li>';
  search_stat.innerHTML = li;
}
/*
    Search Related
                    */




// Toggle Loader

function toggleLoader(option) {
  if (option == 'show') {
    $('.loader-parent').css("display", "flex");
    $('body').css("overflow", "hidden");
  } else {
    $('.loader-parent').css("display", "none");
    $('body').css("overflow", "initial");
  }
}

// Keyword Input Field - Dash Added

$("#search_keyword").on("input", function () {
  const newValue = $(this).val().replace(/\s/g, "-");
  $(this).val(newValue);
});

// Save Search Param

const form = document.getElementById("search_url_form");
form.addEventListener("submit", async (e) => {
  e.preventDefault();
  const submitBtn = $(e.currentTarget).find("button[type=submit]");
  toggleLoader("show");
  $(submitBtn).attr("disabled", true);
  await savingSearch(submitBtn);
});

// Function for Saving Search

async function savingSearch(submitBtn) {
  try {
    var responseSearchParams = await saveSearchParam();
    if (responseSearchParams == 'Success') {
      await saveSearchData();

      toggleLoader("hide");
      $(submitBtn).removeAttr("disabled");

      Swal.fire({
        icon: 'success',
        title: 'Saved Successfully!',
        html: 'The Search has been saved successfully',
        timer: 3000,
        timerProgressBar: true
      });
    }
  } catch (error) {
    toggleLoader("hide");
    $(submitBtn).removeAttr("disabled");

    const { title, errorMessage } = error;
    Swal.fire({
      icon: 'error',
      title: title,
      html: errorMessage,
    });
  }
}

// Function for Saving Search Param

function saveSearchParam() {
  const form = document.getElementById("search_url_form");
  const formData = new FormData(form);
  formData.append("search_category", $("#search_category_select").val());
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: domain + "search/saveSearchParam.php",
      type: "POST",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (xhr) {
        if (xhr.searchParams) {
          // Append Keywords
          var searchId = xhr.searchId;
          var searchParams = xhr.searchParams;
          var searchParamList = $('.search-params-list');
          var searchParamListitem = `
            <li class="nav-item" data-searchParamId="${searchId}">
              <a href="#" class="nav-link">
                ${searchParams}
                <span onclick="deleteSearchParam(event)" class="float-right btn btn-sm btn-danger btn-flat">Delete</span>
              </a>
            </li>
          `;
          searchParamList.append(searchParamListitem);

          resolve(xhr.message);
        }
      },
      error: function (xhr) {
        const response = xhr.responseJSON;
        var title = '';
        var errorMessage = '';

        if (response && response.errors) {
          var errors = response.errors;
          title = 'Error!';
          errorMessage = errors.join('<br>');
        } else {
          title = 'Unexpected Error';
          errorMessage = 'An unexpected error occurred.';
        }

        reject({ message: response?.message ?? 'Error', title: title, errorMessage: errorMessage });
      }
    });
  });
}

// Function for Saving Search Data

function saveSearchData() {
  const formData = new FormData();
  formData.append("action", "manual");
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: domain + "search/saveSearchData.php",
      type: "POST",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (xhr) {
        if (xhr.searchData) {
          search_data = xhr.searchData;
        }
        displaySearch(search_data);
        search_stat(search_data);
        resolve(xhr.message);
      },
      error: function (xhr) {
        const response = xhr.responseJSON;
        var title = 'Unexpected Error';
        var errorMessage = 'An unexpected error occurred.';

        reject({ message: response?.message ?? 'Error', title: title, errorMessage: errorMessage });
      }
    });
  });
}

function displaySearch(json) {
  var category = $('#search_category_select').val();
  if(dataID.length == 0 && category != ""){
    var searchjson = [];
    for(var i=0;i<json.length;i++){
      if(json[i]['category']==category)
        searchjson.push(json[i]);
    }
    json = searchjson;
  }

  var thead = document.querySelector('#searchth');
  var tbody = document.querySelector('#data-table');
  var tr = '';
  var StatusBtnVal = '';
  json.forEach((Element, index) => {
    var a = '';
    var StatusArr = [];
    if (index == 0) {
      tr += '<tr data-widget="expandable-table" class="search' + (index + 1) + '" aria-expanded="true" data-id="' + Element.id + '" data-link="' + Element.link + '">';
    } else {
      tr += ' <tr data-widget="expandable-table" class="search' + (index + 1) + '" aria-expanded="false" data-id="' + Element.id + '" data-link="' + Element.link + '">';
    }
    if(dataID.length==0) tr += '<td><input type="checkbox" class="search-url-table-select-row"></td>';
    tr += '<td>' + (index + 1) + '</td>';
    if(dataID.length==0||dataID.includes('0')) tr += '<td class="search-url-table-image"><img width="100px" src="' + Element.imageUrl + '"></td>';
    if(dataID.length==0||dataID.includes('1')) tr += '<td class="search-url-table-title">'+ Element.title + '</td>';
    if(dataID.length==0||dataID.includes('2')) tr += '<td><b>Type:</b> ' + Element.type + '<br><b>Network:</b> ' + Element.network + '<br><b>Keyword:</b> ' + Element.keyword + '</td>';
    if(dataID.length==0||dataID.includes('3')) tr += '<td>' + Element.date + '</td>';

    if(dataID.length==0||dataID.includes('4')) {
      for (let i = 0; i < searchsts.length; i++) {
        const statusObj = searchsts[i];
        const statusKey = Object.keys(statusObj)[0];
        const statusValue = statusObj[statusKey];
        StatusArr[statusKey] = statusValue;
        a += '<a class="dropdown-item bg-' + statusValue + '" onclick="togglesearchstatut(' + Element.id + ', \'' + statusKey + '\')">'+statusKey+'</a>';
      }

      StatusBtnVal = StatusArr[Element.status];
      tr += '<td>' +
            '<div class="btn-group">' +
              '<button type="button" class="btn btn-'+StatusBtnVal+'">'+Element.status+'</button><button type="button" class="btn btn-'+StatusBtnVal+' dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>' +
              '<div class="dropdown-menu" role="menu" style="">' +
                a +
              '</div>' +
            '</div>' +
          '</td>';
    }

    if(dataID.length==0||dataID.includes('5')) tr += '<td><a href="javascript:void(0);" class="m-1 btn btn-block btn-success btn-sm search-url-table-link" onClick="popupSocial(' + Element.link + ')"><i class="fas fa-envelope"></i> Contact</a><button onclick="openSearchEditForm(event)" class="m-1 btn btn-block btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i> Edit</button><button onclick="deleteSearchItem(event)" class="m-1 btn btn-block btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button><button data-toggle="modal" data-target="#modal-switch" class="m-1 btn btn-block btn btn-primary btn-sm add-search-item"><i class="fas fa-add"></i> Add</button></td>';
    tr += '</tr>';
    tr += '<tr class="expandable-body search-url-table-expandable"><td colspan="8"><p style="display: none;" class="search-url-table-description">' + Element.description + '</p><h5 class="search-url-table-notes-label" style="display: none;">Notes:</h5><p style="display: none;" class="search-url-table-notes text-muted">' + Element.notes + '</p></td></tr> ';

  });
  tbody.innerHTML = tr;
  var thr = '<tr>';
  if(dataID.length==0) thr += '<th><input type="checkbox" id="allleads" name="delete-all" value="lead" title="select all"></th>';
  thr += '<th>#</th>';
  if(dataID.length==0||dataID.includes('0')) thr += '<td>Picture</td>';
  if(dataID.length==0||dataID.includes('1')) thr += '<td>Title</td>';
  if(dataID.length==0||dataID.includes('2')) thr += '<td>Settings</td>';
  if(dataID.length==0||dataID.includes('3')) thr += '<td>Date</td>';
  if(dataID.length==0||dataID.includes('4')) thr += '<td>Status</td>';
  if(dataID.length==0||dataID.includes('5')) thr += '<td>Actions</td>';
  thr += '</tr>';
  thead.innerHTML = thr;
}

// Function For Updating the Counts

function UpdateSearchStatusCount(allStatus) {
  const total = allStatus.length;
  const statusCounts = allStatus.reduce((counts, status) => {
    counts[status] = (counts[status] || 0) + 1;
    return counts;
  }, {});
  const pendingCount = statusCounts['Pending'] || 0;
  const contactedCount = statusCounts['Contacted'] || 0;
  const repliedCount = statusCounts['Replied'] || 0;
  const rejectedCount = statusCounts['Rejected'] || 0;

  $("#total_search_status").text(total);
  $("#total_search_contacted_status").text(contactedCount);
  $("#total_search_replied_status").text(repliedCount);

  $("#search_pending_stat").text(pendingCount);
  $("#search_contacted_stat").text(contactedCount);
  $("#search_replied_stat").text(repliedCount);
  $("#search_rejected_stat").text(rejectedCount);
}

// Delete Search Param

function deleteSearchParam(e) {
  e.preventDefault();

  const target = $(e.currentTarget);

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
      toggleLoader("show");

      const searchItem = $(target).closest("li")[0];
      const searchId = $(searchItem).data("searchparamid");
      const formData = new FormData();
      formData.append("searchId", searchId);

      $.ajax({
        url: domain + "search/deleteSearchParam.php",
        type: "POST",
        data: formData,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function () {
          $(searchItem).remove();

          toggleLoader("hide");

          Swal.fire({
            icon: 'success',
            title: 'Deleted Successfully',
            text: 'The Item has been Deleted',
            timer: 3000,
            timerProgressBar: true
          });
        },
        error: function (xhr) {
          var title = '';
          var errorMessage = '';

          if (xhr.responseJSON && xhr.responseJSON.error) {
            title = 'Error!';
            errorMessage = xhr.responseJSON.error;
          } else {
            title = 'Unexpected Error';
            errorMessage = 'An unexpected error occurred.';
          }

          toggleLoader("hide");

          Swal.fire({
            icon: 'error',
            title: title,
            html: errorMessage,
          });
        }
      });
    }
  });
}

// Delete Search Item

function deleteSearchItem(e) {
  e.preventDefault();

  const target = $(e.currentTarget);

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
      toggleLoader("show");

      const searchItem = $(target).closest("tr")[0];
      const link = $(searchItem).data("link");
      const formData = new FormData();
      formData.append("link", link);

      $.ajax({
        url: domain + "search/deleteSearchData.php",
        type: "POST",
        data: formData,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (xhr) {
          if (xhr.searchData) {
            search_data = xhr.searchData;
          }

          toggleLoader("hide");

          Swal.fire({
            icon: 'success',
            title: 'Deleted Successfully',
            text: 'The Item has been Deleted',
            timer: 3000,
            timerProgressBar: true
          });
        },
        error: function (xhr) {
          var title = '';
          var errorMessage = '';

          if (xhr.responseJSON && xhr.responseJSON.error) {
            title = 'Error!';
            errorMessage = xhr.responseJSON.error;
          } else {
            title = 'Unexpected Error';
            errorMessage = 'An unexpected error occurred.';
          }

          toggleLoader("hide");

          Swal.fire({
            icon: 'error',
            title: title,
            html: errorMessage,
          });
        }
      });
    }
  });
}

// Add Post to Template

function addSearchItem(e) {
  e.preventDefault();

  const target = $(e.currentTarget);

  const searchItem = $(target).closest("tr")[0];
  const id = $(searchItem).data("id");
  $("#post_id").val(id);
}


// Search Item - Edit

$(document).on("click", ".search-item-edit-btn", openSearchEditForm);

function openSearchEditForm(e) {
  e.preventDefault();

  const target = $(e.currentTarget);
  const modalElement = document.getElementById('edit-social');

  const row = $(target).closest('tr')[0];

  const values = {
    id: $(row).data("id"),
    image: $(row).find("td.search-url-table-image img").attr('src'),
    title: $(row).find("td.search-url-table-title").text(),
    link: $(row).data("link"),
    description: $(row).next("tr.search-url-table-expandable").find("p.search-url-table-description").text(),
    notes: $(row).next("tr.search-url-table-expandable").find("p.search-url-table-notes").text()
  };

  // Fill Form
  fillSearchEditForm(values);
  $(modalElement).modal('show');
}

// Function for Filling the Modal Form Fields

function fillSearchEditForm(values) {
  const form = $('.search-url-modal');
  form.attr("data-id", values.id);

  form.find('#search-url-picture').val(values.image);
  form.find('#search-url-title').val(values.title);
  form.find('#search-url-contact').val(values.link);
  form.find('#search-url-description').val(values.description);
  form.find('#search-url-notes').val(values.notes);
}

// Function for Table Specific Search Item

function updateSpecificSearchItem(values) {
  const row = $("tr[data-id='" + values.id + "']");

  $(row).find("td.search-url-table-image").find("img").attr("src", values.imageUrl);

  $(row).find("td.search-url-table-title").text(values.title);

  let contact = $(row).find("a.search-url-table-link");
  $(contact).on("click", function () {
    popupSocial(values.link);
  });

  $(row).next("tr.search-url-table-expandable").find("p.search-url-table-description").text(values.description);
  $(row).next("tr.search-url-table-expandable").find("p.search-url-table-notes").text(values.notes);

  $(row).data("link", values.link);
}

// Search Item - Edit - Form Submission

$(document).on("submit", ".search-url-modal", submitSearchEditForm);

function submitSearchEditForm(e) {
  e.preventDefault();

  const target = $(e.currentTarget);
  const spinner = $(target).find(".spinner-border");
  const submitBtn = $(target).find("#editSocialsubmit");

  $(spinner).css("display", "inline-block");
  $(submitBtn).attr("disabled", true);
  toggleLoader("show");

  const form = document.getElementsByClassName("search-url-modal")[0];
  const modalElement = document.getElementById('edit-social');
  const id = form.dataset.id;
  const formData = new FormData(form);
  formData.append("id", id);

  $.ajax({
    url: domain + "search/editSearchData.php",
    type: "POST",
    data: formData,
    dataType: "json",
    processData: false,
    contentType: false,
    success: function (xhr) {
      if (xhr.updatedItem) {
        var searchData = xhr.updatedItem;

        // Update Table Data
        fillSearchEditForm(searchData);
        updateSpecificSearchItem(searchData);
      }

      $(modalElement).modal('hide');

      $(spinner).css("display", "none");
      $(submitBtn).removeAttr("disabled");
      toggleLoader("hide");

      Swal.fire({
        icon: 'success',
        title: 'Updated Successfully',
        text: 'The Item has been Updated',
        timer: 3000,
        timerProgressBar: true
      });
    },
    error: function (xhr) {
      const response = xhr.responseJSON;
      var title = '';
      var errorMessage = '';

      if (response && response.errors) {
        var errors = response.errors;
        title = 'Error!';
        errorMessage = errors.join('<br>');
      } else {
        title = 'Unexpected Error';
        errorMessage = 'An unexpected error occurred.';
      }

      $(spinner).css("display", "none");
      $(submitBtn).removeAttr("disabled");
      toggleLoader("hide");

      Swal.fire({
        icon: 'error',
        title: title,
        html: errorMessage,
      });
    }
  });
}

// Search Item - Status Only - Form Submission

function togglesearchstatut(id,status) {
  const formData = new FormData();
  formData.append("id", id);
  formData.append("status", status);

  $.ajax({
    url: domain + "search/editSearchData.php",
    type: "POST",
    data: formData,
    dataType: "json",
    processData: false,
    contentType: false,
    success: function (xhr) {
      if (xhr.updatedItem) {
        var searchData = xhr.updatedItem;
        var statuses = xhr.statuses;

        for(var i=0; i<search_data.length; i++){
          if(search_data[i]['id']==searchData['id']) {
            search_data[i] = searchData;
          }
        }

        setTimeout(function () {
          searchjson = [];
          if(dataID.length!=0) {
            for(var i=0;i<search_data.length;i++){
              if(search_data[i]['category']==current_group)
                searchjson.push(search_data[i]);
            }
          } else {
            searchjson = search_data;
          }
          displaySearch(searchjson);
          search_stat(searchjson);
        }, 1000);
      }
    },
    error: function (xhr) {
      const response = xhr.responseJSON;
      var title = '';
      var errorMessage = '';

      if (response && response.errors) {
        var errors = response.errors;
        title = 'Error!';
        errorMessage = errors.join('<br>');
      } else {
        title = 'Unexpected Error';
        errorMessage = 'An unexpected error occurred.';
      }

      Swal.fire({
        icon: 'error',
        title: title,
        html: errorMessage,
      });
    }
  });
}

// Status Color Toggler - Search Items

function toggleColor(colors, currentStatus) {
  const colorKeys = Object.keys(colors);
  const currentIndex = colorKeys.indexOf(currentStatus);
  const nextStatus = colorKeys[(currentIndex + 1) % colorKeys.length];
  return nextStatus;
}

// Select All - Search Items Table

$('#search-data-table-selectAll').on('change', function () {
  var checkboxes = $('.search-url-table-select-row');
  checkboxes.prop('checked', this.checked);
});

$('#search-data-table-delete').on('click', function (e) {
  const target = $(e.currentTarget);

  var selectedIds = [];
  var checkboxes = $('.search-url-table-select-row:checked');
  checkboxes.each(function () {
    var row = $(this).closest('tr');
    var id = row.data('id');
    selectedIds.push(id);
  });

  if (selectedIds.length == 0) {
    Swal.fire({
      icon: 'error',
      title: 'Error!',
      html: 'Please select any row',
    });
  } else {
    deleteSelectedSearchRows(target, selectedIds);
  }
});

// Function for Deleting the Selected Rows

function deleteSelectedSearchRows(target, ids) {
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

      toggleLoader("show");
      target.attr("disabled", true);

      const formData = new FormData();
      formData.append("ids", JSON.stringify(ids));

      $.ajax({
        url: domain + "search/deleteSelectedSearchData.php",
        type: "POST",
        data: formData,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (xhr) {
          if (xhr.searchData) {
            search_data = xhr.searchData;
          }

          $('#search-data-table-selectAll').prop('checked', false);
          var checkboxes = $('.search-url-table-select-row:checked');
          checkboxes.each(function () {
            $(this).prop('checked', false);
          });

          target.removeAttr("disabled");
          toggleLoader("hide");

          Swal.fire({
            icon: 'success',
            title: 'Deleted Successfully',
            text: 'The Item has been Deleted',
            timer: 3000,
            timerProgressBar: true
          });
        },
        error: function (xhr) {
          var title = '';
          var errorMessage = '';

          if (xhr.responseJSON && xhr.responseJSON.error) {
            title = 'Error!';
            errorMessage = xhr.responseJSON.error;
          } else {
            title = 'Unexpected Error';
            errorMessage = 'An unexpected error occurred.';
          }

          target.removeAttr("disabled");
          toggleLoader("hide");

          Swal.fire({
            icon: 'error',
            title: title,
            html: errorMessage,
          });
        }
      });
    }
  });

}

// Cron Job For Latest Feed

function getSearchDataForCron() {
  const formData = new FormData;
  formData.append("cron", true);
  $.ajax({
    url: domain + "search/getSearchData.php",
    type: "POST",
    data: formData,
    dataType: "json",
    processData: false,
    contentType: false,
    success: function (xhr) {
      if (xhr.data) {
        search_data = xhr.data;
      }

      // setTimeout(function () {
      //   searchjson = [];
      //   if(dataID.length!=0) {
      //     for(var i=0;i<search_data.length;i++){
      //       if(search_data[i]['category']==current_group)
      //         searchjson.push(search_data[i]);
      //     }
      //   } else {
      //     searchjson = search_data;
      //   }
      //   displaySearch(searchjson);
      //   search_stat(searchjson);
      // }, 1000);
    },
    error: function (xhr) {
      const response = xhr.responseJSON;
    }
  });

}

setInterval(() => {
  getSearchDataForCron();
}, 6000);

///------------------------------------ VOTING ------------------------------------------------///

// Exemple d'utilisation avec votre JSON

var optionsCountByQuestion = null;
setTimeout(() => {
  optionsCountByQuestion = countOptionsForQuestions(json);
  optionsCountByQuestion.forEach(questionText => {
    const questionOptions = optionsCountByQuestion[questionText];


  });
}, 2000);
function voting() {


  // var votingModal = document.querySelector('#voting .modal-body');
  // var content = '';

  // questions.forEach((Element, index) => {
  //   content += '<div class="card"><div class="card-header">' + Element.question + '</h3></div>';
  //   content += '<div class="card-body p-0"><table class="table"><thead><tr><th style="width: 10px">#</th>';
  var votingModal = document.querySelector('#voting .modal-body');
  var content = '';

  optionsCountByQuestion.forEach((questionObj, index) => {
    content += '<div class="card"><div class="card-header">' + questionObj.question[0].libelle + '</h3></div>';
    content += '<div class="card-body p-0"><table class="table"><thead><tr><th style="width: 10px">#</th>';
    content += '<th>Options</th><th style="width: 40px">Count</th><th>Action</th></tr></thead><tbody> ';

    const answersOccurrences = questionObj.question[0].answers;
    answersOccurrences.sort((a, b) => b.number - a.number); // Tri par ordre décroissant
    answersOccurrences.forEach((answerObj, id) => {
      content += '<tr><td>' + (id + 1) + '.</td><td>' + answerObj.title + '</td>';
      content += '<td><span class="badge bg-primary">' + answerObj.number + '</span></td><td><button type="button" value="' + answerObj.title + '" data-question="' + questionObj.question[0].libelle + '" class="btn btn-sm bg-gradient-dark options">';
      content += '<i class="fa-solid fa-filter"></i> Filter Leads</button></td></tr>';
    });

    content += '</tbody></table></div></div>';
  });

  votingModal.innerHTML = content;
}

setTimeout(voting, 3000);


///filter user by question & answer 


var filteransawerselect = document.querySelectorAll('.options');
setTimeout(() => {
  let activeButton = null;

  document.querySelectorAll('.options').forEach(button => {
    button.addEventListener('click', function (event) {
      const selectedAnswer = this.value;
      const selectedQuestion = this.getAttribute('data-question');

      const filteredJSON = json.filter((item) => {
        return item.question.some((question) => {
          const questionText = question.question ? question.question.trim() : "Questions without libelle";
          return question.answers.some((answer) => {
            const regex = new RegExp(`.*${selectedAnswer.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}.*`);
            return questionText === selectedQuestion && regex.test(answer);
          });
        });
      });


      const isButtonActive = this === activeButton;

      if (activeButton) {
        activeButton.classList.remove('bg-gradient-info');
        activeButton.classList.add('bg-gradient-dark');
        // if (activeButton === this) {
        //  displayelemnt(json);
        // } 
      }

      activeButton = isButtonActive ? null : this;
      this.classList.toggle('bg-gradient-info', !isButtonActive);
      this.classList.toggle('bg-gradient-dark', isButtonActive);

      if (isButtonActive) {
        setTimeout(datajson, 1000);
        intervall = setInterval(datajson, 30000);
      } else {
        var jsons = filteredJSON;

        json.forEach((element, index) => {

          let exist = 0;
          for (let i = 0; i < jsons.length; i++) {
            if (jsons[i].id == element.id) {
              exist += 1;
              break;
            }
          }

          if (exist == 0) {
            $('.' + (index + 1)).hide();
          }
          else {
            $('.' + (index + 1)).show();
          }

        });

        searched = true;
        clearInterval(intervall);
      }

    });
  });


}, 4000);


function countOptionsForQuestions(json) {
  const questionOptionsCount = [];

  json.forEach(item => {
    item.question.forEach(question => {
      // const questionText = question.question.trim();
      // const existingQuestionIndex = questionOptionsCount.findIndex(q => q.question[0].libelle === questionText);
      const questionText = question.question ? question.question.trim() : "Questions without libelle";
      const existingQuestionIndex = questionOptionsCount.findIndex(q => q.question[0].libelle === questionText);

      if (existingQuestionIndex === -1) {
        const questionObj = {
          libelle: questionText,
          answers: []
        };

        question.answers.forEach(answer => {
          const answerText = answer.trim();
          if (answerText !== "") {
            questionObj.answers.push({ title: answerText, number: 1 });
          }
        });

        questionOptionsCount.push({ question: [questionObj] });
      } else {
        const existingQuestion = questionOptionsCount[existingQuestionIndex].question[0];
        question.answers.forEach(answer => {
          const answerText = answer.trim();
          if (answerText !== "") {
            const existingAnswerIndex = existingQuestion.answers.findIndex(a => a.title === answerText);
            if (existingAnswerIndex === -1) {
              existingQuestion.answers.push({ title: answerText, number: 1 });
            } else {
              existingQuestion.answers[existingAnswerIndex].number++;
            }
          }
        });
      }
    });
  });

  return questionOptionsCount;
}




/////////// --------------------- BOOKING ----------------------------------

$(document).ready(function() {
	var type_booking = $('#type_booking').val();
	if (type_booking === 'event') {
		$('#slot, #test1, .test1, .users_booking').hide();
		$('.event').show();
	}
	else {
		$('#slot, #test1, .test1, users_booking').show();
		$('.event').hide();
	}

  $('#type_booking').change(function() {
    var type_booking = $(this).val();
    if (type_booking === 'event') {
      $('#slot, #test1, .test1, .users_booking').hide();
      $('.event').show();
      // ...
    } else {
      $('#slot, #test1, .test1, .users_booking').show();
      $('.event').hide();
      // ...
    }
  });
});


var bookings = '';var bookingdays ='';
$.ajax({
  url: domain + "getservices.php",
  dataType: "json",
  success: function (data) {
    bookings = data;
 bookingdays = bookings[0].days;
    // setTimeout(function () {
    //   displayTemplate(templates);
    // }, 2000);

    // setTimeout(function () {
    //   message_stats();
    // }, 1000);

  }
});
//save booking
$(document).ready(function () {


var submitbook = document.querySelector("#btnBooking")

// var templateEmail = document.getElementById('templateEmail');
var type = document.getElementById('type_booking');
var users = document.getElementById('user_per_slot');
var slot = document.getElementById('slot_booking');


submitbook.addEventListener('click', function (e) {
  e.preventDefault();

  var dayData = {};
  
var tableElement = document.getElementById("test1");

if (tableElement) {
  var activeCells = tableElement.querySelectorAll('.scheduler-active');
  
  var tempDayData = {};

  activeCells.forEach(function(cell) {
    var day = cell.parentNode.querySelector('.scheduler-day-toggle').textContent;
    var hour = parseInt(cell.getAttribute('data-col')); 
    if (!tempDayData[day]) {
      tempDayData[day] = [];
    }
    
    if (tempDayData[day].length === 0) {
      tempDayData[day].push({ start: hour, end: hour });
    } else {
      var currentInterval = tempDayData[day][tempDayData[day].length - 1];
      if (hour === currentInterval.end + 1) {
        currentInterval.end = hour; 
      } else {
        tempDayData[day].push({ start: hour, end: hour });
      }
    }
  });
  
  var dayData = [];

  for (var day in tempDayData) {
    dayData.push({
      "day": day,
      "times": tempDayData[day].map(function(interval) {
        return interval.start === interval.end
          ? interval.start.toString()
          : interval.start + '-' + interval.end;
      })
    });
  }

  //console.log(JSON.stringify(dayData, null, 2));
} else {
    console.log("Table non trouvée.");
  }


var service = [];
// Sélectionnez l'élément de la table avec l'ID "myTable"
var tableElement = document.getElementById("myTable");

// Vérifiez si l'élément a été trouvé
if (tableElement) {
  // Sélectionnez toutes les lignes de données dans le corps du tableau
  var rows = tableElement.querySelectorAll('tbody tr');

  // Créez un tableau pour stocker les données
  

  // Parcourez chaque ligne de données
  rows.forEach(function (row) {
    var name = row.querySelector('.name').value;
    var price = row.querySelector('.price').value;
    var url = row.querySelector('.picture').value;
var dateevent = row.querySelector('.dateevent').value;
let partiesDateevent = '';
 partiesDateevent = dateevent.split('-'); 
dateevent= partiesDateevent[2] + '-' + partiesDateevent[1] + '-' +partiesDateevent[0] ;
var timeevent = row.querySelector('.timeevent').value;
var ticketsevent = row.querySelector('.ticketsevent').value;
    if (name.trim() !== "") {
      var entry = {
        "name": name,
        "price": price , // Si le prix est vide, définissez-le à 0 ? parseInt(price) : 0
        "url": url || "" ,
        "dateevent": dateevent || "",
        "timeevent": timeevent || "",
        "ticketsevent": ticketsevent || ""
      };
      service.push(entry);
    }
  });

  console.log(service);
} else {
  console.log("service undefined.",dayData.length,service.length);
}
//console.log("service undefined.",dayData.length,service.length);


var data = false;
if(type.value == 'booking' )
{  
  if (type.value == '' || slot.value == '' || dayData.length <=0 ||  service.length <=0 ) {
    if (type.value == '') {
      type.style.borderColor = 'red'
    } else { type.style.borderColor = 'green' }
    if (slot.value == '') {
      slot.style.borderColor = 'red'
    } else { slot.style.borderColor = 'green' }
     if (dayData.length <=0 ) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Select times first',
        timer: 2000,
          timerProgressBar: true
      });
    } 

 }
 else {
  data = 'booking';
 }
}

if(type.value == 'event' )
{
  if (type.value == '' || service.length <=0 ) {
    if (type.value == '') {
      type.style.borderColor = 'red'
    } else { type.style.borderColor = 'green' }
    if (slot.value == '') {
      slot.style.borderColor = 'red'
    } else { slot.style.borderColor = 'green' }
     if (date.value == '' || time.value == '') {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Select date and time',
        timer: 2000,
          timerProgressBar: true
      });
    } 

 }
 else {
  data = 'event';
 }
}

 if(data) { 
  if(data == 'booking')
   {const date = new Date();
    const formattedDate = date.toLocaleDateString() + ' / ' + date.getHours() + ':' + date.getMinutes();
    var formData = {
      id: bookings.length + 1,
      type: type.value,
      users: users.value,
      slot: slot.value,
      days: dayData,
      services:service,
      date:formattedDate
    }; 
  }
  if(data == 'event')
   {
    const today = new Date();
    const formattedDate = today.toLocaleDateString() + ' / ' + today.getHours() + ':' + today.getMinutes();
    var formData = {
      id: bookings.length + 1,
      type: type.value,
      users: users.value,
      slot: '',
      days: [],
      services:service,
      date:formattedDate
     }; 
  }
console.log(dayData);


    $.ajax({
      type: 'POST',
      url: 'save.php',
      data: { booking: JSON.stringify(formData) },
      success: function (response) {
        // console.log(response);
        Swal.fire({
          icon: 'success',
          title: 'Congratulation',
          text: 'Booking services added',
          timer: 3000,
            timerProgressBar: true
        });

          // Call the function 
         // updateSelectOptions();
          
      },
      error: function () {
        console.error('Error issue');
      }
    });


  }

});


var editSetting = document.getElementById('editBookingsetting');
editSetting.addEventListener("click", function(){
var days = [];

function processDayInput(input, dayName, daysArray) {
  if (input.value !== '') {
      let day_hours = { day: dayName, times: [] };
      let times = input.value.split(',');
      times.forEach(time => {
          if (time) {
              day_hours.times.push(time);
          }
      });
    
    if(day_hours.times.length)  {  daysArray.push(day_hours);}
  }
}

processDayInput(monday, 'MONDAY', days);

processDayInput(tuesday, 'TUESDAY', days);
processDayInput(wednesday, 'WEDNESDAY', days);
processDayInput(thursday, 'THURSDAY', days);
processDayInput(friday, 'FRIDAY', days);
processDayInput(saturday, 'SATURDAY', days);
processDayInput(sunday, 'SUNDAY', days);
console.log(days);

slot_editbooking =  document.getElementById('slot_editbooking');

bookings[0].days = days;
bookings[0].slot=slot_editbooking.value;
        //  console.log(bookings[0]);


    $.ajax({
      type: 'POST',
      url: 'save.php',
      data: { booking: JSON.stringify(bookings[0]) },
      success: function (response) {
        //  console.log(response);
        //updateTemplate();
        Swal.fire({
          icon: 'success',
          title: 'Congratulation',
          text: 'Booking services updated',
          timer: 3000,
            timerProgressBar: true
        });

          // Call the function 
         // updateSelectOptions();
          
      },
      error: function () {
        console.error('Error issue');
      }
    });
});
});

$.ajax({
  url: domain + "getbooking.php",
  dataType: "json",
  success: function (data) {
    setTimeout(function () {
      userbookings = [];
      if(dataID.length!=0) {
        for(var i=0;i<data.length;i++){
          if(data[i]['groups'].includes(current_group))
            userbookings.push(data[i]);
        }
      } else {
        userbookings = data;
      }
      displayBooking(userbookings);
      booking_stat(userbookings);
    }, 1000);

  }
});

function displayBooking(json) {

  //var data = JSON.parse(json);
  var thead = document.querySelector('#bookingth');
  var tbody = document.querySelector('#bookingtab');
  var tr = '';
  var StatusBtnVal = '';
  json.forEach((Element, index) => {
    var a = '';
    var StatusArr = [];
    const age = calculateAge(Element.birthday);
    let existe = 0;
    if (index == 0) {
      tr += '<tr data-widget="expandable-table" class="booking' + (index + 1) + '" aria-expanded="true">';
    } else {
      tr += ' <tr data-widget="expandable-table" class="booking' + (index + 1) + '" aria-expanded="false">';
    }
    if(dataID.length==0) tr += '<td><input type="checkbox" name="delete-booking" id="" value="' + index + ' " class="delete-booking" /></td>';
    tr += '<td>' + (index + 1) + '</td>';
    if(dataID.length==0||dataID.includes('0')) tr += '<td><p style="width:90px;">' + Element.fullName + '</p></td>';
   
    if(dataID.length==0||dataID.includes('1')) tr += '<td><p style="width:90px;"><a href="' + Element.website + '" target="_blank"onclick="openWebsitePopup(event)">' + Element.website + ' </a></p></td>';
    if(dataID.length==0||dataID.includes('2')) {
      tr += '<td><p style="width:110px;">' + Element.number + '<br>';
      var cleanNumber = Element.number.replace("+", "");
      // change number beginning from 07 to 447
      var qrNumber = cleanNumber.replace(/^447/, '07');
      tr += '<p><img src="https://chart.googleapis.com/chart?cht=qr&chs=100x100&chl=tel:+' + qrNumber + '"></p><p><a aria-label="Chat on WhatsApp" class="btn btn-sm btn-success" href="https://wa.me/' + cleanNumber + '"onclick="openWhatsAppPopup(event)" ><i class="fa-brands fa-whatsapp"></i></i> WhatsApp<a/></p></td>';
    }
    if(dataID.length==0||dataID.includes('3')) tr += '<td><p style="width:90px;">' + Element.email + '</p></td>';

    const dateTimeString = Element.dateofbooking;
    const [datePart, timePart] = dateTimeString.split("/");
    const [day, month, year] = datePart.split("-").map(Number);
    const formattedDate = new Date(year, month - 1, day);
    const optionsDate = { weekday: "short", month: "short", day: "numeric", year: "numeric" };
    const formattedDateString = formattedDate.toLocaleDateString("en-US", optionsDate);
    const formattedTime = timePart;
    const formattedDateTime = `${formattedDateString} ${formattedTime}`;
    if(dataID.length==0||dataID.includes('4')) tr += '<td><p style="width:90px;">' + Element.location + '</p></td>';
    if(dataID.length==0||dataID.includes('5')) tr += '<td><p style="width:75px;">' + Element.booking + '<br> ' + formattedDateTime + '</p></td>';
    if(dataID.length==0||dataID.includes('6')) {
      if (Element.verified == 'true') {
        tr += '<td><span style="cursor:pointer;" class="badge bg-secondary ">Confirmed</span></td>';
      } else { tr += '<td><b>Pending</b></td>'; }
    }

    if(dataID.length==0||dataID.includes('7')) {
      if (Element.unsubscribed == 'true') {
        tr += '<td><span style="cursor:pointer;"  st' + (index + 1) + '" class="badge bg-info">Unsubscribed</span></td>';
        existe++;
      }
      else {
        for (let i = 0; i < bookingsts.length; i++) {
          const statusObj = bookingsts[i];
          const statusKey = Object.keys(statusObj)[0];
          const statusValue = statusObj[statusKey];
          StatusArr[statusKey] = statusValue;
          a += '<a class="dropdown-item bg-' + statusValue + '" onclick="togglebookingstatut(' + index + ', \'' + statusKey + '\')">'+statusKey+'</a>';

  /*
          if (Element.status === statusKey) {
            tr += '<td><span style="cursor:pointer;" onclick="togglebookingstatut(' + index + ')" class="badge bg-' + statusValue + ' st' + (index + 1) + '">' + Element.status + '</span></td>';
            existe++;
            break;
          }
  */
        }
        StatusBtnVal = StatusArr[Element.status];
        tr += '<td>' +
            '<div class="btn-group">' +
            '<button type="button" class="btn btn-'+StatusBtnVal+'">'+Element.status+'</button><button type="button" class="btn btn-'+StatusBtnVal+' dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false"><span class="sr-only">Toggle Dropdown</span></button>' +
            '<div class="dropdown-menu" role="menu" style="">' +
            a +
            '</div>' +
            '</div>' +
            '</td>';

      }
    }
/*
    if (existe == 0) {
      const firstStatus = bookingsts[0];
      const firstStatusKey = Object.keys(firstStatus)[0];
      const firstStatusValue = firstStatus[firstStatusKey];

      tr += '<td><span style="cursor:pointer;" onclick="togglebookingstatut(' + index + ')" class="badge bg-' + firstStatusValue + ' st' + (index + 1) + '">' + firstStatusKey + '</span></td>';
    }
*/

    if(dataID.length==0||dataID.includes('8')) tr += '<td><button class="m-1 btn btn-block btn btn-info btn-sm" onclick="editBooking(' + index + ')" data-toggle="modal" data-target="#edituserbooking"><i class="fas fa-pencil-alt"></i> Edit</button><button class="m-1 btn btn-block btn btn-danger btn-sm" onclick="deleteBooking(' + index + ')" ><i class="fas fa-trash"></i> Delete</button></td>';
    tr += '</tr>';
    tr += '<tr class="expandable-body ' + (index + 1) + '"><td style = "padding:12px !important" colspan = "12"> ';
    tr += '<span>';
    
    Element.question.forEach((quest, position) => {
      tr += ' <h5>' + quest.question + '</h5><p class="text-muted">';
      quest.answers.forEach((answer) => {
        tr += answer + '<br>';
      });
      tr += quest.comment; tr += '</p>';
    });
    tr += '<h5>Notes:</h5><p class="text-muted">' + Element.notes + '</p> ';
    tr += '<h5>Groups:</h5><p class="text-muted">';
    Element.groups.forEach((group) => {
      tr += '<small class="badge badge-primary"> ' + group + '  </small>  ';
    });
    tr += '</p> ';
    tr += ' </span>';
    tr += '</td></tr> ';

  });
  tbody.innerHTML = tr;

  var thr = '<tr>';
  if(dataID.length==0) thr += '<th><input type="checkbox" id="allleads" name="delete-all" value="lead" title="select all"></th>';
  thr += '<th>#</th>';
  if(dataID.length==0||dataID.includes('0')) thr += '<td>Name</td>';
  if(dataID.length==0||dataID.includes('1')) thr += '<td>Website</td>';
  if(dataID.length==0||dataID.includes('2')) thr += '<td>Phone</td>';
  if(dataID.length==0||dataID.includes('3')) thr += '<td>Email</td>';
  if(dataID.length==0||dataID.includes('4')) thr += '<td>Location</td>';
  if(dataID.length==0||dataID.includes('5')) thr += '<td>Booking</td>';
  if(dataID.length==0||dataID.includes('6')) thr += '<td>Confirmed</td>';
  if(dataID.length==0||dataID.includes('7')) thr += '<td>Status</td>';
  if(dataID.length==0||dataID.includes('8')) thr += '<td>Actions</td>';
  thr += '</tr>';
  thead.innerHTML = thr;
}

// Delete a booking
function deleteBooking(id) {
  var groups = userbookings[id]['groups'];
  userbookings.splice(id, 1);
  deleted = userbookings;
  if(userbookings===null){
    deleted = [];
  }

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
      data = deleted;
      $.ajax({
        type: 'POST',
        url: 'save.php',
        data: {
          deleteBooking: JSON.stringify(data)
        },
        success: function () {
          setTimeout(displayBooking(userbookings), 1000);
          setTimeout(function () {
            message_stats();
          }, 1000);
          //updateSelectOptions();
          
          var flag = false;
          for(var i=0; i<userbookings.length; i++){
            flag = userbookings[i]['groups'].some(element => {
              return groups.includes(element)
            })
            if(flag) break;
          }
          if(!flag) {
            groups.forEach(group=>deleteClientLink(group))
          }
        },
        error: function () {
          console.error('Error');
        }
      });

      Swal.fire(
        'Deleted!',
        'Your booking has been deleted.',
        'success'
      );

      setTimeout(function () {
        Swal.close();
      }, 1 * 1000);
    }
  });
}

function togglebookingstatut(id,st) {
  //let newStatus = '';
  var booking = userbookings[id];
/*
  let currentStatus = booking.status;

  var statusButton = document.querySelector('.st' + (id + 1));
  const secondStatus = bookingsts[1];
  const secondStatusKey = Object.keys(secondStatus)[0];
  let statusExists = 0;

  for (let index = 0; index < bookingsts.length; index++) {
    const statusKey = Object.keys(bookingsts[index])[0];

    if (booking.status === statusKey) {
      const nextIndex = (index + 1) % bookingsts.length;
      newStatus = Object.keys(bookingsts[nextIndex])[0];
      statusExists++;
      break;
    }
  }

  if (statusExists === 0) {
    newStatus = secondStatusKey;
  }

  for (let i = 0; i < bookingsts.length; i++) {
    const statusObj = bookingsts[i];
    const statusKey = Object.keys(statusObj)[0];
    const statusValue = statusObj[statusKey];

    if (currentStatus === statusKey) {
      statusButton.classList.remove("bg-" + statusValue);
      statusButton.innerText = statusKey;
      break;
    }
  }

  for (let i = 0; i < bookingsts.length; i++) {
    const statusObj = bookingsts[i];
    const statusKey = Object.keys(statusObj)[0];
    const statusValue = statusObj[statusKey];

    if (newStatus === statusKey) {
      statusButton.classList.add("bg-" + statusValue);
      statusButton.innerText = statusKey;
      break;
    }
  }
*/

  booking.status = st;
  userbookings[id] = booking;

  $.ajax({
    type: 'POST',
    url: 'save.php',
    data: {
      deleteBooking: JSON.stringify(userbookings)
    },
    success: function () {
      setTimeout(displayBooking(userbookings), 1000);
      setTimeout(function () {
        booking_stat(userbookings);
      }, 1000);
    },
    error: function () {
      console.error('Error issue');
    }
  });
}

// Delete multiple Bookings

console.log($("#allbookings"));
$('#allbookings').on('click', function (e) {
  if ($(this).is(':checked', true)) {
    $(".delete-booking").prop('checked', true);
  } else {
    $(".delete-booking").prop('checked', false);
  }
});

var deletedBookings = null;
var deleteBookingBtn = document.getElementById('deleteBooking');
var bookingChecked = document.querySelectorAll('input[name="delete-booking"]');
deleteBookingBtn.addEventListener('click', function (event) {
  event.preventDefault();
  var toDelete = [];
  bookingChecked = document.querySelectorAll('input[name="delete-booking"]');
  console.log(bookingChecked);
  bookingChecked.forEach(input => {
    if (input.checked) {
      toDelete.push(input.value);
    }
  });
  var reversedToDelete = toDelete.reverse();
  toDelete.forEach(del => {
    deletedBookings = userbookings;
    deletedBookings.splice(del, 1);
  });
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete all!'
  }).then((result) => {
    if (result.isConfirmed) {
      if(deletedBookings===null){
        deletedBookings=[];
      }
      data = deletedBookings;
      $.ajax({
        type: 'POST',
        url: 'save.php',
        data: {
          deleteBooking: JSON.stringify(data)
        },
        success: function () {
          bookings = deletedBookings;
          setTimeout(displayBooking(bookings), 1000);
          updateSelectOptions();

          setTimeout(function () {
            message_stats();
          }, 1000);
        },
        error: function () {
          console.error('Error issue');
        }
      });
      Swal.fire(
        'Deleted!',
        'Your bookings have been deleted.',
        'success'
      )
      setTimeout(function () {
        Swal.close();
      }, 1 * 1000);
    }
  });
})




///editt booking data


var userbookingedit = null;
var bookingeditid = '';
function editBooking(id) {
  bookingeditid = id;
  userbookingedit = userbookings[id];
  // var InputTitle = document.getElementById('InputName');
  var InputWebsite = document.getElementById('InputbookWebsite');
  var InputEmail = document.getElementById('InputbookEmail');
  var InputPhone = document.getElementById('InputbookPhone');
  var InputLocation = document.getElementById('InputbookLocation');
  // var InputNote = document.getElementById('InputbookNote');
  var InputName = document.getElementById('InputbookName_fck');

  // const selectElement = document.getElementById('editgroup');
  // // options selected
  // for (var i = 0; i < selectElement.options.length; i++) {
  //   var option = selectElement.options[i];
  //   option.selected = false;
  // }

  // InputTitle.value = surveyedit.fullName;
  InputWebsite.value = userbookingedit.website;
  InputEmail.value = userbookingedit.email;
  InputPhone.value = userbookingedit.number;
  InputLocation.value = userbookingedit.location;
  InputName.value = userbookingedit.fullName;

}

//edit

var editbookingsubmit = document.getElementById('editbookingsubmit');
editbookingsubmit.addEventListener('click', function (event) {
  event.preventDefault();
  var name = document.getElementById('InputbookName_fck').value;
  var website = document.getElementById('InputbookWebsite').value;
  var email = document.getElementById('InputbookEmail').value;
  var phone = document.getElementById('InputbookPhone').value;
  var location = document.getElementById('InputbookLocation').value;

  //save
  if (userbookingedit) {
    userbookingedit.fullName = name;
    userbookingedit.website = website;
    userbookingedit.number = phone;
    userbookingedit.email = email;
    userbookingedit.location = location;
    //surveyedit.date = 
    userbookings[bookingeditid] = userbookingedit;
    
      data = userbookings;
      $.ajax({
        type: 'POST',
        url: 'save.php',
        data: {
          deleteBooking: JSON.stringify(data)
        },
        success: function () {
          // console.log('Data saved');
          setTimeout(displayBooking(data), 1000);

          editbookingsubmit.innerHTML = '<i class="fas fa-check"></i> Saved';
          editbookingsubmit.classList.remove("btn-primary");
          editbookingsubmit.classList.add("btn-success");

          setTimeout(function () {
            editbookingsubmit.innerText = 'Save changes';
            editbookingsubmit.classList.remove("btn-success");
            editbookingsubmit.classList.add("btn-primary");
          }, 3000);

          // setTimeout(function() {
          //   $('#closemodale1').click();
          // }, 3000); 


        },
        error: function () {
          console.error('Error issue');
        }
      });

  }

});



//search_booking
var search_booking = false;
var searchBtn = document.getElementById('search');
var input = document.getElementById('booking_keyword'); 

input.addEventListener('input', function (e) {
  e.preventDefault();
  var keyword = document.getElementById('booking_keyword').value; 
  if(keyword){
  searchbooking(keyword);
}
});

function searchbooking(keyword) {
  var userbookingsfiltered = filterUserBookings(keyword, userbookings); 

  userbookings.forEach((booking, index) => {
    let exist = 0;
    for (let i = 0; i < userbookingsfiltered.length; i++) { 
      if (userbookingsfiltered[i].id == booking.id) { 
        exist += 1;
        break;
      }
    }

    if (exist == 0) {
      $('.booking' + (index + 1)).hide();
    } else {
      $('.booking' + (index + 1)).show();
    }
  });

  search_booking = true;
  // clearInterval(intervall);
  // intervall = null;
}

function filterUserBookings(query, data) { 
  var filteredUserBookings = data.filter(function (entry) {
    var fullNameMatch = entry.fullName.toLowerCase().includes(query.toLowerCase());
    var websiteMatch = entry.website.toLowerCase().includes(query.toLowerCase());
    var phoneMatch = entry.number.toLowerCase().includes(query.toLowerCase());
    //var groupMatch = entry.groups.includes(query);
    return fullNameMatch || websiteMatch || phoneMatch ;
    //  || groupMatch
  });

  return filteredUserBookings;
}

$(document).ready(function () {
  $('#bookingfiltergroup').on("change", function (e) { // Remplace 'filtergroup' par 'bookingfiltergroup'
    var filterselect = document.getElementById('bookingfiltergroup'); // Remplace 'filtergroup' par 'bookingfiltergroup'
    if (filterselect.value != '') {
      searched = true;
      searchByGroup = true;
      searchUserBookingsByGroup(filterselect.value); // Remplace 'searchBookingsByGroup' par 'searchUserBookingsByGroup'

      clearInterval(intervall);
    } else {
      searched = false;
      searchByGroup = false;
      setTimeout(datajson, 1000);
      intervall = setInterval(datajson, 40000);
    }
  });
});

var filterselect = document.getElementById('bookingfiltergroup'); // Remplace 'filtergroup' par 'bookingfiltergroup'
filterselect.addEventListener('change', () => {
  if (filterselect.value != '') {
    searched = true;
    searchByGroup = true;
    searchUserBookingsByGroup(filterselect.value); // Remplace 'searchBookingsByGroup' par 'searchUserBookingsByGroup'

    clearInterval(intervall);
  } else {
    searched = false;
    searchByGroup = false;
    setTimeout(datajson, 1000);
    intervall = setInterval(datajson, 40000);
  }
});

function searchUserBookingsByGroup(groupname) { // Remplace 'searchBookingsByGroup' par 'searchUserBookingsByGroup'
  for (let i = 0; i < userbooking.length; i++) { // Remplace 'bookingsData' par 'userbooking'
    let exist = 0;
    if (userbooking[i].groups.includes(groupname)) { // Remplace 'bookingsData' par 'userbooking'
      $('.booking' + (i + 1)).show();
    } else {
      $('.booking' + (i + 1)).hide();
    }
  }
}



setTimeout(() =>  {

var activeHours = bookingdays 

function activateHours(day, times) {
  var $dayRow = $(".scheduler-day-toggle:contains('" + day + "')").parent();

  times.forEach(function (timeRange) {
      var parts = timeRange.split("-");
      if (parts.length === 1) {
          var singleTime = parseInt(parts[0]);
          var hours = $dayRow.find(".scheduler-hour[data-col='" + singleTime + "']");
          hours.addClass("scheduler-active");
          // console.log(hours);
      } else if (parts.length === 2) {
          var start = parseInt(parts[0]);
          var end = parseInt(parts[1]);
          for (var i = start; i <= end; i++) {
              var hours = $dayRow.find(".scheduler-hour[data-col='" + i + "']");
              hours.addClass("scheduler-active");
              //  console.log(hours);
          }
      }
  });
}

activeHours.forEach(function (entry) {
  activateHours(entry.day, entry.times);
});

}, 5000);


refreshbookingdata = null;
setInterval(() => {
  if (!search_booking) {
    $.ajax({
      url: domain + "getbooking.php",
      dataType: "json",
      success: function (data) {
        userbookings = data;
        setTimeout(function () {
          displayBooking(userbookings);
        }, 2000);
    
        setTimeout(function () {
          booking_stat(userbookings);
        }, 1000);
    
      }
    });  
  } else {
    
  }
}, 10000);


setInterval(() => {
  if (!searched) {
    $.ajax({
      url: domain + "getdata.php",
      dataType: "json",
      success: function (data) {
        json = [];
        if(dataID.length!=0) {
          for(var i=0;i<data.length;i++){
            if(data[i]['groups'].includes(current_group))
              json.push(data[i]);
          }
        } else {
          json = data;
        }
        // console.log(json);
        setTimeout(function () {
          displayelemnt(json);
        }, 1000);
  
        setTimeout(function () {
          leads_stat(json);
        }, 1000);
      }
    });  
  } else {
    
  }
}, 10000);

$("#category_create_btn").click(function() {
  toggleLoader("show");
  $(this).attr("disabled", true);
  savingCategory(this, "new");
})
$("#category_delete_btn").click(function() {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!"
  }).then((result) => {
    if (result.isConfirmed) {
      toggleLoader("show");
      $(this).attr("disabled", true);
      savingCategory(this, "delete");
    }
  });
});
async function savingCategory(submitBtn, method) {
  try {
    var responseCategories = await saveCategory(method);
    if (responseCategories == 'Success') {
      toggleLoader("hide");
      $(submitBtn).removeAttr("disabled");

      Swal.fire({
        icon: 'success',
        title: 'Updated Successfully!',
        html: 'The Category has been updated successfully',
        timer: 3000,
        timerProgressBar: true
      });
    }
  } catch (error) {
    toggleLoader("hide");
    $(submitBtn).removeAttr("disabled");

    const { title, errorMessage } = error;
    Swal.fire({
      icon: 'error',
      title: title,
      html: errorMessage,
    });
  }
}
function saveCategory(method) {
  const createForm = document.getElementById("category_create_form");
  const deleteForm = document.getElementById("category_delete_form");
  const formData = new FormData(method==="new"?createForm:deleteForm);
  formData.append("method", method);
  return new Promise(function (resolve, reject) {
    $.ajax({
      url: domain + `search/${method==="new"?"saveSearchData":"deleteSearchData"}.php`,
      type: "POST",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (xhr) {
        // Append Categories
        var category = xhr.category;
        categories = category;
        if(xhr.data) search_data = xhr.data;
        var categorySelectItems ="";
        for(var i=0;i<category.length;i++){
          categorySelectItems+= `<option value="${category[i]}">${category[i]}</option>`;
        }
        $('#search_category_select').html(categorySelectItems);
        $('#linkfiltergroup').html('<option value="">- SELECT CATEGORY OR RESET-</option>'+categorySelectItems);

        resolve(xhr.message);
      },
      error: function (xhr) {
        const response = xhr.responseJSON;
        var title = '';
        var errorMessage = '';

        if (response && response.errors) {
          var errors = response.errors;
          title = 'Error!';
          errorMessage = errors.join('<br>');
        } else {
          title = 'Unexpected Error';
          errorMessage = 'An unexpected error occurred.';
        }

        reject({ message: response?.message ?? 'Error', title: title, errorMessage: errorMessage });
      }
    });
  });
}

$("#RSS_feed_field").hide();
$('#search_type').change(function(){
  if($(this).val()=="rss"){
    $("#RSS_feed_field").show();
    $("#network_field").hide();
    $("#keyword_field").hide();
  } else {
    $("#RSS_feed_field").hide();
    $("#network_field").show();
    $("#keyword_field").show();
    $("#search_rss").val("");
  }
})
$("#select_template_btn").click(function() {
  toggleLoader("show");
  $(this).attr("disabled", true);
  saveTemplate();
})
function saveTemplate() {
  const formData1 = new FormData;
  formData1.append("cron", true);
  $.ajax({
    url: domain + "search/getSearchData.php",
    type: "POST",
    data: formData1,
    dataType: "json",
    processData: false,
    contentType: false,
    success: function (xhr) {
      if (xhr.data) {
        var searchData = xhr.data;
        var post = searchData.filter(item=>item.id===$("#post_id").val())[0];

        const date = new Date();
        const formattedDate = date.toLocaleDateString() + ' / ' + date.getHours() + ':' + date.getMinutes();
        const formData = {
          id: templates.length + 1,
          group: $("#template_group").val(),
          image: post.imageUrl,
          title: post.title,
          content: post.description,
          url: post.link,
          sendemail: false,
          sendsms: false,
          sendpush: false,
          date: formattedDate
        };
        
        $.ajax({
          url: domain + `save.php`,
          type: "POST",
          data: { template: JSON.stringify(formData) },
          success: function (response) {
            Swal.fire({
              icon: 'success',
              title: 'Congratulation',
              text: 'Template added',
            });
            
            updateTemplate();
            // Call the function 
            updateSelectOptions();
    
            toggleLoader("hide");
            $(submitBtn).removeAttr("disabled");
          },
          error: function () {
            console.error('Error issue');
            toggleLoader("hide");
            $(submitBtn).removeAttr("disabled");
          }
        });
      }
    }
  });
}

function loaddatalist(group, arr=[]) {
  var datalist = "";
  switch (group) {
    case "leads":
      datalist = `
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="0" name="name" id="todoCheck0" ${arr.includes('0')?"checked":""}>
            <label for="todoCheck0"></label>
          </div>
          <span class="text">Name</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="1" name="age" id="todoCheck1" ${arr.includes('1')?"checked":""}>
            <label for="todoCheck1"></label>
          </div>
          <span class="text">Age</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="2" name="website" id="todoCheck2" ${arr.includes('2')?"checked":""}>
            <label for="todoCheck2"></label>
          </div>
          <span class="text">Website</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="3" name="phone" id="todoCheck3" ${arr.includes('3')?"checked":""}>
            <label for="todoCheck3"></label>
          </div>
          <span class="text">Phone</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="4" name="email" id="todoCheck4" ${arr.includes('4')?"checked":""}>
            <label for="todoCheck4"></label>
          </div>
          <span class="text">Email</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="5" name="location" id="todoCheck5" ${arr.includes('5')?"checked":""}>
            <label for="todoCheck5"></label>
          </div>
          <span class="text">Location</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="6" name="date" id="todoCheck6" ${arr.includes('6')?"checked":""}>
            <label for="todoCheck6"></label>
          </div>
          <span class="text">Date</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="7" name="confirmed" id="todoCheck7" ${arr.includes('7')?"checked":""}>
            <label for="todoCheck7"></label>
          </div>
          <span class="text">Confirmed</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="8" name="status" id="todoCheck8" ${arr.includes('8')?"checked":""}>
            <label for="todoCheck8"></label>
          </div>
          <span class="text">Status</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="9" name="group" id="todoCheck9" ${arr.includes('9')?"checked":""}>
            <label for="todoCheck9"></label>
          </div>
          <span class="text">Actions</span>					
        </li>
      `;
      break;
    case "bookings":
      datalist = `
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="0" name="name" id="todoCheck0" ${arr.includes('0')?"checked":""}>
            <label for="todoCheck0"></label>
          </div>
          <span class="text">Name</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="1" name="website" id="todoCheck1" ${arr.includes('1')?"checked":""}>
            <label for="todoCheck1"></label>
          </div>
          <span class="text">Website</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="2" name="phone" id="todoCheck2" ${arr.includes('2')?"checked":""}>
            <label for="todoCheck2"></label>
          </div>
          <span class="text">Phone</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="3" name="email" id="todoCheck3" ${arr.includes('3')?"checked":""}>
            <label for="todoCheck3"></label>
          </div>
          <span class="text">Email</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="4" name="location" id="todoCheck4" ${arr.includes('4')?"checked":""}>
            <label for="todoCheck4"></label>
          </div>
          <span class="text">Location</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="5" name="booking" id="todoCheck5" ${arr.includes('5')?"checked":""}>
            <label for="todoCheck5"></label>
          </div>
          <span class="text">Booking</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="6" name="confirmed" id="todoCheck6" ${arr.includes('6')?"checked":""}>
            <label for="todoCheck6"></label>
          </div>
          <span class="text">Confirmed</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="7" name="status" id="todoCheck7" ${arr.includes('7')?"checked":""}>
            <label for="todoCheck7"></label>
          </div>
          <span class="text">Status</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="8" name="group" id="todoCheck8" ${arr.includes('8')?"checked":""}>
            <label for="todoCheck8"></label>
          </div>
          <span class="text">Actions</span>					
        </li>
      `;
      break;
    case "search":
      datalist = `
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="0" name="picture" id="todoCheck0" ${arr.includes('0')?"checked":""}>
            <label for="todoCheck0"></label>
          </div>
          <span class="text">Picture</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="1" name="title" id="todoCheck1" ${arr.includes('1')?"checked":""}>
            <label for="todoCheck1"></label>
          </div>
          <span class="text">Title</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="2" name="settings" id="todoCheck2" ${arr.includes('2')?"checked":""}>
            <label for="todoCheck2"></label>
          </div>
          <span class="text">settings</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="3" name="date" id="todoCheck3" ${arr.includes('3')?"checked":""}>
            <label for="todoCheck3"></label>
          </div>
          <span class="text">Date</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="4" name="status" id="todoCheck4" ${arr.includes('4')?"checked":""}>
            <label for="todoCheck4"></label>
          </div>
          <span class="text">Status</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="5" name="actions" id="todoCheck5" ${arr.includes('5')?"checked":""}>
            <label for="todoCheck5"></label>
          </div>
          <span class="text">Actions</span>
        </li>
      `;
      break;
    case "templates":
      datalist = `
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="0" name="image" id="todoCheck0" ${arr.includes('0')?"checked":""}>
            <label for="todoCheck0"></label>
          </div>
          <span class="text">Image</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="1" name="ulink" id="todoCheck1" ${arr.includes('1')?"checked":""}>
            <label for="todoCheck1"></label>
          </div>
          <span class="text">Link</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="2" name="title" id="todoCheck2" ${arr.includes('2')?"checked":""}>
            <label for="todoCheck2"></label>
          </div>
          <span class="text">Title</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="3" name="Content" id="todoCheck3" ${arr.includes('3')?"checked":""}>
            <label for="todoCheck3"></label>
          </div>
          <span class="text">Content</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="4" name="status" id="todoCheck4" ${arr.includes('4')?"checked":""}>
            <label for="todoCheck4"></label>
          </div>
          <span class="text">Status</span>
        </li>
        <li>
          <div class="icheck-primary d-inline ml-2">
            <input type="checkbox" value="5" name="actions" id="todoCheck5" ${arr.includes('5')?"checked":""}>
            <label for="todoCheck5"></label>
            </div>
            <span class="text">Actions</span>
        </li>
      `;
      break;
    default:
      break;
  }
  return datalist;
}

$("#custom-tabs-one-leads-tab").click(function(){
  var options = '';
  for(var i=0;i<data_groups.length;i++){
    options += '<option value="' + data_groups[i] + '">' + data_groups[i] + '</option>';
  }
  var groupform = '<label for="InputGroup">1. Select Group</label><select style="width:100%" class="form-control" id="linkfiltergroup" name="filtergroup" onchange="linkfilterchange(this)"><option value="">- SELECT GROUP OR RESET-</option>' + options + '</select>';
  $("#group-form").html(groupform);
  $("#data-list").html(loaddatalist('leads'));
  $("#cplLink").val('');
  $("#create-link-type").val("leads");
})

$("#custom-tabs-one-bookings-tab").click(function(){
  var options = '';
  for(var i=0;i<data_groups.length;i++){
    options += '<option value="' + data_groups[i] + '">' + data_groups[i] + '</option>';
  }
  var groupform = '<label for="InputGroup">1. Select Group</label><select style="width:100%" class="form-control" id="linkfiltergroup" name="filtergroup" onchange="linkfilterchange(this)"><option value="">- SELECT GROUP OR RESET-</option>' + options + '</select>';
  console.log(groupform)
  $("#group-form").html(groupform);
  $("#data-list").html(loaddatalist('bookings'));
  $("#cplLink").val('');
  $("#create-link-type").val("bookings");
})

$("#custom-tabs-one-search-tab").click(function(){
  var options = '';
  for(var i=0;i<categories.length;i++){
    options += '<option value="' + categories[i] + '">' + categories[i] + '</option>';
  }
  var groupform = '<label for="InputGroup">1. Select Category</label><select style="width:100%" class="form-control" id="linkfiltergroup" name="filtergroup" onchange="linkfilterchange(this)"><option value="">- SELECT CATEGORY OR RESET-</option>' + options + '</select>';
  $("#group-form").html(groupform);
  $("#data-list").html(loaddatalist('search'));
  $("#cplLink").val('');
  $("#create-link-type").val("search");
})

$("#custom-tabs-one-templates-tab").click(function(){
  var options = '';
  console.log(template_groups)
  for(var i=0;i<template_groups.length;i++){
    options += '<option value="' + template_groups[i] + '">' + template_groups[i] + '</option>';
  }
  var groupform = '<label for="InputGroup">1. Select Group</label><select style="width:100%" class="form-control" id="linkfiltergroup" name="filtergroup" onchange="linkfilterchange(this)"><option value="">- SELECT GROUP OR RESET-</option>' + options + '</select>';
  $("#group-form").html(groupform);
  $("#data-list").html(loaddatalist('templates'));
  $("#cplLink").val('');
  $("#create-link-type").val("templates");
})

var cplBtn = document.getElementById("cplBtn");
var cplLink = document.getElementById("cplLink");

cplBtn.onclick = function(){
  navigator.clipboard.writeText(cplLink.value);
  cplBtn.innerHTML ="COPIED";
  setTimeout(function(){
    cplBtn.innerHTML="COPY";
  }, 3000);
}

const linkform = document.getElementById("link-data-form");
linkform.addEventListener("submit", async (e) => {
  e.preventDefault();
  if($('#linkfiltergroup').val()==""){
    Swal.fire({
      icon: 'error',
      title: "Error issue",
      html: "Please select group",
    });
    return;
  }
  await creatingLink();
});

function creatingLink() {
  const linkformdata = new FormData(linkform);
  var keyword = "";
  for (const pair of linkformdata.entries()) {
    if(pair[0]!="filtergroup" && pair[0]!="link"){
      keyword += pair[1];
    }
  }
  const formData = {
    id: $("#create-link-type").val(),
    group: linkformdata.get('filtergroup'),
    key: keyword,
    link: domain + "c-" + $("#create-link-type").val() + ".php?id=" + makeRandomString(5)
  }
  $.ajax({
    url: domain + "save.php",
    type: "POST",
    data: {linkdata: JSON.stringify(formData)},
    success: function (responsive) {
      cplLink.value = formData['link'];
      $("#cplVisitBtn").attr("href", formData['link']);
      client_links = JSON.parse(responsive);
      Swal.fire({
        icon: 'success',
        title: 'Congratulation',
        text: 'Client link created',
      });
    },
    error: function () {
      console.log("Error issue");
    }
  });
}

function loadLinkData(linkdata){
  linkdata = linkdata.length!=0 ? linkdata : {'key':'',link:''};
  var arr = linkdata['key'].split('');
  $("#data-list").html(loaddatalist($("#create-link-type").val(), arr));
  $("#cplLink").val(linkdata['link'].replace(/\\/g, ''));
  $("#cplVisitBtn").attr("href", linkdata['link'].replace(/\\/g, ''));
}

function linkfilterchange(){
  var group=$("#linkfiltergroup").val();
  var index = 0;
  var flag = false;
  var clientlinks = [];
  for(var i=0; i<client_links.length;i++){
    if(client_links[i]['id']==$("#create-link-type").val())
      clientlinks.push(client_links[i]);
  }
  for(var i=0;i<clientlinks.length;i++){
    if(clientlinks[i].group==group){
      flag = true;
      index = i;
      break;
    }
  }
  
  var linkdata = [];
  if(flag) {
    linkdata = clientlinks[index];
  }
  loadLinkData(linkdata);
}

function deleteClientLink(group) {
  var arr = [];
  for(var i=0;i<client_links.length;i++){
    if(!(client_links[i]['group']==group && client_links[i]['id']==$("#create-link-type").val())){
      arr.push(client_links[i])
    }
  }
  
  $.ajax({
    url: domain + "save.php",
    type: "POST",
    data: {deleteLinkdata: JSON.stringify(arr)},
    success: function () {
      Swal.fire({
        icon: 'success',
        title: 'Delete!',
        text: 'Client link has been deleted',
      });
      loadLinkData("");
      client_links = arr;
    },
    error: function () {
      console.log("Error issue");
    }
  });
}

$("#cplDelBtn").click(function(){
  const group = $("#linkfiltergroup").val();
  deleteClientLink(group);
})