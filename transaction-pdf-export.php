<?php
  include("bank-control.php");
  include("tools/transaction-control.php");
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="libs/pure-min.css">
    <link rel="stylesheet" href="libs/grids-responsive-min.css">

    <title>Transaction Details PDF</title>

    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            overflow: hidden;
        }

        .menu {
            padding: 0;
            list-style: none;
        }

        .menu li {
            vertical-align: top;
        }

        .menu li a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            font-family: sans-serif;
            padding: 10px 0;
            line-height: 25px;
        }

        .menu li a:hover {
            font-style: italic;
        }

        #panel {
            background: #141f2b;
            padding: 10px;
            height: 100%;
        }

        #wrapper {
            overflow: hidden;
            height: 100%;
            background: rgba(193, 193, 193, 1);
        }

        #output {
            width: 100%;
            height: 100%;
            background: rgba(193, 193, 193, 1);
        }
    </style>

</head>
<body>

<div class="pure-g" style="padding-top: 0px; height: 100%;">
    <div id="wrapper" class="pure-u-1 pure-u-md-5-5">
        <iframe id="output"></iframe>
    </div>
</div>

<script src="libs/jspdf.debug.js"></script>
<script src="libs/faker.min.js"></script>
<script src="libs/jspdf.plugin.autotable.js"></script>
<script src="jspdf.tools.js"></script>

<!-- Some scripts to make the examples work nicely -->
<script>

    var arr_trans_details = [];

</script>
<?php
    if (isset($_SESSION['current_trans_details'])) {
      $trans_details = $_SESSION['current_trans_details'];
      foreach ($trans_details as $trans) {
        $trans_detail = unserialize($trans);
        echo '<script>'.
            'var trans_details = {'.
              'date: "'.$trans_detail->date.'",'.
              'type: "'.$trans_detail->type.'",'.
              'data: "'.$trans_detail->data.'",'.
              'credit: "'.$trans_detail->credit.'",'.
              'debit: "'.$trans_detail->debit.'",'.
              'balance: "'.$trans_detail->balance.'"'.
            '};'.
            'arr_trans_details.push(trans_details);'.
        '</script>';
      }
    }
 ?>
<?php
    $currentDate = date('F j, Y');
    $pastDate = "";
    $acct_no = "";
    $acct_type = "";
    $fullname = "";
    switch ($_SESSION['current_dates']) {
      case "Current": $pastDate = date('F j, Y', strtotime('-1 day')); break;
      case "Last 7 days": $pastDate = date('F j, Y', strtotime('-7 day')); break;
      case "Last 30 days": $pastDate = date('F j, Y', strtotime('-30 day')); break;
      case "Last 3 months": $pastDate = date('F j, Y', strtotime('-3 months')); break;
      case "Last 6 months": $pastDate = date('F j, Y', strtotime('-6 months')); break;
      case "Last 12 months": $pastDate = date('F j, Y', strtotime('-12 months')); break;
      default: break;
    }

    $query = "SELECT account_no, account_type, firstname, lastname FROM acct_type INNER JOIN user_account ON
      user_account.account_type_id=acct_type.idacct_type INNER JOIN personal_info ON user_account.personal_info_id=personal_info.idpersonal_info
      WHERE user_account.iduser_account=".$_SESSION['current_user_acct_id'];
    $result = mysqli_query($link, $query);
    if ($result) {
    		$row = mysqli_fetch_array($result);
    		if ($row) {
          $acct_no = $row['account_no'];
          $acct_type = $row['account_type'];
          $firstname = $row['firstname'];
          $lastname = $row['lastname'];
          $fullname = ucfirst($firstname).' '.ucfirst($lastname);
        }
    }

    echo '<script>'.
        'var fullname = "'.$fullname.'";'.
        'var acctStr = "'.$acct_no.' ('.$acct_type.')";'.
        'var fromDate = "'.$pastDate.'";'.
        'var toDate = "'.$currentDate.'";'.
    '</script>';
 ?>
<script>
    window.onhashchange = function () {
        update();
    };

    function getBase64Image(img) {
        var canvas = document.createElement("canvas");
        canvas.width = img.width;
        canvas.height = img.height;

        var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);
        var dataURL = canvas.toDataURL("image/png");

        return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
    }

    function generatePDF() {

      var doc = new jsPDF('l');
      var totalPagesExp = "{total_pages_count_string}";

      var pageContent = function (data) {
          // HEADER
          doc.setFontSize(20);
          doc.setTextColor(40);
          doc.setFontStyle('normal');
          if (base64Img) doc.addImage(base64Img, 'PNG', data.settings.margin.left, 15, 10, 10);
          doc.text("TyBank Transaction Details", data.settings.margin.left + 15, 22);

          // FOOTER
          var str = "Page " + data.pageCount;
          // Total page number plugin only available in jspdf v1.0+
          if (typeof doc.putTotalPages === 'function') {
              str = str + " of " + totalPagesExp;
          }
          doc.setFontSize(10);
          doc.text(str, data.settings.margin.left, doc.internal.pageSize.height - 10);
      };

      var columns = ["Date", "Transaction Type", "Transaction Data", "Credit", "Debit", "Balance"];
      var data = [];

      for (var i = 0; i < arr_trans_details.length; i++) {
        var details = arr_trans_details[i];
        data.push([details.date, details.type, details.data, details.credit, details.debit, details.balance]);
      }

      doc.setFontSize(10);
      doc.setTextColor(100);
      var text = "\nAccount Name       :  " + fullname +
                 "\nAccount No            :  " + acctStr +
                 "\nTransaction Dates :  " + fromDate + " - " + toDate;
      doc.text(text, 14, 30);
      if (tybanklogoImg) doc.addImage(tybanklogoImg, 'PNG', 245, 4, 40, 40);

      doc.autoTable(columns, data, {
          startY: 50,
          theme: "grid",
          addPageContent: pageContent,
          margin: {top: 30}
      });

      // Total page number plugin only available in jspdf v1.0+
      if (typeof doc.putTotalPages === 'function') {
          doc.putTotalPages(totalPagesExp);
      }

      return doc;

    }

    function update(shouldDownload) {
      var firstname = fullname;
      var doc = generatePDF();

      doc.setProperties({
          title: 'TyBank Transaction Details',
          subject: 'Transaction details of TyBank Account Holder: ' + firstname
      });

      if (shouldDownload) {
          doc.save('transaction-table.pdf');
      }
      else {
          document.getElementById("output").src = doc.output('datauristring');
      }
    }

    imgToBase64('document.png', function(base64) {
        base64Img = base64;
    });

    imgToBase64('tybanklogo.png', function(base64) {
        tybanklogoImg = base64;
        update();
    });

</script>

</body>
</html>
