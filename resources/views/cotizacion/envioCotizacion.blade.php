@extends('layouts.master')

@section('title', 'Enviar Cotizacion')

@section('styles')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js" integrity="sha512-hZf9Qhp3rlDJBvAKvmiG+goaaKRZA6LKUO35oK6EsM0/kjPK32Yw7URqrq3Q+Nvbbt8Usss+IekL7CRn83dYmw==" crossorigin="anonymous"></script> --}}
@endsection
    


@section('content')
    <section  style="background-color: white"
    class=" col-xs-12 rounded-lg mb-5">
        <div class="d-flex w-100 justify-content-center mt-5"><h1>Enviar cotización</h1></div>
        
        <form action="{{ route('cotizacion.enviar') }}" method="POST">
            @csrf
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-md-6">
                        <label>Correo electronico</label>
                        <input type="email" name="correo" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>ID</label>
                        <input readonly type="number"  value="{{$id}}" name="id" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        
                    </div>
                    <div class="col-md-6">
            
                    </div>
                </div>
                <div class="d-flex w-100 justify-content-center mt-5 ">
                    <button type="submit" class="btn btn-info mb-5">Enviar PDF</button>
                </div>

            </div>
        </form>
    </section>

@endsection

@section('scripts')
    <script>
        // var ctx = document.getElementById('myChart').getContext('2d');
        // var myChart = new Chart(ctx,{
        //     type: "bar",
        //     data:{
        //         labels:['col1', 'col2', 'col3'],
        //         datasets:[{
        //             label:'Num datos',
        //             data:[10,9,15]
        //         }]
        //     }
        // });
    </script>
@endsection
