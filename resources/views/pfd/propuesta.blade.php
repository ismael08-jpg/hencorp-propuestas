<!DOCTYPE html>
<html lang="es" style="margin:0">
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


        /* .tabla, 
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
        } */
        .tabla,
        th,
        td,
        tr {
            
        }

       

        .tabla,
        td {
            background-color: white;
            color: black;
        }

        .tabla,
        th {
            background-color: #02163a;
            color: white;
            border-color: #02163a;
        }
        table{
            text-align: center;
        }
        
        
        .margin{
            margin: 0%;
        }
        

        .fondo{

            background-color: #02163a;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 750px;
        }

       
        

        td{
            height: 30px;
        }

        .ima{
            margin-bottom: 200px;
            
        }

       

        .arial{font-family:  "Arial Black", "Arial Bold", sans-serif; font-size: 12px;  
            
        }

        .margin-page{
            margin-top:2.5cm;
            margin-bottom: 2.5cm;
            margin-left: 3cm;
            margin-right: 2.5cm;
        }

        .pie{
            
            
           
        }
        
    </style>
</head>
<body class="fondo">
    
        <img  height="200" width="750" style="margin-top: 150px" src="{{ asset('assets/img/hencorp-nav.png') }}" alt="Hencorp">
        <header class="titulo arial"><h2 style="margin-top: 100px">Contacto</h2></header>
        <p class="arial" style="color: #0684fc; font-size:20px">Correo: {{$contacto}}</p>
    
    <footer  style="position: absolute; bottom: 0; background-color: #02163a;">
        <p class="arial" style="text-align: center; color: azure; font-size: 20px">Informe generado {{date("Y-m-d")}}</p>
    </footer>
</body>
<body class="margin-page" >
    
        <p class="arial" style=" font-size: 30px; color: #02163a; text-align:center">{{$enc->nombre_cotizacion}}</p>
        <table style="" class="tabla arial">
            <thead class="">
                <tr>
                    <th>Grupo</th>
                    <th>Deudor</th>
                    <th>Monto disponible hasta por (US$)</th>
                    <th>Rendimiento Promedio (%)</th>
                    <th>Vencimiento</th> 
                    <th>País</th>
                    <th>Industria</th>
                    <th>Concentración actual en el  Grupo (%)</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($tablaPdf as $tb)
                    <tr>
                        <td>{{$tb['grupo_economico']}}</td>
                        <td scope="row">{{$tb['nombre_deudor'] }}</td>
                        <td>${{ number_format($tb['monto_cot'], 2, '.', ',' )  }}</td>
                        <td>{{ number_format(($tb['tasa_cot']), 2, '.', ',' )  }}%</td>
                        <td>{{ substr($tb['fecha_cot'], 0, -8) }}</td>
                        <td>{{$tb['pais']}}</td>
                        <td>{{$tb['industria']}}</td>
                        <td>{{number_format($tb['concentracion'], 2, '.', ',' )}}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($contador==12 || $contador == 13 || $contador == 11)
        @include('pfd.footer')
        <div class="page-break" ></div>
        @endif
        <table style=" margin-top: 25px; float: right; text-align:center;" class="tabla arial">
            <tr>
                <th>Total invertido (US$)</th>
                <th>Rendimiento Promedio (%)</th>
                <th>Plazo Promedio (Días)</th>
            </tr>
            <tr>
                <td>${{number_format($totalSaldo, 2, '.', ',' )}}</td>
                <td><p>{{number_format(($tasaPortafolio*100), 2, '.', ',' )}}%</p></td>
                <td><p>{{number_format($diasPortafolio, 2, '.', ',' )}}</p></td>
            </tr>
        </table>
        
        @include('pfd.footer')
</body>
</html>