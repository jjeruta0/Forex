@extends('apps.app')
@section('content')
@inject('exchange', 'App\Http\Controllers\ExchangeRate')
<div class="container-fluid px-0">
  <img src="{{asset('/images/Palitan-ng-piso.webp')}}" class="img -responsive" style="max-width:100%;"/>
</div> 

  <div class="container py-4">
    <div class="div card shadow" style="border-radius:0px;border:1px solid #043f7e">
      <div class="card-body">
         <div class="row">
          <input type="hidden" id="checkConversion" value="current">

          <div class="col-xl-3">
              <label for="">Halaga</label>
              <input type="text" class="form-control" id="inputCurrency" style="border-radius:0px;">
          </div>
    
          <div class="col-xl-4" id="columnPisoCurrent">
              <label for="">Pilipinas Piso</label>
              <input type="text" class="form-control" id="pisoValue" value="PHP" disabled style="border-radius:0px;">
            </div>
    
            <div class="col-xl-1 d-flex justify-content-center pt-2 mt-2" id="columnButton" style="cursor:pointer">
              <a class="btn-circle btn-xl" id="currentConversionCurrent">
                <img src="https://img.icons8.com/glyph-neue/40/0D41C7/data-in-both-directions.png"/>
              </a>
            </div>
            
          <div class="col-xl-4" id="columnIbaPaCurrent">
            <label>Iba Pang Mga Pananalapi</label>
            <select class="form-select mb-2" id="secondCurrency" aria-label="Default select example" style="border-radius:0px;">
              <option value="USD">USD</option>
              @foreach ($country as $countryCurrent)
              <option value="{{$countryCurrent[0]}}">{{$countryCurrent[0]}} ({{$countryCurrent[1]}})</option>
              @endforeach
            </select>
          </div>
    
          <div class="col-xl-4 d-none" id="columnIbaPaReverse">
            <label>Iba Pang Mga Pera</label>
            <select class="form-select mb-2" border-radius:0px; id="secondCurrencyReverse" aria-label="Default select example">
              <option value="USD">USD</option>
              @foreach ($country as $country)
              <option value="{{$country[0]}}">{{$country[0]}} ({{$country[1]}})</option>
              @endforeach
            </select>
          </div>
    
          <div class="col-xl-1 d-none  d-flex justify-content-center pt-2 mt-2" id="columnButtonReverse">
            <a class="btn-circle btn-xl d-none" id="triggerReverse">
              <img src="https://img.icons8.com/glyph-neue/40/043f7e/data-in-both-directions.png"/>
            </a>
          </div>

          <div class="col-xl-4 d-none" id="pisoReverse">
            <label for="">Pilipinas Piso</label>
            <input type="text" class="form-control" id="pisoValueReverse"  style="border-radius:0px;" value="PHP" disabled>
          </div>

          <div class="" id="convertedContainer" style="display: none;border-radius:0px;">
            <p class="mb-0 text-secondary" id="textFirst"></p>
            <p class="mb-0"><h3 id="textSecond"></h3></p>
          </div>
          <hr>
          <div class="d-flex justify-content-end">
            <button class="btn" style="border-radius: 0px;background-color:#0D41C7;color:#fff;" id="btnConvert">Convert</button>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="container py-4">
    <div class="div card shadow" style="border-radius:0px;border:1px solid #043f7e">
      <div class="card-body">
        <p style="font-size:25px;font-weight:bold;color:#545454"><img src="https://img.icons8.com/glyph-neue/64/545454/ruble.png"/> HALAGA NG PISO SA IBANG MGA PANANALAPI</p>
         <div class="row">
          <div class="col-lg-12">
            <table class="table table-striped" id="forexCurrencies">
              <thead>
                <tr>
                  <th scope="col">WATAWAT</th>
                  <th scope="col">BANSA</th>
                  <th scope="col">PANANALAPI</th>
                  <th scope="col">SIMBOLO</th>
                </tr>
                </thead>
              <tbody>
                @foreach ($rates['conversion_rates'] as $country => $value)
                <tr>
                  <td><img src="https://countryflagsapi.com/png/{{ 
                  strtolower(substr($country, 0, -1)) 
                  }} " alt="" width="50px" height="30px"></td>
                   <td>
                      {{-- {{ $exchange::test($country)}} --}}
                      {{ $exchange::getCountryName($country)}}

                  </td>
                  <td>{{ $value }}</td>
                  <td>{{ $country }}</td>
                </tr>
                @endforeach
              </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>
  </div>



