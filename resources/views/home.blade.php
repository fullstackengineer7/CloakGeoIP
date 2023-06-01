<!DOCTYPE html>
<html lang="en">

<head>
  @include('partials.header')
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Bingo</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div>   <h1>Title1&nbsp;</h1>   </div>
    <div>   <h1>Title2&nbsp;</h1>   </div>
    <div>   <h1>Title3&nbsp;</h1>   </div>
    <div>   <h1>Title4&nbsp;</h1>   </div>

    @include('partials.navbar')

  </header><!-- End Header -->

  @include('partials.sidebar')

  <main id="main" class="main">

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Your playing field<span>| Today</span></h5>
                  <div style="display: grid;
                            grid-template-columns: 20% 20% 20% 20% 20%;
                            justify-items: center;
                            align-items: center;
                            max-width: 400px; margin: auto;
                  ">
                      @for ($i = 1; $i <= 50; $i++)
                        <button type="button" class="btn btn-outline-info" style="width:50px; height:50px; margin-top: 10px;font-weight: bold;" id="btn_digit_{{$i}}" onclick="onChangeDigit({{$i}})">{{ $i }}</button>
                      @endfor
                     <!--    <button type="button" class="btn btn-outline-info" style="width:50px; height:50px; margin-top: 10px;font-weight: bold;" > </button> -->
                  </div>
                  <hr>

                      <!--   @if ($i % 5 === 0)
                          <br>
                        @endif -->
                  <form style="max-width: 700px;margin: auto;">
                      <div class="row mb-3">
                        <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
                        <div class="col-sm-10">
                          <input type="date" class="form-control" id="bid_date" onChange="onChangeDate(e)">
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Bid</label>
                        <div class="col-sm-10">
                          <select class="form-select" aria-label="Default select example" id="bid_amount" onChange="onChangeBid(e)">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option> 
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="300">300</option>
                            <option value="400">400</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                            <option value="2000">2000</option>
                            <option value="5000">5000</option>
                          </select>
                        </div>
                      </div>
                  </form>
                </div>

              </div>
            </div><!-- End Recent Sales -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Quick-Tipps<!--  <span>| Today</span> --></h5>

              <div class="activity">
                  <div class="activity-content">
                    If you would like to generate suggestions for numbers by quick tip, we provide you with the following selection aid. The probability of winning does not change with your selection.<br>
                  </div>
                  <button type="button" class="btn btn-secondary">Coincidence</button>

              </div>

            </div>
          </div><!-- End Recent Activity -->

          <!-- Budget Report -->
          <div class="card">          

            <div class="card-body pb-0">
              <h5 class="card-title">Budget Report <span>| This Month</span></h5>
              <button onclick="testGameOne()" type="button" class="btn btn-primary rounded-pill" style="display:block;margin: 10px 5px;width: 150px;">Next</button>
              <button onclick="handleSubmit()" type="button" class="btn btn-success rounded-pill" style="margin: 10px 5px; width: 150px;">Submit</button>
              <p>Your stake: <br>
                  plus processing fee</p>
            </div>
          </div><!-- End Budget Report -->

        </div>

      </div>
    </section>

  </main><!-- End #main -->
  <div class="modal fade" id="betting-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="betting-modal-title">Warning</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="betting-modal-content">
          Please select number, date and bet amount fields correctly.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  @include('partials/footer')
  @auth
  <script type="text/javascript">
    var conn = new WebSocket('ws://10.10.12.196:8090/?token={{ auth()->user()->token }}');
    var from_user_id = "{{ Auth::user()->id }}";
    var to_user_id = "";

    conn.onopen = function(e){
      console.log("Connection established!");
      loadUnreadNotifications(from_user_id);
    }

    conn.onmessage = function(e){
        console.log("socket msg from server => ", e.data);
        var data = JSON.parse(e.data);
        if(data.type == "game1_betting_result"){
            if(result.status == true){
                if(result.win == true){
                    $("#betting-modal-title").html("Congratulations!");
                    $("#betting-modal-content").html("You have won " + data.amount +" coins successfully!");
                  } else {                            
                    $("#betting-modal-title").html("Hi!");
                    $("#betting-modal-content").html("You have lost " + data.amount + " coins. Please try again.");
                }
                $("#betting-modal").modal('show'); 
                // alert("res from server" + result.status);
            } else {
                // show warning modal
                $("#betting-modal-title").html("Warning!");
                $("#betting-modal-content").html(result.error);
                $("#betting-modal").modal('show');
            }
        }
    }

    

    const testGameOne = (e) => {
        alert("aa");
        let data = {
            first_name: "firstname", last_name: "lastname", telephone: "telephone",
            email: "email", message: "message", type:"help_from_user", token: "token"
        }
        conn.send(JSON.stringify(data));     
    }

    @endauth
  </script>
</body>

</html>