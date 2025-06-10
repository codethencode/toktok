<h2>Nouvelle demande de contact</h2>

<p><strong>Nom :</strong> {{ $data['nom'] }}</p>
<p><strong>Email :</strong> {{ $data['email'] }}</p>
<p><strong>Téléphone :</strong> {{ $data['telephone'] ?? 'Non renseigné' }}</p>

<hr>

<p><strong>Message :</strong></p>
<p>{{ $data['message'] }}</p>
<a href="https://toquetoque.net">https://toquetoque.net</a>