<div style="width:75%;float:left;font-family: Microsoft Tai Le">
    <p>Estimado/a <strong>{{$nombre}}</strong>,</p>

    <p>¡Enhorabuena! Ha sido admitido a la {{App\SystemConfig::first()->getNameEs()}}</p>

    <p>Ya puedes acceder a la enseñanza virtual usando el correo asignado a usted: <strong>{{$newEmail}}</strong> y la contraseña que introdujo al hacer la inscripción</p>

    <p>Un Saludo,</p>

    <p>Dirección de la {{App\SystemConfig::first()->getNameEs()}}.</p>

    <hr/>

    <p>Dear <strong>{{$nombre}}</strong>,</p>

    <p>Congratulations! You have been admitted to {{App\SystemConfig::first()->getNameEs()}}</p>

    <p>You may now access the virtual teaching platform using your new email: <strong>{{$newEmail}}</strong> and the password you provided when submitting your inscription</p>

    <p>Yours truly,</p>

    <p>{{App\SystemConfig::first()->getNameEs()}} Staff.</p>
</div>
<div style="width:25%;float:left">
    <img src="{{Illuminate\Support\Facades\URL::to(App\SystemConfig::first()->getIcon())}}" style="max-width:100%"/>
</div>