@endsection


@section('script')
<script>
    
$ ( document ).ready(function() {
    $("#convertedContainer").hide()

    $.ajax({
        type: 'GET',
        url: '/exchange-rate',
        mimeType: 'json',
        success: function(response) {
          console.log(response)
            $.each(response, function(index, value) {
                var body = "<tr>";
                body    += "<td>" + index + "</td>";
                body    += "<td>" + value + "</td>";
                body    += "<td>" + index + "</td>";
                body    += "</tr>";
                $( body ).appendTo( $( "#currencyExchangeValue" ) );
            });
        },
        error: function() {
            alert('Fail!');
        }
    });

    /*DataTables instantiation.*/
    $( "#forexCurrencies" ).DataTable();

//  ------------ Convertion currency ------------------
  let origValue = "USD";
  $('#secondCurrency').on('change', function() {
    origValue = $(this).val()
  })

  $("#currentConversionCurrent").click(function() {
    //HIDE CURRENT FIELDS
    $("#columnPisoCurrent").addClass('d-none');
    $("#columnButton").addClass('d-none');
    $("#columnIbaPaCurrent").addClass('d-none');

    //SHOW REVERSE FIELDS
    $("#pisoReverse").removeClass('d-none');
    $("#triggerReverse").removeClass('d-none')
    $("#columnButtonReverse").removeClass('d-none')
    $("#columnIbaPaReverse").removeClass('d-none')
    $("#checkConversion").val('reverse')
    console.log(origValue)
    $("#secondCurrencyReverse").val(origValue).trigger('change')

  })

  let reverseValue = "";
  $('#secondCurrencyReverse').on('change', function() {
    reverseValue = $(this).val()
  })

  $("#triggerReverse").click(function() {
    //HIDE REVERSE FIELDS
    $("#pisoReverse").addClass('d-none');
    $("#triggerReverse").addClass('d-none')
    $("#columnButtonReverse").addClass('d-none')
    $("#columnIbaPaReverse").addClass('d-none')
    //SHOW REVERSE FIELDS
    $("#columnPisoCurrent").removeClass('d-none');
    $("#columnButton").removeClass('d-none');
    $("#columnIbaPaCurrent").removeClass('d-none');
    $("#checkConversion").val('current')

    $("#secondCurrency").val(reverseValue).trigger('change')


  })

  //WHEN TRIGGER CONVERT BUTTON
  $("#btnConvert").click(function() {
    $("#textFirst").empty()
    $("#textSecond").empty()


    var valueCurrency = $("#inputCurrency").val();
    var check = $("#checkConversion").val()

    if(valueCurrency !="") {
      //ANIMATE
      $("#convertedContainer").slideUp("slow");
      $("#convertedContainer").slideDown("slow");
      let selectedCurrency = "";

      //CHECK IF FOREIGN TO PHP CURRENCY OR PHP CURRENCY TO PHP CURRENCY
      if(check == 'current') {
        let initialCurrency = $("#pisoValue").val();
        selectedCurrency = $("#secondCurrency").val(); 

        $.ajax({
              type: "GET",
              url: '/conversion/'+initialCurrency+'/'+selectedCurrency+'/'+valueCurrency,
              success: function(response) {
                $("#textSecond").append(response + " " + selectedCurrency)
              }
          });

          $("#textFirst").append(valueCurrency+" " + initialCurrency + "=")
          
      } else {
        let initialCurrency = $("#pisoValueReverse").val();
        selectedCurrency = $("#secondCurrencyReverse").val(); 

        $.ajax({
              type: "GET",
              url: '/conversion/'+selectedCurrency+'/'+initialCurrency+'/'+valueCurrency,
              success: function(response) {
                $("#textSecond").append(response + " " + initialCurrency)
              }
          });
        $("#textFirst").append(valueCurrency+" " + selectedCurrency + "=")
      }
    }

  })
});
</script>
@endsection