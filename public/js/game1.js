
    console.log("game1 section");
    // $(document).ready(function(){

        let digit = null;
        let prev_digit = null;
        let date = null;
        let bid = 0;
     
        const onChangeDigit = ( num ) => {
            digit = num;
            console.log("digit = ", digit);
            $("#btn_digit_" + num).html('<i class="bi bi-check-circle"/>');
            $("#btn_digit_" + num).css("background","#198754");
            if(prev_digit != null){
                $("#btn_digit_" + prev_digit).html(prev_digit);
                $("#btn_digit_" + prev_digit).css("background","#fff");
            }
            prev_digit = num;
        }

        const onChangeDate = (e) => {
            date = e.target.value;
            console.log("date = ", date);
        }

        const onChangeBid = (e) => {
            bid = e.target.value;
            console.log("bid = ", bid);
        }
        // <!-- AJAX CALL CSRF TOKEN -->
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const handleSubmit = (e) => {
            date = $("#bid_date").val();
            bid = $("#bid_amount").val();
                console.log("digit = " + digit + " , date =  " + date + " , bid = " + bid);
            $.post({ 
                url:'/api/sendBidGame1',
                data:{digit: digit, date:date, bid:bid},
                success: function(result){
                    if(result.status === true){
                        $("#betting-modal-title").html("Congratulations!");
                        $("#betting-modal-content").html("You have transfered successfully!");
                        $("#betting-modal").modal('show');
                        // alert("res from server" + result.status);
                    } else {
                        // show warning modal
                        $("#betting-modal-title").html("Warning!");
                        $("#betting-modal-content").html(result.error);
                        $("#betting-modal").modal('show');
                    }
                }                 
            });

        }

        const testGameOne = (e) => {
            $.post({
                url:'/api/testGameOne',
                data: {},
                success: function( result ){
                    console.log("Result of Game1 = ", result.data);
                }
            });
        }

        function loadUnreadNotifications(from_user_id){
            
        }

        function sendNotification(from_user_id){

        }

    // });

