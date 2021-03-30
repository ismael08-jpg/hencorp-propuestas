<div class="bs-example">

    <nav class="navbar navbar-expand-md navbar-light bg-azul  ">
     

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        

        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">

  
            <div class="navbar-nav">
                
                
            </div>


            <form class="form-inline">
                <div class="input-group navbar-collapse justify-content-center" id="navbarCollapse">                    
                    <center>
                        @if (auth()->user()->tipo_usuario==1)
                            <a class="navbar-brand" href="{{route('administrador.index')}}">
                                <img src="{{ asset('assets/img/hencorp-nav.png') }}" width="200" height="" 
                                    class=" d-inline-block align-top" alt="">
                            </a>   
                        @else
                            <a class="navbar-brand" href="{{route('catalogo-creditos.index')}}">
                                <img src="{{ asset('assets/img/hencorp-nav.png') }}" width="200" height="" 
                                    class=" d-inline-block align-top" alt="">
                            </a>
                        @endif
                    </center>
                </div>
            </form>


            <div class="navbar-nav" style="padding-right: 90px;" >
               
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" style="color:white; " data-toggle="dropdown">{{auth()->user()->nombre}}</a>
                        <div class="dropdown-menu" style="width:50px">
                            
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <input type="submit" class="dropdown-item" class="btn btn-round btn-azul" value="Cerrar sesión">
                            </form>

                            
                            <a href="#"  class="dropdown-item">Rol: @if (auth()->user()->tipo_usuario==1)
                                Admin @else Consultor @endif</a>
                        </div>
                    </div>   
                
            </div>

            

            
        </div>


    </nav>



</div>















