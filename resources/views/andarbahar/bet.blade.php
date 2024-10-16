@extends('admin.app')
@section('app')

<div class="container-fluid mt-3" style="margin-bottom: 60px;">
    <form action="{{route('andar_bahar.bet')}}" method="post">
        @csrf
        
        <!-- Period Number -->
        <h1 class="text-center">Period No - 111502605</h1>
        <div id="total-bets" style="position: absolute; right: 10px;">
                        <b style="font-size: 20px;">Total Amount: 0</b>
                    </div>
                </div>
        <!-- Andar and Bahar Buttons -->
        <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-andar" type="button">Andar</button>
            <button class="btn btn-bahar ml-3" type="button">Bahar</button>
        </div>

        <!-- Input Boxes -->
        <div class="d-flex justify-content-center mt-4">
            <input type="text" class="form-control input-box" value="0" readonly>
            <input type="text" class="form-control input-box ml-3" value="0" readonly>
        </div>

        <!-- Betting Form Inputs -->
        <div class="d-flex justify-content-center mt-4">
            <input type="text" class="form-control form-input" name="period_no" value="111502604">
            <select class="form-select form-input ml-3" name="bet_option">
                <option>Andar</option>
                <option>Bahar</option>
            </select>
            <button class="btn btn-submit ml-3" type="submit">Submit</button>
            <button class="btn btn-refresh ml-3" type="button">
                <img src="https://img.icons8.com/fluency/48/000000/refresh.png" alt="Refresh" style="height: 24px;">
            </button>
        </div>

        <!-- Percentage Input -->
        <div class="d-flex justify-content-center mt-4">
            <input type="text" class="form-control form-input" name="percentage" value="30.00%">
            <button class="btn btn-submit ml-3" type="submit">Submit</button>
        </div>
    </form>
</div>

<!-- Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


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

<!-- Custom CSS -->
<style>
    body {
        background-color: #f8f9fa;
    }

    h1 {
        font-size: 32px;
        font-weight: bold;
    }

    .btn-andar {
        background: linear-gradient(to right, red, purple);
        color: white;
        width: 150px;
        height: 60px;
        font-size: 18px;
        border: none;
        border-radius: 5px;
    }

    .btn-bahar {
        background: linear-gradient(to right, green, purple);
        color: white;
        width: 150px;
        height: 60px;
        font-size: 18px;
        border: none;
        border-radius: 5px;
    }

    .input-box {
        width: 100px;
        height: 40px;
        text-align: center;
    }

    .form-input {
        width: 200px;
        height: 40px;
    }

    .btn-submit {
        background-color: teal;
        color: white;
        border-radius: 5px;
        height: 40px;
        width: 100px;
    }

    .btn-refresh {
        background-color: transparent;
        border: none;
        height: 40px;
        width: 50px;
    }

    .ml-3 {
        margin-left: 12px;
    }

    .mt-5 {
        margin-top: 50px;
    }

    .mt-4 {
        margin-top: 20px;
    }
</style>

@endsection
