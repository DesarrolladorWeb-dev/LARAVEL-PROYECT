   @if(Auth::user()->image)
        <div class="container-avatar">
                    <!-- RE ESTA MANERA PUEDO CAMBIAR LA RUTA Y NO SE CAMBIARA  -->
                <img  class ="avatar"  src="{{route('user.avatar',['filename' => Auth::user()->image ])}}"/> 
        </div>
   @endif

