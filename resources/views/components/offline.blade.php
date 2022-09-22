@extends('apps.app')
@section('content')
<div class="container mt-5">
    <div class="row">
      <div class="col-xl-6">
        <div class="row">
          <div class="col-xl-6">
            <label for="exampleFormControlInput1" class="form-label">PHP ₱ - Philippine Peso</label>
            <select class="form-select mb-2" aria-label="Default select example">
              <option value="1" disabled selected>Piso</option>
            </select>
            <div class="mb-3">
              <input type="email" class="form-control" id="exampleFormControlInput1" value="1">
            </div>
          </div>
          <div class="col-xl-6">
            <label for="exampleFormControlInput1" class="form-label">USD $ - US Dollar</label>
            <select class="form-select mb-2" aria-label="Default select example">
              <option value="USD" selected>USD</option>
              {{-- @foreach ($country as $country)
              <option value="{{$country[0]}}">{{$country[0]}}</option>
              @endforeach --}}
            </select>
            <div class="mb-3">
              <input type="email" class="form-control" id="exampleFormControlInput1">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container mt-2" style="background-color: rgb(41, 78, 164);">
    <div class="row">
      <div class="col-xl-12 p-4 shadow">
        <div class="card" style="max-width: 100%">
          <table class="table table-striped" id="forexCurrency";>
            <thead>
              <h3 style="text-align:center">HALAGA NG PISO SA PILIPINAS</h3>
              <h4 style="text-align:center">SUB-SEKTOR NG MGA OPERASYON SA PANANALAPI</h4>
              <h5 style="text-align:center">na-update na petsa</h5>
              <tr>
                <th scope="col">BANSA</th>
                <th scope="col">PALITAN</th>
                <th scope="col">SIMBOLO</th>
              </tr>
            </thead>
            <tbody id="currencyExchangeValue">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div> 
@endsection