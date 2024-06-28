<div>
    <h1>Bienvenue sur IntuitRisks</h1>
    <p>Bonjour {{ $data["name"]}}, </p>
    <p>Vous avez été à ajouté à l'équipe de gestion de risques de {{$data["company_name"]}}.</p>
    <p>Votre nom d'utilisateur pour vous connecter sur IntuitRisks est le suivant : {{$data["email"]}}</p>
    <p>Veuillez finaliser votre inscription en créant votre mot de passe à l'adresse suivante :</p>
    <a href="{{$data['url']}}">Créer mon mot de passe</a>

    <p>Si le bouton ci-dessus ne fonctionne pas, utilisez cet url dans votre navigateur :</p>
    <p>{{$data['url']}}<p>
</div>

<style>
    a {
        padding: 10px 20px;
        background-color: #0E7C7B;
        border-radius: 25px;
        color: white;
    }
</style>