<?php 
session_start();

if(isset($_SESSION['admin_uid']) || isset($_SESSION['eng_uid']))
{
include_once("header.php");
include_once("db-config.php");

$page_title = " Dashboard";
$sub_page_title = "Dashboard ";

//DB Connections
$con = new mysqli($host, $user,$pass,$db_name);

//Total members
$select_query = "select count(id) as data_count from $hotels_table where status!='E'";
$result = $con->query($select_query) or die(mysqli_error($con));
$data = $result->fetch_array();
$total_hotels = $data['data_count'];

//Total Courses
$select_query = "select count(id) as data_count from $members_table where status!='E'";
$result = $con->query($select_query) or die(mysqli_error($con));
$data = $result->fetch_array();
$total_customers = $data['data_count'];

//Total Events
$select_query = "select count(id) as data_count from $hotel_booking_table where status!='E'";
$result1 = $con->query($select_query) or die(mysqli_error($con));
$data = $result1->fetch_array();
$total_bookings= $data['data_count'];

//Total Teachers
$select_query = "select sum(final_total) as data_sum from $hotel_booking_table where status!='E'";
$result1 = $con->query($select_query) or die(mysqli_error($con));
$data = $result1->fetch_array();
$total_booking_value= $data['data_sum'];

?>
        <section class="section">
          <div class="section-header">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
								<div class="section-header-breadcrumb-content">
									<h1><?php echo $page_title; ?></h1>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
								<div class="section-header-breadcrumb-chart float-right">
									<div class="breadcrumb-chart m-l-50">
										<div class="float-right">
											<div class="icon m-b-10">
												<div class="chart header-bar">
													<canvas width="49" height="40" ></canvas>
												</div>
											</div>
										</div>
										<div class="float-right m-r-5 m-l-10 m-t-1">
											<div class="chart-info">
												<span>$10,415</span>
												<p>Last Week</p>
											</div>
										</div>
									</div>
								
									<div class="breadcrumb-chart m-l-50">
										<div class="float-right">
											<div class="icon m-b-10">
												<div class="chart header-bar2">
													<canvas width="49" height="40" ></canvas>
												</div>
											</div>
										</div>
										<div class="float-right m-r-5 m-l-10 m-t-1">
											<div class="chart-info">
												<span>$22,128</span>
												<p>Last Month</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="card card-sales-widget card-bg-blue-gradient">
                <div class="card-icon shadow-primary bg-blue">
                  <i class="fas fa-user-plus"></i>
                </div>
                <div class="card-wrap pull-right">
                  <div class="card-header">
                    <h3><?php echo $total_hotels; ?></h3>
                    <h4>Total Hotels</h4> 
                  </div>
                </div>
                <div class="card-chart">
                  <div id="chart-1"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="card card-sales-widget card-bg-yellow-gradient">
                <div class="card-icon shadow-primary bg-warning">
                  <i class="fas fa-drafting-compass"></i>
                </div>
                <div class="card-wrap pull-right">
                  <div class="card-header">
                    <h3><?php echo $total_customers; ?></h3>
                    <h4>Total Customers</h4>
                  </div>
                </div>
                <div class="card-chart">
                  <div id="chart-2"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="card card-sales-widget card-bg-orange-gradient">
                <div class="card-icon shadow-primary bg-hibiscus">
                  <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="card-wrap pull-right">
                  <div class="card-header">
                    <h3><?php echo $total_bookings; ?></h3>
                    <h4>Total Bookings</h4>
                  </div>
                </div>
                <div class="card-chart">
                  <div id="chart-3"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
              <div class="card card-sales-widget card-bg-green-gradient">
                <div class="card-icon shadow-primary bg-green">
                  <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap pull-right">
                  <div class="card-header">
                    <h3>₹ <?php echo $total_booking_value; ?></h3>
                    <h4>Total Booking Value</h4>
                  </div>
                </div>
                <div class="card-chart">
                  <div id="chart-4"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Calendar</h4>
                </div>
                <div class="card-body" style="max-height:600px;overflow: auto;">


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
                  </style>
                  <form method="get" id="search_frm">
                     <?php
                     if($_SESSION['uType'] == "SA" || $_SESSION['uType'] == "AD")
                     {
                         ?>
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
                        <?php
                     }
                     ?>
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
                        if($_SESSION['uType'] == "HA")
                        {
                            $select_query = "SELECT id from $hotels_table where hotel_admin_id='$_SESSION[admin_uid]'";
                            $record = $con->query($select_query);
                            $data = $record->fetch_array();
                            
                            $filter = "hotel_id='$data[id]'";
                        }
                        else
                            $filter = "hotel_id='$_GET[hotel_id]'";
                        $select_query = "SELECT * from $hotel_rooms_tables where $filter and status='A'";
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
                      eventMouseover: function(calEvent, jsEvent) {
                          if(calEvent.description != "")
                          {
                            var tooltip = '<div class="tooltipevent" style="width:280px;height:141px;color:#fff;background:#aa66cd;border-top:10px solid #5f1881;border-radius:0px;padding:5px 10px;position:absolute;z-index:10001;">' + calEvent.description + '</div>';
                            var $tooltip = $(tooltip).appendTo('body');

                            $(this).mouseover(function(e) {
                                $(this).css('z-index', 10000);
                                $tooltip.fadeIn('500');
                                $tooltip.fadeTo('10', 1.9);
                            }).mousemove(function(e) {
                                $tooltip.css('top', e.pageY + 10);
                                $tooltip.css('left', e.pageX + 20);
                            });
                          }
                        },

                        eventMouseout: function(calEvent, jsEvent) {
                            $(this).css('z-index', 8);
                            $('.tooltipevent').remove();
                        },
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
                        $select_query = "SELECT rb.*,bk.first_name,bk.email,bk.phone_number,bk.booking_code,bk.created_at from $hotel_room_booking_table rb 
                                          inner join $hotel_booking_table bk on rb.booking_id=bk.id 
                                          where rb.status='A'";
                        $record = $con->query($select_query);
                        while($data = $record->fetch_array())
                        {
                          $checkout_date = date('Y-m-d', strtotime("+1 day", strtotime($data['checkout_date'])));
                          echo "{ id: '$data[booking_id]', resourceId: '$data[room_no_id]', start: '$data[checkin_date]', end: '$checkout_date', title: '$data[first_name] ($data[booking_code])',description: '<table><tr><th>Booking ID</th><td>:</td><td>$data[booking_code]</td></tr><tr><th>Name</th><td>:</td><td>$data[first_name]</td></tr><tr><th>Email</th><td>:</td><td>$data[email]</td></tr><tr><th>Mobile</th><td>:</td><td>$data[phone_number]</td></tr><tr><th>Booked At</th><td>:</td><td>$data[created_at]</td></tr></table>' },";
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
                                                or (checkin_date<='$next_date' and checkout_date>='$next_date')) and status='A'";
                            $result2 = $con->query($select_query2) or die(mysqli_error($con));
                            $count2 = $result2->num_rows;

                            $AVL = $data['num_of_rooms'] - $count2;

                            echo "{ id: 'D$iid', resourceId: 'R$data[id]', start: '$next_date', end: '$next_date', title: '$AVL AVL.',description: '' },";
                          }
                        }
                        ?>
                      ]
                    });
                    
                  });
                  </script>

                </div>
              </div>
            </div>
          </div>
          <!--
          <div class="row">
          	<div class="col-lg-6 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Monthly Sales</h4>
                </div>
                <div class="card-body">
                 	<div id="monthlySalesChart"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Yearly Sales</h4>
                </div>
                <div class="card-body">
                  <div id="yearlySalesChart"></div>
                </div>
              </div>
            </div>
           </div>-->
           <div class="row">
            
            <!--<div class="col-lg-8 col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Invoice details</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Created At</th>
                      </tr>
                      <?php
                      /*$select_query = "select * from $master_notice_board_table where status!='E' order by id asc";
                      $result = $con->query($select_query) or die(mysqli_error($con));
                     if($result->num_rows > 0)
                     {
                      while($data = $result->fetch_array()) 
                      {
                      echo "<tr>
                          <td> $data[title]</td>
                          <td> $data[description]</td>
                          <td> $data[created_at]</td>
                          </tr>";
                      }
                    }*/
                    ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>-->
            
        </section>
		
		<!-- footer -->
<?php 
      include('footer_dashboard.php'); 
      $con->close();
	} else {
		echo "<script>window.location.href='login.php'</script>";
        exit();
	}
?>			
