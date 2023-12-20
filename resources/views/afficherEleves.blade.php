<h2>Tableau des élèves</h2>
<ul>
    @foreach($eleves as $eleve)
        <li>{{ $eleve->nom }} {{ $eleve->prenom }}</li>
    @endforeach
</ul>