<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='calendar/fullcalendar.css' rel='stylesheet' />
<!--<link href='https://fullcalendar.io/js/fullcalendar-2.5.0/fullcalendar.print.css' rel='stylesheet' media='print' />-->
<link href='calendar/scheduler.min.css' rel='stylesheet' />
<!--<script src='calendar/moment.min.js'></script>-->
<script src="assets/js/app.min.js"></script>
<script src='calendar/fullcalendar.js'></script>
<script src='calendar/scheduler.js'></script>
<style>
  .fc-license-message
  {
    display: none;
  }
  .popper,
.tooltip {
  position: absolute;
  z-index: 9999;
  background: #FFC107;
  color: black;
  width: 150px;
  border-radius: 3px;
  box-shadow: 0 0 2px rgba(0,0,0,0.5);
  padding: 10px;
  text-align: center;
}
.style5 .tooltip {
  background: #1E252B;
  color: #FFFFFF;
  max-width: 200px;
  width: auto;
  font-size: .8rem;
  padding: .5em 1em;
}
.popper .popper__arrow,
.tooltip .tooltip-arrow {
  width: 0;
  height: 0;
  border-style: solid;
  position: absolute;
  margin: 5px;
}

.tooltip .tooltip-arrow,
.popper .popper__arrow {
  border-color: #FFC107;
}
.style5 .tooltip .tooltip-arrow {
  border-color: #1E252B;
}
.popper[x-placement^="top"],
.tooltip[x-placement^="top"] {
  margin-bottom: 5px;
}
.popper[x-placement^="top"] .popper__arrow,
.tooltip[x-placement^="top"] .tooltip-arrow {
  border-width: 5px 5px 0 5px;
  border-left-color: transparent;
  border-right-color: transparent;
  border-bottom-color: transparent;
  bottom: -5px;
  left: calc(50% - 5px);
  margin-top: 0;
  margin-bottom: 0;
}
.popper[x-placement^="bottom"],
.tooltip[x-placement^="bottom"] {
  margin-top: 5px;
}
.tooltip[x-placement^="bottom"] .tooltip-arrow,
.popper[x-placement^="bottom"] .popper__arrow {
  border-width: 0 5px 5px 5px;
  border-left-color: transparent;
  border-right-color: transparent;
  border-top-color: transparent;
  top: -5px;
  left: calc(50% - 5px);
  margin-top: 0;
  margin-bottom: 0;
}
.tooltip[x-placement^="right"],
.popper[x-placement^="right"] {
  margin-left: 5px;
}
.popper[x-placement^="right"] .popper__arrow,
.tooltip[x-placement^="right"] .tooltip-arrow {
  border-width: 5px 5px 5px 0;
  border-left-color: transparent;
  border-top-color: transparent;
  border-bottom-color: transparent;
  left: -5px;
  top: calc(50% - 5px);
  margin-left: 0;
  margin-right: 0;
}
.popper[x-placement^="left"],
.tooltip[x-placement^="left"] {
  margin-right: 5px;
}
.popper[x-placement^="left"] .popper__arrow,
.tooltip[x-placement^="left"] .tooltip-arrow {
  border-width: 5px 0 5px 5px;
  border-top-color: transparent;
  border-right-color: transparent;
  border-bottom-color: transparent;
  right: -5px;
  top: calc(50% - 5px);
  margin-left: 0;
  margin-right: 0;
}
</style>
</head>
<body>
<?php
include_once("db-config.php");
//DB connect
$con = new mysqli($host, $user,$pass,$db_name);
?>
<form method="get" id="search_frm">
  Hotel: 
  <select class="form-control" name="hotel_id" id="hotel_id" required onchange="getElementById('search_frm').submit();" style="margin:10px;padding:2px;">
    <option value=''>Select Hotel</option>
    <?php
    $select_query = "select id,name as hotel_name,hotel_admin_id from $hotels_table where status!='E'";
    $result = $con->query($select_query) or die(mysqli_error($con));
    while($data = $result->fetch_array())
    {
      if($_GET['hotel_id'] == $data['id'])
        echo "<option value='$data[id]' selected>$data[hotel_name]</option>";
      else
        echo "<option value='$data[id]'>$data[hotel_name]</option>";
    }
    ?>
  </select>
