<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>소종 Default팀</title>
<?php
  include 'functions.php';
?>
</head>
<body>
  <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
  <script type = "text/javascript">
    var experimentee = 0;

    var experiments = ["BT", "BC", "LT", "RT", "LC", "RC"];
    var expcounts = [18,20,18,18,20,20]

    var expNum = 0;
    var caseNum = 0;

    function case_reset(){
      caseNum = 0; expNum = 0; 
      dataSave();
    }
    function case_up(){
      if (caseNum<expcounts[expNum]-1) caseNum++; 
      else if (expNum<5) {caseNum=0;expNum++;}
      dataSave();
    }
    function case_down(){
      if (caseNum>0) caseNum--; 
      else if (expNum>0) {expNum--; caseNum=expcounts[expNum]-1;}
      dataSave();
    }
    function refresh(){
      var caseNumText = ("0" + (caseNum+1)).slice(-2);

      var infotext = document.getElementById('infotext');
      infotext.innerHTML = experiments[expNum] + caseNumText;
    }
    function dataSave(){
        var dataForm = document.getElementById('dataForm');
        var inputExpNum = document.getElementById('input_exp_num');
        var inputCaseNum = document.getElementById('input_case_num');

        inputExpNum.value = expNum
        inputCaseNum.value = caseNum;
        dataForm.target="ifrm";
        console.log(inputCaseNum.value);
        dataForm.submit();
    }
  </script>
  <input type="button" id="case_up" onclick="case_up()">case_up</input>
  <input type="button" id="case_down" onclick="case_down()">case_down</input>
  <input type="button" id="reset" onclick="case_reset()">reset</input>
  <h1 id="infotext" style="text-align:center; font-size:30em;line-height:0.3em"> </h1>

  <form id="dataForm" action="changeExpData.php" method="post">
    <iframe name="ifrm" width="0" height="0" frameborder="0"></iframe> 
    <input id="input_exp_num" type="hidden" name="exp_num" value=0>
    <input id="input_case_num" type="hidden" name="case_num" value=0>
    <input type="submit" style="visibility:hidden">
  </form>

  <script type="text/javascript">
  
  timer = setInterval( function () {
    $.ajax ({
        type : "POST",
        url : "expDataPage.php",
        data: {action: 'test'},
        dataType : "json",
        cache : false,
        success : function (data) {
          console.log(data);
          expNum = Number(data['exp_num']);
          caseNum = Number(data['case_num']);
          refresh();
        },
        error: function(xhr, status, error) {
          console.log(xhr + status + " : " + error)
        }
    });
  }, 1000);
  </script>
  
<body>
</html>