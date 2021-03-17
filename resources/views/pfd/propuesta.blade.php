<!DOCTYPE html>
<html lang="es" class="margin">
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
            justify-content: center;
            align-items: center;
            text-align: center;
            color: azure;
        }


        .tabla, 
        tr, 
        th{
            border-radius: 50%;
            
            width: 100%;
            font-family: Arial;
            
        }
        th{
            background-color: #02163a;
            color: azure;
        }

        .tabla,
        tr  
        {
            border: 2px solid #0684fc;
        }

        td{
            border-top: 2px solid #0684fc;
            border-right: 2px solid #0684fc;
        }
        
        .margin{
            margin: 0%;
        }
        

        .fondo{
            top: 0cm;
            left: 0cm;
            right: 0cm;
            
            
            background-color: #02163a;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 750px;
            /* position: fixed; */
            

        }

        .ima{
            margin-bottom: 200px;
            
        }

        .principal{
            margin-top: 2.5cm;
            margin-left: 3cm;
            margin-bottom: 2.5cm;
            margin-right: 2.5cm;

        }
        
    </style>
</head>
<body>
    <section class="fondo">
        <br>
        <header class="titulo"><h2 style="margin-top: 70px">{{$enc->nombre_cotizacion}}</h2></header>
        <br>
        <br>
        <br>
        
        <img class="ima" height="150" width="500" src="{{ asset('assets/img/hencorp.jpeg') }}" alt="HOla mundo">
        
    </section>
    <footer style="position: absolute; bottom: 0; background-color: #02163a;">
        <p style="text-align: center; color: azure">Informe generado {{date("Y-m-d")}}</p>
    </footer>
    
    <div class="page-break" style="margin-bottom: 2.5cm"></div><!--Termina la primera Pagina-->
    <div class="principal">
        <table style="text-align:;" class="tabla">
            <thead class="">
                <tr>
                    <th>Deudor</th>
                    <th>Monto disponible hasta por</th>
                    <th>Tasa %</th>
                    <th>Vencimiento</th>
                    <th>Grupo</th>
                    <th>Pais</th>
                    <th>Concentración</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($tablaPdf as $tb)
                    <tr>
                        <td scope="row">{{$tb['nombre_deudor'] }}</td>
                        <td>${{ number_format($tb['monto_cot'], 2, '.', ',' )  }}</td>
                        <td>{{ number_format($tb['tasa_cot'], 2, '.' )  }}%</td>
                        <td>{{ substr($tb['fecha_cot'], 0, -8) }}</td>
                        <td>{{$tb['grupo_economico']}}</td>
                        <td>{{$tb['pais']}}</td>
                        <td>{{$tb['concentracion']}}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        {{-- <img src="{{$chart->getUrl()}}" alt=""> --}}
        <div><h1>{{$tasaPortafoloio}}</h1></div>
    </div>
    <footer style="position: absolute; bottom: 0;">
        <p style="text-align: center;">Informe generado {{date("Y-m-d")}}</p>
    </footer>
</body>
</html>