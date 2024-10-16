@extends('admin.app')
@section('app')

<div class="container-fluid vh-100" style="display: flex; align-items: center; justify-content: center; background-color: white;">
    <div class="row w-100">
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30" style="width: 100%;">

                <!-- Static period number and total bets -->
                <div class="row" style="padding: 10px; position: relative; margin-bottom: 20px;">
                    <!-- Period No on the left -->
                    <div id="gmsno" style="position: absolute; left: 10px;">
                        <b style="font-size: 20px;">Period No - 0000000001</b>
                        <a href="#" style="margin-left: 10px;">
                            <i class="fa fa-refresh" aria-hidden="true" style="font-size: 20px;"></i>
                        </a>
                    </div>

                    <!-- Total Bets on the right -->
                    <div id="total-bets" style="position: absolute; right: 10px;">
                        <b style="font-size: 20px;">Total Amount: 0</b>
                    </div>
                </div>

                <!-- Row to display numbers 0 to 9 -->
                <div class="row justify-content-center" style="padding-top: 10px; padding-bottom: 10px;">
                    @for ($i = 0; $i <= 9; $i++)
                        <div class="card col-md-1 mx-1" style="background-color:#3594de; height:50px;">
                            <center><h4 class="text-white">{{ $i }}</h4></center>
                        </div>
                    @endfor
                </div>

                <!-- Row to display empty result boxes -->
                <div class="row justify-content-center" style="padding-bottom: 10px;" id="result-boxes">
                    @for ($i = 0; $i <= 9; $i++)
                        <div class="card col-md-1 mx-1" style="background-color:#fff; height:50px; border: 2px solid #000;">
                            <div class="card-body p-1">
                                <b style="font-size: 12px;" id="result-box-{{ $i }}">{{ $i }}</b>
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- Form section for game period and result -->
                <form action="{{ route('spin.bet') }}" method="post">
                    @csrf
                    <input type="hidden" name="game_id" value="1"> <!-- Static game_id -->
                    <input type="hidden" name="gamesno" value="1001"> <!-- Static gamesno -->

                    <div class="row justify-content-center" style="margin-bottom: 10px;">
                        <div class="col-md-3 form-group d-flex">
                            <input type="text" name="game_no" class="form-control" placeholder="Game Serial Number" value="1001" style="font-size: 12px;">
                        </div>

                        <div class="col-md-3 form-group d-flex">
                            <input type="number" name="number" class="form-control" min="0" max="16" placeholder="Result" value="1" style="font-size: 12px;">
                        </div>

                        <div class="col-md-2 form-group d-flex">
                            <button type="submit" class="form-control btn btn-info" style="font-size: 12px;"><b>Submit</b></button>
                        </div>

                        <div class="col-md-1 form-group d-flex mt-1">
                            <a href=""><i class="fa fa-refresh" aria-hidden="true" style="font-size: 20px;"></i></a>
                        </div>
                    </div>

                    <!-- Static percentage field -->
                    <div class="row justify-content-center">
                        <div class="col-md-3 form-group d-flex">
                            <input type="hidden" name="id" value="1">
                            <input type="text" name="parsantage" value="10" class="form-control" placeholder="Win Percentage" style="font-size: 12px;">
                            <span><b>%</b></span>
                        </div>
                        <div class="col-md-2 form-group">
                            <button type="submit" class="form-control btn btn-info" style="font-size: 12px;"><b>Update</b></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function fetchData() {
        console.log('Fetching data... (static)');
        const staticData = {
            bets: [
                { amount: 100, gamesno: 1001 },
                { amount: 200, gamesno: 1001 }
            ],
            gameid: 1,
        };

        updateBets(staticData.bets);
        updateGameId(staticData.gameid);
        updateTotalBets(staticData.bets); // Pass the bets array to calculate the total
    }

    function updateBets(bets) {
        console.log('Updated Bets:', bets);
        var gmsno = '<b style="font-size: 20px;">Period No - 100000001</b>';

        // Reset all result boxes to zero before updating
        for (let i = 1; i <= 36; i++) {
            document.getElementById('result-box-' + i).innerHTML = 0; 
        }

        // Update result boxes with the amounts from bets
        bets.forEach((item, index) => {
            var resultBox = document.getElementById('result-box-' + (index + 1));
            if (resultBox) {
                resultBox.innerHTML = item.amount; 
            }
        });

        $('#gmsno').html(gmsno);
    }

    function updateGameId(gameid) {
        console.log('Updated Game ID:', gameid);
    }

    function updateTotalBets(bets) {
        console.log('Updating Total Bets...');
        const totalAmount = bets.reduce((sum, bet) => sum + bet.amount, 0); // Calculate total amount
        console.log('Total Amount:', totalAmount);
        $('#total-bets b').text('Total Amount: ' + totalAmount); // Update Total Bets dynamically
    }

    function refreshData() {
        fetchData();
        setInterval(fetchData, 5000); // 5 seconds interval
    }

    document.addEventListener('DOMContentLoaded', refreshData);
</script>

@endsection
