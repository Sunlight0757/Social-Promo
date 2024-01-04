<!DOCTYPE html>
<?php require 'config.php' ?>
<html>
  <head>
    <style>
      .note {
        animation-name: fade;
        animation-duration: 4s;
      }
      @keyframes fade {
        from {opacity: 0;}
        to {opacity: 1;}
      }
      .result-success {
        color: green;
      }
      .result-failed {
        color: red;
      }
    </style>
  </head>
  <body onLoad={onLoad()}>
    <div id="demo"></div>
    <script src="src/plugins/jquery/jquery.min.js"></script>
    <script>
      var users = [];
      function onLoad() {
        $.getJSON('<?=datafile?>', function (data) {
          loadData(data);
        });
      }
      
      function loadData(users) {
        var result = users.splice(0, 10);
        console.log(users);
        $.ajax({
          url: 'send-bulk-email.php',
          type: 'POST',
          data: {users: JSON.stringify(result)},
          success: function(response) {
            var data = JSON.parse(response);
            console.log(data);
            // console.log(response);
            if(data.length>0){
              var i=0;
              timer2 = setInterval(function() {
                $('#demo').append(data[i]);
                i++;
                if(i==result.length) {
                  i=0;
                  clearInterval(timer2);
                  if(users.length>0) {
                    loadData(users);
                  }
                }
              }, 1000)
            }
          },
          error: function(xhr, status, error) {
            console.log('AJAX Error:', error);
          }
        });
      }
    </script>
  </body>
</html>