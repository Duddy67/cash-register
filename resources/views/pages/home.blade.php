
<div class="h2">Bienvenue sur l'application.</div>

 @auth
    <div class="col-12">Vous pouvez maintenant accéder au tableau d'<a href="{{ route('operations.index') }}">opérations</a></div>
 @else
    <div class="col-12">Merci de bien vouloir vous <a href="{{ route('login') }}">connecter</a> pour accéder aux fonctionnalités de l'application.</div>
 @endif
