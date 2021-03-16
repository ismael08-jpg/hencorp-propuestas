<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Propuesta</title>
    
    <style>
        .page-break {
            page-break-after: always;
        }
        .titulo{
            border: 2px solid azure;
            border-radius: 15px;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: azure;
            
        }

        html{
            background-color: blue;
        }

        .tabla, 
        tr, 
        th{
            border: 2px solid  #02163a ;
            border-radius: 50%;
            width: 100%;
        }

        

        

        .fondo{
            background-color: #02163a;
            justify-content: center;
            align-items: center;
            text-align: center;

        }

        .ima{
            margin-bottom: 200px;
            
        }
        
    </style>
</head>
<body>
    <section class="fondo">
        <header class="titulo"> {{$enc->nombre_cotizacion}}</header>
        <br>
        <br>
        <br>
        
        <img class="ima" height="150" width="500" src="{{ asset('assets/img/hencorp.jpeg') }}" alt="HOla mundo">
        
    </section>
    
    <footer style="position: absolute; bottom: 0;">
        <p style="text-align: center;">Informe generado {{date("Y-m-d")}}</p>
    </footer>
    
    <div class="page-break"></div><!--Termina la primera Pagina-->
    <div>
        <table style="text-align:;" class="tabla">
            <thead class="">
                <tr>
                    <th>Grupo Económico</th>
                    <th>Monto disponible hasta por</th>
                    <th>Tasa %</th>
                    <th>Fecha</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($det as $detalle)
                    <tr>
                        <td scope="row">{{ $detalle->grupo_economico }}</td>
                        <td>${{ number_format($detalle->monto_cot, 2, '.', ',' )  }}</td>
                        <td>{{ number_format($detalle->tasa_cot, 2, '.' )  }}%</td>
                        <td>{{ substr($detalle->fecha_cot, 0, -8) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <img src="{{$chart->getUrl()}}" alt="">
    </div>
    <footer style="position: absolute; bottom: 0;">
        <p style="text-align: center;">Informe generado {{date("Y-m-d")}}</p>
    </footer>
</body>
</html>