</form>

  <div id='calendar'></div>

  <script type="text/javascript">
    $(function() { // document ready
  
  $('#calendar').fullCalendar({
    resourceAreaWidth: 230,
    now: '<?php echo date('Y-m-d'); ?>',
    editable: false,
    aspectRatio: 1.5,
    scrollTime: '00:00',
    header: {
      left: 'promptResource today prev,next',
      center: 'title',
      right: ''
    },
    firstDay: 1,
    defaultView: 'customWeek',
    views: {
        customWeek: {
            type: 'timeline',
            duration: { weeks: 1 },
            slotDuration: {days: 1},
            buttonText: 'Custom Week'
        }
    },
    resourceLabelText: 'Rooms',
    resources: [
      <?php
      $select_query = "SELECT * from $hotel_rooms_tables where hotel_id='$_GET[hotel_id]' and status='A'";
      $record = $con->query($select_query);
      while($data = $record->fetch_array())
      {
        echo "{ id: 'R$data[id]', title: '$data[name]'";
        $select_rn = "SELECT * from $hotel_room_number_table where room_id='$data[id]' and status='A'";
        $record_rn = $con->query($select_rn);
        if($record_rn->num_rows > 0)
        {
          echo ", children: [";
          while($data_rn = $record_rn->fetch_array())
          {
            $room_no = 10000 + $data_rn['id'];
            echo "{ id: '$data_rn[id]', title: '$room_no', eventColor: 'green' },";
          }
          echo "]";
        }
        echo "},";
      }
      ?>
    ],
     eventDidMount: function(info) {
      var tooltip = new Tooltip(info.el, {
        title: info.event.extendedProps.description,
        placement: 'top',
        trigger: 'hover',
        container: 'body'
      });
    },
    events: [
      <?php
      $select_query = "SELECT rb.*,bk.first_name,bk.booking_code from $hotel_room_booking_table rb 
                        inner join $hotel_booking_table bk on rb.booking_id=bk.id 
                        where rb.status='A'";
      $record = $con->query($select_query);
      while($data = $record->fetch_array())
      {
        $checkout_date = date('Y-m-d', strtotime("+1 day", strtotime($data['checkout_date'])));
        echo "{ id: '$data[booking_id]', resourceId: '$data[room_no_id]', start: '$data[checkin_date]', end: '$checkout_date', title: '$data[first_name] ($data[booking_code])',description: '$data[first_name] ($data[booking_code])' },";
      }

      //AVL Disp
      for($i=-30;$i<=30;$i++)
      {
        $next_date = date("Y-m-d", strtotime("$i day"));
        $iid = 0;
        $select_query = "SELECT * from $hotel_rooms_tables where hotel_id='$_GET[hotel_id]' and status='A'";
        $record = $con->query($select_query);
        while($data = $record->fetch_array())
        {
          $iid++;
          $select_query2 = "SELECT id,room_no_id from $hotel_room_booking_table where room_id='$data[id]' 
                              and ((checkin_date<='$next_date' and checkin_date>='$next_date') 
                              or (checkout_date>='$next_date' and checkout_date<='$next_date')
                              or (checkin_date<='$next_date' and checkout_date>='$next_date')) and status!='E'";
          $result2 = $con->query($select_query2) or die(mysqli_error($con));
          $count2 = $result2->num_rows;

          $AVL = $data['num_of_rooms'] - $count2;

          echo "{ id: 'D$iid', resourceId: 'R$data[id]', start: '$next_date', end: '$next_date', title: '$AVL AVL.',description: '-' },";
        }
      }
      ?>
    ]
  });
  
});
  </script>

</body>
</html>
